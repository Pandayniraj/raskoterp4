<?php

namespace App\Http\Controllers;

use App\Helpers\UserSystemInfoHelper;
use App\Models\AttendanceChangeRequest;
use App\Models\AttendanceChangeRequestProxy;
use App\Models\ShiftAttendance;
use App\User;
use AttendanceHelper;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class ShiftAttendanceController extends Controller
{



    public function clockin(Request $request)
    {



        $makeClock = AttendanceHelper::clockin();





        // dd($request->all());
        if($makeClock['success']){

            Flash::success($makeClock['message']);

        }else{

            Flash::error($makeClock['message']);

        }
        return redirect()->back();
    }

    public function clockout(Request $request)
    {

        $makeClock = AttendanceHelper::clockout();

        if($makeClock['success']){

            Flash::success($makeClock['message']);

        }else{

            Flash::error($makeClock['message']);

        }

        return redirect()->back();
    }

    public function filter_report()
    {
        $page_title = 'Shift | attendance';
        $shifts = \App\Models\Shift::pluck('shift_name as name', 'id');

        return view('admin.shift_attendance.filterreport', compact('shifts', 'page_title'));
    }

    public function filter_reportShow(Request $request)
    {
        $shifts = \App\Models\Shift::pluck('shift_name as name', 'id');

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $ShiftAttendance = ShiftAttendance::where(function ($query) use ($request) {
            if ($request->shift_id && $request->shift_id != '') {
                return $query->where('shift_id', $request->shift_id);
            }
        })
        ->where('date', '>=', $request->start_date)
        ->where('date', '<=', $request->end_date)
        ->orderBy('date', 'desc')
        ->get()
        ->groupBy('shift_id');
        $page_title = 'Shift | attendance';

        $allReport = AttendanceHelper::reportSummary($ShiftAttendance); //pram1=>attendance list with shiftgroup , parm2 => boolean value to filter user (default false), parm3 userlist array to filter (optional)
        $selectedShift = $request->shift_id;
        $allReport = $allReport['result'];


        return view('admin.shift_attendance.filterreport', compact('shifts', 'allReport', 'start_date', 'end_date', 'page_title','selectedShift'));
    }

    public function filter_reportByUser($userid, $shift_id, $date)
    {
        $attendance = ShiftAttendance::where('user_id', $userid)
                        ->where('shift_id', $shift_id)
                        ->where('date', $date)->get();
        $report = [];
        $breaks = AttendanceHelper::breakDuration($shift_id);
        $report['user'] = \App\User::find($userid);
        $report['shift'] = \App\Models\Shift::find($shift_id);
        $report['breakduration'] = $breaks;

        $officeTime = AttendanceHelper::calculateOfficeTime($report);

        $report['officeTime'] = $officeTime['officeTime'] / 60;

        $report['requiredworkTime'] = $officeTime['requiredworkTime'];


        $report = AttendanceHelper::singleuserAttendanceReport($attendance, $report);

        $editable = (\Request::get('user') && \Request::get('user') == 'self') ? false : true;
        if(count($attendance)==0){
            return view('admin.shift_attendance.markattendance.createNewAttendance', compact('report', 'date', 'editable'));
        }
        else{
            return view('admin.shift_attendance.detailtimereport', compact('report', 'date', 'editable'));

        }

    }


    public function clockoutreportByUser($userid, $shift_id, $date)
    {
        $attendance = ShiftAttendance::where('user_id', $userid)
                        ->where('shift_id', $shift_id)
                        ->where('date', $date)->get();
        $report = [];
        $breaks = AttendanceHelper::breakDuration($shift_id);
        $report['user'] = \App\User::find($userid);
        $report['shift'] = \App\Models\Shift::find($shift_id);
        $report['breakduration'] = $breaks;

        $officeTime = AttendanceHelper::calculateOfficeTime($report);

        $report['officeTime'] = $officeTime['officeTime'] / 60;

        $report['requiredworkTime'] = $officeTime['requiredworkTime'];


        $report = AttendanceHelper::singleuserAttendanceReport($attendance, $report);

        $editable = (\Request::get('user') && \Request::get('user') == 'self') ? false : true;
            return view('admin.shift_attendance.markattendance.createClockOutAttendance', compact('report', 'date', 'editable'));


    }
    public function makeUserClockout(Request $request){

//        $attendance = ShiftAttendance::where('user_id', auth()->user()->id)
//            ->where('shift_id', $request->shift_id)
//            ->where('date', $request->date)->where('attendance_status',2)->delete();
        $attendanceid = ShiftAttendance::where('user_id', auth()->user()->id)
            ->where('shift_id', $request->shift_id)
            ->where('date', $request->date)->where('attendance_status',1)->first();

//        $clock_out = ShiftAttendance::create([
//            'user_id' => auth()->user()->id ,
//            'shift_id' => $request->shift_id ,
//            'date' => $request->date ,
//            'time' => $request->time ,
//            'attendance_status' => 2 ,
//            'source' => 'adjusted',
//            'ip_address' => '0.0.0.0' ,
//            'remarks' => $request->reason ,
//            'is_adjusted' => 1 ,
//        ]);

        $requestedAttendace = [

            'attendance_id'=>$attendanceid->id,
            'user_id'=>\Auth::user()->id,
            'actual_time'=>$request->time,
            'requested_time'=>$request->time,
            'reason'=>$request->reason,
            'date'=>$request->time,
            'attendance_status' => 2,
            'status'=>1,
        ];
        $checkRequest=\App\Models\AttendanceChangeRequest::where('attendance_id',$attendanceid->id)->where('attendance_status',2)->first();
        if($checkRequest->status==1){
            Flash::success('You have already Requested');
            return redirect()->back();
        }

        \App\Models\AttendanceChangeRequest::create($requestedAttendace);
        
        $request_to_email=  'dharmendra.sah@gninepal.org'; //auth()->user()->firstLineManger->email;
            $request_from_email=auth()->user()->email;
            $request_to_name=auth()->user()->firstLineManger->first_name;

              try {
                \Mail::send('emails.email-attendancerequestupdate', [], function ($message) use ($request_to_email, $request_from_email) {
                    $message->subject('Time Change Request Has Been Forwarded');
                    $message->to($request_to_email);
                    $message->from($request_from_email);
                });

                Flash::success('Thank you, attendance change request has been sent to '.$request_to_name.' for perusal.');
            } catch (\Exception $e) {
                Flash::error('Error in sending mails : Invaild Email');
            }
//        dd($clock_out);
        Flash::success('You request is been applied');
        return redirect()->back();

    }

    public function fixattendance(Request $request, $attendanceId)
    {
        if ($attendanceId != 'new') {
            $attendance = ShiftAttendance::find($attendanceId);
            $attendance->update(['time'=>$request->time]);
        } else {
            $attribute = [
                'user_id'=>$request->user_id,
                'date'=>$request->date,
                'shift_id'=>$request->shift_id,
                'time'=>$request->time,
                'is_adjusted'=>1
            ];
            $lastAttendence = ShiftAttendance::where('shift_id', $request->shift_id)
                            ->where('user_id', $request->user_id)
                            ->where('date', $request->date)
                            ->orderBy('attendance_status', 'desc')
                            ->first();

            if ($lastAttendence) {
                $nextStatus = $lastAttendence->attendance_status + 1;

                $attribute['attendance_status'] = $nextStatus;

                ShiftAttendance::create($attribute);
            } else {
                abort(404);
            }
        }

        return ['success'=>true];
    }

    private function getReportSummaryArray($ShiftAttendance)
    {
        $allReport = AttendanceHelper::reportSummary($ShiftAttendance)['result'];
        $excelReport = [];
        foreach ($allReport as $key => $summaryreport) {
            $thisReport = $summaryreport['data_by_date'];

            foreach ($thisReport as $key => $report) {
                $thisDate = $report['date'];
                $userReports = $report['data'];
                foreach ($userReports as $ur => $thisUserReport) {
                    $result = [];
                    $thisUserReport = (object) $thisUserReport;
                    // if( $thisUserReport->clockin){
                    // 	dd($thisUserReport);
                    // }

                    $result['emp_id'] = $thisUserReport->user->id;
                    $result['date'] = $thisDate;
                    $result['first_name'] = $thisUserReport->user->first_name;

                    $result['last_name'] = $thisUserReport->user->last_name;

                    $result['degination'] = $thisUserReport->user->designation->designations;

                    $result['shift_name'] = $thisUserReport->shift->shift_name;

                    $result['officeTime'] = AttendanceHelper::minutesToHours($thisUserReport->officeTime).' hrs/'.AttendanceHelper::minutesToHours($thisUserReport->requiredworkTime).' hrs';

                    $result['clockin'] = $thisUserReport->clockin;

                    $locationIn = json_decode($thisUserReport->in_location);

                    $result['in_location'] = $locationIn ? $locationIn->street_name.'/'.$locationIn->formatted_address : '-';

                    $locationOut = json_decode($thisUserReport->out_location);

                    $result['lateby'] = $thisUserReport->lateby ? AttendanceHelper::minutesToHours($thisUserReport->lateby).' hrs' : '-';

                    $result['earlyby'] = $thisUserReport->earlyby ? AttendanceHelper::minutesToHours($thisUserReport->earlyby).' hrs' : '-';

                    $result['break_taken'] = $thisUserReport->summary['breakTime'] ? AttendanceHelper::minutesToHours($thisUserReport->summary['breakTime']).' hrs' : '-';

                    $result['work_done'] = $thisUserReport->summary['workTime'] ? AttendanceHelper::minutesToHours($thisUserReport->summary['workTime']).' hrs' : '-';

                    $result['overTime'] = $thisUserReport->overTime ? AttendanceHelper::minutesToHours($thisUserReport->overTime).' hrs' : '-';

                    $result['clockout'] = $thisUserReport->clockout;
                    $result['out_location'] = $locationOut ? $locationOut->street_name.'/'.$locationOut->formatted_address : '-';
                    $result['remark'] = $thisUserReport->summary['message'];
                    $excelReport[] = $result;
                }
            }
        }

        return ['summary'=>$excelReport];
    }

    public function download_report(Request $request, $type)
    {
        $ShiftAttendance = ShiftAttendance::where(function ($query) use ($request) {
            if ($request->shift_id && $request->shift_id != '') {
                return $query->where('shift_id', $request->shift_id);
            }
        })
        ->where('date', '>=', $request->start_date)
        ->where('date', '<=', $request->end_date)
        ->orderBy('date', 'desc')
        ->get()
        ->groupBy('shift_id');

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $report = $this->getReportSummaryArray($ShiftAttendance);

        $summaryReport = $report['summary'];

        // dd($summaryReport);
        if ($type == 'pdf') {
            $pdf = \PDF::loadView('admin.shift_attendance.pdf.filterreportPDF', compact('start_date', 'end_date', 'summaryReport'));
            // return view('admin.shift_attendance.pdf.filterreportPDF',compact('start_date','end_date','summaryReport'));
            $file = "attendance_report_{$start_date}_{$end_date}";
            if (\File::exists('attendance/'.$file)) {
                \File::Delete('attendance/'.$file);
            }

            return $pdf->download($file);
        }
        //else download excel

        return \Excel::download(new \App\Exports\ExcelExport($summaryReport), "attendance_report_{$start_date}_{$end_date}.{$type}");
    }

    public function myTimeHistory()
    {
        $page_title = 'My Time History';
        $page_description = 'Show Your Time History ';
       
        $days=[];
        $begin = new \DateTime( date('Y-m-01'));
        $end   = new \DateTime( date('Y-m-t') );

        for($i =  $begin; $i <= $end; $i->modify('+1 day')){
            $days[]= $i->format("Y-m-d");
        }

        $date_in = date('Y-m');
        $start_date = $date_in.'-01';
        $end_date = $date_in.'-31';

        $attendance = ShiftAttendance::where('user_id', \Auth::user()->id)
                        ->where('date', '>=', $start_date)
                        ->where('date', '<=', $end_date)
                        ->get()
                        ->groupBy('shift_id');
        $allReport = AttendanceHelper::singleuserAttendanceReportWithShift($attendance);
        return view('admin.shift_attendance.mytimehistroy', compact('allReport','page_title', 'page_description', 'date_in','days', 'start_date', 'end_date'));
    }

    public function myTimeHistoryUpdate(Request $request)
    {
        $page_title = 'Time Report';
        $days=[];
        $begin = new \DateTime( date('Y-m-01',strtotime($request->date_in)) );

        $end   = new \DateTime( date('Y-m-t',strtotime($request->date_in)) );

       

        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            $days[]= $i->format("Y-m-d");
        }

       
        $page_description = 'Time History Report';
        $date_in = $request->date_in;
        $start_date = $date_in.'-01';
//        $end_date = date('Y-m-t', strtotime($start_date));
        $end_date = $date_in.'-31';

        $attendance = ShiftAttendance::where('user_id', \Auth::user()->id)
                        ->where('date', '>=', $start_date)
                        ->where('date', '<=', $end_date)
                        ->get()
                        ->groupBy('shift_id');

        $allReport = AttendanceHelper::singleuserAttendanceReportWithShift($attendance);

        if ($request->has('date_in') && count($allReport) == 0) {
            Flash::warning('You have no any attendance records on this day');
        }


        return view('admin.shift_attendance.mytimehistroy', compact('page_title', 'page_description', 'allReport', 'date_in','days', 'start_date', 'end_date'));
    }

    public function myTimeHistoryStore(Request $request)
    {
        $checkAttendance = ShiftAttendance::find($request->attendance_id);

       if(!$checkAttendance){
           $shiftAttendance=ShiftAttendance::create([
               'user_id'=>auth()->user()->id,
               'shift_id'=>$request->shift_id,
               'date'=>$request->date,
               'time'=>$request->time,
           ]);
          $request['attendance_id']=$shiftAttendance->id;
       };

        $checkAttendance = ShiftAttendance::find($request->attendance_id);


        if ($checkAttendance->user_id != \Auth::user()->id) {
            Flash::error('You cannot change other attendance');

            return redirect()->back();
        }


        $requestedAttendace = [

            'attendance_id'=>$checkAttendance->id,
            'user_id'=>\Auth::user()->id,
            'actual_time'=>$checkAttendance->time,
            'date'=>$request->time,
            'requested_time'=>$request->time,
            'reason'=>$request->reason,
            'attendance_status'=>1,
            'status'=>1,
        ];
//        dd($requestedAttendace['date']);

        \App\Models\AttendanceChangeRequest::create($requestedAttendace);

         $request_to_email=auth()->user()->firstLineManger->email;
            $request_from_email=auth()->user()->email;
            $request_to_name=auth()->user()->firstLineManger->first_name;

              try {
                Mail::send('emails.email-attendancerequestupdate', [], function ($message) use ($request_to_email, $request_from_email) {
                    $message->subject('Time Change Request Has Been Forwarded');
                    $message->to($request_to_email);
                    $message->from($request_from_email, env('APP_COMPANY'));
                    $message->cc(env('REPORT_EMAIL'));
                });

                Flash::success('Thank you, attendance change request has been sent to '.$request_to_name.' for perusal.');
            } catch (\Exception $e) {
                Flash::error('Error in sending mails : Invaild Email');
            }

        Flash::success('You request is been applied');

        return redirect()->back();
    }

    public function timeChangeRequest()
    {
        $page_title = 'Timechange Request';
        $page_description = 'Timechange Request';

        if (\Auth::user()->hasRole(['admins','hr-staff'])){
            $timechange = \App\Models\AttendanceChangeRequest::where(function ($q){
                if(\request('user')){
                    return $q->where('user_id',\request('user'));
                }})->where(function ($q){
                if(\request('status')){
                    return $q->where('status',\request('status'));
                }})->orderBy('id', 'desc')->get();
         $sub_ordinates = User::select('first_name', 'last_name', 'id')->where('enabled', '1')->get();
        }elseif(\App\Helpers\TaskHelper::is_line_manager(\Auth::user()->id)){
            $user = \Auth::user();
            $timechange = collect();
            $sub_ordinates = collect();
            $sub_ordinates = $sub_ordinates->merge(\App\User::where('first_line_manager',\Auth::user()->id)->get());
            $sub_ordinates_id = $sub_ordinates->pluck(id);
            $timechange_id = \App\Models\TimeChangeRequestForward::where('to_id',\Auth::user()->id)->where('forward_source','attendance')->pluck('change_id');


            $timechange = $timechange->merge(\App\Models\AttendanceChangeRequest::
                                        where(function ($q){
                                                    if(\request('user')){
                                                        return $q->where('user_id',\request('user'));
                                                    }})->where(function ($q){
                                                    if(\request('status')){
                                                        return $q->where('status',\request('status'));
                                                    }})->whereIn('id',$timechange_id)->get());
            $request_user_id  = \request('user');
            $request_user = \App\User::where('id',$request_user_id)->first();
            if((\request('user') == \Auth::user()->id) || (empty(\request('user'))) || (\App\Helpers\TaskHelper::is_line_manager(\Auth::user()->id)))
            {
            $timechange = $timechange->merge(\App\Models\AttendanceChangeRequest::
                                        where(function ($q) use($sub_ordinates_id){
                                                    if(\request('user')){
                                                        return $q->where('user_id',\request('user'));
                                                    }else{
                                                        return $q->whereIn('user_id',$sub_ordinates_id);
                                                    }})->where(function ($q){
                                                    if(\request('status')){
                                                        return $q->where('status',\request('status'));
                                                    }})->orderBy('id', 'desc')->get());
            $timechange = $timechange->merge(\App\Models\AttendanceChangeRequest::
                                        where(function ($q) use($sub_ordinates_id){
                                                    if(\request('user')){

                                                        return $q->where('user_id',\request('user'));

                                                    }else{
                                                        return $q->where('user_id',\Auth::user()->id);
                                                    }})->where(function ($q){
                                                    if(\request('status')){
                                                        return $q->where('status',\request('status'));
                                                    }})->orderBy('id', 'desc')->get());
            }
            $timechange__user_id = \App\Models\TimeChangeRequestForward::where('to_id',\Auth::user()->id)->where('forward_source','attendance')->pluck('from_id');

            $sub_ordinates = $sub_ordinates->merge(\App\User::whereIn('id',$timechange__user_id)->get());
        }else{
               // $sub_ordinates = \Auth::user();
               $timechange = \App\Models\AttendanceChangeRequest::
                                        where(function ($q){
                                                    if(\request('user')){
                                                        return $q->where('user_id',\request('user'));
                                                    }else{
                                                        return $q->where('user_id',\Auth::user()->id);
                                                    }})->where(function ($q){
                                                    if(\request('status')){
                                                        return $q->where('status',\request('status'));
                                                    }})->orderBy('id', 'desc')->get();
        }

            // $forward_messages = \App\Models\TimeChangeRequestForward::where('forward_source','attendance')->where('from_id',Auth::user()->id)->get();
        return view('admin.shift_attendance.timeChangeRequest', compact('is_second_line_manager','is_first_line_manager','page_title', 'sub_ordinates','page_description', 'timechange','forward_messages'));
    }

    public function timeRequestModal($id)
    {
        $timechange = \App\Models\AttendanceChangeRequest::find($id);
        $attendance = ShiftAttendance::find($timechange->attendance_id);
        $forwaded = \App\Models\TimeChangeRequestForward::where('change_id',$timechange->id)->first();
        return view('admin.shift_attendance.timechange_approve_modal', compact('forwaded','forward_messages','is_second_line_manager','page_title', 'page_description', 'timechange', 'attendance'));
    }


    public function timechange_view_modal($id)
    {
        $timechange = \App\Models\AttendanceChangeRequest::find($id);
        $attendance = ShiftAttendance::find($timechange->attendance_id);
        $forwaded = \App\Models\TimeChangeRequestForward::where('change_id',$timechange->id)->first();



         $user = \Auth::user();
            $sub_ordinates = \App\User::where('first_line_manager',\Auth::user()->id)->get();
            if(count($sub_ordinates) == 1  && empty($sub_ordinates[0]->second_line_manager))
            {
                $is_second_line_manager = 1;
                $forward_messages = \App\Models\TimeChangeRequestForward::where('forward_source','attendance')->where('change_id',$id)->where('to_id',\Auth::user()->id)->first();
            }
         //forward note
        return view('admin.shift_attendance.timechange_view_modal', compact('forwaded','forward_messages','is_second_line_manager','page_title', 'page_description', 'timechange', 'attendance'));
    }


       public function timechangeForwardModal($id)
    {
        $timechange = \App\Models\AttendanceChangeRequest::find($id);
        $attendance = ShiftAttendance::find($timechange->attendance_id);

        $users = \App\User::where('id',$timechange->user_id)->first()->second_line_manager;
        if(empty($users)){
            $users = \App\User::where('id',$timechange->user_id)->first()->first_line_manager;
        }
        $line_manager = \App\User::where('id',$users)->get();
        return view('admin.shift_attendance.timechange_forward_approve_modal', compact('line_manager','page_title', 'page_description', 'timechange', 'attendance'));
    }


    public function updateTimeChangeRequest(Request $request, $id)
    {


        $timechange = \App\Models\AttendanceChangeRequest::find($id);
        $attendance = ShiftAttendance::find($timechange->attendance_id);

        if(!$attendance){
            $attendance=ShiftAttendance::create([
                'date'=>$timechange->requested_time,
                'time'=>$timechange->requested_time,
                'attendance_status'=>$timechange->attendance_status,
                'remarks'=>$timechange->reason,
                'shift_id'=>$timechange->shift_id,
                'user_id'=>$timechange->user_id,
                'is_adjusted'=>1,
            ]);
            $timechange['attendance_id']=$attendance->id;
        }




        if($timechange->attendance_status==2){

            $i=ShiftAttendance::where('user_id', $attendance->user_id)
            ->where('shift_id', $attendance->shift_id)
            ->where('date',date('Y-m-d',strtotime($timechange->requested_time)))->where('attendance_status','2');
            $i->delete();
                ShiftAttendance::create([
                    'date'=>$timechange->requested_time,
                    'time'=>$timechange->requested_time,
                    'attendance_status'=>$timechange->attendance_status,
                    'remarks'=>$timechange->reason,
                    'is_adjusted'=>1,
                    'shift_id'=>$attendance->shift_id,
                    'user_id'=>$attendance->user_id,
                ]);
        }elseif($request->status == 2){
             $attendance = ShiftAttendance::find($timechange->attendance_id);
            $attendance->update([
                'time'=>$timechange->requested_time,
                'is_adjusted'=>1,
            ]);
        }


        $timechange->update([
            'status'=>$request->status,
            'approved_by'=>\Auth::user()->id,
        ]);


        $request_to_name =  \App\Helpers\TaskHelper::getUser($attendance->user_id)->first_name;
        // dd( $request_to_name);
        $request_to_email =  \App\Helpers\TaskHelper::getUser($attendance->user_id)->email;
        $request_from_email =  \App\Helpers\TaskHelper::getUser(\Auth::user()->id)->email;
        // $note = $request->note;

         try {
                Mail::send('emails.email-attendancerequestapproved', [], function ($message) use ($request_to_email, $request_from_email) {
                    $message->subject('Time Change Request Has Been Updated');
                    $message->to($request_to_email);
                    $message->from($request_from_email, env('APP_COMPANY'));
                    $message->cc(env('REPORT_EMAIL'));
                });

                Flash::success('Thank you, attendance change request  update has been sent to '.$request_to_name.'.');
            } catch (\Exception $e) {
                Flash::error('Error in sending mails : Invaild Email');
            }



        Flash::success('TimeChangeRequest Successfully Accepted');

        return redirect()->back();
    }
    public function forwardTimeChangeRequest($id)
    {
        $timechange = \App\Models\AttendanceChangeRequest::find($id);
        $timechange->update(['is_forwarded' => 1,]);
        Flash::success('Request is Forwarded to Second line Manager');
        return redirect()->back();
    }


    public function updateforwardTimeChangeRequest(Request $request ,$id)
    {
        $timechange = \App\Models\AttendanceChangeRequest::find($id);
        $data = new \App\Models\TimeChangeRequestForward();
        $data->change_id = $timechange->id;
        $data->from_id = $timechange->user_id;
        $data->to_id = $request->user_id;
        $data->status = $timechange->status;
        $data->forward_source = 'attendance';
        $data->note = $request->note;
        $data->save();
        $request_to_name =  \App\Helpers\TaskHelper::getUser($request->user_id)->first_name;
        $request_to_email =  \App\Helpers\TaskHelper::getUser($request->user_id)->email;
        $request_from_email =  \App\Helpers\TaskHelper::getUser($timechange->user_id)->email;
        // $note = $request->note;

         try {
                Mail::send('emails.email-attendancerequestupdate', [], function ($message) use ($request_to_email, $request_from_email) {
                    $message->subject('Time Change Request Has Been Forwarded');
                    $message->to($request_to_email);
                    $message->from($request_from_email, env('APP_COMPANY'));
                    $message->cc(env('REPORT_EMAIL'));
                });

                Flash::success('Thank you, attendance change request has been sent to '.$request_to_name.' for perusal.');
            } catch (\Exception $e) {
                Flash::error('Error in sending mails : Invaild Email');
            }
        $timechange = \App\Models\AttendanceChangeRequest::find($id);
        $timechange->update(['is_forwarded' => 2,]);
        Flash::success('Request is Forwarded to Next line Manager');
        return redirect()->back();

    }
    public function attendanceRequestProxy(Request $request)
    {



        if ($request->user_id != \Auth::user()->id) {
            Flash::error('You cannot change other attendance');
            return redirect()->back();
        }
        $i=1;

        foreach ($request->date as $key=>$value){

            if($request->attendance_id[$key]==""){
                $request['clock_out']=$request->clock_in;

            }
            $requestedAttendace = [
                'user_id'=>\Auth::user()->id,
                'attendance_id'=>$request->attendance_id[$key],
                'date'=>$value,
                'shift_id'=>$request->shift_id,
                'actual_time'=>date('Y-m-d H:i:s',strtotime($value.' '.date('H:i:s'))),
                'requested_time'=>date('Y-m-d H:i:s',strtotime($value.' '.$request->clock_out[$key])),
                'attendance_status'=> $request->attendance_status[$key] ,
                'reason'=>$request->reason[$key],
                'status'=>1,

//                'attendance_id'=>$attendanceid->id,
//                'user_id'=>\Auth::user()->id,
//                'actual_time'=>$request->time,
//                'requested_time'=>$request->time,
//                'reason'=>$request->reason,
//                'date'=>$request->time,
//                'attendance_status' => 2,
//                'status'=>1,
            ];
            //dd($requestedAttendace['clock_time']);
            $attendnceProxy = \App\Models\AttendanceChangeRequest::create($requestedAttendace);
            if ($i==1){
                $group_id =$attendnceProxy->id;

                $attendnceProxy->save();
                $i++;
            }
            $request_to_email=auth()->user()->firstLineManger->email;
            $request_from_email=auth()->user()->email;
            $request_to_name=auth()->user()->firstLineManger->first_name;

              try {
                Mail::send('emails.email-attendancerequestupdate', [], function ($message) use ($request_to_email, $request_from_email) {
                    $message->subject('Time Change Request Has Been Forwarded');
                    $message->to($request_to_email);
                    $message->from($request_from_email, env('APP_COMPANY'));
                    $message->cc(env('REPORT_EMAIL'));
                });

                Flash::success('Thank you, attendance change request has been sent to '.$request_to_name.' for perusal.');
            } catch (\Exception $e) {
                Flash::error('Error in sending mails : Invaild Email');
            }


            try {
                Mail::send('emails.email-attendancerequest', compact('request_to'), function ($message) use ($attributes, $email_to, $request) {
                    $message->subject('New attendance has been Request');
                    $message->to($email_to);
                    $message->from(env('APP_EMAIL'), env('APP_COMPANY'));
                    $message->cc(env('REPORT_EMAIL'));
                });

                Flash::success('Thank you, attendance has been sent to '.$request_to_name.' for perusal.');
            } catch (\Exception $e) {
                Flash::error('Error in sending mails : Invaild Email');
            }



        }






        Flash::success('Your request has been forwarded');
        return redirect()->to('/home');
    }
    public function attendanceProxyModal($id)
    {

        $timechange = \App\Models\AttendanceChangeRequestProxy::find($id);
        $page_title = $timechange->attendance_status==1?'Clock in':'Clock Out';
        $childInfo = \App\Models\AttendanceChangeRequestProxy::where('groups',$id)->whereNotNull('groups')->get();

        return view('admin.shift_attendance.attendance_proxy_modal', compact('page_title','childInfo', 'timechange'));
    }
    public function updateAttendanceProxy(Request $request, $id)
    {
        $timechange = \App\Models\AttendanceChangeRequestProxy::where('groups',$id)->get();
        if ($request->status == 2) {
            foreach ($timechange as $item) {
                $test = $this->updateNewAttendance($item);
                $item->update([
                    'status'=>$request->status,
                    'approved_by'=>\Auth::user()->id,
                ]);
            }
        }


        Flash::success('Time Change Request Successfully Updated');
        return redirect()->back();
    }
    public function forwardAttendanceProxy(Request $request, $id)
    {
        $timechange = \App\Models\AttendanceChangeRequestProxy::find($id);
        $timechange->update(['is_forwarded' => 1,]);
        Flash::success('Request is Forwarded to Second line Manager');
        return redirect()->back();
    }
    public  function  updateNewAttendance($timechange){
        if(strtotime($timechange->end_time)){
            $old_attendance =  \App\Models\ShiftAttendance::where([
                ['user_id',$timechange->user_id ],['date',$timechange->date]
            ])->delete();
        }else{
            $old_attendance =  \App\Models\ShiftAttendance::where([
                ['user_id',$timechange->user_id ],['date',$timechange->date],['attendance_status',1]
            ])->delete();
        }
        //clock In
        $clock_in = ShiftAttendance::create([
            'user_id' => $timechange->user_id ,
            'shift_id' => $timechange->shift_id ,
            'date' => $timechange->date ,
            'time' => $timechange->clock_time ,
            'attendance_status' => 1 ,
            'source' => 'adjusted',
            'ip_address' => '0.0.0.0' ,
            'remarks' => $timechange->reason ,
            'is_adjusted' => 1 ,
        ]);//clock In
        $clock_out = ShiftAttendance::create([
            'user_id' => $timechange->user_id ,
            'shift_id' => $timechange->shift_id ,
            'date' => $timechange->date ,
            'time' => $timechange->end_time ,
            'attendance_status' => 2 ,
            'source' => 'adjusted',
            'ip_address' => '0.0.0.0' ,
            'remarks' => $timechange->reason ,
            'is_adjusted' => 1 ,
        ]);
        return true;
    }
    public function attendanceAdjustModal(Request $request)
    {

//        dd($type=='yesterday_out');
        $type = $request->type;
        $allAtt=\AttendanceHelper::getUserAttendanceUncomplete(\Auth::user()->id, date('Y-m-d',strtotime('-1 year')), date('Y-m-d'));
        $userAtt =[];
        $timechange = \App\Models\AttendanceChangeRequest::where('user_id',\Auth::user()->id)->where('attendance_status',2)->get();
        $dates=[];
        $leftCheckin=[];
        for ( $i = strtotime("+1 days", strtotime($allAtt->first()->date)); $i <= strtotime(date('Y-m-d',strtotime("-1 days",strtotime(date('Y-m-d',strtotime('today')))))); $i = $i + 86400 ) {
            $leftCheckin[] = date( 'Y-m-d', $i );
        }

        foreach($timechange as  $shiftDate){
        array_push($dates,date('Y-m-d',strtotime($shiftDate['date'])) );
        }
       foreach ($allAtt as $att){
           if ($att->date!=date('Y-m-d') && !in_array($att->date,$dates)){
               $userAtt[]=$att;

           }
       }

        //chek in
        $missedAtt =[];
        $checkinRq = \App\Models\AttendanceChangeRequest::where('user_id',\Auth::user()->id)->where('attendance_status',1)->get();
        $checkinDate=[];
        foreach($checkinRq as  $shiftDate){
            array_push($checkinDate,date('Y-m-d',strtotime($shiftDate['date'])) );
        }
        foreach ($leftCheckin as $att){
            if ($att!=date('Y-m-d') && !in_array($att,$checkinDate)){
                $missedAtt[]=$att;

            }
        }

        $shift = \AttendanceHelper::getUserShift(\Auth::user()->id);
        $checked_value = date('Y-m-d');
        if($type == 'yesterday_out'){
            $checked_value = null;
        }
        return view('admin.attendance.adjustment_modal', compact('type', 'userAtt', 'missedAtt','shift', 'checked_value'));

    }
    public function adjustmentlist(){
        $user = \Auth::user()->first();
        if(\Auth::user()->hasRole(['admins','hr-staff'])) {
            $adjust_attendance = AttendanceChangeRequestProxy::groupBy('groups')->orderBy('created_at', 'desc')->limit(8)->get();
        }else{
            $adjust_attendance = AttendanceChangeRequestProxy::where('user_id',$user->id)->groupBy('groups')->orderBy('created_at', 'desc')->limit(8)->get();
        }
        return view('admin.attendance.adjustment_list', compact('adjust_attendance '));



    }
    public function deleteModal($id){
        $error = null;

        $modal_route = route('admin.timechange_request.delete',$id);
        $modal_title='Delete';

        $modal_body = 'Are you sure you want to Delete?';

        return view('modal_confirmation', compact('error', 'modal_route', 'modal_title', 'modal_body'));
    }
    public function delete($id){
        $changeRequest=AttendanceChangeRequest::find($id);
        $changeRequest->delete();
        Flash::success('Time Change Request Successfully Deleted');
        return redirect()->back();

    }


    public function importShiftAttendance()
    {
       $page_title = 'Import Attendance | history';
       $page_description = 'Import Attendance Report Previous Device';
      return view('admin.shift_attendance.import');
    }

    public function storeImportShiftAttendance(Request $request)
    {
          try {
            if ($request->hasFile('import_file')) {
                $file = $request->file('import_file');
               $i= \Excel::import(new \App\Imports\AttendanceExcelImport(), $file);
                Flash::success('Entry imported successfully');
                return redirect()->back()->with('response','Data was imported successfully!');
            }else{
             Flash::error('Select File To Import');
            return redirect()->back()->with('response','Select File Import!');
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


}

@extends('layouts.master')
@section('content')

<style>
    #leads-table td:first-child {
        text-align: center !important;
    }

    #leads-table td:nth-child(2) {
        font-weight: bold !important;
    }

    #leads-table td:last-child a {
        margin: 0 2px;
    }

    tr {
        text-align: center;
    }

    #nameInput,
    #productInput,
    #statusInput,
    #ratingInput {
        background-image: url('/images/searchicon.png');
        /* Add a search icon to input */
        background-position: 10px 12px;
        /* Position the search icon */
        background-repeat: no-repeat;
        /* Do not repeat the icon image */
        font-size: 16px;
        /* Increase font-size */
        padding: 12px 12px 12px 40px;
        /* Add some padding */
        border: 1px solid #ddd;
        /* Add a grey border */
        margin-bottom: 12px;
        /* Add some space below the input */
        margin-right: 5px;
    }

    tr {
        text-align: left !important;
    }

    .openlink:hover {
        color: blue;
        cursor: pointer;
    }

    .blink_me {
  animation: blinker 1s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}
.thumbnail{
    max-width: 100px !important;
    max-height: 100px !important;
    height: auto;
    float: left;
}
</style>

<section class="content-header" style="margin-top: -35px; margin-bottom: 20px">
    <h1>
        Just In Tasks!
        <small>Tasks that are just created</small>
    </h1>

    {{ TaskHelper::topSubMenu('topsubmenu.projects')}}
    {!! MenuBuilder::renderBreadcrumbTrail(null, 'root', false) !!}
</section>

<div class='row'>
    <div class='col-md-12 box'>
        <!-- Box -->
        {!! Form::open( array('route' => 'admin.leads.enable-selected', 'id' => 'frmLeadList') ) !!}
        <div class="box">
            <div class="box-header">

                <div class="wrap" style="margin-top:5px;">
                    <div class="filter form-inline" style="margin:0 30px 0 0;">
                        <a class="btn btn-default btn-sm" href="#" onclick="openwindow()" title="admin/projects/general.button.create">
                            <i class="fa fa-edit"></i> Quick Task
                        </a>
                        {!! Form::text('start_date', \Request::get('start_date'), ['style' => 'width:120px;', 'class' => 'form-control', 'id'=>'start_date_project', 'placeholder'=>'Start Date']) !!}&nbsp;&nbsp;
                        <!-- <label for="end_date" style="float:left; padding-top:7px;">End Date: </label> -->
                        {!! Form::text('end_date', \Request::get('end_date'), ['style' => 'width:120px; display:inline-block;', 'class' => 'form-control', 'id'=>'end_date_project', 'placeholder'=>'End Date']) !!}&nbsp;&nbsp;

                        {!! Form::select('user_id', ['' => 'Select user'] + $users, \Request::get('user_id'), ['id'=>'filter-user-project', 'class'=>'form-control', 'style'=>'width:110px; display:inline-block;']) !!}
                        &nbsp;&nbsp;

                        {!! Form::select('status_id', ['' => 'select','new' => 'New','ongoing' => 'ongoing','completed'=>'completed'], \Request::get('status_id'), ['id'=>'filter-status-project', 'class'=>'form-control', 'style'=>'width:100px; display:inline-block;']) !!}&nbsp;&nbsp;

                        <span class="btn btn-primary btn-sm" id="btn-submit-filter-project-task">
                            <i class="fa fa-list"></i> {{ trans('admin/projects/general.button.filter') }}
                        </span>

                        <span class="btn btn-default btn-sm" id="">
                            <i class="fa fa-list"></i>

                            <a href="/admin/project_tasks">{{ trans('admin/projects/general.button.reset') }}</a>
                        </span>




   <span class="pull-right">
                <form method="GET" action="/admin/projects/search/tasks/">
                 <div class="input-group input-group-sm hidden-xs" style="width: 260px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search Tasks">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                  </div>
                </div>
                </form>

   </span>
    </div></div>



            </div>
            <div class="box-body col-md-9">


                <div class="">
                    <table class="table table-hover table-no-border table-striped" id="leads-table">
                        <thead>
                            <tr class="bg-info">
                                <th>Task #</th>
                                <th></th>
                            <th>{{ trans('admin/projects/general.columns.project_task') }}</th>
                                <th>{{ trans('admin/projects/general.columns.end_date') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if(isset($projects_tasks) && !empty($projects_tasks))
                            @foreach($projects_tasks as $lk => $lead)
                            <tr>

                                <td>{{\FinanceHelper::getAccountingPrefix('PROJECT_TASK_PRE')}}{{ $lead->id }}</td>

                                <td>

                                </td>

                                <td title="{{ $lead->desciption}}"><span class="" style="font-size: 20px !important">
                                         <span class="openlink" id="{{$lead->id}}">
                                            @if($lead->status == 'completed')
                                            <span style="color: gray">{!! $lead->subject !!}</span>
                                            @else
                                             {!! $lead->subject !!}
                                             @endif

                                        </span>
                                        <mark><?php
                                        if(!empty($lead->category_id)){
                                           echo $lead->category->name ;
                                        }
                                        ?></span></mark>
                                    </span>

              <div class="user-block ">

                    <img src="/images/profiles/{{$lead->user->image ? $lead->user->image:'logo.png'}}" class="img-circle img-bordered-sm" style="width: 22px;height: 22px;" alt="User Imagefff">
                        <span class="username">
                          <a href="/admin/profile/show/{{ $lead->user->id}}">{{ substr($lead->user->first_name,0,8)." ".substr($lead->user->last_name,0,15) }}</a>
                          <small>{{ $lead->user->designation->designations }}</small>

                        </span>
                        <small>
                     @if($lead->status == 'new')
                    <span class="description blink_me"> Created {{Carbon\Carbon::parse($lead->created_at)->diffForHumans()}}</span>
                     @else
                     <span class="description">  {{Carbon\Carbon::parse($lead->created_at)->diffForHumans()}}</span>
                     @endif

                     <?php
                if($lead->status == 'completed'){
                    echo '<i style="color:green" class="fa fa-check-circle"></i> completed';
                }elseif($lead->status == 'ongoing'){
                    echo '<i class="fa fa-refresh fa-spin"></i> ongoing';

                }else{
                     echo 'new';
                }

                ?>

                    in {{ $lead->project->name}}
                    </small>
                  </div>

                  <i style="color:lightgray" class="fa fa-user-plus"></i> involves {{$lead->peoples}} &nbsp; &nbsp;
                  <span class="text-muted">
                  <i style="color:" class="fa fa-commenting"> </i> {{ \TaskHelper::comment_count($lead->id)}} </span>


                  
                    <div class="col-md-12" style="padding-top:8px">
                        <div class="card">
                            <div class="card-body">
                                
                                <div class="row">
                                   

                            <?php 
                            $task_attachments = \App\Models\ProjectTaskAttachment::where('task_id', $lead->id)->get();

                            ?>


                                    @foreach($task_attachments as $key => $ta)
                                    @if(is_array(getimagesize(public_path().'/task_attachments/'.$ta->attachment)))
                                    <div class="">
                                        <div class="thumbnail img-responsive img-enlargable">
                                            <a href="/task_attachments/{{$ta->attachment}}" download="{{$ta->attachment}}">

                                                <img src="/task_attachments/{{$ta->attachment}}" alt="task_img" style="height: 88px;">
                                                <div class="caption" style=" border-top: 1px solid black;">
                                                    <p style="padding: 0; margin: 0;">
                                                        {{ substr($ta->attachment,-10) }}..
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    @else
                                    <div class="">
                                        <div class="thumbnail img-responsive img-enlargable">
                                            <a href="/task_attachments/{{$ta->attachment}}" download="{{$ta->attachment}}">

                                                <span class="mailbox-attachment-icon" style="height: 120px;"><i class="fa fa-file-pdf-o"></i></span>

                                                <div class="caption" style="padding: 0 !important;margin-top: -15px; border-top: 1px solid black;">
                                                    <p style="padding: 0; margin: 0;">
                                                        {{ substr($ta->attachment,-10) }}..
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>

                            </td>
                                </td>
                                <td>
                                     <mark><small>

                                    <?php

                                    echo Carbon\Carbon::parse($lead->end_date)->diffForHumans();

                                    ?>
                                </small>
                                </mark>
                            </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>



                </div> <!-- table-responsive -->



            </div><!-- /.box-body -->

  <div class="col-md-3">
                <span style="font-weight: bold;font-size: 16px; padding-bottom: 15px"> Comments</span>
                <div class="box-widget">
                <div class="box-footer box-comments">



            @foreach($comments as $k => $v)
                <!-- /.box-comment -->
              <div style="padding-bottom: 12px; padding-top: 12px; " class="box-comment">
                <!-- User image -->
                <img style="float: left; margin-right: 5px" width="25px" height="25px" class="img-circle img-sm" src="/images/profiles/{{$v->user->image ? $v->user->image : 'logo.png'}}" alt="User Image">

                <div class="comment-text">
                      <span class="username">

                        <a href="/admin/profile/show/{{ $v->user->id}}">
                        {{ substr($v->user->first_name,0,8)." ".substr($v->user->last_name,0,15) }}</a>

                        in <span class="text-muted">{{ $v->task->subject}}</span><br/>

                      </span><!-- /.username -->
                   {!! mb_substr($v->comment_text,0,300) !!}
                   <small>
                  <span class="text-muted pull-right">{{Carbon\Carbon::parse($v->created_at)->diffForHumans()}}</span></small>
                </div>
                <br/>
                <!-- /.comment-text -->
              </div>

              @endforeach


            </div>
        </div>


         <span style="font-weight: bold;font-size: 16px; padding-bottom: 15px"> Activities</span>
                <div class="box-widget">
                <div class="box-footer box-comments">



            @foreach($activityx as $k => $v)
                <!-- /.box-comment -->
              <div style="padding-bottom: 12px; padding-top: 12px; " class="box-comment">
                <!-- User image -->
                <img style="float: left; margin-right: 7px" width="25px" height="25px" class="img-circle img-sm" src="/images/profiles/{{$v->user->image ? $v->user->image : 'logo.png'}}" alt="User Image">

                <div class="comment-text">
                      <span class="username">

                        <a href="/admin/profile/show/{{ $v->user->id}}">
                        {{ substr($v->user->first_name,0,8)." ".substr($v->user->last_name,0,15) }}</a>
                      </span><!-- /.username -->
                   {!! mb_substr($v->activity,0,100) !!}
                   <small>
                      <span class="text-muted">{{ $v->task->subject}}</span>
                  <span class="text-muted pull-right">{{Carbon\Carbon::parse($v->created_at)->diffForHumans()}}</span></small>
                </div>
                <br/>
                <!-- /.comment-text -->
              </div>

              @endforeach


            </div>
        </div>
            </div>


            <div style="text-align: center;"> {!! $projects_tasks->render() !!} </div>


        </div><!-- /.box -->

        <div role="dialog" class="modal fade" id="sendSMS" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width:500px;">
                <!-- Modal content-->
                <div class="modal-content">
                    <div style="background:green; color:#fff; text-align:center; font-weight:bold;" class="modal-header">
                        <button data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Send SMS</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <!-- <span>Note: Maximum 138 character limit</span><br/> -->
                            <!-- <textarea rows="3" name="message" class="form-control" id="compose-textarea" onBlur="countChar(this)" placeholder="Type your message." maxlength="138"></textarea> -->
                            <textarea rows="3" name="message" class="form-control" id="compose-textarea" placeholder="Type your message."></textarea>
                            <!-- <span class="char-cnt"></span> -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="document.forms['frmLeadList'].action = '{!! route('admin.leads.send-sms') !!}';  document.forms['frmLeadList'].submit(); return false;" title="{{ trans('general.button.disable') }}" class="btn btn-primary">{{ trans('general.button.send') }}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('general.button.cancel') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="lead_type" id="lead_type" value="{{\Request::get('type')}}">
        {!! Form::close() !!}

    </div><!-- /.col -->

</div><!-- /.row -->
@endsection


<!-- Optional bottom section for modals etc... -->
@section('body_bottom')

<script language="JavaScript">
    function toggleCheckbox() {
        checkboxes = document.getElementsByName('chkLead[]');
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = !checkboxes[i].checked;
        }
    }

</script>

<script src="{{ asset ("/bower_components/admin-lte/plugins/daterangepicker/moment.js") }}" type="text/javascript"></script>
<link href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap-datetimepicker.css") }}" rel="stylesheet" type="text/css" />
<script src="{{ asset ("/bower_components/admin-lte/bootstrap/js/bootstrap-datetimepicker.js") }}" type="text/javascript"></script>

<script>
    function openwindow() {
        var win = window.open(`/admin/project_tasks/create/task-global-modal`, '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=500,left=500,width=400, height=560');
    }

    function HandlePopupResult(result) {
        if (result) {
            location.reload();
            let tasks = result.task;
            var newtaskid = result.id;
            setTimeout(function() {
                $('#new').prepend(tasks);
                $("#ajax_status").after("<span style='color:green;' id='status_update'>Task sucessfully created</span>");
                $('#status_update').delay(3000).fadeOut('slow');
                jQueryTaskStuff(`.new${newtaskid}`);
            }, 500);
        } else {
            $("#ajax_status").after("<span style='color:red;' id='status_update'>failed to create Task</span>");
            $('#status_update').delay(3000).fadeOut('slow');
        }
    }

    $(function() {
        $('#start_date_project').datetimepicker({
            //inline: true,
            format: 'YYYY-MM-DD HH:mm'
            , sideBySide: true
        });
        $('#end_date_project').datetimepicker({
            //inline: true,
            format: 'YYYY-MM-DD HH:mm'
            , sideBySide: true
        });
    });

</script>
<script>
    $("#btn-submit-filter-project-task").on("click", function() {

        user_id = $("#filter-user-project").val();
        start_date = $("#start_date_project").val();
        end_date = $("#end_date_project").val();
        status_id = $("#filter-status-project").val();


        window.location.href = "{!! url('/') !!}/admin/project_tasks?user_id=" + user_id + "&start_date=" + start_date + "&end_date=" + end_date + "&status_id=" + status_id;
    });

</script>

<script>
    function HandlePeopleChanges(prams, task_ids, isChanged) { // this function is called from another window
        if (prams) {
            console.log(prams);
            $.post("/admin/ajaxTaskPeopleUpdate", {
                    id: task_ids
                    , peoples: prams
                    , _token: $('meta[name="csrf-token"]').attr('content')
                }
                , function(data) {
                    console.log(data);
                    //alert("Data: " + data + "\nStatus: " + status);
                });
        }
        if (isChanged) {
            location.reload();
        }

    }

    function UpdateChanges(isChanged) {
        if (isChanged) {
            location.reload();
        }
    }


    $('.openlink').click(function() {
        let id = this.id;
        //window.open('/admin/project_task/'+id);
        window.open('/admin/project_task/' + id, '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=0,left=100,width=999, height=660');
    });



    function searchName() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("nameInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("leads-table");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[2];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function searchProduct() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("productInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("leads-table");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[3];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function searchStatus() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("statusInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("leads-table");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[6];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function searchRating() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("ratingInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("leads-table");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[7];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

</script>

@endsection

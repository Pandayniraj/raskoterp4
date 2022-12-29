<?php

namespace App\Http\Controllers;

use App\Models\MarriageRegistration;
use App\Models\StockMove;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * THIS CONTROLLER IS USED AS PRODUCT CONTROLLER.
 */
class MarriageRegistrationController extends Controller
{
    public function index()
    {
        $marriageregistration = MarriageRegistration::orderBy('id', 'desc')->get();

        $page_title = 'Marriage Registration';
        $page_description = 'lists';

        return view('admin.marriage-registration.index', compact('page_title', 'page_description', 'marriageregistration'));
    }

    public function create()
    {
        $page_title = 'Admin | Marriage Registration | Create';
        $page_description = 'for creating Marriage Registration';
        
        return view('admin.marriage-registration.create', compact('page_title', 'page_description'));
    }

    public function store(Request $request)
    {
        $attributes = $request->all();
        // dd($attributes);
        $attributes['user_id']=\auth()->user()->id;
        if ($request->file('groom_photo')) {
            $files = $request->file('groom_photo');
            $doc_name = time() . "" . $files->getClientOriginalName();
            $destinationPath = public_path('/groom_photo/');
            $files->move($destinationPath, $doc_name);
            $attributes['groom_photo'] = "/groom_photo/" . $doc_name;

        }
        if ($request->file('bride_photo')) {
            $files = $request->file('bride_photo');
            $doc_name = time() . "" . $files->getClientOriginalName();
            $destinationPath = public_path('/bride_photo/');
            $files->move($destinationPath, $doc_name);
            $attributes['bride_photo'] = "/bride_photo/" . $doc_name;
            
        }
        \DB::beginTransaction();
        $localtax = MarriageRegistration::create($attributes);
        \DB::commit();

        Flash::success('Marriage Registration created Successfully');

        return redirect('/admin/marriage');
    }

    public function edit(Request $request, $id)
    {
        $page_title = 'Admin | Marriage Registration | Edit';
        $page_description = '';
        
        $marriageregistration = MarriageRegistration::where('id', $id)->first();

        return view('admin.marriage-registration.edit', compact('page_title', 'page_description','marriageregistration'));
    }

    public function update(Request $request, $id)
    {
        $attributes = $request->except('_token');
        $attributes['user_id']=\auth()->user()->id;
        if ($request->file('groom_photo')) {
            $files = $request->file('groom_photo');
            $doc_name = time() . "" . $files->getClientOriginalName();
            $destinationPath = public_path('/groom_photo/');
            $files->move($destinationPath, $doc_name);
            $attributes['groom_photo'] = "/groom_photo/" . $doc_name;

        }
        if ($request->file('bride_photo')) {
            $files = $request->file('bride_photo');
            $doc_name = time() . "" . $files->getClientOriginalName();
            $destinationPath = public_path('/bride_photo/');
            $files->move($destinationPath, $doc_name);
            $attributes['bride_photo'] = "/bride_photo/" . $doc_name;
            
        }
        \DB::beginTransaction();
        MarriageRegistration::where('id', $id)->update($attributes);
        \DB::commit();

        Flash::success('Marriage Registration Updated Succesfully.');

        return redirect('/admin/marriage');
    }

}

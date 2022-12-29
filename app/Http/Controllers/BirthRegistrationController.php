<?php

namespace App\Http\Controllers;

use App\Models\BirthRegistration;
use App\Models\StockMove;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * THIS CONTROLLER IS USED AS PRODUCT CONTROLLER.
 */
class BirthRegistrationController extends Controller
{
    public function index()
    {
        $birthregistration = BirthRegistration::orderBy('id', 'desc')->get();

        $page_title = 'Birth Registration';
        $page_description = 'lists';

        return view('admin.birth-registration.index', compact('page_title', 'page_description', 'birthregistration'));
    }

    public function create()
    {
        $page_title = 'Admin | Birth Registration | Create';
        $page_description = 'for creating Birth Registration';
        
        return view('admin.birth-registration.create', compact('page_title', 'page_description'));
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
        $localtax = BirthRegistration::create($attributes);
        \DB::commit();

        Flash::success('Birth Registration created Successfully');

        return redirect('/admin/birth');
    }

    public function edit(Request $request, $id)
    {
        $page_title = 'Admin | Birth Registration | Edit';
        $page_description = '';
        
        $birthregistration = BirthRegistration::where('id', $id)->first();

        return view('admin.birth-registration.edit', compact('page_title', 'page_description','birthregistration'));
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
        BirthRegistration::where('id', $id)->update($attributes);
        \DB::commit();

        Flash::success('Birth Registration Updated Succesfully.');

        return redirect('/admin/birth');
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\MigrationRegistration;
use App\Models\StockMove;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * THIS CONTROLLER IS USED AS PRODUCT CONTROLLER.
 */
class MigrationRegistrationController extends Controller
{
    public function index()
    {
        $migrationregistration = MigrationRegistration::orderBy('id', 'desc')->get();

        $page_title = 'Migration Registration';
        $page_description = 'lists';

        return view('admin.migration-registration.index', compact('page_title', 'page_description', 'migrationregistration'));
    }

    public function create()
    {
        $page_title = 'Admin | Migration Registration | Create';
        $page_description = 'for creating Migration Registration';
        
        return view('admin.migration-registration.create', compact('page_title', 'page_description'));
    }

    public function store(Request $request)
    {
        $attributes = $request->all();
        // dd($attributes);
        $attributes['user_id']=\auth()->user()->id;
        \DB::beginTransaction();
        $localtax = MigrationRegistration::create($attributes);
        \DB::commit();

        Flash::success('Migration Registration created Successfully');

        return redirect('/admin/migration');
    }

    public function edit(Request $request, $id)
    {
        $page_title = 'Admin | Migration Registration | Edit';
        $page_description = '';
        
        $migrationregistration = MigrationRegistration::where('id', $id)->first();

        return view('admin.migration-registration.edit', compact('page_title', 'page_description','migrationregistration'));
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
        MigrationRegistration::where('id', $id)->update($attributes);
        \DB::commit();

        Flash::success('Migration Registration Updated Succesfully.');

        return redirect('/admin/migration');
    }

}

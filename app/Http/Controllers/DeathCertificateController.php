<?php

namespace App\Http\Controllers;

use App\Models\DeathCertificate;
use App\Models\StockMove;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * THIS CONTROLLER IS USED AS PRODUCT CONTROLLER.
 */
class DeathCertificateController extends Controller
{
    public function index()
    {
        $deathcertificate = DeathCertificate::orderBy('id', 'desc')->get();

        $page_title = 'Death Certificate';
        $page_description = 'lists';

        return view('admin.death-certificate.index', compact('page_title', 'page_description', 'deathcertificate'));
    }

    public function create()
    {
        $page_title = 'Admin | Death Certificate | Create';
        $page_description = 'for creating Death Certificate';
        
        return view('admin.death-certificate.create', compact('page_title', 'page_description'));
    }

    public function store(Request $request)
    {
        $attributes = $request->all();
        // dd($attributes);
        $attributes['user_id']=\auth()->user()->id;
        \DB::beginTransaction();
        $localtax = DeathCertificate::create($attributes);
        \DB::commit();

        Flash::success('Death Certificate created Successfully');

        return redirect('/admin/death');
    }

    public function edit(Request $request, $id)
    {
        $page_title = 'Admin | Death Certificate | Edit';
        $page_description = '';
        
        $deathcertificate = DeathCertificate::where('id', $id)->first();

        return view('admin.death-certificate.edit', compact('page_title', 'page_description','deathcertificate'));
    }

    public function update(Request $request, $id)
    {
        $attributes = $request->except('_token');
        $attributes['user_id']=\auth()->user()->id;
        \DB::beginTransaction();
        DeathCertificate::where('id', $id)->update($attributes);
        \DB::commit();

        Flash::success('Death Certificate Updated Succesfully.');

        return redirect('/admin/death');
    }

}

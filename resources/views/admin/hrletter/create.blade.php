@extends('layouts.master')

@section('head_extra')
    <!-- Select2 css -->
    @include('partials._head_extra_select2_css')
@endsection

@section('content')

<section class="content-header" style="margin-top: -35px; margin-bottom: 20px">
            <h1>
                {{ $page_title ?? "Page Title" }}
                <small>{!! $page_description ?? "Page description" !!}</small>
            </h1>
            <p>Template Vars: <pre> {{first_name}} {{last_name}} designation mobile_phone email address basic_salary home_phone department</pre> start and followed by double curly brackets. Or select ant templates to see examples</p>

            {!! MenuBuilder::renderBreadcrumbTrail(null, 'root', true)  !!}
        </section>

    <div class='row'>
        <div class='col-md-12'>
            <div class="box box-body">
                {!! Form::open( ['route' => 'admin.hrletter.store','class'=>'form-horizontal', 'id' => 'form_edit_proposal'] ) !!}

                @include('partials._hrletter_form')
                
                <div class="form-group">
                    {!! Form::submit( trans('general.button.create'), ['class' => 'btn btn-primary', 'id' => 'btn-submit-edit'] ) !!}
                    <a href="{!! route('admin.hrletter.index') !!}" title="{{ trans('general.button.cancel') }}" class='btn btn-default'>{{ trans('general.button.cancel') }}</a>
                </div>
                
                {!! Form::close() !!}

            </div><!-- /.box-body -->
        </div><!-- /.col -->

    </div><!-- /.row -->



@endsection

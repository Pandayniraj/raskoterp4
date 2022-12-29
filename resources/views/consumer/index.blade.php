@extends('layouts.master')
@section('content')

<section class="content-header" style="margin-top: -35px; margin-bottom: 20px">
    <h1>
        {{ $page_title }}
        <small>उपभोक्ता समिति व्यवस्थापन</small>
    </h1>

    {!! MenuBuilder::renderBreadcrumbTrail(null, 'root', false) !!}
</section>

<div class="box box-primary">
    <div class="box-header with-border">
        <div class='row'>
            <div class='col-md-12'>
           
                <div style="display: inline;">
                    <a class="btn btn-primary btn-sm" title="Create New Ticket" href="{{ route('consumer.create') }}">
                        <i class="fa fa-plus"></i>&nbsp;<strong> 
                        {{-- {{ trans('admin/ticket/general.button.create') }}--}}create</strong> 
                    </a>
                </div>

                <div class="box-tools pull-right">
                           <input type="text" class="input-sm" placeholder="Type to search" id='search-term'>
                           <button class="btn btn-primary btn-sm" id='search' type="button"><i class="fa fa-search"></i>&nbsp;Search</button>
                           <button class="btn btn-danger btn-sm"  id='clear'><i class="fa fa-close"></i>&nbsp;Clear</button>
                        </div>

            </div>
        </div>

        <div class="tab-responsive">
       		<table class="table table-striped">
            
                <thead>
                    <tr>
                        <th>प्रकार</th>
                        <th>उपभोक्ता समितिको नाम </th>
                        <th>ठेगाना </th>
                        <th>सम्पर्क नं</th>
                        <th>बैकको नाम, शाखा</th>
                        <th>बैक खाता नं.</th>
                        <th></th>

                    </tr>

                </thead>

                <tbody>
               @foreach ($consumers as $key => $consumer)
                    <tr>
                        <td>{{ $consumer->Type}}</td>
                        <td>{{ $consumer->Name}}</td>
                        <td>{{ $consumer->Address}}</td>
                        <td>{{ $consumer->ContactNumber}}</td>
                        <td>{{ $consumer->NameOfBank}}</td>
                        <td>{{ $consumer->BankAccountNo}}</td>
                        <td>{{ $consumer->ToAmount}}</td>
                        <td>
                            <a href="{!! route('consumer.edit', $consumer->Id) !!}" title="{{ trans('general.button.edit') }}"><i class="fa fa-edit"></i></a>
                            <a href="{!! route('consumer.delete', $consumer->Id) !!}" onclick="return confirm('Are you sure you want to delete this item?');" title="{{ trans('general.button.delete') }}"><i class="fa fa-trash deletable"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>

            </table>
        </div>


    </div>
</div>

<script type="text/javascript">
    

      $('#search').click(function(){
            let val =  $('#search-term').val();
            window.location.href = `{{ url('/') }}/admin/chalani?term=${val}`;
        });
        $('#clear').click(function(){
            window.location.href = `{{ url('/') }}/admin/chalani`;
        });
</script>
@endsection
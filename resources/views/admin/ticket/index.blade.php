@extends('layouts.master')
@section('content')

<section class="content-header" style="margin-top: -35px; margin-bottom: 20px">
    <h1>
        {{ $page_title }}
        <small>View Tickets</small>
    </h1>

    {{ TaskHelper::topSubMenu('topsubmenu.hr')}}


    {!! MenuBuilder::renderBreadcrumbTrail(null, 'root', false) !!}
</section>

<div class="box box-primary">
    <div class="box-header with-border">
        <div class='row'>
            <div class='col-md-12'>
                 <div class="box-tools pull-right">
                           <input type="text" class="input-sm" placeholder="{{ trans('admin/ticket/general.placeholder.search') }}" id='search-term'>
                           <button class="btn btn-primary btn-sm" id='search' type="button"><i class="fa fa-search"></i>&nbsp;{{ trans('admin/ticket/general.button.search') }}</button>
                           <button class="btn btn-danger btn-sm"  id='clear'><i class="fa fa-close"></i>&nbsp;{{ trans('admin/ticket/general.button.clear') }}</button>
                        </div>

                <div style="display: inline;">
                    <a class="btn btn-primary btn-sm" title="Create New Ticket" href="{{ route('admin.ticket.create') }}">
                        <i class="fa fa-plus"></i>&nbsp;<strong> 
                        {{ trans('admin/ticket/general.button.create') }}</strong>
                    </a>
                </div>
            </div>
        </div>





            <div class="tab-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ trans('admin/ticket/general.columns.ticket') }}</th>
                            <th>{{ trans('admin/ticket/general.columns.last_updated') }}</th>
                            <th>{{ trans('admin/ticket/general.columns.subject') }}</th>
                            <th>{{ trans('admin/ticket/general.columns.from') }}</th>
                            <th>{{ trans('admin/ticket/general.columns.status') }}</th>
                            <th>{{ trans('admin/ticket/general.columns.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($tickets as $key=>$ticket)
                            <tr @if($ticket->form_source == 'external') class="bg-info" @endif>
                                
                                <td>#{{  $ticket->ticket_number }}</td>
                                <td>{{  date('Y/m/d h:i A',strtotime($ticket->created_at)) }}</td>
                                <td> <a href="{{ route('admin.ticket.show',$ticket->id) }}" class="text-muted"> {{ $ticket->issue_summary }} </a></td>
                                <td>@if($ticket->from_user??'') {{$ticket->from_user}} &lt;<a href="mailto:{{$ticket->from_email}}">{{$ticket->from_email}}</a>&gt; @else {{ $ticket->user->first_name??'' }}  {{ $ticket->user->last_name??'' }} &lt;<a href="mailto:{{ $ticket->user->email??'' }}">{{ $ticket->user->email??''}}</a> &gt;@endif </td>
                                <td> 
                                    @if($ticket->ticket_status == 1)
                                     <label class="label label-default">Open</label>
                                    @elseif($ticket->ticket_status == 2)
                                     <label class="label label-success">Resolved</label>
                                    @else
                                     <label class="label label-danger">Closed</label>
                                    @endif
                                   
                                </td>

                                <td>
                                @if ( $ticket->isEditable()  )
                                    <a href="{!! route('admin.ticket.edit', $ticket->id) !!}" title="{{ trans('general.button.edit') }}"><i class="fa fa-edit"></i></a>
                                @else
                                    <i class="fa fa-edit text-muted" title="{{ trans('admin/cases/general.error.cant-edit-this-document') }}"></i>
                                @endif
                                @if ( $ticket->isDeletable() )
                                    <a href="{!! route('admin.ticket.confirm-delete', $ticket->id) !!}" data-toggle="modal" data-target="#modal_dialog" title="{{ trans('general.button.delete') }}"><i class="fa fa-trash deletable"></i></a>
                                @else
                                    <i class="fa fa-trash text-muted" title="{{ trans('admin/cases/general.error.cant-delete-this-document') }}"></i>
                                @endif

                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            


<div style="text-align: center;"> {!! $tickets->appends(\Request::except('page'))->render() !!} </div>
        </div>


    </div>
</div>

<script type="text/javascript">
    

      $('#search').click(function(){
            let val =  $('#search-term').val();
            window.location.href = `{{ url('/') }}/admin/ticket?term=${val}`;
        });
        $('#clear').click(function(){
            window.location.href = `{{ url('/') }}/admin/ticket`;
        })
</script>
@endsection
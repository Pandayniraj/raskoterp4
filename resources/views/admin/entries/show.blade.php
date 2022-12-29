@extends('layouts.master')
@section('content')

<div class="col-xs-12">
          <div class="box">
              <div class="box-header with-border">
                <h1>{{ \Auth::user()->organization->organization_name }}</h1>
                <p> {{ \Auth::user()->organization->address }} </p>
                <h2 style="font-size: 16.5px;font-weight: bold;">{{\FinanceHelper::get_entry_type_name($entries->entrytype_id)}} Voucher</h2>
              </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div>
			            	Number : {{$entries->number}}
                    <br>Date : {{ $entries->date }} / {{ TaskHelper::getNepaliDate($entries->date) }}
                    <br>
                    <br>
                    <table class="table table-bordered">
                      <tbody>
                        <tr class="bg-info">
                          <th>Dr/Cr</th>
                          <th>Ledger</th>
                          <th>Dr Amount (IDR)</th>
                          <th>Cr Amount (IDR)</th>
                          <th>Narration</th>
                        </tr>
                        @foreach($entriesitem as $items)
                        <tr>
                          <td>@if($items->dc == 'D') Dr @else Cr @endif</td>
                          <td>[{{$items->ledgerdetail->code}}] {{$items->ledgerdetail->name}}</td>
                          @if($items->dc == 'D')
                          <td>{{number_format($items->amount,2)}}</td>
                          <td></td>
                          @else
                          <td></td>
                          <td>{{number_format($items->amount,2)}}</td>
                          @endif
                          <td>{{$items->narration}}</td>
                        </tr>
                        @endforeach
                        <tr>
                          <td></td>
                          <td><strong>Total</strong></td>
                          <td style="font-size: 16.5px"><strong>Dr {{number_format($entries->dr_total,2)}}</strong></td>
                          <td style="font-size: 16.5px"><strong>Cr {{number_format($entries->cr_total,2)}}</strong></td>
                          <td></td>
                        </tr>
                       
                      </tbody>
                    </table>
                    <br>Tag : {{ $entries->tagname->title }}<br><br><br>

                    @if($entries->entrytype_id == 14)
                    Approved by: ..............<br><br><br>
                    Received by: ..............<br><br><br>
                    @endif

                    {{ nl2br($entries->notes) }}<br/>
                    Created at: {{ $entries->created_at }}<br/>
                    Created by: {{ $entries->user->username }}<br/>



                    <br/><br/>

          					<a href="/admin/entries/edit/{{$entries->entrytype->label}}/{{$entries->id}}" class="btn btn-primary">Edit</a>
          					<a href="/admin/entries/{{$entries->id}}/confirm-delete" class="btn btn-danger" data-toggle="modal" data-target="#modal_dialog">Delete</a>
          					<a href="/admin/entries" class="btn btn-default">Close</a>
          					<a href="/admin/entries/pdf/{{$entries->entrytype->label}}/{{$entries->id}}" class="btn btn-primary">PDF</a>
                    <a href="/admin/entries/excel/{{$entries->entrytype->label}}/{{$entries->id}}" class="btn btn-success">Excel</a>

          					<a href="/admin/entries/print/{{$entries->entrytype->label}}/{{$entries->id}}" class="btn btn-primary">Print</a>
				         </div>
            </div>
        </div>
</div>


@endsection

<!-- Optional bottom section for modals etc... -->
@section('body_bottom')


@endsection  
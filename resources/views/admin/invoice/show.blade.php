@extends('layouts.master')

@section('head_extra')
<!-- Select2 css -->
@include('partials._head_extra_select2_css')

@endsection

@section('content')
<style>
    .box-comment {
        margin-bottom: 5px;
        padding-bottom: 5px;
        border-bottom: 1px solid #eee;
    }

    .box-comment img {
        float: left;
        margin-right: 10px;
    }

    .username {
        font-weight: bold;
    }

    .comment-text span {
        display: block;
    }

</style>

<div class='row'>
    <div class='col-md-12'>

        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <img width="30%" height="" src="/images/logo-invoice.png">
                        <span class="pull-right">
                            <span>


                            Tax Invoice</span>
                            <a href="/admin/invoice/print/{{ $ord->id }}" target="_blank" class="btn btn-default btn-sm"><i class="fa fa-print"></i> Print</a>

                            <a href="/admin/invoice1">
                                <button type="button" class="btn btn-success btn-sm pull-right">
                                    <i class="fa fa-times-circle"></i> Close
                                </button>
                            </a> &nbsp;

                              


                        </span>
                        @if( $paidAmount >= $ord->total_amount )
                                <td><span class="label label-success">Paid</span></td>
                                @elseif($paidAmount > 0)
                                <td><span class="label label-info">Partial</span></td>
                                @else
                                <td><span class="label label-warning">Unpaid</span></td>
                                @endif
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div align="center" style="background-color: #CCCCCC">
                    @if(!$ord->is_bill_active)
                    {{$ord->void_reason}}
                    @endif
                </div>
                <div class="col-sm-4 invoice-col">
                    <address>
                        <strong>{{ env('APP_COMPANY') }} </strong><br>
                        {{ env('APP_ADDRESS1') }}<br>
                        {{ env('APP_ADDRESS2') }}<br>
                        Phone: {{ env('APP_PHONE1') }}<br>
                        Email: {{ env('APP_EMAIL') }}<br />
                        Sellers PAN: {{ \Auth::user()->organization->vat_id }}
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    To
                    <address>
                        <strong>Name: {{ $ord->name }}</strong><br>
                        {{ $ord->client->name }}<br />
                        Address: {!! nl2br($ord->address ) !!}<br />
                        PAN: {!! $ord->client->vat !!}

                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>{{ ucwords(str_replace("_", " ", ucfirst($ord->order_type)))}} {{\FinanceHelper::getAccountingPrefix('TAX_INVOICE_PRE')}}{{ $ord->id }}</b><br>


                    <b>Bill Date:</b> {{ date("d/M/Y", strtotime($ord->bill_date )) }}<br>
                    <?php $timestamp = strtotime($ord->created_at) ?>
                    <b>Valid Till:</b> {{ date("d/M/Y", strtotime("+30 days", $timestamp )) }}<br>
                    <b>Terms :</b> {!! $ord->terms !!}<br>
                    Generated by: {{ $ord->user->first_name}} {{ $ord->user->last_name}}<br>
                    <b>Customer Account:</b> #{{ $ord->client_id }}
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            Thank you for choosing {{ env('APP_COMPANY') }}. Your {{ ucwords(str_replace("_", " ", ucfirst($ord->order_type)))}} is detailed below. If you find errors or desire certain changes, please contact us.
            <hr />
            <!-- Table row -->
            <div class="row col-xs-12 table-responsive">
                <div class="col-xs-12 table-responsive">
                    <table id="t01" class="table table-striped">
                        <thead class="bg-gray">
                            <tr>

                                <th>Particulars</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orderDetails as $odk => $odv)
                            <tr>
                                @if($odv->is_inventory == 1)
                                <td style="font-size: 16.5px">{{ $odv->product->name }}</td>
                                @elseif($odv->is_inventory == 0)
                                <td>{{ $odv->description }}</td>
                                @endif
                                <td>{{ $odv->price }}</td>
                                <td>{{ $odv->quantity }}</td>
                                <td>{{ $odv->units->name }}</td>
                                <td>{{ env('APP_CURRENCY').' '.$odv->total }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->


            <div class="row">
                <!-- accepted payments column -->
                <div class="col-xs-6">

                    <?php
           $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
           ?>

                    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;text-transform: capitalize;font-size: 16,5px">
                        In Words: {{ $f->format($ord->total_amount)}}
                    </p>


                    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                        Above information is only an estimate of services/goods described above.
                    </p>

                    <h4> Special Notes and Instruction</h4>
                    <p class="text-muted well well-sm well-primary no-shadow" style="margin-top: 10px;">
                        {!! nl2br($ord->comment) !!}
                    </p>

                    <p class="text-muted well well-sm well-success no-shadow" style="margin-top: 10px;">
                        ___________________________________

                        <br>Authorized Signature
                    </p>
                </div>
                <!-- /.col -->
                <div class="col-xs-6">


                    <div>
                        <table id="" class="table-responsive table table-striped">
                            <tbody>
                                <tr style="padding:0px; margin:0px;">
                                    <th style="width:50%">Sub Total:</th>
                                    <td>{{ env('APP_CURRENCY').' '. number_format($ord->subtotal,2) }}</td>
                                </tr>
                                <tr style="padding:0px; margin:0px;">
                                    <th style="width:50%">Discount Amount</th>
                                    <td>{{env('APP_CURRENCY')}} {{$ord->discount_amount }}</td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Taxable Amount</th>
                                    <td>{{env('APP_CURRENCY').' '. number_format($ord->taxable_amount,2) }}</td>
                                </tr>
                                <tr style="padding:0px; margin:0px;">
                                    <th style="width:50%">Tax Amount(13%):</th>
                                    <td>{{ env('APP_CURRENCY').' '. number_format($ord->tax_amount,2) }}</td>
                                </tr>
                                <tr style="padding:0px; margin:0px;">
                                    <th style="width:50%">Total:</th>
                                    <td>{{ env('APP_CURRENCY').' '. number_format($ord->total_amount,2) }}</td>
                                </tr>
                                <!--   <tr>
                <th>Discount:</th>
                <td>{{ env('APP_CURRENCY').' '.($ord->discount_amount ? $ord->discount_amount : '0') }}</td>
              </tr>
              <tr>
                <th>Tax Amount</th>
                <td>{{ env('APP_CURRENCY').' '.$ord->total_tax_amount }}</td>
              </tr>

              <tr>
                <th>Total:</th>
                <td>{{ env('APP_CURRENCY').' '.$ord->total }}</td>
              </tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
                <div class="col-xs-12">



                </div>
            </div>
        </section>



    </div><!-- /.col -->

</div><!-- /.row -->

@endsection

@section('body_bottom')
<!-- Select2 js -->
@include('partials._body_bottom_select2_js_user_search')
@endsection

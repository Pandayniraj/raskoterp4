
<!DOCTYPE html>
<html>
<head>
 <link href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
<style type="text/css">
  .table td, .table th {
    border: none !important;
}
 @media print {

          @page { margin: 0; }

          body { margin: 1.6cm; }

        }
</style>
</head>
<body onload="window.print()">


<div class='row' style="padding-left: 10px;margin-right: 3px;">
   <div class='col-md-12' id='printElement'>
      <!-- title row -->
      <div class="row">
         <div class="col-xs-12">
            <h2 class="">
               <img width="240" src="{{env('APP_URL')}}/{{ '/org/'.$organization->logo }}">
            </h2>
         </div>
         <!-- /.col -->
      </div>
      <!-- info row -->
      <table class="table">
         <tr>
            <td>
               <h2 style="margin-top: -20px;">Credit Note</h2>
               <address>
                  <span style="font-size: 16.5px">{{ env('APP_COMPANY') }} </span><br>
                  {{ env('APP_ADDRESS1') }}<br>
                  {{ env('APP_ADDRESS2') }}<br>
                  Phone: {{ env('APP_PHONE1') }}<br>
                  Email: {{ env('APP_EMAIL') }}<br/>
                  Generated by: {{ $ord->user->first_name}} {{ $ord->user->last_name}}<br>
                  Sellers PAN:  {{ \Auth::user()->organization->vat_id }}
               </address>
            </td>
            <td>
               <table class="table">
                  <tr>
                     <td>
                        To
                        <address>
                           <span style="font-size: 16.5px">{{ $ord->name }}</span><br>
                           Email: @if($ord->source == 'lead'){{ $ord->lead->email }}@else{{ $ord->client->email }}@endif<br>
                           @if($ord->source=='client') {{ $ord->client->name }} @else {{ $ord->lead->name }} @endif
                           <br/>
                           Address: {!! nl2br($ord->address ) !!}<br/>
                           @if($ord->source == 'client') Purchaser's PAN: {!! $ord->customer_pan  !!} @endif
                        </address>
                     </td>
                     <td>
                        <b>Crdit Note Number: #CN{{ $ord->credit_note_no }}</b><br>
                        <b>Bill Date:</b> {{ date("d/M/Y", strtotime($ord->bill_date )) }}<br>
                        <?php $timestamp = strtotime($ord->created_at) ?>
                        <b>Valid Till:</b> {{ date("d/M/Y", strtotime("+30 days", $timestamp )) }}<br>
                        <b>Terms :</b> {!! $ord->terms  !!}<br>
                        <b>{{ ucwords($ord->source) }} Account:</b> #@if($ord->source == 'lead') {{ $ord->lead->id }} @else {{ $ord->client->id }} @endif<br>
                        <b>Source:</b> {{ ucfirst($ord->source) }} 
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
      <!-- /.row -->
      <p>Thank you for choosing us. Your Credit Note is detailed below. If you find errors or desire certain changes, please contact us.
      </p>
      <!-- Table row -->
      <div class="row">
         <div class="col-xs-12 table-responsive">
            <table id="" class="table table-striped">
               <thead class="bg-gray">
                  <tr>
                     <th>Description</th>
                     <th>Price</th>
                     <th>Qty</th>
                     <th>Total</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($orderDetails as $odk => $odv)
                  <tr>
                     @if($odv->is_inventory == 1)
                     <td>{{ $odv->product->name }}</td>
                     @elseif($odv->is_inventory == 0)
                     <td>{{ $odv->description }}</td>
                     @endif
                     <td>{{ $odv->price }}</td>
                     <td>{{ $odv->quantity }}</td>
                     <td>{{ env('APP_CURRENCY').' '.$odv->total }}</td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
         <!-- /.col -->
      </div>
      <div class="row">
         <!-- accepted payments column -->
         <div class="col-xs-6">
            <?php
               $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
               ?>
            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;text-transform: capitalize;font-size: 16.5px">
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
            <div class="table-responsive">
               <table id="" class="table table-striped">
                  <tbody>
                     <tr style="padding:0px; margin:0px;">
                        <th style="width:50%" >Sub Total:</th>
                        <td>{{ env('APP_CURRENCY').' '. number_format($ord->subtotal,2) }}</td>
                     </tr>
                     <tr style="padding:0px; margin:0px;">
                        <th style="width:50%">Discount Amount</th>
                        <td>{{$ord->discount_amount }} </td>
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
                        <td style="font-size: 16.5px">{{ env('APP_CURRENCY').' '. number_format($ord->total_amount,2) }}</td>
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
      <div class="row" style="margin-top: 20px;padding-left: 5px;">

         <div class="col-md-12">
            <div align="center">Thank You for your custom</div>
            <p  style="border-top-style: dashed;margin-top: 20px;"></p>

   
            <!-- /.row -->
            <p><b>Please Deduct this credit from your next payment to us</b></p>
            <div class="row">
               <div class="col-md-8">
                  {{ env('APP_COMPANY') }}, {{ env('APP_ADDRESS1') }},{{ env('APP_PHONE1') }}
               </div>
               <div class="col-md-4">
                  {{ env('APP_EMAIL') }}
               </div>
            </div>
            <br> 
            <!-- /.row -->
            <!-- this row will not appear when printing -->
            <div class="row no-print">
               <div class="col-xs-12">
               </div>
            </div>
         </div>
      </div>
      <!-- /.col -->
   </div>
   <!-- /.row -->
</div>



</body>
</html>


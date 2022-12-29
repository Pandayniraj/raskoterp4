@extends('layouts.master')
@section('content')

<section class="content-header" style="margin-top: -35px; margin-bottom: 20px">
    <h1>
        {{ $page_title }}
        <small>View Plan/Program Registration</small>
    </h1>

   

    {!! MenuBuilder::renderBreadcrumbTrail(null, 'root', false) !!}
</section>

<div class="box box-primary">
    <div class="box-header with-border">
        <div class='row'>
            <div class='col-md-12'>
           
                <div style="display: inline;">
                    <a class="btn btn-primary btn-sm" title="Create New Ticket" href="#">
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
                        <th>दर्ता नं.</th>
                        <th>कार्यक्रम/आयोजना/क्रियाकलापको नाम</th>
                        <th>छेत्र</th>
                        <th>स्रोत/अनुदानको किसिम</th>
                        <th>विनियोजन किसिम</th>
                        <th>वडा नं.</th>
                        <th>विनियोजन रकम</th>
                        <th>भुक्तानी रकम</th>
                        <th>बाँकी रकम</th>
                        <th></th>

                    </tr>

                </thead>

                <tbody>
               @foreach ($plans as $plan )
                   
                    <tr>

                        <td>{{$plan->Id}}</td>
                        <td><a href="{{ route('plan.next', $plan->Id)}}">{{$plan->name}}</a></td>
                        <td>{{$plan->area->Name}}</td>
                        <td>{{$plan->grant->Name}}</td> 
                        <td>{{$plan->appropriation->Name}}</td>
                        <td>{{$plan->ward}}</td>
                        <td>{{$plan->appropriationamt}}</td>
                        <td>0</td>
                        <td>0</td>
                        <td>
                            <a href="{!! route('plan.edit', $plan->Id) !!}" title="{{ trans('general.button.edit') }}"><i class="fa fa-edit"></i></a>
                            <a href="{!! route('plan.delete', $plan->Id) !!}" onclick="return confirm('Are you sure you want to delete this item?');" title="{{ trans('general.button.delete') }}"><i class="fa fa-trash deletable"></i></a>
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
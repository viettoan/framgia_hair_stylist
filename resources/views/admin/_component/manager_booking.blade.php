@extends('admin.master')
@section('style')
    {{ Html::style('bower/AdminLTE/plugins/datatables/dataTables.bootstrap.css') }}
    {{ Html::style('css/admin/style.css') }}
@endsection

@section('content')
    <div class="content-wrapper ">
      <section class="content-header">
        <h1>
            {{ __('Hi Admin 1') }}
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> {{ __('Home') }} </a></li>
          <li><a href="#"> {{ __('Manager') }}</a></li>
          <li class="active"> {{ __('Booking And Customer') }}</li>
        </ol>
    </section>
    <section class="content " id="manager_booking">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ __('Manager Booking') }}</h3>
                </div>
                <div class="box-body over-flow-edit">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Render booking id</th>
                                <th>User id</th>
                                <th>Phone</th>
                                <th>Name</th>
                                <th>Name Stylist</th>
                                <th>Grand total</th>
                                <th>Action</th>
                            </tr>   
                        </thead>
                        <tbody>
                             <tr>
                                <td>1</td>
                                <td>1</td>
                                <td>1</td>
                                <td>123456789</td>
                                <td>User 1</td>
                                <td>Stylist 1</td>
                                <td>80.000</td>
                                <td class=" ">
                                    {{-- <a href="#" class="btn btn-success"><i class="fa fa-search-plus "></i></a> --}}
                                    <a href="#" class="btn btn-info"><i class="fa fa-edit "></i></a>
                                    <a class="btn btn-danger" href="#"><i class="fa fa-trash-o "></i></a>
                                     <a class="btn btn-success" href="javascript:void(0)" v-on:click="showBooking"><i class="fa fa-map-o"></i></a>
                                </td>
                            </tr>  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </section>
    <div class="modal fade" id="showBooking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body" >
                    <h3 class ="text-center"><i>{{ __('Booking #123') }}</i></h3>
                    <h4 class ="text-center">{{ __('FSalon 434 Tran Khac Chan') }}</h4>
                    <div class="row">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('User Name') }}</th>
                                    <th>{{ __('Phone') }}</th>
                                    <th>{{ __('Stylist') }}</th>
                                    <th>{{ __('Service') }}</th>
                                    <td>{{ __('Time') }}</td>
                                    <td>{{ __('Day') }}</td>
                                    <th>{{ __('Grand total') }}</th>
                                </tr>   
                            </thead>
                            <tbody>
                                 <tr>
                                    <td>{{ __('Nguyen Thi Hanh') }}</td>
                                    <td>{{ __('123456789') }}</td>
                                    <td>{{ __('Japan') }}</td>
                                    <td>{{ __('Shammpo') }}</td>
                                    <td>{{ __('15:00 PM') }}</td>
                                    <td>{{ __('15-4-2018') }}</td>
                                    <td>{{ __('100.000 VND') }}</td>
                                </tr>  
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    {{ Html::script('js/admin/manager_booking.js') }}
    {{ Html::script('js/admin/manager_customer.js') }}
    {{ Html::script('bower/AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}
    {{ Html::script('bower/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}
@endsection

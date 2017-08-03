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
            <div class="modal-content border-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h3 class ="text-center"><i>{{ __('Booking #123') }}</i></h3>
                    <h4 class ="text-center">{{ __('FSalon 434 Tran Khac Chan') }}</h4>
                </div>
                <div class="modal-body" >
                    <div class="row">
                        <div class="col-md-12">
                            <div class = "row fix-row" >
                                <div class="col-md-5 text-right">{{ __('Name :') }}</div>
                                <div class="col-md-5 col-md-offset-1">Nguyen Van Nam</div>
                            </div>
                            <div class = "row fix-row" >
                                <div class="col-md-5 text-right">{{ __('Phone :') }}</div>
                                <div class="col-md-5 col-md-offset-1">123456789</div>
                            </div>
                            <div class = "row fix-row" >
                                <div class="col-md-5 text-right">{{ __('Time :') }}</div>
                                <div class="col-md-5 col-md-offset-1">14:00 PM</div>
                            </div>
                            <div class = "row fix-row" >
                                <div class="col-md-5 text-right">{{ __('Day :') }}</div>
                                <div class="col-md-5 col-md-offset-1">15-3-2018</div>
                            </div>
                            <div class = "row fix-row" >
                                <div class="col-md-5 text-right">{{ __('Stylist :') }}</div>
                                <div class="col-md-5 col-md-offset-1">Juli - Fram</div>
                            </div>
                            <div class = "row fix-row" >
                                <div class="col-md-5 text-right">{{ __('Deparment :') }}</div>
                                <div class="col-md-5 col-md-offset-1">FSalon 434 Tra  Khac Chan</div>
                            </div>
                        </div>
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

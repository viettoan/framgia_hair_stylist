@extends('admin.master')
@section('style')
    {{ Html::style('bower/AdminLTE/plugins/datatables/dataTables.bootstrap.css') }}
    {{ Html::style('css/admin/style.css') }}
@endsection

@section('content')
    <div class="content-wrapper ">
    <section class="content-header">
        <h1>
            {{ __('Booking') }}
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
                <div class="box-header" style="position: relative;">
                    <div class="indicator hide list-booking-indicator"></div>

                    <h3 class="box-title">{{ __('Manager Booking') }}</h3>
                    <div class="clearfix"></div>
                    <div class="col-md-6 well">
                        <div class="form-group col-md-12 select_booking_manage">
                            <select  class="form-control" id="sel1" v-on:change="selectDay">
                                <option value="">{{ __('Today') }}</option>
                                <option value="day">{{ __('Day') }}</option>
                                <option value="space">{{__('About Time')}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12 select_booking_manage">
                            <div class="col-md-6">
                                <input type="date" class="form-control" v-model="start_date" v-on:change="selectStartDay" v-if="show_input.start">
                            </div>
                            <div class="col-md-6">
                                <input type="date" class="form-control" v-model="end_date" v-on:change="selectEndDay" v-if="show_input.end">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="col-md-4">{{ __('Status') }}</label>
                        <div class="form-group col-md-8 select_booking_manage">
                            <select  class="form-control" id="sel1" v-on:change="selectStatus">
                                <option value="">{{ __('All') }}</option>
                                <option value="0">{{ __('Cancel') }}</option>
                                <option value="1">{{ __('Wating') }}</option>
                                <option value="2">{{ __('Finish') }}</option>
                            </select>
                        </div>
                        <label class="col-md-4">{{ __('Number day') }}</label>
                        <div class="form-group col-md-8 select_booking_manage">
                            <select  class="form-control" id="sel1" v-on:change="selectPerPage">
                                <option value="5">5</option>
                                <option value="10" selected>10</option>
                                <option value="20">20</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                    </div>
                </div>
            <div class="box" style="position: relative;">
                <div class="indicator hide list-booking-indicator">
                    <div class="spinner"></div>
                </div>
                <div class="clearfix"></div>
                <div class="box-body over-flow-edit">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default" v-for="item in items">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" v-bind:href="'#open-booking-day-' + item.date_book">
                                        {{__('Date Book') }}: @{{ item.date_book }}
                                        <span class="label label-warning">
                                            @{{ item.list_book.length }}
                                        </span>
                                    </a>
                                </h4>
                            </div>
                            <div  v-bind:id="'open-booking-day-' + item.date_book" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{__('ID') }}</th>
                                                <th>{{ __('NameCustomer') }}</th>
                                                <th>{{ __('Phone') }}</th>
                                                <th>{{ __('Department') }}</th>
                                                <th>{{ __('NameStylist') }}</th>
                                                <th>{{ __('TimeStart') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>   
                                        </thead>
                                        <tbody>
                                           <tr v-for="list in item.list_book">
                                            <td>@{{ list.id }}</td>
                                            <td>@{{ list.name }}</td>
                                            <td>@{{ list.phone }}</td>
                                            <td>@{{ list.department.address }}</td>
                                            <td>@{{ list.stylist.name }}</td>
                                            <td>@{{ convertHourMinute( list.time_start) }}</td>
                                            <td class=" ">
                                                <a class="btn btn-success" href="javascript:void(0)" v-on:click="showBooking"><i class="fa fa-map-o"></i></a>
                                            </td>
                                        </tr>  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
</div>
@endsection

@section('script')
    {{ Html::script('js/admin/manager_booking.js') }}
    {{ Html::script('bower/AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}
    {{ Html::script('bower/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}
@endsection

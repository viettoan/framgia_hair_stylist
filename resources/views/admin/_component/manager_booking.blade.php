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
                            <select  class="form-control select-multi-status" id="sel1" v-on:change="selectStatus" multiple>
                                <option value="0">{{ __('Cancel') }}</option>
                                <option value="1">{{ __('Wating') }}</option>
                                <option value="3">{{ __('Inlate') }}</option>
                                <option value="2">{{ __('Complete') }}</option>
                            </select>
                        </div>
                        <label class="col-md-4">{{ __('Department') }}</label>
                        <div class="form-group col-md-8 select_booking_manage">
                            <select  class="form-control" id="sel1" v-on:change="selectDepartment">
                                <option value="">{{ __('All') }}</option>
                                <option v-bind:value="department.id" v-for="department in showDepartments">@{{ department.name }}</option>
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
                                                <th>{{ __('Status') }}</th>
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
                                            <td v-if="list.status == 0">
                                                <span class="label label-danger">
                                                    {{ __('Danger') }}
                                                </span>
                                            </td>
                                            <td v-if="list.status == 1">
                                                <span class="label label-warning">
                                                    {{ __('Waiting') }}
                                                </span>
                                            </td>
                                            <td v-if="list.status == 2">
                                                <span class="label label-success">
                                                    {{ __('Complete') }}
                                                </span>
                                            </td>
                                            <td v-if="list.status == 3">
                                                <span class="label label-warning">
                                                    {{ __('Inlate') }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" v-on:click="changer_status(list)"><i class="fa fa-fw  fa-eyedropper get-color-icon-edit" ></i></a>
                                            </td>
                                        </tr>  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="modal fade" id="update_status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title" id="myModalLabel">{{ __('Update Booking') }}</h4>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="update_status(changer_status_booking.id)">
                                        <div class="form-group">
                                         <label class="col-md-1">{{ __('Status') }}</label>
                                        <div class="form-group col-md-5 select_booking_manage">
                                            <select  class="form-control select-multi-status" id="sel1" v-model="changer_status_booking.status">
                                                    <option v-bind:value="0">{{ __('Cancel') }}</option>
                                                    <option v-bind:value="1">{{ __('Wating') }}</option>
                                                    <option v-bind:value="3">{{ __('Inlate') }}</option>
                                                    <option v-bind:value="2">{{ __('Complete') }}</option>
                                            </select>
                                        <br/>    
                                        </div> 
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa fa-plus" aria-hidden="true"></i> {{ __('Create') }}
                                            </button>
                                            <button class="btn btn-default" data-dismiss="modal">
                                                <i class="fa fa-external-link-square" aria-hidden="true"></i>
                                                {{ __('Close') }}
                                            </button>
                                        </div>
                                    </form>
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

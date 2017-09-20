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
                                <option value="2">{{ __('Complete') }}</option>
                                <option value="3">{{ __('Inlate') }}</option>
                                <option value="4">{{ __('Inprogress') }}</option>
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
                            <div  v-bind:id="'open-booking-day-' + item.date_book" class="panel-collapse collapse in scoll-time">
                                <div class="panel-body">
                                    <table id="example1" class="table table-bordered table-striped ok">
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
                                            <td v-bind:id="list.id">@{{ list.id }}</td>
                                            <td>@{{ list.name }}</td>
                                            <td><a :href="'tel:' + list.phone">@{{ list.phone }}</a></td>
                                            <td>@{{ list.department.address }}</td>
                                            <td>@{{ list.stylist.name }}</td>
                                            <td>@{{ convertHourMinute( list.time_start) }}</td>
                                            <td v-if="list.status == 0">
                                                <span class="label label-danger">
                                                    {{ __('Cancel') }}
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
                                                <span class="label label-primary">
                                                    {{ __('Inlate') }}
                                                </span>
                                            </td>
                                            <td v-if="list.status == 4">
                                                <span class="label label-primary">
                                                    {{ __('Inprogress') }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" v-on:click="changer_status(list)"> <i aria-hidden="true" class="fa fa-pencil-square-o"></i></a>
                                                <a href="javascript:void(0)" v-on:click="bookingDetail(list)"> <i class="fa fa-eye" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!-- show log status by order_booking_id -->
                    <div class="modal fade" id="show_log_status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title" id="myModalLabel">{{ __('History') }}</h4>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{__('ID') }}</th>
                                                <th>{{ __('User') }}</th>
                                                <th>{{ __('Old Status') }}</th>
                                                <th>{{ __('New Status') }}</th>
                                                <th>{{ __('Message') }}</th>
                                                <th>{{ __('Time') }}</th>
                                            </tr>   
                                        </thead>
                                        <tbody>
                                           <tr v-for="status in logStatus">
                                                <th>@{{ status.id }}</th>
                                                <th>@{{ status.get_user.name }}</th>
                                                <th>@{{ status.old_status }}</th>
                                                <th>@{{ status.new_status }}</th>
                                                <th>@{{ status.message }}</th>
                                                <th>@{{ status.created_at }}</th>
                                           </tr>
                                        </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end show log status by order_booking_id -->
                    <div class="modal fade" id="update_status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title" id="myModalLabel">{{ __('Update Booking') }}</h4>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="update_status(changer_status_booking.id)">
                                        <div class="form-group row">
                                        <label class="col-md-2">{{ __('Status') }}</label>
                                        <div class="form-group col-md-5 select_booking_manage">
                                            <!-- if status is cancel -->
                                            <select  class="form-control select-multi-status" id="sel1" v-if="status == 0" v-model="changer_status_booking.status" disabled="disabled">
                                                <option v-bind:value="0">{{ __('Cancel') }}</option>
                                                <option v-bind:value="1">{{ __('Waiting') }}</option>
                                                <option v-bind:value="2">{{ __('Complete') }}</option>
                                                <option v-bind:value="3">{{ __('Inlate') }}</option>
                                                <option v-bind:value="4">{{ __('Inprogress') }}</option>
                                            </select>

                                            <!-- if status is Complete -->
                                             <select  class="form-control select-multi-status" id="sel1" v-if="status == 2" v-model="changer_status_booking.status" disabled="disabled">
                                                <option v-bind:value="0">{{ __('Cancel') }}</option>
                                                <option v-bind:value="1">{{ __('Waiting') }}</option>
                                                <option v-bind:value="2">{{ __('Complete') }}</option>
                                                <option v-bind:value="3">{{ __('Inlate') }}</option>
                                                <option v-bind:value="4">{{ __('Inprogress') }}</option>
                                            </select>

                                            <!-- if status is wating -->
                                            <select  class="form-control select-multi-status" id="sel1" v-if="status == 1" v-model="changer_status_booking.status">
                                                <option v-bind:value="3">{{ __('Inlate') }}</option>
                                                <option v-bind:value="4">{{ __('Inprogress') }}</option>
                                            </select>

                                            <!-- if status is Inlate -->
                                            <select  class="form-control select-multi-status" id="sel1" v-if="status == 3" v-model="changer_status_booking.status">
                                                <option v-bind:value="4">{{ __('Inprogress') }}</option>
                                                <template v-if="status == 4">
                                                    <option v-bind:value="2">{{ __('Complete') }}</option>
                                                </template>
                                            </select>

                                            <!-- if status is Inprogress-->
                                            <select  class="form-control select-multi-status" id="sel1" v-if="status == 4" v-model="changer_status_booking.status">
                                                <option v-bind:value="2">{{ __('Complete') }}</option>
                                            </select>  
                                        </div> 
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2">{{ __('Message') }}</label>
                                            <div class="col-md-9">
                                                <textarea class=" form-control" name="message" id="message" v-model="changer_status_booking.message"></textarea>
                                            </div>  
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa fa-plus" aria-hidden="true"></i> {{ __('Edit') }}
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
                    <div class="modal fade" id="showBill" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">{{ __('Booking Detail') }}</h4>
                                </div>
                                <div class="modal-body">
                                  <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                        <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="createItem" class="form-horizontal">
                                    <div class="form-group">
                                        <div class="col-md-2">
                                            <label for="name" class="text-center label_bill">
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <strong>
                                                    {{ __('Infor Customer') }}
                                                </strong>
                                            </label>
                                        </div>
                                            <div class="col-md-10 flexbox-annotated-section-content">
                                                <br>
                                                    <div class="col-md-4">
                                                    <div class="col-md-2">
                                                        <strong>{{ __('Name') }}</strong>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-10">
                                                        <div class="input-group">
                                                          <div class="input-group-addon">
                                                            <i class="fa fa-user"></i>
                                                            </div>
                                                            <input class="form-control input-md field-compulsory-before" placeholder="Name" disabled="disabled" type="text" v-model="bill.customer_name">
                                                        </div>
                                                    </div>
                                                    </div>
                                                   
                                                    <div class="col-md-4">
                                                        <div class="col-md-2">
                                                            <strong>{{ __('Phone') }}</strong>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="col-md-12   ">
                                                        <div class="input-group">
                                                          <div class="input-group-addon">
                                                            <i class="fa fa-phone" aria-hidden="true"></i>
                                                            </div>
                                                            <input class="form-control input-md field-compulsory-before" placeholder="Name" disabled="disabled" type="text" v-model="bill.phone">
                                                        </div>
                                                        </div>
                                                    </div>
                                                 
                                                    <div class="col-md-4">
                                                        <div class="col-md-2">
                                                            <strong>{{ __('Status') }}</strong>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="col-md-10">
                                                            <div class="input-group" v-if="status == 0">
                                                                <div class="input-group-addon">
                                                                <i class="fa fa-bandcamp" aria-hidden="true"></i>
                                                                </div>
                                                                <input class="form-control input-md field-compulsory-before" disabled="disabled" type="text" value="Cancel">
                                                            </div>
                                                            <div class="input-group" v-if="status == 1">
                                                                <div class="input-group-addon">
                                                                <i class="fa fa-bandcamp" aria-hidden="true"></i>
                                                                </div>
                                                                <input class="form-control input-md field-compulsory-before" disabled="disabled" type="text" value="Waiting">
                                                            </div>
                                                            <div class="input-group" v-if="status == 2">
                                                                <div class="input-group-addon">
                                                                <i class="fa fa-bandcamp" aria-hidden="true"></i>
                                                                </div>
                                                                <input class="form-control input-md field-compulsory-before" disabled="disabled" type="text" value="Complete">
                                                            </div>
                                                            <div class="input-group" v-if="status == 3">
                                                                <div class="input-group-addon">
                                                                <i class="fa fa-bandcamp" aria-hidden="true"></i>
                                                                </div>
                                                                <input class="form-control input-md field-compulsory-before" disabled="disabled" type="text" value="Inlate">
                                                            </div>
                                                            <div class="input-group" v-if="status == 4">
                                                                <div class="input-group-addon">
                                                                <i class="fa fa-bandcamp" aria-hidden="true"></i>
                                                                </div>
                                                                <input class="form-control input-md field-compulsory-before" disabled="disabled" type="text" value="Inprogress">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-2">
                                                <label for="name" class="text-center label_bill">
                                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                    <strong>
                                                        {{ __('Infor Booking') }}
                                                    </strong>
                                                </label>
                                            </div>
                                            <div class="col-md-10 flexbox-annotated-section-content"  v-if="booking.id">
                                                <br>
                                                    <div class="col-md-6">
                                                    <div class="col-md-2">
                                                        <strong>{{ __('Dep Name')}}</strong>:
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="input-group">
                                                          <div class="input-group-addon">
                                                            <i class="fa fa-home" aria-hidden="true"></i>
                                                            </div>
                                                            <input class="form-control input-md field-compulsory-before" placeholder="Name" disabled="disabled" type="text" v-model="booking.department.name">
                                                        </div>
                                                    </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                    <div class="col-md-2">
                                                         <strong>{{__('Dep Address')}}</strong>:
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="input-group">
                                                          <div class="input-group-addon">
                                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                            </div>
                                                            <input class="form-control input-md field-compulsory-before" placeholder="Name" disabled="disabled" type="text" v-model="booking.department.address">
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <br>
                                                    <div class="col-md-6">
                                                    <div class="col-md-2">
                                                        <strong> {{ __('Day Booking') }}</strong>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="input-group">
                                                          <div class="input-group-addon">
                                                            <i class="fa fa-calendar-o" aria-hidden="true"></i>
                                                            </div>
                                                            <input class="form-control input-md field-compulsory-before" placeholder="Name" disabled="disabled" type="text" v-model="booking.render_booking.time_start">
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <div class="col-md-2">
                                                        <strong>{{ __('Time start') }}</strong>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="input-group">
                                                          <div class="input-group-addon">
                                                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                                                            </div>
                                                            <input class="form-control input-md field-compulsory-before" placeholder="Name" disabled="disabled" type="text" v-model="booking.stylist.name">
                                                        </div>
                                                    </div>
                                                    </div>
                                                     <div class="clearfix"></div>
                                                    <br>
                                                    <div class="col-md-6">
                                                    <div class="col-md-2">
                                                        <strong>{{ __('Stylist') }}</strong>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="input-group">
                                                          <div class="input-group-addon">
                                                            <i class="fa fa-user-circle" aria-hidden="true"></i> 
                                                            </div>
                                                            <input class="form-control input-md field-compulsory-before" placeholder="Name" disabled="disabled" type="text" v-model="booking.stylist.name">
                                                        </div>
                                                    </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                    <div class="col-md-2">
                                                        <strong>{{ __('Phone Stylist') }}</strong>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="input-group">
                                                          <div class="input-group-addon">
                                                            <i class="fa fa-phone" aria-hidden="true"></i>
                                                            </div>
                                                            <input class="form-control input-md field-compulsory-before" placeholder="Name" disabled="disabled" type="text" v-model="booking.stylist.phone">
                                                        </div>
                                                    </div>
                                                    </div>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                            <div class="col-md-2">
                                                <label for="name" class="text-center label_bill">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                    <strong>
                                                        {{ __('Add Service') }}
                                                    </strong>
                                                </label>
                                            </div>
                                            <div class="col-md-10 flexbox-annotated-section-content"  v-if="booking.id">
                                            <div v-if="status == 4">
                                                <div class="col-sm-3">
                                                    <label>{{ __('Service') }}</label>
                                                    <select  class="form-control" v-model="billItem.service_product_id" v-on:change="select_service">
                                                        <option value=""></option>
                                                        <option v-bind:value="service.id" v-for="service in services">
                                                            @{{ service.name }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>{{ __('Stylist') }}</label>
                                                    <select  class="form-control" v-model="billItem.stylist_id" v-on:change="select_stylist">
                                                        <option value=""></option>
                                                        <option v-bind:value="stylist.id" v-for="stylist in stylists">
                                                            @{{ stylist.name }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2 ">
                                                    <label >{{ __('Price') }}</label>
                                                    <input type="text" disabled readonly v-bind:value="billItem.price" class="form-control"/>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label >{{ __('Qty') }}</label>
                                                    <input type="number" v-model="billItem.qty" value="1" class="form-control"/>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label >{{ __('Action') }}</label>
                                                    <a class="btn btn-success" v-on:click="addService" v-if="!isEditBillItem.status">
                                                        {{__('Add Service') }}
                                                    </a>
                                                    <a class="btn btn-warning" v-on:click="submitEditBillItem(isEditBillItem.index)" v-else>
                                                        {{__('Update Service') }}
                                                    </a>
                                                </div>
                                            </div>
                                                
                                            <div class="col-sm-12">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('STT') }}</th>
                                                            <th>{{ __('Service Name') }}</th>
                                                            <th>{{ __('Stylist Name') }}</th>
                                                            <th>{{ __('Price') }}</th>
                                                            <th>{{ __('Qty') }}</th>
                                                            <th>{{ __('Action') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr id ="list_service" v-for="(billItem, keyObject) in orderItems.get_order_items" v-bind:class="{'label-warning': isEditBillItem.status && isEditBillItem.index == keyObject}">
                                                            <td>@{{ keyObject + 1 }}</td>
                                                            <td>@{{ billItem.service_name }}</td>
                                                            <td>@{{ billItem.stylist_name }}</td>
                                                            <td>@{{ billItem.price }} VND</td>
                                                            <td>@{{ billItem.qty }}</td>
                                                            <td> <a href="javascript:void(0)" v-on:click="editBillItem(keyObject)">
                                                                <i aria-hidden="true" class="fa fa-pencil-square-o"></i>
                                                            </a>
                                                            <a href="javascript:void(0)" v-on:click="deleteBillItem(keyObject, billItem.id)">
                                                                <i class="fa fa-fw  fa-close get-color-icon-delete"></i>
                                                            </a></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                           {{--  <td>{{ __('Grand Total : ') }}</td>
                                                            <td>@{{ bill.grand_total }} VND</td> --}}
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="form-group text-center">
                                            <div v-if="status == 4">
                                                <button class="btn btn-success" v-on:click="createBill" v-if="!bill.id">
                                                <i class="fa fa-plus" aria-hidden="true"></i> {{ __('Create') }}
                                                </button>
                                                <button class="btn btn-warning" v-on:click="createBill" v-else>
                                                    <i class="fa fa-plus" aria-hidden="true"></i> {{ __('Update Service') }}
                                                </button>
                                            </div>
                                            </div>     
                                            </div>
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

@extends('admin.master')
@section('style')
{{ Html::style('bower/AdminLTE/plugins/datatables/dataTables.bootstrap.css')}}
{{ Html::style('css/admin/bill.css') }}
{{ Html::style('css/admin/style.css') }}
@endsection

@section('content')
<div class="content-wrapper" id="manager_bill">
    <section class="content-header">
        <h1>
            {{ __('Bill') }}
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    {{ __('Home') }}
                </a>
            </li>
            <li>
                <a href="#">
                    {{ __('Manager') }}
                </a>
            </li>
            <li class="active">
                {{ __('List Bill') }}
            </li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6 well">
                <div class="form-group col-md-12 select_booking_manage">
                    <select  class="form-control" v-model="filterParams.type" v-on:change="getListBill">
                        <option value="">{{ __('Today') }}</option>
                        <option value="day">{{ __('Day') }}</option>
                        <option value="space">{{__('About Time')}}</option>
                    </select>
                </div>
                <div class="form-group col-md-12 select_booking_manage">
                    <div class="col-md-6">
                        <input type="date" class="form-control" v-model="inputDate.start_date" v-on:change="selectStartDay" v-if="filterParams.type != ''">
                    </div>
                    <div class="col-md-6">
                        <input type="date" class="form-control" v-model="inputDate.end_date" v-on:change="selectEndDay" v-if="filterParams.type == 'space'">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <label class="col-md-4">{{ __('Status') }}</label>
                <div class="form-group col-md-8 select_booking_manage">
                    <select  class="form-control select-multi-status" id="sel1" v-on:change="selectStatus" multiple>
                        <option value="">{{ __('All') }}</option>
                        <option value="0">{{ __('Wating') }}</option>
                        <option value="1">{{ __('Complete') }}</option>
                        <option value="2">{{ __('Cancel') }}</option>
                    </select>
                </div>
                <label class="col-md-4">{{ __('Department') }}</label>
                <div class="form-group col-md-8 select_booking_manage">
                    <select  class="form-control" v-model="filterParams.department_id" v-on:change="getListBill">
                        <option value="">{{ __('All') }}</option>
                        <option v-bind:value="department.id" v-for="department in departments">@{{ department.name }}</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ __('Manager List Bill') }}</h3>
                        <button class="col-md-offset-1 btn btn-success" v-on:click="addBill">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            {{ __('Create bill') }}
                        </button>
                    </div>
                    <div class="panel panel-default" v-for="item in listBill">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" v-bind:href="'#open-booking-day-' + item.date">
                                    {{__('Date Bill') }}: @{{ item.date }}
                                    <span class="label label-warning">
                                        @{{ item.list_bill.length }}
                                    </span>
                                </a>
                            </h4>
                        </div>
                        <div  v-bind:id="'open-booking-day-' + item.date" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{__('ID') }}</th>
                                            <th>{{ __('NameCustomer') }}</th>
                                            <th>{{ __('Phone') }}</th>
                                            <th>{{ __('Department') }}</th>
                                            <th>{{ __('Grand Total') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>   
                                    </thead>
                                    <tbody>
                                       <tr v-for="list in item.list_bill">
                                            <td>@{{ list.id }}</td>
                                            <td>@{{ list.customer_name }}</td>
                                            <td>@{{ list.phone }}</td>
                                            <td>@{{ list.department.name }}</td>
                                            <td>@{{ list.grand_total }}</td>
                                            <td>
                                                <span class="label label-danger" v-if="list.status == 0">
                                                    {{ __('Waiting') }}
                                                </span>
                                                <span class="label label-success" v-if="list.status == 1">
                                                    {{ __('Complete') }}
                                                </span>
                                                <span class="label label-warning" v-if="list.status == 2">
                                                    {{ __('Cancel') }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" v-on:click="editBill(list)">
                                                    <i aria-hidden="true" class="fa fa-pencil-square-o fa-2x"></i>
                                                </a>
                                                <a href="javascript:void(0)" v-on:click="exportshowBill(list)"><i class="fa fa-external-link-square fa-2x" aria-hidden="true"></i></a>
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
    </section>
    <div class="modal fade" id="showBill" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('Create Bill') }}</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="createItem" class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label for="name" class="label_bill ">{{ __('Phone Customer') }}</label>
                                <span class="text-danger">
                                    @{{formErrors.phone}}
                                </span>
                                <input type="text" name="phone" class="form-control" v-on:keyup="keyPhone" v-model="bill.phone"/>
                            </div>
                            <div class="col-sm-6">
                                <label for="name" class="label_bill">{{ __('Name Customer') }}</label>
                                <input type="text" class="form-control" v-model="bill.customer_name"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label for="name" class="label_bill">{{ __('Department') }}</label>
                                <select  class="form-control" v-model="bill.department_id" v-on:change="changeDeparment">
                                    <option value=""></option>
                                    <option v-bind:value="department.id" v-for="department in departments">
                                        @{{ department.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="name" class="label_bill">{{ __('Status') }}</label>
                                <select  class="form-control" v-model="bill.status">
                                    <option value="0">{{ __('Waitting') }}</option>
                                    <option value="1">{{ __('Complete') }}</option>
                                    <option value="2">{{ __('Cancel') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label for="name" class="text-center label_bill">
                                    {{ __('Infor Booking') }}
                                </label>
                                <div v-if="booking.id">
                                    <div class="col-sm-4">
                                        <p>Department: @{{ booking.department.name }}</p>
                                        <p>Address: @{{ booking.department.address }}</p>
                                    </div>
                                    <div class="col-sm-4">
                                        <p>Day Booking: @{{ booking.render_booking.day }}</p>
                                        <p>Time start: @{{ booking.render_booking.time_start }}</p>
                                    </div>
                                    <div class="col-sm-4">
                                        <p>Stylist: @{{ booking.stylist.name }}</p>
                                        <p>Phone: @{{ booking.stylist.phone }}</p>
                                    </div>
                                </div>
                                <div v-if="!booking.id">
                                    <div class="col-sm-4" class="text-danger">
                                      <i> {{ __('Not Booking') }} </i>
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <div class="form-group col-md-12 ">
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
                                <label >{{ __('Qty') }}</label>
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
                                        <th>{{ __('Row Total') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id ="list_service" v-for="(billItem, keyObject) in billItems" v-bind:class="{'label-warning': isEditBillItem.status && isEditBillItem.index == keyObject}">
                                        <td>@{{ keyObject + 1 }}</td>
                                        <td>@{{ billItem.service_name }}</td>
                                        <td>@{{ billItem.stylist_name }}</td>
                                        <td>@{{ billItem.price }}</td>
                                        <td>@{{ billItem.qty }}</td>
                                        <td>@{{ billItem.row_total }} VND</td>
                                        <td> <a href="javascript:void(0)" v-on:click="editBillItem(keyObject)">
                                        <i aria-hidden="true" class="fa fa-pencil-square-o"></i>
                                    </a>
                                    <a href="javascript:void(0)" v-on:click="deleteBillItem(keyObject)">
                                        <i class="fa fa-fw  fa-close get-color-icon-delete"></i>
                                    </a></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ __('Grand Total : ') }}</td>
                                        <td>@{{ bill.grand_total }} VND</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-success" v-on:click="createBill" v-if="!bill.id">
                                <i class="fa fa-plus" aria-hidden="true"></i> {{ __('Create Bill') }}
                            </button>
                            <button class="btn btn-warning" v-on:click="createBill" v-else>
                                <i class="fa fa-plus" aria-hidden="true"></i> {{ __('Update Bill') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Export Bill --}}
    <div class="modal fade" id="exportshowBill" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('Bill Detail') }}</h4>
                </div>
                <div class="modal-body" >
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 border_bill col-xs-10 col-xs-offset-1"> 
                            <div class="bookingleft-agile font_bill" >
                                <table class="table table-hover">
                                      <thead>
                                          <tr>
                                              <th >{{__('ID : ') }}</th>
                                              <th>@{{exportBill.id}}</th>
                                          </tr>
                                      </thead>
                                      <thead>
                                           <tr>
                                           <th ><i class="fa fa-id-card-o"> : </th>
                                           <th>@{{exportBill.name_customer}} - @{{exportBill.phone_customer}}</td>
                                           </tr>
                                      </thead>
                                      <thead>
                                          <tr>
                                              <th><i class="fa fa-calendar"> : </i></th>
                                              <th>@{{exportBill.checkout}} </th>
                                          </tr>
                                      </thead>
                                  </table>  
                                <table class="table table-striped">
                                    <thead>
                                        <tr >
                                            <th>{{ __('Service') }}</th>
                                            <th>{{ __('Stylist') }}</th>
                                            <th>{{ __('Qty') }}</th>
                                            <th>{{ __('Price') }}</th>
                                            <th>{{ __('Row Total') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="export_bill in exportBill.exportBill_item" >
                                            <td>@{{export_bill.service_name}}</td>
                                            <td>@{{export_bill.stylist.name}}</td>
                                            <td>@{{export_bill.qty}}</td>
                                            <td>@{{export_bill.price}}</td>
                                            <td>@{{export_bill.row_total}}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <th><h3><i>{{ __('Grand Total :') }}</i></h3></th>
                                            <td><h3>@{{ exportBill.grand_total }}</h3></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                            </div>
                        </div>
                    </div>
                    <br>
                    <form class="text-center">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">

                                <a :href="'/admin/export_bill/' + exportBill.id"><i class="fa fa-plus" aria-hidden="true"></i> {{ __('Export') }}</a>
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
@endsection
@section('script')
{{ Html::script('js/admin/manager_bill.js') }}
@endsection

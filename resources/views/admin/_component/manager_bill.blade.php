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
            <br>
            <div class="col-xs-12">
                <div class="box">
                    
                    <div class="box-header">
                        <div class="form-group col-md-12 select_booking_manage">
                            <div class="col-md-12 well">
                                <div class="col-md-1">
                                    <a class="btn btn-primary date-prev" v-on:click = "datePrev()">
                                        {{ __('Pre Day') }}
                                    </a>
                                </div>
                                <div class="form-group col-md-8 col-md-offset-1 select_booking_manage">
                                    <div class="col-md-12">
                                        <button v-on:click="today()" class="col-md-2 btn btn-success">Today</button>
                                        <div class="col-md-4">
                                            <input type="date"  class="form-control" v-model="inputDate.start_date" v-on:change="selectStartDay">
                                        </div>
                                        <div class="col-md-2 date-to">
                                            <input type="checkbox" id="to" value="1" v-on:click="showDateFrom()"> Date To:
                                        </div>
                                        <div class="col-md-4 date-from">
                                            <input type="date" class=" form-control" v-model="inputDate.end_date" v-on:change="selectEndDay">
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-md-1">
                                    <a class="btn btn-primary next-date" v-on:click = "dateNext()">
                                        {{ __('Next day') }}
                                    </a>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <!-- listBill -->
                    <div class="panel panel-default" v-for="item in listBill">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" v-bind:href="'#open-booking-day-' + item.date">
                                    <b>@{{ item.date }}</b>
                                    <span class="label label-warning">
                                        @{{ item.list_bill.length }}
                                    </span>
                                </a>
                            </h4>
                        </div>
                        <div  v-bind:id="'open-booking-day-' + item.date" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <table class="table table-bordered table-striped" id="MyTable">
                                    <thead>
                                        <tr>
                                            <th>{{__('ID') }}</th>
                                            <th>{{ __('Time') }}</th>
                                            <th class="col-md-3">{{ __('NameCustomer') }}</th>
                                            <th class="col-md-2">{{ __('Phone') }}</th>
                                            <th>
                                               {{ __('Departments') }}
                                            </th>
                                            <th>{{ __('Grand Total') }}</th>
                                        </tr>   
                                    </thead>
                                    <tbody>
                                    <tr>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <input type="text" class="form-control" name="customer_name" v-on:keyup="searchBill(item.date)" v-model="search.customer_name">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" v-on:keyup="searchBill(item.date)" name="phone" v-model="search.phone">
                                            </td>
                                            <td>
                                                <select  class="form-control" v-model="search.department_id" v-on:change="searchBill(item.date)">
                                                    <option value="">{{ __('All') }}</option>
                                                    <option v-bind:value="department.id" v-for="department in departments">@{{ department.name }}</option>
                                                </select>
                                            </td>
                                            <td></td>
                                        </tr>
                                       <tr v-for="list in item.list_bill">
                                            <td>@{{ list.id }}</td>
                                            <td><b>@{{ handleDate(list.updated_at) }}</b></td>
                                            <td> <a v-bind:href="'/admin/profile/'+ list.customer_id">@{{ list.customer_name }}</a></td>
                                            <td>@{{ list.phone }}</td>
                                            <td>@{{ list.department.name }}</td>
                                            <td>@{{ (list.grand_total).toLocaleString('de-DE') }} VND</td>
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
                    <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="" class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label for="name"><i class="fa fa-phone" aria-hidden="true"></i> <strong>{{ __('Phone Customer') }}</strong></label>
                                <span class="text-danger">
                                    @{{formErrors.phone}}
                                </span>
                                <input type="text" name="phone" class="form-control" v-on:keyup="keyPhone" v-model="bill.phone" />
                            </div>
                            <div class="col-sm-6">
                                <label for="name"><i class="fa fa-user" aria-hidden="true"></i> <strong>{{ __('Name Customer') }}</strong></label>
                                <input type="text" class="form-control" v-model="bill.customer_name"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label for="name" class="text-center">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i> <strong>{{ __('Infor Booking') }}</strong>
                                </label>
                                <div v-if="booking.id">
                                    <div class="col-sm-4">
                                        <p><strong>{{ __('Department:') }}</strong> @{{ booking.department.name }}</p>
                                        <p><strong>{{ __('Address:') }}</strong>@{{ booking.department.address }}</p>
                                    </div>
                                    <div class="col-sm-4">
                                        <p><strong>{{ __('Day Booking:') }}</strong>@{{ booking.render_booking.day }}</p>
                                        <p><strong>{{ __('Time start:') }}</strong>@{{ booking.render_booking.time_start }}</p>
                                    </div>
                                    <div class="col-sm-4">
                                        <p><strong>{{ __('Stylist:') }}</strong> @{{ booking.stylist.name }}</p>
                                        <p><strong>{{ __('Stylist Phone:') }}</strong>@{{ booking.stylist.phone }}</p>
                                    </div>
                                </div>
                                <div v-if="!booking.id">
                                    <div class="col-sm-4" class="text-danger">
                                      <i> {{ __('Not Booking') }} </i>
                                    </div>
                                </div>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id ="list_service" v-for="(order_item, keyObject) in booking.order_items" v-bind:class="{'label-warning': isEditBillItem.status && isEditBillItem.index == keyObject}">
                                        <td>@{{ keyObject + 1 }}</td>
                                        <td>@{{ order_item.service_name }}</td>
                                        <td>@{{ order_item.stylist }}</td>
                                        <td>@{{ (order_item.price).toLocaleString('de-DE') }} VND</td>
                                        <td>@{{ order_item.qty }}</td>    
                                    </tr>
                                    <tr>
                                        <td ></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ __('Grand Total : ') }}</td>
                                        <td>@{{ (bill.grand_total).toLocaleString('de-DE') }} VND</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-success" :disabled="booking.status != 4 ||  bill.service_total == 0 " v-on:click="createBill" v-if="!bill.id">
                                <i class="fa fa-plus" aria-hidden="true"></i> {{ __('Create Bill') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Export Bill --}}
    <div class="modal fade" id="exportshowBill" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('Bill Detail') }}</h4>
                </div>
                <div class="modal-body" >
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 border_bill col-xs-10 col-xs-offset-1">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <img src="{{ asset('images/3.png') }}" class="img-responsive">
                                </div>
                                <div class="col-md-8">
                                    <h1>Hair Salon</h1>
                                    <p>Dia chi: 424 Tran Khat Tran - Hai Ba Trung - Ha Noi</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h3>Bill Detail</h3><hr>
                                <div>
                                    <p><b>Bill No: </b>@{{exportBill.id}}</p>
                                    <p><b>Name: </b>@{{exportBill.name_customer}}</p>
                                    <p><b>Phone: </b>@{{exportBill.phone_customer}}</p>
                                    <p><b>Date: </b>@{{exportBill.checkout}}</p>
                                </div><hr>
                                <div>
                                    <table class="table">
                                        <thead>
                                            <tr >
                                                <th>{{ __('Service') }}</th>
                                                <th>{{ __('Qty') }}</th>
                                                <th>{{ __('Price') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="export_bill in exportBill.exportBill_item" >
                                                <td class="col-md-4">@{{export_bill.service_name}}</td>
                                                <td class="col-md-4">@{{export_bill.qty}}</td>
                                                <td class="col-md-4">@{{ (export_bill.price).toLocaleString('de-DE') }} VND</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div><hr>
                                <div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td class="col-md-4"></td>
                                                <td class="col-md-4"><h3 class="text-right">ToTal :</h3></td>
                                                <td class="col-md-4"><h3 class="pull-left">@{{ exportBill.grand_total }} VND</h3></td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
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

@extends('admin.master')
@section('style')
{{ Html::style('bower/AdminLTE/plugins/datatables/dataTables.bootstrap.css')}}
{{ Html::style('css/admin/bill.css') }}
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
                                                    <i class="fa fa-fw  fa-eyedropper get-color-icon-edit"></i>
                                                </a>
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
                                <label for="name">{{ __('Phone Customer') }}</label>
                                <span class="text-danger">
                                    @{{formErrors.phone}}
                                </span>
                                <input type="text" name="phone" class="form-control" v-on:keyup="keyPhone" v-model="bill.phone"/>
                            </div>
                            <div class="col-sm-6">
                                <label for="name">{{ __('Name Customer') }}</label>
                                <input type="text" class="form-control" v-model="bill.customer_name"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label for="name">{{ __('Department') }}</label>
                                <select  class="form-control" v-model="bill.department_id" v-on:change="changeDeparment">
                                    <option value=""></option>
                                    <option v-bind:value="department.id" v-for="department in departments">
                                        @{{ department.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="name">{{ __('Status') }}</label>
                                <select  class="form-control" v-model="bill.status">
                                    <option value="0">{{ __('Waitting') }}</option>
                                    <option value="1">{{ __('Complete') }}</option>
                                    <option value="2">{{ __('Cancel') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label for="name" class="text-center">
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
                                        Khong co booking nao
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <div class="form-group col-md-12 well">
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
                            <div class="col-sm-2">
                                <label>{{ __('Price') }}</label>
                                <input type="text"   v-model="billItem.price" class="form-control"/>
                            </div>
                            <div class="col-sm-2">
                                <label>{{ __('Qty') }}</label>
                                <input type="number" v-model="billItem.qty" value="1" class="form-control"/>
                            </div>
                            <div class="col-sm-2">
                                <label>{{ __('Qty') }}</label>
                                <a class="btn btn-success" v-on:click="addService" v-if="!isEditBillItem.status">
                                    {{__('Add Service') }}
                                </a>
                                <a class="btn btn-warning" v-on:click="submitEditBillItem(isEditBillItem.index)" v-else>
                                    {{__('Update Service') }}
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="well">
                                <div class="col-sm-1">{{ __('STT') }}</div>
                                <div class="col-sm-2">{{ __('Service Name') }}</div>
                                <div class="col-sm-2">{{ __('Stylist Name') }}</div>
                                <div class="col-sm-2 text-right">{{ __('Price') }}</div>
                                <div class="col-sm-1 text-right">{{ __('Qty') }}</div>
                                <div class="col-sm-2 text-right">{{ __('Row Total') }}</div>
                                <div class="col-sm-2 text-right">{{ __('Action') }}</div>
                            </div>

                            <div class="well" id ="list_service" v-for="(billItem, keyObject) in billItems" v-bind:class="{'label-warning': isEditBillItem.status && isEditBillItem.index == keyObject}">
                                <div class="col-sm-1">@{{ keyObject + 1 }}</div>
                                <div class="col-sm-2">@{{ billItem.service_name }}</div>
                                <div class="col-sm-2">@{{ billItem.stylist_name }}</div>
                                <div class="col-sm-2 text-right">@{{ billItem.price }}</div>
                                <div class="col-sm-1 text-right">@{{ billItem.qty }}</div>
                                <div class="col-sm-2 text-right">@{{ billItem.row_total }}</div>
                                <div class="col-sm-2 text-right">
                                    <a href="javascript:void(0)" v-on:click="editBillItem(keyObject)">
                                        <i class="fa fa-fw  fa-eyedropper get-color-icon-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" v-on:click="deleteBillItem(keyObject)">
                                        <i class="fa fa-fw  fa-close get-color-icon-delete"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="well">
                                <div class="col-sm-8 text-right">{{ __('Grand Total') }}</div>
                                <div class="col-sm-2 text-right">@{{ bill.grand_total }}</div>
                            </div>
                        </div>

                        <div class="form-group text-right">
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

    <div class="modal fade" id="showBill" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('Export Bill') }}</h4>
                </div>
                <div class="modal-body" >
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 border_bill "> 
                            <div class="bookingleft-agile font_bill" >
                                <div class="col-md-12">
                                    <div class="col-md-3 icon_salon"> <img class = "fix_size_icon" src={{ asset('images/salon1.png')}} alt=""> 
                                    </div>
                                    <div class="col-md-9">
                                        <h2 class="text-center font_bill"><i> {{ __(' FSalon Bill ') }} <i> </h2>
                                        <h5 class="text-center"> <b> {{ __('434 Tran Khat Chan - Hai Ba Trung - Ha Noi') }}</b></h5>
                                        <p  class="text-center">{{ __('Tel: +8432 123 456  -  Email: admin@support.com') }}</p>
                                    </div>
                                </div>
                                <p>{{ __('ID: 0007') }} </p>
                                <p>{{ __('Name : Juliet  -  Phone : 123 456 678') }} </p>
                                <p>{{ __('Check-in date : 22/12/2017  -  Time : 14:00:PM ') }}</p>
                                <p>{{ __('Check-out date : 23/12/2017  -  Time : 15:00:PM') }} </p>
                                <form action="#" method="get">
                                    <div class="name-agile">
                                        <p>{{ __('Chair Number') }} : <i></i> </p>
                                    </div>
                                    <div class="name-agile">
                                        12
                                    </div>
                                </form>
                                <p>{{ __('Stylist : Juliet') }} </p>
                                <div class="col-md-12" >
                                    <div class="col-md-4 fix_padding" >{{ __('Service') }}</div>
                                    <div class="col-md-2 fix_padding" >{{ __('Nb') }}</div>
                                    <div class="col-md-3 fix_padding" >{{ __('Price') }}</div>
                                    <div class="col-md-3 fix_padding" >{{ __('T.Tien') }}</div>
                                </div>
                                <div class="col-md-12 border_botton">
                                    <div class="col-md-4" >
                                        <div class="name-agile">
                                            Hair cuts
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="name-agile">
                                            1
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="name-agile">
                                            80.000
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="name-agile">
                                            80.000
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 total_bill">
                                    <div class="col-md-4">TOTAL</div>
                                    <div class="col-md-2">6</div>
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3 ">200.000 VND</div>
                                </div>
                                <br>
                                <div class="col-md-12">
                                    <div class="col-md-4" ><h3 class = "font_bill">{{ __('Pay Cash :') }}</h3></div>
                                    <div class="col-md-8" ><h3 class = "font_bill"><b>500.000 VND</b></h3></div>
                                </div>
                                <div class="col-md-12 footer" >
                                    <div class="col-md-4"><h3 class = "font_bill">{{ __('Change :') }}</h3></div>
                                    <div class="col-md-8"><h3 class = "font_bill"><b>300.000 VND</b></h3></div>
                                </div>
                                <div class="col-md-12" >
                                    <h3 class="text-center font_bill"><i class="fa fa-asterisk" aria-hidden="true"></i>{{ __('Have a nice day') }} <i class="fa fa-asterisk" aria-hidden="true"></i></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <form class="text-center">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-plus" aria-hidden="true"></i> {{ __('Export') }}
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
@endsection

@section('script')
{{ Html::script('js/admin/manager_bill.js') }}
@endsection

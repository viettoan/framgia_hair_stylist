@extends('admin.master')
@section('style')
{{ Html::style('bower/AdminLTE/plugins/datatables/dataTables.bootstrap.css')}}
{{ Html::style('css/admin/style.css') }}
@endsection

@section('content')
<div class="content-wrapper" id="manager_servece">
    <section class="content-header">
        <h1>
            {{ __('Customer') }}
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
                {{ __('Customer') }}
            </li>
        </ol>
    </section>
    <div class="col-md-12">  
        <div class="col-md-4 search_customer">
            <label class="col-md-4">{{ __('Search') }}</label>
            <div class="col-md-8">
                <input v-on:keyup="filteCustomer" v-model="params.keyword" placeholder="Search for phone number..">
            </div>
        </div>
        <div class="col-md-4 col-md-offset-2">
            <label class="col-md-4">{{ __('Number User') }}</label>
            <div class="form-group col-md-8 select_booking_manage">
                <select  class="form-control" v-on:change="showInfor" v-model="params.per_page">
                    <option value="" selected>{{ __('Select') }}</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
            <label class="col-md-4">{{ __('Page') }}</label>
            <div class="form-group col-md-8">
                <select  class="form-control" v-on:change="showInfor" v-model="params.page">
                    <option v-bind:value="dataPage" v-for="dataPage in dataPages">
                        @{{ dataPage }}
                    </option>
                </select>
            </div> 
        </div>
    </div>
      <div class="modal fade" id="showBill_Detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"  v-on:click="hideBill"  aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
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
                                              <th>{{ __('1') }}</th>
                                          </tr>
                                      </thead>
                                      <thead>
                                           <tr>
                                           <th ><i class="fa fa-id-card-o"> : </th>
                                           <th>{{ __('tranvanmy - 0232323223') }}</td>
                                           </tr>
                                      </thead>
                                      <thead>
                                          <tr>
                                              <th><i class="fa fa-calendar"> : </i></th>
                                              <th>{{ __('29/20/2000') }}</th>
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
                                        <tr>
                                            <td>{{ __('cattoc') }}</td>
                                            <td>{{ __('trung') }}</td>
                                            <td>{{ __('200') }}</td>
                                            <td>{{ __('200') }}</td>
                                            <td>{{ __('200') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="col-md-10 col-md-offset-1 border_bill col-xs-10 col-xs-offset-1">
                        <div class="col-md-4">
                            <img width="200px" id="zoom_01" src="{{ asset('images/hair1.jpg') }}" data-zoom-image="{{ asset('images/hair1.jpg') }}"/>
                        </div>
                        <div class="col-md-4 test-xxx">
                            <img width="200px" id="zoom_02" src="{{ asset('images/hair2.jpg') }}" data-zoom-image="{{ asset('images/hair2.jpg') }}"/>
                        </div>
                        <div class="col-md-4">
                            <img width="200px" id="zoom_03" src="{{ asset('images/hair3.jpg') }}" data-zoom-image="{{ asset('images/hair3.jpg') }}"/>
                        </div>
                        
                    </div> 
                    <br>
                    <button class="btn btn-default"  v-on:click="hideBill">
                        <i class="fa fa-external-link-square" aria-hidden="true"></i>
                        {{ __('Close') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ __('Manager Customer') }}
                            <span class="label label-warning">
                                @{{ items.length}}            
                            </span>
                        </h3>
                        <button class="col-md-offset-1 btn btn-success" v-on:click="addItem">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            {{ __('Create Customer') }}
                        </button>
                    </div>
                    <div class="box-body over-flow-edit">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Phone') }}</th>
                                    <th>{{ __('Gender') }}</th>
                                    <th>{{ __('Permision') }}</th>
                                    <th>{{ __('admin.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in items">
                                    <td>@{{ item.id }}</td>
                                    <td>@{{ item.name }}</td>
                                    <td>@{{ item.email }}</td>
                                    <td>@{{ item.phone }}</td>
                                    <td>@{{ item.gender }}</td>
                                    <td v-if="item.permission == 0">
                                        <span class="label label-success">
                                            {{ __('Nomal') }}
                                        </span>
                                    </td>
                                    <td v-if="item.permission == 1">
                                        <span class="lable label-success">
                                            {{ __('Assistant') }}
                                        </span>
                                    </td>
                                    <td v-if="item.permission == 2">
                                        <span class="label label-success">
                                            {{ __('Main_Worker') }}
                                        </span>
                                    </td>
                                    <td v-if="item.permission == 3">
                                        <span class="label label-success">
                                            {{ __('Admin') }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" v-on:click="edit_cutomer(item)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        <a href="javascript:void(0)" v-on:click="comfirmDeleteItem(item)"><i class="fa fa-fw  fa-close get-color-icon-delete" ></i></a>
                                        <a href="javascript:void(0)" v-on:click="viewUser(item)"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
{{--      <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('Detail Customer') }}</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="update_customer(fillItem.id)">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="col-sm-4">
                                <i><label for="name">{{ __('Name') }}</label></i>
                                <span class="text-danger">(*)</span>
                                <input type="text" name="name" class="form-control create_customer " v-model="fillItem.name"/>
                            </div>
                            <div class="col-sm-4">
                                <i><label for="name">{{ __('Email') }}</label></i>
                                <span class="text-danger">(*)</span>
                                <input type="text" name="name" class="form-control create_customer " v-model="fillItem.email"/>
                            </div>
                            <div class="col-sm-4">
                                <i><label for="name">{{ __('Phone') }}</label></i>
                                <span class="text-danger">(*)</span>
                                <input type="text" name="name" class="form-control create_customer " v-model="fillItem.phone"/>
                            </div>
                        </div>
                         <div class="col-sm-12">
                            <div class="col-sm-4">
                                <i><label for="name">{{ __('Birthday') }}</label></i>
                                <input type="date" id="sel1" class="form-control create_customer" name="birthday"  v-model="fillItem.birthday">
                            </div>
                            <div class="col-sm-4">
                                <i><label for="name">{{ __('Gender') }}</label></i>
                                <select  class="form-control create_customer" id="sel1" v-model="fillItem.gender">
                                    <option value="" selected>{{ __('Select Gender') }}</option>
                                    <option value="male">
                                        <i class="fa fa-male" aria-hidden="true"></i>
                                        {{ __('male') }}
                                    </option>
                                    <option value="female">{{ __('Famele') }}</option>
                                    <option value="orther">{{ __('Orther') }}</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <i><label for="name">{{ __('Department') }}</label></i>
                                <select  class="form-control create_customer" id="sel1" v-model="fillItem.department_id">
                                    <option v-bind:value="department.id"  v-for="department in showDepartments">
                                        @{{ department.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <i><label for="name">{{ __('Permission') }}</label></i>
                                <select  class="form-control create_customer" id="sel1" v-model="fillItem.permission">
                                    <option value="0">{{ __('NOMAL') }}</option>
                                    <option value="1">{{ __('ASSISTANT') }}</option>
                                    <option value="2">{{ __('MAIN_WORKER') }}</option>
                                    <option value="3">{{ __('ADMIN') }}</option>
                                </select>
                            </div>
                            <div class="col-sm-14">
                                <textarea class="form-control" name="about_me" rows="5" v-model="fillItem.about">
                            </textarea>
                            </div>
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
    </div> --}}
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <div class="row">
                    <div class="col-md-8"><h4 class="modal-title" id="myModalLabel">{{ __('Edit Customer') }}</h4>
                    </div>
                    <div class="col-md-4 button-edit-customer">
                        <div class="btn btn-default">{{__('Hủy') }}</div>
                        <div class="btn btn-primary">{{__('Cập nhật') }}</div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-horizontal">
                            <div class="col-md-4">
                                <h4>{{ __('Thông tin chung') }}</h4>
                                <p>{{ __('Một số thông tin cơ bản của khách hàng.') }}</p>
                            </div>
                            <div class="col-md-8 flexbox-annotated-section-content">
                                <div class="col-md-12 flexbox-grid-form">
                                            <label class="text-title-field" for="inputlastname">{{ __('Họ va Tên ') }}</label>
                                            <input type="text" class=" flexbox-grid-form-input form-control" id="inputlastname" data-bind="value: LastName">
                                </div>
                                <div class="col-md-12 flexbox-grid-form">
                                    <label class="text-title-field" for="inputemail">{{ __('Địa chỉ Email') }}</label>
                                    <input type="text" class="form-control flexbox-grid-form-input" id="inputemail" data-bind="value: Email">
                                </div>
                                <div class="col-md-12 flexbox-grid-form">
                                    <label class="text-title-field" for="inputdate">{{ __('Ngày sinh') }}</label>
                                    <input type="date" class="form-control flexbox-grid-form-input" id="inputemail" data-bind="value: ngaysinh">
                                </div>
                               <div class="col-md-12 flexbox-grid-form">
                                    <label for="name">{{ __('Gender') }}</label>
                                    <select  class="form-control create_customer" v-model="fillItem.gender">
                                        <option value="" selected>{{ __('Select Gender') }}</option>
                                        <option value="male">
                                            <i class="fa fa-male" aria-hidden="true"></i>
                                            {{ __('male') }}
                                        </option>
                                        <option value="female">{{ __('Famele') }}</option>
                                        <option value="orther">{{ __('Orther') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 form-horizontal">
                            <div class="col-md-4">
                                <h4>{{ __('Địa chỉ') }}</h4>
                                <p>{{ __('Địa chỉ chính của khách hàng này.') }}</p>
                            </div>
                            <div class="col-md-8 flexbox-annotated-section-content">
                                <div class="col-md-12 flexbox-grid-form">
                                    <div class="col-md-6 flexbox-grid-form-item">
                                        <label class="text-title-field" for="inputlastname">{{ __('Địa chỉ') }}</label>
                                        <input type="text" class=" flexbox-grid-form-input form-control" id="inputlastname" data-bind="value: address">
                                    </div>
                                    <div class="col-md-6 flexbox-grid-form-item1">   
                                        <div class="flexbox-grid-form-item">
                                            <label class="text-title-field" for="inputfirstname">{{ __('Số điện thoại') }}</label>
                                            <input type="text" class="form-control flexbox-grid-form-input" id="inputfirstname" data-bind="value: phone">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 form-horizontal">
                            <div class="col-md-4">
                                <h4>{{ __('Địa chỉ') }}</h4>
                                <p>{{ __('Địa chỉ chính của khách hàng này.') }}</p>
                            </div>
                            <div class="col-md-8 flexbox-annotated-section-content">
                                <div class="col-md-12 flexbox-grid-form">
                                    <label class="text-title-field" for="inputlastname">{{ __('Ghi chú') }}</label>
                                    <textarea class=" flexbox-grid-form-input form-control " placeholder="Nhập ghi chú về khách hàng..." rows="3" data-bind="value: Notes"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="showUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('Detail Customer') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-horizontal">
                            <div class="col-md-4 flexbox-annotated-section-content" id="infor_customer">
                                <div class="col-md-12 flexbox-grid-form">
                                    <label class="text-title-field" for="inputlastname">{{ __('Họ va Tên :   ') }} </label>
                                        @{{ fillItem.name }}
                                </div>
                                <div class="col-md-12 flexbox-grid-form">
                                    <label class="text-title-field" for="inputemail">{{ __('Địa chỉ Email') }}</label>
                                    <input type="text" class="form-control flexbox-grid-form-input" id="inputemail" v-model="fillItem.email" disabled="disabled">
                                </div>
                                <div class="col-md-12 flexbox-grid-form">
                                    <label class="text-title-field" for="inputdate">{{ __('Ngày sinh') }}</label>
                                    <input type="date" class="form-control flexbox-grid-form-input" id="inputemail" v-model="fillItem.birthday" disabled="disabled">
                                </div>
                               <div class="col-md-12 flexbox-grid-form">
                                    <label for="name">{{ __('Gender') }}</label>
                                    <select  class="form-control create_customer" v-model="fillItem.gender" v-model="fillItem.gender" disabled="disabled">
                                        <option value="" selected>{{ __('Select Gender') }}</option>
                                        <option value="male">
                                            <i class="fa fa-male" aria-hidden="true"></i>
                                            {{ __('male') }}
                                        </option>
                                        <option value="female">{{ __('Famele') }}</option>
                                        <option value="orther">{{ __('Orther') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-7 col-md-offset-1">
                                <div class="col-md-12 flexbox-annotated-section-content" >
                                    <div class="col-md-12 flexbox-grid-form-item1">   
                                        <div class="flexbox-grid-form-item">
                                            <label class="text-title-field" for="inputfirstname">{{ __('Số điện thoại') }}</label>
                                            <input type="text" class="form-control flexbox-grid-form-input" id="inputfirstname" v-model="fillItem.phone" disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="col-md-12 flexbox-grid-form-item1">   
                                        <div class="flexbox-grid-form-item">
                                            <label class="text-title-field" for="inputfirstname">{{ __('Số điện thoại') }}</label>
                                            <input type="text" class="form-control flexbox-grid-form-input" id="inputfirstname" v-model="fillItem.phone" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12 flexbox-annotated-section-content" id="about_customer">
                                    <div class="col-md-12 flexbox-grid-form">
                                        <label class="text-title-field" for="inputlastname">{{ __('About') }}</label>
                                        <textarea class=" flexbox-grid-form-input form-control " placeholder="About" rows="3" v-model="fillItem.about" disabled="disabled"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12 flexbox-annotated-section-content" id=" about_customer">
                            <div class="col-md-12 flexbox-grid-form">
                                <label class="text-title-field" for="inputlastname">{{ __('List Bill') }}</label>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('STT') }}</th>
                                            <th>{{ __('Ma') }}</th>
                                            <th>{{ __('Thanh Toan') }}</th>
                                            <th>{{ __('Ngay Tao') }}</th>
                                            <th>{{ __('View') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ __('1') }}</td>
                                            <td>{{ __('MD1') }}</td>
                                            <th>{{ __('500$') }}</th>
                                            <td>{{ __('10/10') }}</td>
                                            <td>
                                                <a href="javascript:void(0)" class="btn btn-success" v-on:click="viewBill">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group">
                               <button class="btn btn-default" data-dismiss="modal">
                                <i class="fa fa-external-link-square" aria-hidden="true"></i>
                                {{ __('Close') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="create-item" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content content_create_customer">
                <div class="modal-header">    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('Create Customer') }}</h4>
                </div>
                    <div class="modal-body">
                        <div class="row"> 
                        <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="createItem">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="col-sm-4">
                                        <i><label for="name">{{ __('Name') }}</label></i>
                                        <span class="text-danger">(*)</span>
                                        <input type="text" name="name" class="form-control create_customer " v-model="newItem.name"/>
                                    </div>
                                    <div class="col-sm-4">
                                        <i><label for="name">{{ __('Email') }}</label></i>
                                        <span class="text-danger">(*)</span>
                                        <input type="email" name="email" class="form-control create_customer" v-model="newItem.email"/>
                                    </div>
                                    <div class="col-sm-4">
                                        <i><label for="name">{{ __('Phone') }}</label></i>
                                        <span class="text-danger">(*)</span>
                                        <input type="text" name="phone" class="form-control create_customer" v-model="newItem.phone"/>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="col-sm-4">
                                        <i><label for="name">{{ __('Password') }}</label></i>
                                        <span class="text-danger">(*)</span>
                                        <input type="password" name="password" class="form-control create_customer" v-model="newItem.password"/>
                                    </div>
                                    <div class="col-sm-4">
                                        <i><label for="name">{{ __('Confirm Password') }}</label></i>
                                        <span class="text-danger">(*)</span>
                                        <input type="password" name="password_confirmation" class="form-control create_customer" v-model="newItem.password_confirmation"/>
                                    </div>
                                    <div class="col-sm-4">
                                        <i><label for="name">{{ __('Birthday') }}</label></i>
                                        <input type="date" id="sel1" class="form-control create_customer" name="birthday"  v-model="newItem.birthday">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="col-sm-4">
                                        <i><label for="name">{{ __('Department') }}</label></i> 
                                        <div class="form-group">
                                            <select  class="form-control create_customer" id="sel1" v-model="newItem.department_id">
                                                <option value="" selected>{{ __('Select Department') }}</option>
                                                <option v-bind:value="department.id" v-for="department in showDepartments">@{{ department.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <i><label for="name">{{ __('Gender') }}</label></i> 
                                        <select  class="form-control create_customer" id="sel1" v-model="newItem.gender">
                                            <option value="" selected>{{ __('Select Gender') }}</option>
                                            <option value="male">
                                                <i class="fa fa-male" aria-hidden="true"></i>
                                                {{ __('Male') }}
                                            </option>
                                            <option value="female">{{ __('Famele') }}</option>
                                            <option value="orther">{{ __('Orther') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <i><label for="name">{{ __('Permission') }}</label></i> 
                                        <select  class="form-control create_customer" id="sel1" v-model="newItem.permission">
                                            <option value="" selected>{{ __('Select Permission') }}</option>
                                            <option value="0">{{ __('NOMAL') }}</option>
                                            <option value="1">{{ __('ASSISTANT') }}</option>
                                            <option value="2">{{ __('MAIN_WORKER') }}</option>
                                            <option value="3">{{ __('ADMIN') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="col-sm-12">
                                        <i><label for="name" id="specialize">{{ __('Specialize') }}</label></i>
                                        <textarea class="form-control" name="specialize" rows="5" v-model="newItem.specialize"></textarea>
                                        <i><label for="name"  id="specialize">{{ __('About Me') }}</label></i>
                                        <textarea class="form-control" name="about_me" rows="5" v-model="newItem.about_me">
                                        </textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12 text-center fix-button-creat-customer">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-plus" aria-hidden="true"></i> {{ __('Create') }}
                                        </button>
                                        <button class="btn btn-default" data-dismiss="modal">
                                            <i class="fa fa-external-link-square" aria-hidden="true"></i>
                                            {{ __('Close') }}
                                        </button>
                                    </div>
                                </div>    
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- comfirm delete item -->
        <div class="modal fade" id="delete-item" tabindex="-1" role="dialog" aria-labelledby="Heading" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                        </button>
                        <h4 class="modal-title custom_align" id="Heading">{{ trans('admin.deleteUser') }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            <span class="glyphicon glyphicon-warning-sign"></span> {{ trans('admin.user_comfirm_delete') . ': ' }} @{{ deleteItem.name }}
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <a href="javascript:void(0)" v-on:click="delItem(deleteItem.id)" class="btn btn-danger">
                            <span class="glyphicon glyphicon-ok-sign"></span> {{ trans('admin.yes') }}
                        </a>
                        <button type="button" class="btn btn-success" data-dismiss="modal">
                            <span class="glyphicon glyphicon-remove"></span> {{ trans('admin.no') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('script')
    {{ Html::script('js/admin/manager_customer_admin.js') }}
    {{ Html::script('js/admin/image_zoom.js') }}
@endsection

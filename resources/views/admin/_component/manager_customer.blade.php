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
                <div class="modal-body scroll_bill" >
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 border_bill col-xs-10 col-xs-offset-1"> 
                            <div class="bookingleft-agile font_bill" >
                                <table class="table table-hover">
                                    <thead>
                                       <tr>
                                            <th >{{__('ID : ') }}</th>
                                            <th>@{{ showBillDetails.order_booking_id }}</th>
                                        </tr>
                                        <tr>
                                            <th ><i class="fa fa-id-card-o"> : </th>
                                            <th>@{{ showBillDetails.customer_name}} - @{{ showBillDetails.phone }}</td>
                                        </tr>
                                        <tr>
                                            <th><i class="fa fa-calendar"> : </i></th>
                                            <th>@{{ showBillDetails.created_at  }}</th>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Service_total') }}</th>
                                            <th>@{{ showBillDetails.service_total  }}</th>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Department') }}</th>
                                            <th v-if="showBillDetails.department">@{{ showBillDetails.department.name }}</th>
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
                                        <tr v-for="bill_item in showBillDetails.bill_items">
                                            <td>@{{ bill_item.service_name }}</td>
                                            <td>@{{ bill_item.stylist.name }}</td>
                                            <td>@{{ bill_item.qty }}</td>
                                            <td>@{{ bill_item.price }}</td>
                                            <td>@{{ bill_item.row_total }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="col-md-10 col-md-offset-1 border_bill col-xs-10 col-xs-offset-1">
                    <div v-if="showBillDetails.booking">
                        <div v-for="image in showBillDetails.booking.images">
                            <img v-bind:src="asset('image.path_origin')" id="bill_image">
                        </div>
                    </div>
                        {{-- <div class="col-md-4">
                            <a class="image-item" href="{{ asset('images/1.jpg')}}" target="blank" ><img src="{{ asset('images/1.jpg')}}" class="img-thumbnail img-responsive"></a>
                        </div>
                        <div class="col-md-4 test-xxx">
                            <a class="image-item" href="{{ asset('images/1.jpg')}}" target="blank" ><img src="{{ asset('images/1.jpg')}}" class="img-thumbnail img-responsive"></a>
                        </div>
                        <div class="col-md-4">
                            <a class="image-item" href="{{ asset('images/1.jpg')}}" target="blank" ><img src="{{ asset('images/1.jpg')}}" class="img-thumbnail img-responsive"></a>
                        </div>  --}}
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
                                    <td>
                                        <a href="javascript:void(0)" v-on:click="viewUser(item)">
                                            @{{ item.name }}
                                        </a>
                                    </td>
                                    <td>@{{ item.email }}</td>
                                    <td>@{{ item.phone }}</td>
                                    <td>@{{ item.gender }}</td>
                                    <td v-if="item.permission == 0">
                                        <span class="label label-success">
                                            {{ __('Nomal') }}
                                        </span>
                                    </td>
                                    <td v-if="item.permission == 1">
                                        <span class="label label-success">
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
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Show all image-->
    <div class="modal fade" id="all-images" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Images</h4>
                </div>
                <div class="modal-body row">
                    <div class="col-md-12 grid-image parent-container">
                        <a class="image-item" href="{{ asset('images/1.jpg')}}" target="blank" ><img src="{{ asset('images/1.jpg')}}" class="img-thumbnail img-responsive"></a>
                        <a class="image-item" href="{{ asset('images/2.jpg')}}" target="blank" ><img src="{{ asset('images/2.jpg')}}" class="img-thumbnail img-responsive"></a>
                        <a class="image-item" href="{{ asset('images/4.jpg')}}" target="blank" ><img src="{{ asset('images/4.jpg')}}" class="img-thumbnail img-responsive"></a>
                        <a class="image-item" href="{{ asset('images/4.jpg')}}" target="blank" ><img src="{{ asset('images/4.jpg')}}" class="img-thumbnail img-responsive"></a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end show all image -->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="update_customer(fillItem.id)">
                <div class="row">
                    <div class="col-md-8"><h4 class="modal-title" id="myModalLabel">{{ __('Edit Customer') }}</h4>
                    </div>
                    <div class="col-md-4 button-edit-customer">
                        <div class="btn btn-default">{{__('Hủy') }}</div>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-plus" aria-hidden="true"></i> {{ __('Update') }}
                        </button>
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
                                    <input type="text" class=" flexbox-grid-form-input form-control" id="inputlastname" v-model="fillItem.name">
                                </div>
                                <div class="col-md-12 flexbox-grid-form">
                                    <label class="text-title-field" for="inputemail">{{ __('Địa chỉ Email') }}</label>
                                    <input type="text" class="form-control flexbox-grid-form-input" id="inputemail" v-model="fillItem.email">
                                </div>
                                <div class="col-md-12 flexbox-grid-form">
                                    <label class="text-title-field" for="inputdate">{{ __('Ngày sinh') }}</label>
                                    <input type="date" class="form-control flexbox-grid-form-input" id="inputemail"  v-model="fillItem.birthday">
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
                                    <div class="col-md-12 flexbox-grid-form-item1">   
                                        <div class="flexbox-grid-form-item">
                                            <label class="text-title-field" for="inputfirstname">{{ __('Số điện thoại') }}</label>
                                            <input type="text" class="form-control flexbox-grid-form-input" id="inputfirstname" v-model="fillItem.phone">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 form-horizontal">
                            <div class="col-md-4">
                                <h4>{{ __('About') }}</h4>
                            </div>
                            <div class="col-md-8 flexbox-annotated-section-content">
                                <div class="col-md-12 flexbox-grid-form">
                                    <label class="text-title-field" for="inputlastname">{{ __('About') }}</label>
                                    <textarea class=" flexbox-grid-form-input form-control " placeholder="Nhập ghi chú về khách hàng..." rows="3" v-model="fillItem.about" ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="showUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                    <div class="modal-body">
                        <div>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="home">
                                    <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        {{ __('Information Customer') }}
                                    </div>
                                        <div class="panel-body">
                                            <div class="form-group col-md-4">
                                                <div class="box-body box-profile">
                                                    <div class="col-md-10">
                                                    <img class="img-responsive img-circle" src="{{ asset('images/4.jpg')}}" alt="User profile picture">    
                                                    <h3 class="profile-username text-center">
                                                    <i class="fa fa-leaf" aria-hidden="true"></i>
                                                    @{{ fillItem.name}}
                                                    </h3>
                                                    <a :href="'tel:' + fillItem.phone" class="btn btn-primary btn-block"><b>{{ __('Contact') }}</b></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-8" style="border-left: 1px solid #ddd">
                                                <div class="col-md-12">
                                                    <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
                                                        <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true"><i class="fa fa-info" aria-hidden="true"></i>{{ __('Infor') }}</a></li>
                                                        <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false"> <i class="fa fa-list" aria-hidden="true"></i> {{ __('List Bill') }}</a></li>
                                                        <li class=""><a href="#settings" data-toggle="tab" aria-expanded="false"><i class="fa fa-file-image-o" aria-hidden="true"></i> {{ __('Image') }}</a></li>
                                                    </ul>
                                                    <div class="tab-content">
                                                    <div class="tab-pane active" id="activity">
                                                        <div class="post">
                                                            <ul class="list-group list-group-unbordered">
                                                                <li class="list-group-item">
                                                                    <b><i class="fa fa-phone" aria-hidden="true"></i>{{ __('Phone') }} :</b>
                                                                    <a>@{{ fillItem.phone}}</a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                                                    <b>{{ __('Gmail') }}:</b>
                                                                    <a>
                                                                        @{{ fillItem.email }}
                                                                    </a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b><i class="fa fa-transgender" aria-hidden="true"></i>{{ __('Gender') }} :</b><a>@{{ fillItem.gender }}</a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b><i class="fa fa-id-card" aria-hidden="true"></i> {{ __('Permistion') }} :</b>
                                                                    <a>
                                                                        <span  v-if="fillItem.permission == 0" class="label label-success">
                                                                            {{ __('Nomal') }}
                                                                        </span>
                                                                        <span  v-if="fillItem.permission == 1" class="label label-success">
                                                                            {{ __('Assistant') }}
                                                                        </span>
                                                                        <span  v-if="fillItem.permission == 2" class="label label-success">
                                                                            {{ __('Main_Worker') }}
                                                                        </span>
                                                                        <span  v-if="fillItem.permission == 3" class="label label-success">
                                                                            {{ __('Admin') }}
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b><i class="fa fa-birthday-cake" aria-hidden="true"></i> {{ __('Gender') }} :</b><a> @{{ fillItem.birthday }}</a>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <b><i class="fa fa-bandcamp" aria-hidden="true"></i> {{ __('About') }} :</b><a> @{{ fillItem.about }}</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    {{-- List bill --}}
                                                    <div class="tab-pane" id="timeline">
                                                        <ul class="timeline timeline-inverse">
                                                            <li class="time-label" v-for="showBill in showBills" >
                                                                <span class="bg-red">
                                                                  @{{ showBill.created_at }}
                                                                </span>
                                                                <br/>
                                                                <div class="col-md-offset-1">
                                                                    <table class="table">
                                                                        <tbody>
                                                                            <tr>
                                                                            <td>
                                                                            <a href="javascript:void(0)" v-on:click="viewBill(showBill.id)">{{ __('HD-') }}:@{{ showBill.id }}
                                                                            </a></td>
                                                                            <td v-if="showBill.department">
                                                                            <a href="javascript:void(0)" v-on:click="viewBill(showBill.id)">
                                                                               @{{ showBill.department.name}}
                                                                               </a>
                                                                            </td>
                                                                            <td>@{{ showBill.grand_total }} VND</td>
                                                                            <td>
                                                                                <a href="javascript:void(0)" class="btn btn-success" v-on:click="viewBill(showBill.id)">
                                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                                </a>
                                                                            </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="tab-pane" id="settings">
                                                        <div class="timeline-item">
                                                            <div role="tabpanel" class="tab-pane" id="messages">
                                                                <div class="modal-body row">
                                                                    <div class="col-md-12 grid-image parent-container">
                                                                        <a class="image-item" href="{{ asset('images/1.jpg')}}" target="blank" ><img src="{{ asset('images/1.jpg')}}" class="img-thumbnail img-responsive"></a>
                                                                        <a class="image-item" href="{{ asset('images/2.jpg')}}" target="blank" ><img src="{{ asset('images/2.jpg')}}" class="img-thumbnail img-responsive"></a>
                                                                        <a class="image-item" href="{{ asset('images/4.jpg')}}" target="blank" ><img src="{{ asset('images/4.jpg')}}" class="img-thumbnail img-responsive"></a>
                                                                        <a class="image-item" href="{{ asset('images/4.jpg')}}" target="blank" ><img src="{{ asset('images/4.jpg')}}" class="img-thumbnail img-responsive"></a>
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
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="messages">
                                    <div class="modal-body row">
                                        <div class="col-md-12 grid-image parent-container">
                                            <a class="image-item" href="{{ asset('images/1.jpg')}}" target="blank" ><img src="{{ asset('images/1.jpg')}}" class="img-thumbnail img-responsive"></a>
                                            <a class="image-item" href="{{ asset('images/2.jpg')}}" target="blank" ><img src="{{ asset('images/2.jpg')}}" class="img-thumbnail img-responsive"></a>
                                            <a class="image-item" href="{{ asset('images/4.jpg')}}" target="blank" ><img src="{{ asset('images/4.jpg')}}" class="img-thumbnail img-responsive"></a>
                                            <a class="image-item" href="{{ asset('images/4.jpg')}}" target="blank" ><img src="{{ asset('images/4.jpg')}}" class="img-thumbnail img-responsive"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="create-user" role="dialog" aria-labelledby="myModalLabel">
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

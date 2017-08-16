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
                <input id="myInput" onkeyup="myFunction()" placeholder="Search for phone number..">
            </div>
        </div>
        <div class="col-md-4 col-md-offset-2">
            <label class="col-md-4">{{ __('Number User') }}</label>
            <div class="form-group col-md-8 select_booking_manage">
                <select  class="form-control" id="sel1" v-on:change="selectPerPage">
                    <option value="" selected>{{ __('Select') }}</option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
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
                                        <a href="javascript:void(0)" v-on:click="edit_Service(item)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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
    <div class="modal fade" id="showUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('Detail Customer') }}</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="createItem">
                        <div class="panel panel-success">
                            <div class="panel-heading">{{__('Information')}}</div>
                            <div class="panel-body">
                                <div class="col-sm-4">
                                    <p>Name:  @{{ fillItem.name }} </p>
                                    <p>Email:  @{{ fillItem.email }} </p>
                                </div>
                                <div class="col-sm-4">
                                    <p>Phone:  @{{fillItem.phone}} </p>
                                    <p>
                                        {{__('Gender:') }}
                                        <span class="label label-danger">
                                            @{{ fillItem.gender }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-sm-4">
                                    <p>Birthday: @{{ fillItem.birthday }}</p>
                                </div>
                            </div>
                            <br>
                            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                {{ __('About Customer') }}
                            </button>
                            <br>
                            <div class="collapse" id="collapseExample">
                                <div class="well">
                                    @{{ fillItem.about }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
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
    <div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                                                {{ __('male') }}
                                            </option>
                                            <option value="female">female</option>
                                            <option value="orther">orther</option>
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
        {{-- edit service --}}
        <div class="modal fade" id="edit_Service" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{ __('Update Service') }}</h4>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateService(fillItem.id)">
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <span class="text-danger">(*)</span>
                                <input type="text" name="name" class="form-control" v-model="fillItem.name"/>
                                <label for="name">{{ __('admin.Short_description') }}</label>
                                <input type="text" name="short_description" class="form-control" v-model="fillItem.short_description"/>
                                <label for="name">{{ __('admin.Description') }}</label>
                                <textarea type="text" name="description" class="form-control" v-model="fillItem.description">
                                </textarea>
                                <label for="name">{{ __('Price') }}</label>
                                <span class="text-danger">(*)</span>
                                <input type="number" name="price" class="form-control" v-model="fillItem.price"/>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-plus" aria-hidden="true"></i> {{ __('Update') }}
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
    {{ Html::script('js/admin/manager_customer_admin.js') }}
@endsection
@extends('admin.master')
@section('style')
{{ Html::style('bower/AdminLTE/plugins/datatables/dataTables.bootstrap.css')}}
@endsection

@section('content')
<div class="content-wrapper" id="manager_servece">
    <section class="content-header">
        <h1>
            {{ _('Service') }}
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    {{ _('Home') }}
                </a>
            </li>
            <li>
                <a href="#">
                    {{ _('Manager') }}
                </a>
            </li>
            <li class="active">
                {{ _('Service') }}
            </li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ _('Manager Service') }}</h3>
                        <button class="col-md-offset-1 btn btn-success" v-on:click="addItem">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            {{ __('Create Service') }}
                        </button>
                    </div>
                    <div class="box-body over-flow-edit">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ _('ID') }}</th>
                                    <th>{{ __('admin.Name') }}</th>
                                    <th>{{ __('admin.Short_description') }}</th>
                                    <th>{{ __('admin.Description') }}</th>
                                    <th>{{ __('admin.Price') }}</th>
                                    <th>{{ __('admin.Avg_rate') }}</th>
                                    <th>{{ __('admin.Total_rate') }}</th>
                                    <th>{{ __('admin.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>name_1</td>
                                    <td>name_1@gmail.com</td>
                                    <td>0984010953</td>
                                    <td>12345678</td>
                                    <td>12/11/1994</td>
                                    <td>name_1.jpg</td>
                                    <td><a href=""><i class="fa fa-fw  fa-eyedropper get-color-icon-edit" ></i></a>
                                        <a href="#"><i class="fa fa-fw  fa-close get-color-icon-delete" ></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('Create Service') }}</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="createItem">
                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                                <span class="text-danger">(*)</span>
                                    <input type="text" name="name" class="form-control" v-model="newItem.name"/>
                                    <div v-if="formErrors.length == 2">
                                        <span v-if="formErrors['0']" class="error text-danger">
                                            @{{ formErrors['0'] }}
                                        </span>
                                    </div>
                                    <br>
                            <label for="name">{{ __('admin.Short_description') }}</label>
                                <input type="text" name="short_description" class="form-control" v-model="newItem.short_description"/>
                            <label for="name">{{ __('admin.Description') }}</label>
                                <textarea type="text" name="description" class="form-control" v-model="newItem.description">
                                </textarea>
                            <label for="name">{{ __('Price') }}</label>
                                <span class="text-danger">(*)</span>
                                <input type="number" name="price" class="form-control" v-model="newItem.price"/>
                                <div v-if="formErrors.length == 1">
                                    <span v-if="formErrors['0']" class="error text-danger">
                                        @{{ formErrors['0'] }}
                                    </span>
                                </div>
                                <span v-if="formErrors['1']" class="error text-danger">
                                    @{{ formErrors['1'] }}
                                </span>
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
@endsection

@section('script')
    {{ Html::script('js/admin/manage_service.js') }}
@endsection

@extends('admin.master')
@section('style')
{{ Html::style('bower/AdminLTE/plugins/datatables/dataTables.bootstrap.css')}}
@endsection

@section('content')
<div class="content-wrapper" id="manager_servece">
    <section class="content-header">
        <h1>
            {{ __('Service') }}
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
                {{ __('Service') }}
            </li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ __('Manager Service') }}</h3>
                        <button class="col-md-offset-1 btn btn-success" v-on:click="addItem">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            {{ __('Create Service') }}
                        </button>
                    </div>
                    <div class="box-body over-flow-edit">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
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
                                <tr v-for="item in items">
                                    <td>@{{ item.id }}</td>
                                    <td>@{{ item.name }}</td>
                                    <td>@{{ item.short_description }}</td>
                                    <td>@{{ item.description }}</td>
                                    <td>@{{ item.price }}</td>
                                    <td>@{{ item.avg_rate }}</td>
                                    <td>@{{ item.total_rate }}</td>
                                    <td>
                                        <a href="javascript:void(0)" v-on:click="edit_Service(item)"><i class="fa fa-fw  fa-eyedropper get-color-icon-edit" ></i></a>
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
                    <h4 class="modal-title" id="myModalLabel">{{ __('Create Service') }}</h4>
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

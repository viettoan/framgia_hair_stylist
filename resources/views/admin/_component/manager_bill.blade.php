@extends('admin.master')
@section('style')
{{ Html::style('bower/AdminLTE/plugins/datatables/dataTables.bootstrap.css')}}
@endsection

@section('content')
<div class="content-wrapper" id="manager_servece">
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
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ _('Manager List Bill') }}</h3>
                        <button class="col-md-offset-1 btn btn-success" v-on:click="addItem">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            {{ __('Create bill') }}
                        </button>
                    </div>
                    <div class="box-body over-flow-edit">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Customer_name') }}</th>
                                    <th>{{ __('Phone') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Service_total') }}</th>
                                    <th>{{ __('Grand_total') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>name_1</td>
                                    <td>0984010953</td>
                                    <td>display</td>
                                    <td>3</td>
                                    <td>800000</td>
                                    <td>
                                    <a href="#" class="btn btn-info"><i class="fa fa-edit "></i></a>
                                    <a class="btn btn-danger" href="#"><i class="fa fa-trash-o "></i></a>
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
                                <select class="form-control te">
                                  <option>Name 1</option>
                                  <option>Name 2</option>
                                </select>
                                    <br>
                            <label for="name">{{ __('Phone') }}</label>
                                <span class="text-danger">(*)</span>
                                <input type="text" name="phone" class="form-control"/>
                            <label for="name">{{ __('Service') }}:</label><br>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="inlineCheckbox1" value="option1"> Service 1
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="inlineCheckbox2" value="option2"> Service 2
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="inlineCheckbox3" value="option3"> Service 3
                                </label>
                                <br><br>    
                            <label for="name">{{ __('Price') }}</label>
                                <span class="text-danger">(*)</span>
                                <input type="number" name="price" class="form-control" v-model="newItem.price"/>
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
    {{-- {{ Html::script('js/admin/manage_service.js') }} --}}
@endsection

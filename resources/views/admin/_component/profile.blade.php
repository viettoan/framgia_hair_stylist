@extends('admin.master')
@section('style')
{{ Html::style('css/admin/style.css') }}
@endsection
@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="row" id="profile_customer">
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        @if(($user->avatar == '') || ($user->avatar == NULL))
                        <a class="image-item-profile" href={{ asset($user->avatar) }} target="blank" >
                            <img class="profile-user-img img-responsive img-circle" src={{ asset('bower/AdminLTE/dist/img/user4-128x128.jpg') }}  alt="User profile picture">
                        </a>
                        @else
                        <a class="image-item" href={{ asset($user->avatar) }} target="blank">
                            <img class="profile-user-img img-responsive img-circle" src={{ asset($user->avatar) }} alt="User profile picture">
                        </a>
                        @endif
                        <div class="clearfix"></div>
                        <br>
                        <h3 class="profile-username text-center">{{ $user->name }}</h3>
                        <br>
                        <ul class="list-group list-group-unbordered">
                            <li class="permistion_profile">
                                @if($user->permission == 0)
                                <b>{{ __('Permistion') }}</b> <a class="pull-right">
                                <span class="label label-success">
                                    {{ __('Nomal') }}
                                </span></a>
                                @endif
                                @if($user->permission == 1)
                                <b>{{ __('Permistion') }}</b>
                                <a class="pull-right">
                                    <span class="label label-success">
                                        {{ __('Assistant') }}
                                    </span>
                                </a>
                                @endif
                                @if($user->permission == 2)
                                <b>{{ __('Permistion') }}</b> <a class="pull-right">
                                <span class="label label-success">
                                    {{ __('Main_Worker') }}
                                </span>
                            </a>
                            @endif
                            @if($user->permission == 3)
                            <b>{{ __('Permistion') }}</b> <a class="pull-right">
                            <span class="label label-success">
                                {{ __('Admin') }}
                            </span>
                        </a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div> 
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-body box-profile">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home"><i class="fa fa-info" aria-hidden="true"></i> {{ __('INFOR') }}</a></li>
                    <li><a data-toggle="tab" href="#menu1" v-on:click="showBill('{{ $user->id }}')"><i class="fa fa-list" aria-hidden="true"></i> {{ __('LIST BILL') }}</a></li>
                    <li><a data-toggle="tab" href="#menu2" v-on:click="showImage('{{ $user->id }}')"><i class="fa fa-file-image-o" aria-hidden="true"></i> {{ __('Image') }}</a></li>
                    <a class="btn btn-success pull-right" href={{ route('admin.customer') }} ><i class="fa fa-arrow-left" aria-hidden="true"></i> Exit</a>
                </ul>

                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <div class="panel-body">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td class="col-md-3">
                                            <strong>
                                                <i class="fa fa-user-o"></i> Name
                                            </strong>
                                        </td>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3">
                                            <strong>
                                                <i class="fa fa-envelope-o"></i> Email
                                            </strong>
                                        </td>
                                        @if(($user->email == null) || ($user->email == ''))
                                        <td><span class="label label-success">NUll</span></td>
                                        @else
                                        <td>{{ $user->email }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3">
                                            <strong>
                                                <i class="fa fa-transgender"></i> Gender
                                            </strong>
                                        </td>
                                        <td>{{ $user->gender }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3">
                                            <strong>
                                                <i class="fa fa-birthday-cake"></i> Birthday
                                            </strong>
                                        </td>
                                        <td>
                                            {{ $user->birthday }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3">
                                            <strong>
                                                <i class="fa fa-address-card" aria-hidden="true"></i> Address
                                            </strong>
                                        </td>
                                        @if(($user->address == null) || ($user->address == ''))
                                        <td><span class="label label-success">NUll</span></td>
                                        @else
                                        <td>{{ $user->address }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td class="col-md-3">
                                            <strong>
                                                <i class="fa fa-bandcamp" aria-hidden="true"></i> About
                                            </strong>
                                        </td>
                                        @if(($user->about_me == null) || ($user->about_me == ''))
                                        <td><span class="label label-success">NUll</span></td>
                                        @else
                                        <td>{{ $user->about_me }}</td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <br>
                        <div class="col-md-3">

                            <h4 v-if=" showBills.length != 0"><span class="label label-success">
                                {{ __('Total Bill:') }} @{{ showBills.length }}
                            </span></h4>
                        </div>
                        <p v-if=" showBills.length == 0" class="alert alert-warning text-center"><i class="fa fa-smile-o" aria-hidden="true"></i> {{ __('NO BIll') }}</p>
                        <table class="table table-hover" v-if="showBills.length != 0 ">
                            <thead>
                                <tr>
                                    <th>{{  __('Deparment') }}</th>
                                    <th>{{  __('Created') }}</th>
                                    <th>{{ __('View') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="showBill in showBills">
                                    <td>@{{ showBill.department.name}}</td>
                                    <td>@{{ showBill.created_at }}</td>
                                    <td><a v-on:click="viewBill(showBill.id)"  class="btn btn-success"> <i class="fa fa-eye" aria-hidden="true"></i> </a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="menu2" class="tab-pane fade" v-if="showImages.length !=0 ">
                        <div v-for="image in showImages">
                            <div v-for="imgage in image.bookings.images">
                                <a class="image-item" v-bind:href="'/'+imgage.path_origin" target="blank" >
                                    <img v-bind:src="'/'+imgage.path_origin" class="img-thumbnail img-responsive"></a>
                                </div>
                            </div>
                        </div>
                        <div id="menu2" class="tab-pane fade" v-if="showImages.length ==0 ">
                            <p v-if=" showBills.length == 0" class="alert alert-warning text-center"><i class="fa fa-smile-o" aria-hidden="true"></i> {{ __('NO IMAGE') }}</p>
                        </div>
                    </div>
                </ul>
                <div class="modal fade" id="showBill_Detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close"  v-on:click="hideBill"  aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">{{ __('Bill Detail') }}</h4>
                            </div>
                            <div class="modal-body scroll_bill" >
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#bill_detail">{{ __('Infor') }}</a></li>
                                    <li><a data-toggle="tab" href="#image_bill">{{ __('Images') }}</a></li>
                                </ul>

                                <div class="tab-content">
                                    <div id="bill_detail" class="tab-pane fade in active">
                                        <div class="row">
                                            <div class="col-md-10 col-md-offset-1 border_bill col-xs-10 col-xs-offset-1" id="infor_bill_customer"> 
                                                <div class="bookingleft-agile font_bill" >
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th >{{__('ID : ') }}</th>
                                                                <th>FSL:@{{ showBillDetails.order_booking_id }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th>{{ __('Name Customer') }}</th>
                                                                <th>@{{ showBillDetails.customer_name}} - @{{ showBillDetails.phone }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>{{ __('Date Create') }}</th>
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
                                                        <div class="clearfix"></div>
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>{{ __('Service') }}</th>
                                                                    <th>{{ __('Stylist') }}</th>
                                                                    <th>{{ __('Qty') }}</th>
                                                                    <th>{{ __('Price') }}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody v-if="showBillDetails.booking">
                                                                <tr v-for=" service in showBillDetails.booking.get_order_items">
                                                                    <td>@{{ service.service_name }}</td>
                                                                    <td>@{{ service.stylist_name.name }}</td>
                                                                    <td>@{{ service.qty }}</td>
                                                                    <td>@{{ (service.price).toLocaleString('de-DE') }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="image_bill" class="tab-pane fade">
                                            <div class="col-md-10 col-md-offset-1 border_bill col-xs-10 col-xs-offset-1" id="scroll_image">
                                                <div v-if="showBillDetails.booking">
                                                    <div v-if="showBillDetails.booking.images.length !=0 " v-for="image in showBillDetails.booking.images"> 
                                                        <a class="image-item" v-bind:href="'/'+image.path_origin" target="blank" >
                                                            <img v-bind:src="'/'+image.path_origin" class="img-thumbnail img-responsive"></a>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
{{ Html::script('js/admin/profile_cusotmer_admin.js') }}
@endsection

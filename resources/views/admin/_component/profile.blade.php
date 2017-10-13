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
                        <a class="image-item-profile" href={{ asset($user->avatar) }} target="blank">
                            <img class="profile-user-img img-responsive img-circle" src={{ asset($user->avatar) }} alt="User profile picture">
                        </a>
                        @endif
                        <div class="clearfix"></div>
                        <br>
                        <h3 class="profile-username text-center">{{ $user->name }}</h3>
                        <br>
                        <ul class="list-group list-group-unbordered">
                            <li class="permistion_profile">
                                @if($user->permission == config('custom.permistion.nomal'))
                                <b> <i class="fa fa-snowflake-o" aria-hidden="true"></i> {{ __('Permistion') }}</b> <a class="pull-right">
                                <span class="label label-success">
                                    {{ __('Nomal') }}
                                </span></a>
                                @endif
                                @if($user->permission == config('custom.permistion.assistant'))
                                <b><i class="fa fa-snowflake-o" aria-hidden="true"></i> {{ __('Permistion') }}</b>
                                <a class="pull-right">
                                    <span class="label label-success">
                                        {{ __('Assistant') }}
                                    </span>
                                </a>
                                @endif
                                @if($user->permission == config('custom.permistion.main_worker'))
                                <b><i class="fa fa-snowflake-o" aria-hidden="true"></i> {{ __('Permistion') }}</b> <a class="pull-right">
                                <span class="label label-success">
                                    {{ __('Main_Worker') }}
                                </span>
                            </a>
                            @endif
                            @if($user->permission == config('custom.permistion.admin'))
                            <b><i class="fa fa-snowflake-o" aria-hidden="true"></i> {{ __('Permistion') }}</b> <a class="pull-right">
                            <span class="label label-success">
                                {{ __('Admin') }}
                            </span>
                            </a>
                            @endif
                        </li>
                        <br>
                        <li class="permistion_profile">
                            <b><i class="fa fa-user-o"></i> {{ __('Name') }}</b> <p class="pull-right">
                                {{ $user->name }}</p>
                        </li>
                        <br>
                        <li class="permistion_profile">
                            <b><i class="fa fa-phone" aria-hidden="true"></i> {{ __('Phone') }}</b> <p class="pull-right">
                                {{ $user->phone }}</p>
                        </li>
                        <br>
                        <li class="permistion_profile">
                             <b><i class="fa fa-envelope-o"></i> {{ __('Email') }}</b>
                             @if(empty($user->email))
                             <p class="pull-right"><span class="label label-success">NUll</span></p>
                             @else
                             <p class="pull-right">{{ $user->email }}</p>
                             @endif
                        </li>
                        <br>
                        <li class="permistion_profile">
                             <b><i class="fa fa-transgender"> </i>{{ __('Gender') }}</b> <p class="pull-right">
                               {{ $user->gender }}</p>
                        </li>
                        <br>
                        <li class="permistion_profile">
                            <b><i class="fa fa-birthday-cake"></i> {{ __('Birthday') }}</b> 
                            @if(empty($user->birthday))
                                <p class="pull-right"><span class="label label-success">NUll</span></p>
                            @else
                                <p class="pull-right">{{ date('d-m-Y', strtotime($user->birthday)) }}</p>
                            @endif
                        </li>
                        <br>
                        <li class="permistion_profile">
                             <b><i class="fa fa-address-card" aria-hidden="true"></i> {{ __('Address') }}</b> 
                            @if(empty($user->address))
                                <p class="pull-right"><span class="label label-success">NUll</span></p>
                            @else
                                <p class="pull-right">{{ $user->address }}</p>
                            @endif
                        </li>
                        <br>
                        <li class="permistion_profile">
                             <b><i class="fa fa-bandcamp" aria-hidden="true"></i> {{ __('Description') }}</b>
                            @if(empty($user->about_me))
                                <p class="pull-right"><span class="label label-success">NUll</span></td>
                            @else
                                <p class="pull-right">{{ $user->about_me }}</td>
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
                    <li class="active" ><a data-toggle="tab" href="#menu1"><i class="fa fa-list" aria-hidden="true"></i> {{ __('Bills') }} <span class="badge">{{ $countBill }}</span></a></li>
                    <li><a data-toggle="tab" href="#menu2" v-on:click="showImage('{{ $user->id }}')"><i class="fa fa-file-image-o" aria-hidden="true"></i> {{ __('Images') }}</a></li>
                    <a class="btn btn-success pull-right" href={{ route('admin.customer') }} ><i class="fa fa-arrow-left" aria-hidden="true"></i> Exit</a>
                </ul>

                <div class="tab-content">
                    <div id="menu1" class="tab-pane fade in active">
                        <br>
                        <div class="col-md-3">
                        </div>
                        @if( $billByCustomerId == null || $billByCustomerId == '')
                            <p class="alert alert-warning text-center"><i class="fa fa-smile-o" aria-hidden="true"></i> {{ __('NO BIll') }}</p>
                        @else
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('Department') }}</th>
                                    <th>{{  __('Created') }}</th>
                                    <th>{{ __('Grand Total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($billByCustomerId as $list)
                                <tr v-on:click="viewBill({{ $list->id }})">
                                    <td>{{ $list->Department->name }}</td>
                                    <td>{{ date_format($list->created_at,"d-m-Y | H:i") }}</td>
                                    <td>{{ number_format($list->grand_total) }} VND</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <hr>
                            <div class="pull-right total_bill_user" >
                            <strong>
                                {{ number_format($total) }} VND
                            </strong>
                            </div>
                        @endif
                    </div>
                    <div id="menu2" class="tab-pane fade" v-if="showImages.length !=0 ">
                        <div v-for="image in showImages">
                        <br>
                            <table class="table table-bordered">
                                <thead>
                                    <div>
                                        <strong>@{{ date }}</strong>
                                        <hr>
                                    </div>
                                </thead>
                                <tbody>
                                    <div v-for="imgage in image.bookings.images">
                                        <div class="text-center" style="margin-left: 50px;">
                                            <a class="image-item" v-bind:href="'/'+imgage.path_origin" target="blank" >
                                            <img v-bind:src="'/'+imgage.path_origin" class="img-thumbnail img-responsive"></a>
                                        </div>
                                    </div>
                                </tbody>
                            </table>
                        </div>
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

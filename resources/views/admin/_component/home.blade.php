@extends('admin.master')
@section('style')
    {{ Html::style('bower/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}
    {{ Html::style('css/admin/style.css') }}
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __('Sales Report') }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>{{ __('Home') }}</a></li>
            <li class="active">{{ __('sales report') }}</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-4 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ __('150') }}</h3>
                        <p>{{ __('Bill') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('admin.list_bill') }}" class="small-box-footer">{{ __('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>53<sup style="font-size: 20px">%</sup></h3>
                        <p>{{ __('Booking') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('admin.booking') }}" class="small-box-footer">{{ __('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ __('44') }}</h3>
                        <p>{{ __('Customer') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ route('admin.customer') }}" class="small-box-footer">{{ __('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 ">
                <div class="box">
                    <div class="box-header with-border">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#day">{{ __('Day') }}</a></li>
                            <li><a data-toggle="tab" href="#month">{{ __('Month') }}</a></li>
                            <li><a data-toggle="tab" href="#year">{{ __('Year') }}</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="day" class="tab-pane fade in active">
                                <h3 class="text-center">{{ __('Day Report') }}</h3>
                                <div class="col-md-6">
                                    <main>
                                      <p class="text-center">
                                        <strong>{{ __('Bar Chart Monthly Report') }} </strong>
                                    </p>
                                    <bar-chart-day></bar-chart-day>
                                    </main>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-center">
                                        <strong>{{ __('Stylist - Total Hair') }}</strong>
                                    </p>
                                    <div class="col-md-6">
                                        <div class="progress-group">
                                            <span class="progress-text">Stylist 1</span>
                                            <span class="progress-number"><b>160</b>/200</span>

                                            <div class="progress sm">
                                                <div class="progress-bar progress-bar-aqua" style="width: 10%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="progress-group">
                                            <span class="progress-text">Stylist 6</span>
                                            <span class="progress-number"><b>160</b>/200</span>

                                            <div class="progress sm">
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="month" class="tab-pane">
                                <h3 class="text-center">{{ __('Month Report') }}</h3>
                                <div class="col-md-6">
                                    <main>
                                      <p class="text-center">
                                        <strong>{{ __('Bar Chart Monthly Report') }} </strong>
                                    </p>
                                    <bar-chart-month></bar-chart-month>    
                                    </main>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-center">
                                        <strong>{{ __('Stylist - Total Hair') }}</strong>
                                    </p>
                                    <div class="col-md-6">
                                        <div class="progress-group">
                                            <span class="progress-text">Stylist 1</span>
                                            <span class="progress-number"><b>160</b>/200</span>

                                            <div class="progress sm">
                                                <div class="progress-bar progress-bar-aqua" style="width: 10%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="progress-group">
                                            <span class="progress-text">Stylist 6</span>
                                            <span class="progress-number"><b>160</b>/200</span>

                                            <div class="progress sm">
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="year" class="tab-pane">
                                <h3 class="text-center">{{ __('Year Report') }}</h3>
                                <div class="col-md-6">
                                    <main>
                                      <p class="text-center">
                                        <strong>{{ __('Bar Chart Monthly Report') }} </strong>
                                    </p>
                                    <bar-chart-year></bar-chart-year>    
                                    </main>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-center">
                                        <strong>{{ __('Stylist - Total Hair') }}</strong>
                                    </p>
                                    <div class="col-md-6">
                                        <div class="progress-group">
                                            <span class="progress-text">Stylist 1</span>
                                            <span class="progress-number"><b>160</b>/200</span>

                                            <div class="progress sm">
                                                <div class="progress-bar progress-bar-aqua" style="width: 10%"></div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="progress-group">
                                            <span class="progress-text">Stylist 6</span>
                                            <span class="progress-number"><b>160</b>/200</span>

                                            <div class="progress sm">
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%"></div>
                                            </div>
                                        </div>
                                        <div class="progress-group">
                                            <span class="progress-text">Stylist 7</span>
                                            <span class="progress-number"><b>310</b>/400</span>

                                            <div class="progress sm">
                                                <div class="progress-bar progress-bar-aqua" style="width: 17%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                                    <h5 class="description-header">$35,210.43</h5>
                                    <span class="description-text">TOTAL REVENUE</span>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                                    <h5 class="description-header">$10,390.90</h5>
                                    <span class="description-text">TOTAL COST</span>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
                                    <h5 class="description-header">$24,813.53</h5>
                                    <span class="description-text">TOTAL PROFIT</span>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <div class="description-block">
                                    <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
                                    <h5 class="description-header">1200</h5>
                                    <span class="description-text">GOAL COMPLETIONS</span>
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
    {{ Html::script('bower/jsapi/index') }}
    {{ Html::script('https://unpkg.com/vue-chartjs/dist/vue-chartjs.full.min.js') }}
    {{ Html::script('js/admin/report.js') }}
@endsection

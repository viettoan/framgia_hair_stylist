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
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ __('150') }}</h3>
                        <p>{{ __('New Orders') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">{{ __('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>53<sup style="font-size: 20px">%</sup></h3>
                        <p>{{ __('Bounce Rate') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">{{ __('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ __('44') }}</h3>
                        <p>{{ __('User Registrations') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">{{ __('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ __('65') }}</h3>
                        <p>{{ __('Unique Visitors') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">{{ __('More info') }} <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 ">
                <div class="box">
                    <div class="box-header with-border">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="active" id ="day"><a href="#day" role="tab" data-toggle="tab">{{ __('Day') }}</a></li>
                            <li id ="week"><a href="#week" role="tab" data-toggle="tab">{{ __('Week') }}</a></li>
                            <li id ="monthly"><a href="#monthly" role="tab" data-toggle="tab">{{ __('Monthly') }}</a></li>
                        </ul>
                        <h3 class="text-center">{{ __('Monthly Report') }}</h3>
                        <div class="box-body  ">
                                <div class="col-md-6">
                                    <main>
                                      <p class="text-center">
                                        <strong>{{ __('Bar Chart Monthly Report') }} </strong>
                                    </p>
                                      <div id="bar-chart"></div>
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
                                        <div class="progress-group">
                                            <span class="progress-text">Stylist 2</span>
                                            <span class="progress-number"><b>310</b>/400</span>

                                            <div class="progress sm">
                                                <div class="progress-bar progress-bar-aqua" style="width: 5%"></div>
                                            </div>
                                        </div>
                                        <div class="progress-group">
                                            <span class="progress-text">Stylist 3</span>
                                            <span class="progress-number"><b>480</b>/800</span>

                                            <div class="progress sm">
                                                <div class="progress-bar progress-bar-aqua" style="width: 8%"></div>
                                            </div>
                                        </div>
                                        <div class="progress-group">
                                            <span class="progress-text">Stylist 4</span>
                                            <span class="progress-number"><b>480</b>/800</span>

                                            <div class="progress sm">
                                                <div class="progress-bar progress-bar-red" style="width: 2%"></div>
                                            </div>
                                        </div>
                                        <div class="progress-group">
                                            <span class="progress-text">Stylist 5</span>
                                            <span class="progress-number"><b>480</b>/800</span>

                                            <div class="progress sm">
                                                <div class="progress-bar progress-bar-aqua" style="width: 15%"></div>
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
                                        <div class="progress-group">
                                            <span class="progress-text">Stylist 8</span>
                                            <span class="progress-number"><b>480</b>/800</span>

                                            <div class="progress sm">
                                                <div class="progress-bar progress-bar-aqua" style="width: 13%"></div>
                                            </div>
                                        </div>
                                        <div class="progress-group">
                                            <span class="progress-text">Stylist 9</span>
                                            <span class="progress-number"><b>480</b>/800</span>

                                            <div class="progress sm">
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%"></div>
                                            </div>
                                        </div>
                                        <div class="progress-group">
                                            <span class="progress-text">Stylist 10</span>
                                            <span class="progress-number"><b>480</b>/800</span>
                                            <div class="progress sm">
                                                <div class="progress-bar progress-bar-green" style="width: 30%"></div>
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
            </div>
        </section>
    </div>
@endsection
@section('script')
    {{ Html::script('bower/jsapi/index') }}
    {{ Html::script('js/admin/report.js') }}
@endsection

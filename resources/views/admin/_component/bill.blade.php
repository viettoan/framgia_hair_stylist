@extends('admin.master')
@section('style')
    {{ Html::style('css/admin/bill.css') }}
    {{ Html::script('bower/jquery-2.1.4.min/index.js')}}
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header text-center">
        <h1>
            {{ __('Hair Salon Booking Bill ') }}
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="box">
            <div class="col-md-6 col-md-offset-3 bill_fix_height">
                <section class="booking-agile">
                    <div class="headbooking-agile">
                        <div class="bookingleft-agile">
                            <h2> {{ __('Your Bill') }} </h2>
                            <form action="#" method="get">
                                <div class="name-agile">
                                    <p>{{ __('Your name') }}</p>
                                    <input type="text" name="name" value="your name" >
                                </div>
                                <div class="phone-agile">
                                    <p> {{ __('Phone') }}  </p>
                                    <input type="text" name="phone" value="your phone">
                                </div>
                                <div class="arrival-agile">
                                    <p> {{ __('Check-in date') }}</p>
                                    <input type="date" class="date" id="datepicker">
                                </div>
                                <div class="departure-agile">
                                    <p> {{ __('Check-out date') }}</p>
                                    <input class="date" id="datepicker" type="date"/>
                                </div>
                                <div class="clear"></div>
                                <div class="stylist-agile">
                                    <p> {{ __('Stylist') }}</p>
                                    <select>
                                        <option value="">{{ __('stylist 1') }}</option>
                                        <option value="text">stylist 2</option>
                                        <option value="text">stylist 3</option>
                                        <option value="text">stylist 4</option>
                                    </select>
                                </div>
                                <div class="department-agile">
                                    <!--728x90-->
                                    <p>{{ __('Department') }}</p>
                                    <select>
                                        <option value="">department 1</option>
                                        <option value="text">department 2</option>
                                        <option value="text">department 3</option>
                                        <option value="text">department 4</option>
                                    </select>
                                </div>
                                <div class="clear"></div>
                                <div class="time-agile">
                                    <p>{{ __('Time') }}</p>
                                    <input class="date" id="datepicker" type="time"  />
                                </div>
                                <div class="service-agile">
                                    <p>{{ __('Service 1') }}</p>
                                    <select>
                                        <option value=""></option>
                                        <option value="text">HairCuts 1 - 50.000 VND</option>
                                        <option value="text">HairCuts 2 - 50.000 VND</option>
                                        <option value="text">HairCuts 3 - 50.000 VND</option>
                                        <option value="text">HairCuts 4 - 50.000 VND</option>
                                    </select>
                                </div>
                                <div class="clear"></div>
                                <div class="service-agile">
                                    <p>{{ __('Service 2') }}</p>
                                    <select>
                                        <option value=""></option>
                                        <option value="text">Shamppo 1 - 30.000 VND</option>
                                        <option value="text">Shampoo 2 - 30.000 VND</option>
                                        <option value="text">Shampoo 3 - 30.000 VND</option>
                                        <option value="text">Shampoo 4 - 30.000 VND</option>
                                    </select>
                                </div>
                                <div class="service-agile">
                                    <!--728x90-->
                                    <p>{{ __('Service 3') }}</p>
                                    <select>
                                        <option value=""></option>
                                        <option value="text">Nhuom 1 - 60.000 VND</option>
                                        <option value="text">Nhuom 2 - 60.000 VND</option>
                                        <option value="text">Nhuom 3 - 60.000 VND</option>
                                        <option value="text">Nhuom 4 - 60.000 VND</option>
                                    </select>
                                </div>
                                <div class="clear"></div>
                                <div class="phone-agile">
                                    <!--728x90-->
                                    <p>{{ __('Department Phone') }}</p>
                                    <input class="date" id="datepicker" type="text" value="+84 123 456 765" />
                                </div>
                                <div class="email-agile">
                                    <!--728x90-->
                                    <p>{{ __('Department Email') }}</p>
                                    <input type="email" name = "email" value="support@example.com">
                                </div>
                                <div class="address-agile">
                                    <!--728x90-->
                                    <p>{{ __('Address') }}</p>
                                    <input class="date" type="text" value="Street 434 Tran Khat Tran" />
                                </div>
                                <div class="total-agile ">
                                    <!--728x90-->
                                    <p>{{ __('Total') }}</p>
                                    <input class="date" type="text" value="80.000VND" />
                                </div>
                                <div class="clear"></div>
                                <div class="submit-agile">
                                    <input type="submit" value="check availability">
                                </div>
                                <div class="clear"></div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
            <div class="clear"></div>
            </div>
        </div>
    </section>
</div>
@endsection

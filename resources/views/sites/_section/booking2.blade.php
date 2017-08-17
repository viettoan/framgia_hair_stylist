<div id="fh5co-pricing" data-section="pricing">
    <div class="container">
        <div class="row">
            <div class="col-md-12 section-heading text-center">
                <h2 class="single-animate animate-pricing-1">{{ __('Booking Start') }}</h2>
            </div>
        </div>
        <div class="row" style="position: relative;">
            <div class="indicator hide frontend-booking-indicator">
                <div class="spinner"></div>
            </div>
            <div class="col-md-5 col-sm-12 col-xs-12" id="infor_user">
                <div class="price-box to-animate">
                    <div>
                        <form>
                            <label class="text-success form-name">
                                <h4>
                                    <i class="fa fa-info" aria-hidden="true"></i>
                                    {{ __('Input info') }}
                                </h4>
                            </label>
                            <div class="form-group">
                                <label for="search-name-input" class="search-name-input">
                                    <i class="fa fa-user" aria-hidden="true" style="font-size:23px"></i>
                                </label>
                                <input type="name" class="name-input form-control input-lg" v-model="newItem.name" placeholder="{{ __('Your name') }}">
                            </div>
                            <div class="form-group">
                                <label for="search-phone-input" class="search-phone-input">
                                    <i class="fa fa-phone" aria-hidden="true" style="font-size:23px"></i>
                                </label>
                                <input type="Phone" class="phone-input form-control input-lg" v-model="newItem.phone" placeholder="{{ __('Your phone number') }}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-sm-12 col-xs-12 choice_address" id="choice_address">
                <div class="price-box to-animate">
                    <label class="text-success form-name">
                        <h4> 
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                {{ __('Choose Deparment') }}
                        </h4>
                    </label>
                    <ul class="ul-booking department-booking">
                        <li class=" li-booking choose-department" v-for="item in items"
                        >
                        <a>
                            <div  v-bind:class="{den: selected.department_id == item.id}"
                            v-on:click="selectDepartment(item.id)">
                                <span class="a-booking" href="javascript:void(0)" >
                                    @{{ item.name }}
                                    <span class="span_address"> 
                                    @{{ item.address }} </span>
                                </span>
                            </div>
                        </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 choice_address" id="choice_list_time">
                <div class="price-box to-animate">
                    <div class="row">
                        <div class="wrap-stylist-choice col-md-5 col-sm-12">
                            <label class="text-success form-name">
                                <h4>
                                <i class="fa fa-user" aria-hidden="true"></i>
                                    {{ __('Choose Stylist') }}
                                </h4>
                            </label>
                            <div class="form-group">
                                <select class="form-control input-lg" id="sel1" v-on:change="changeStylist">
                                    <option  class="active " value="">{{ __('No Stylist Choosen')  }}</option>
                                    <option v-for="stylist in renderStylists" v-bind:value="stylist.id">
                                    @{{ stylist.name }}
                                </option>
                                </select>
                            </div>
                            <div class="wrap-choose-date">
                                <div>
                                    <ul class="ul-date-booking">
                                        <li class="li-date-booking">
                                        <div v-bind:class="{active1: selected.date == 1}" v-on:click="selectDay(1)">
                                            <a class="a-booking" href="javascript:void(0)" 
                                            >
                                                {{ __('Today') }}
                                            </a>
                                        </div>
                                        </li>
                                        <li class="li-date-booking">
                                        <div v-bind:class="{active1: selected.date == 2}" v-on:click="selectDay(2)">
                                            <a class="a-booking" href="javascript:void(0)" 
                                            >
                                                {{ __('Tomorrow') }}
                                            </a>
                                        </div>
                                        </li>
                                        <li class="li-date-booking">
                                            <div v-bind:class="{active1: selected.date == 3}" v-on:click="selectDay(3)">
                                                <a class="a-booking" href="javascript:void(0)" 
                                                >
                                                    {{__('The next day') }}
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="wrap-booking-time col-md-7 col-sm-12 col-xs-12 ">
                            <label class="text-success form-name">
                                <h4>
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    {{ __('Choose Time') }}
                                </h4>
                            </label>
                            <div class="booking-time">
                                <ul class="wrap-all-item ul-booking-time" >
                                    <li class="li-booking-time"  v-for="render in renderBookings">
                                        <div v-if="render.status == 0" v-on:click="full">
                                            <a class="a-time-booking" href="javascript:void(0)">  @{{ convertTimeMinute(render.time_start) }}
                                            </a>
                                            <div class="bottom-div-status full_booking">
                                                <span>@{{render.statusLabel }}</span>
                                            </div>
                                        </div>
                                        <div v-if="render.status == 1" v-on:click="selectTime(render.id)" v-bind:class="{active2: selected.render_id == render.id}">
                                            <a class="a-time-booking" href="javascript:void(0)">  @{{ convertTimeMinute(render.time_start) }}
                                            </a>
                                            <div class="bottom-div-status">
                                                <span>@{{render.statusLabel }}</span>
                                            </div>
                                        </div>
                                        <div v-if="render.status == 2" v-on:click="offDay">
                                            <a class="a-time-booking" href="javascript:void(0)">  @{{ convertTimeMinute(render.time_start) }}
                                            </a>
                                            <div class="bottom-div-status">
                                                <span>@{{render.statusLabel }}</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <button type="button" :disabled="!select_render_booking" v-on:click="clickBooking" class="btn btn-success booking_btn">
                                    <i class="fa fa-bookmark-o" aria-hidden="true"></i> 
                                    {{ __('Booking') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id ="order_booking">
                <div class="row fix-top">
                    <div class = "col-md-12 content" >
                        <div class="box-info">
                            <div class="logo-img">
                                <img src="/images/logo.png" alt="logo image">
                            </div>
                            <div class="text-center top_success">
                                <p class="success_booking">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    {{ __('Set the schedule to success') }}
                                </p>  
                                <p class="success_thank"><em>{{ __('Thank you!!!') }}</em></p>
                            </div>
                            <p class="label label-success customer-info"> {{ __('Customer information') }}
                            </p>
                            <div class="text-center">
                                <p class="name">@{{ newItem.name }}</p>
                                <p class="phone">@{{ newItem.phone }}</p>
                            </div>
                            <hr>
                            <div class="col-md-4 text-center right-border" style="">
                                <p class="label label-success">{{ __('Stylist information') }}</p>
                                <p>@{{ success_stylist.name }}</p>
                                <p>@{{ success_stylist.email }}</p>
                                <p>@{{ success_stylist.phone }}</p>
                            </div>
                            <div class="col-md-4 text-center right-border" style="">
                                <p class="label label-success">{{ __('Deparment information') }}</p>
                                <p>@{{ success_deparment.name }}</p>
                                <p>@{{ success_deparment.address }}</p>
                            </div>
                            <div class="col-md-4 text-center" style="">
                                <p class="label label-success">{{ __('Time information') }}</p>
                                <p>@{{ success_time.day }}</p>
                                <p>@{{ success_time.time_start }}</p>
                            </div>
                            <br>
                            <div class="clearfix"></div>
                            <div class="exit-btn">
                                <a href="/">
                                    <button class="btn btn-info">{{ __('BACK') }}</button>
                                </a>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>

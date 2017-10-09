<div id="fh5co-pricing" data-section="pricing">
    <div class="container">
        <div class="row">
            <div class="col-md-12 section-heading text-center">
            </div>
        </div>
        <div class="row wrap-step booking_start">
            <div class="col-sm-4 zIndex-hr">
                <div class="wrap-icon-step step_mobile">
                    <a href="javascript:void(0)" class="circle themed-background info-circle">
                        <img src = "/images/beard.png">
                    </a>
                    <h4 style="margin-left:-6%;" class="step_booking"><strong>STEP 1: </strong> Your information</h4>
                </div>
            </div>
            <hr class="hr-step">
            <div class="col-sm-4 wrap-overlap overlap-department">
                <div class="wrap-icon-step">
                    <a href="javascript:void(0)" class="circle themed-background department-circle">
                        {{-- <i class="fa fa-building" aria-hidden="true"></i> --}}
                        {{-- <img src = "/logo/13-512.png"> --}}
                        <img src = "/images/beard.png"> 
                    </a>
                    <h4 class="step_booking"><strong>STEP 2: </strong> Departments</h4>
                </div>
                <div class="overlap">
                </div>
            </div>
            <div class="col-sm-4 wrap-overlap overlap-booking">
                <div class="wrap-icon-step">
                    <a href="javascript:void(0)" class="circle themed-background booking-circle">
                        <img src = "/images/cut.png">
                    </a>
                    <h4 class="step_booking"><strong>STEP 3: </strong>Booking time</h4>
                </div>
                <div class="overlap">
                </div>
            </div>
        </div>
        <hr>
        <div class="content-step">
            <div id="infor_user">
                <div class="price-box to-animate info-group-form">
                    <form>
                        <label class="text-success form-name">
                            <h4>
                                <i class="fa fa-info" aria-hidden="true"></i>
                                {{ __('Input info') }}
                            </h4>
                        </label>
                        <div class="form-group">
                            <label for="search-name-input" class="search-name-input">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </label>
                            <input type="name" class="name-input form-control input-lg" v-model="newItem.name" placeholder="{{ __('Your name') }}">
                        </div>
                        <div class="form-group">
                            <label for="search-phone-input" class="search-phone-input">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                            </label>
                            <input type="Phone" class="phone-input form-control input-lg" v-model="newItem.phone" placeholder="{{ __('Your phone number') }}">
                        </div>
                        <button type="button" v-on:click="phoneNameValidation" class="btn btn-primary step-button first-step"> <p id="next_step" >Next step</p>
                            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="content-step2">
            <div id="choice_address">
                <div class="price-box infor_box_customer to-animate department-group-form">
                    <label class="text-success form-name">
                        <h4> 
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                {{ __('Choose Deparment') }}
                        </h4>
                    </label>
                    <ul class="ul-booking department-booking">
                        <li class="li-booking choose-department"  id="department_mobile" v-for="item in items">
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
                    <button type="button" class="btn btn-primary step-button prev-step" v-on:click="prevStep">
                        <p id="prevStep_mobile">Prev step</p> 
                        <i class="fa fa-angle-double-left" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btn btn-primary step-button second-step" v-on:click="nextBookingStep">
                        <p id="nextStep_mobile">Next step</p> 
                        <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                    </button>
                    
                </div>
            </div>
        </div>
        <div class="content-step3">
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
                                            <a class="a-booking" href="javascript:void(0)">
                                                {{ __('Today') }}
                                            </a>
                                        </div>
                                        </li>
                                        <li class="li-date-booking">
                                        <div v-bind:class="{active1: selected.date == 2}" v-on:click="selectDay(2)">
                                            <a class="a-booking" href="javascript:void(0)">
                                                {{ __('Tomorrow') }}
                                            </a>
                                        </div>
                                        </li>
                                        <li class="li-date-booking">
                                            <div v-bind:class="{active1: selected.date == 3}" v-on:click="selectDay(3)">
                                                <a class="a-booking" href="javascript:void(0)">
                                                    {{__('Next Day') }}
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
                                    {{ __('Book') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id ="order_booking">
                <div class="row fix-top">
                    <div class = "col-md-12 content">
                        <div class="box-info">
                            <div class="text-center top_success">
                                <div>
                                    <i class="fa fa-check-square-o fa-3x" aria-hidden="true"></i>
                                </div>
                                <div class="success_booking">
                                    <h2>{{ __('Success_bill') }}</h2>
                                </div>  
                            </div>
                            <div class="col-md-6 box-sub-info">
                                <div class="col-md-12 text-center right-border">
                                    <i class="fa fa-user fa-2x" aria-hidden="true"></i>
                                    <p class="name">@{{ newItem.name }}</p>
                                    <p><a :href="'tel:' + newItem.phone">@{{ newItem.phone }}</a></p>
                                    
                                </div>
                                <div class="col-md-12 text-center right-border" style="">
                                    <hr>
                                    <i class="fa fa-scissors fa-2x" aria-hidden="true"></i>
                                    <p>@{{ success_stylist.name }}</p>
                                    <p><a :href="'mailto:' + success_stylist.email">@{{ success_stylist.email }}</a></p>
                                    <p><a :href="'tel:' + success_stylist.phone">@{{ success_stylist.phone }}</a></p>
                                </div>
                            </div>
                            <div class="col-md-6 box-sub-info">
                                <div class="col-md-12 text-center" style="">
                                    <i class="fa fa-home fa-2x" aria-hidden="true"></i>
                                    <p>@{{ success_deparment.name }}</p>
                                    <p>@{{ success_deparment.address }}</p>
                                </div>
                                <div class="col-md-12 text-center" style="">
                                    <hr>
                                    <i class="fa fa-clock-o fa-2x" aria-hidden="true"></i>
                                    <p>@{{ success_time.day }}</p>
                                    <p>@{{ success_time.time_start }}</p>
                                </div>
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

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
            <div class="col-md-5 col-sm-12" id="infor_user">
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
            <div class="col-md-7 col-sm-12 choice_address" id="choice_address">
                <div class="price-box to-animate">
                    <label class="text-success form-name">
                        <h4> 
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                {{ __('Choose Deparment') }}
                        </h4>
                    </label>
                    <ul class="ul-booking department-booking">
                        <li class=" li-booking choose-department">
                            <a class="a-booking" href="javascript:void(0)" >
                                36 Trần Quốc Hoàn 
                                <span class="span_address">Q.Cầu Giấy - HN </span>
                            </a>
                        </li>
                        <li class=" li-booking choose-department">
                            <a class="a-booking" href="javascript:void(0)" >
                                36 Trần Quốc Hoàn 
                                <span class="span_address">Q.Cầu Giấy - HN </span>
                            </a>
                        </li>
                        <li class=" li-booking choose-department">
                            <a class="a-booking" href="javascript:void(0)" >
                                36 Trần Quốc Hoàn 
                                <span class="span_address">Q.Cầu Giấy - HN </span>
                            </a>
                        </li>
                        <li class=" li-booking choose-department">
                            <a class="a-booking" href="javascript:void(0)" >
                                36 Trần Quốc Hoàn 
                                <span class="span_address">Q.Cầu Giấy - HN </span>
                            </a>
                        </li>
                        <li class=" li-booking choose-department">
                            <a class="a-booking" href="javascript:void(0)" >
                                36 Trần Quốc Hoàn 
                                <span class="span_address">Q.Cầu Giấy - HN </span>
                            </a>
                        </li>
                        <li class=" li-booking choose-department">
                            <a class="a-booking" href="javascript:void(0)" >
                                36 Trần Quốc Hoàn
                                <span class="span_address">Q.Cầu Giấy - HN </span>
                            </a>
                        </li>
                        <li class=" li-booking choose-department">
                            <a class="a-booking" href="javascript:void(0)" >
                                36 Trần Quốc Hoàn 
                                <span class="span_address">Q.Cầu Giấy - HN </span>
                            </a>
                        </li>
                        <li class=" li-booking choose-department">
                            <a class="a-booking" href="javascript:void(0)" >
                                36 Trần Quốc Hoàn 
                                <span class="span_address">Q.Cầu Giấy - HN </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 choice_address" id="choice_list_time">
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
                                    <option>Test</option>
                                    <option>Test</option>
                                    <option>Test</option>
                                    <option>Test</option>
                                    <option>Test</option>
                                    <option>Test</option>
                                    <option>Test</option>
                                    <option>Test</option>
                                    <option>Test</option>
                                    <option>Test</option>
                                    <option>Test</option>
                                    <option>Test</option>
                                    <option>Test</option>
                                </select>
                            </div>
                            <div class="wrap-choose-date">
                                <div>
                                    <ul class="ul-date-booking">
                                        <li class="li-date-booking">
                                            <a class="a-booking" href="javascript:void(0)" >
                                                Today
                                                <span class="span_address">8/4</span>
                                            </a>
                                        </li>
                                        <li class="li-date-booking">
                                            <a class="a-booking" href="javascript:void(0)" >
                                                Tomorow
                                                <span class="span_address">9/4</span>
                                            </a>
                                        </li>
                                        <li class="li-date-booking">
                                            <a class="a-booking" href="javascript:void(0)" >
                                                The next day
                                                <span class="span_address">10/4</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="wrap-booking-time col-md-7 col-sm-12">
                            <label class="text-success form-name">
                                <h4>
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    {{ __('Choose Time') }}
                                </h4>
                            </label>
                            <div class="booking-time">
                                <ul class="wrap-all-item ul-booking-time">
                                    <li class="li-booking-time">
                                        <a class="a-time-booking" href="javascript:void(0)"> 10:05
                                        </a>
                                        <div class="bottom-div-status">
                                            <span>Full</span>
                                        </div>
                                    </li>
                                    <li class="li-booking-time">
                                        <a class="a-time-booking" href="javascript:void(0)"> 10:15
                                        </a>
                                        <div class="bottom-div-status">
                                            <span>Full</span>
                                        </div>
                                    </li>
                                    <li class="li-booking-time">
                                        <a class="a-time-booking" href="javascript:void(0)"> 10:30
                                        </a>
                                        <div class="bottom-div-status">
                                            <span>Full</span>
                                        </div>
                                    </li>
                                    <li class="li-booking-time">
                                        <a class="a-time-booking" href="javascript:void(0)"> 10:45
                                        </a>
                                        <div class="bottom-div-status">
                                            <span>Full</span>
                                        </div>
                                    </li>
                                    <li class="li-booking-time">
                                        <a class="a-time-booking" href="javascript:void(0)"> 11:00
                                        </a>
                                        <div class="bottom-div-status">
                                            <span>Full</span>
                                        </div>
                                    </li>
                                    <li class="li-booking-time">
                                        <a class="a-time-booking" href="javascript:void(0)"> 11:15
                                        </a>
                                        <div class="bottom-div-status">
                                            <span>Full</span>
                                        </div>
                                    </li>
                                    <li class="li-booking-time available-booking">
                                        <a class="a-time-booking" href="javascript:void(0)"> 11:30
                                        </a>
                                        <div class="bottom-div-status">
                                            <span>Available</span>
                                        </div>
                                    </li>
                                    <li class="li-booking-time available-booking">
                                        <a class="a-time-booking" href="javascript:void(0)"> 11:45
                                        </a>
                                        <div class="bottom-div-status">
                                            <span>Available</span>
                                        </div>
                                    </li>
                                    <li class="li-booking-time available-booking">
                                        <a class="a-time-booking" href="javascript:void(0)"> 11:50
                                        </a>
                                        <div class="bottom-div-status ">
                                            <span>Available</span>
                                        </div>
                                    </li>
                                    <li class="li-booking-time available-booking">
                                        <a class="a-time-booking " href="javascript:void(0)"> 16:05
                                        </a>
                                        <div class="bottom-div-status">
                                            <span>Available</span>
                                        </div>
                                    </li>
                                    <li class="li-booking-time available-booking">
                                        <a class="a-time-booking" href="javascript:void(0)"> 16:05
                                        </a>
                                        <div class="bottom-div-status">
                                            <span>Available</span>
                                        </div>
                                    </li>
                                </ul>
                                <button type="button" v-on:click="clickBooking" class="btn btn-success booking_btn">
                                    <i class="fa fa-bookmark-o" aria-hidden="true"></i> 
                                    {{ __('Booking') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

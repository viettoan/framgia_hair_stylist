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
            <div class="col-md-4 col-sm-6" id="infor_user">
                <div class="price-box to-animate">
                    <div>
                        <form>
                            <label class="text-success">
                                <h4>
                                    <i class="fa fa-info" aria-hidden="true"></i>
                                    {{ __('Input info') }}
                                </h4>
                            </label>
                            <div class="form-group">
                                <input type="name" class="form-control" v-model="newItem.name" placeholder="{{ __('Your name') }}">
                            </div>
                            <div class="form-group">
                                <input type="Phone" class="form-control" v-model="newItem.phone" placeholder="{{ __('Your phone number') }}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 choice_address" id="choice_address">
                <div class="price-box to-animate">
                    <h4> 
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                            {{ __('Choice Deparment') }}
                    </h4>
                    <div class="row">
                        <div v-for="item in items">
                            <div v-bind:class="{den: selected.department_id == item.id}" class="choose-department ok" v-on:click="selectDepartment(item.id)">
                                <a href="javascript:void(0)" >
                                    @{{ item.name }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr/>
                        <h4>
                            <i class="fa fa-calendar-o" aria-hidden="true"></i>
                            {{ __('Choice Day') }}
                        </h4>
                    <div>
                        <div class="table-responsive">
                            <table class="table select-day">
                            <tr>
                                <td class="danger" v-bind:class="{active: selected.date == 1}" v-on:click="selectDay(1)">{{ __('Today') }}</td>
                                <td class="danger" v-bind:class="{active: selected.date == 2}" v-on:click="selectDay(2)">{{ __('Tomorrow') }}</td>
                                <td class="danger"  v-bind:class="{active: selected.date == 3}" v-on:click="selectDay(3)">{{ __('Next Day') }}</td>
                            </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6" id="choice_list_time">
                <div class="price-box to-animate">
                    <div>
                        <h4>
                        <i class="fa fa-user" aria-hidden="true"></i>
                            {{ __('Choice Stylist') }}
                        </h4>
                
                        <div class="form-group">
                            <select class="form-control" id="sel1" v-on:change="changeStylist">
                                <option  class="active" value="">{{ __('No Choice Stylist')  }}</option>
                                <option v-for="stylist in renderStylists" v-bind:value="stylist.id">
                                    @{{ stylist.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <h4>
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        {{ __('Choice Time') }}
                    </h4>
                    <div>
                        <div v-for="render in renderBookings" class="text-center">
                            <div v-if="render.status == 0">
                                <div class="choice-time-full" v-on:click="full">
                                    <a href="javascript:void(0)">
                                        @{{ convertTimeMinute(render.time_start) }}
                                    </a>
                                    <br/>
                                    <span class="label label-warning">@{{render.statusLabel }}</span>
                                </div>
                            </div>
                            <div v-if="render.status == 1" class="select-time" v-on:click="selectTime(render.id)">
                                <div  v-bind:class="{active: selected.render_id == render.id}" class="choice-time">
                                    <a href="javascript:void(0)">@{{ convertTimeMinute(render.time_start) }}</a>
                                     <br/>
                                    <span class="label label-success">@{{render.statusLabel }}</span>
                                </div>
                            </div>
                            <div v-if="render.status == 2">
                                <div class="choice_time" v-on:click="offDay">
                                    <a href="javascript:void(0)">@{{ convertTimeMinute(render.time_start) }}</a>
                                     <br/>
                                    <span class="label label-success">@{{render.statusLabel }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" :disabled="!select_render_booking" v-on:click="clickBooking" class="btn btn-success booking_btn">
                        <i class="fa fa-bookmark-o" aria-hidden="true"></i> 
                        {{ __('Booking') }}
                    </button>
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

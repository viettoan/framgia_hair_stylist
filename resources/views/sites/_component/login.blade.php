@extends('sites.master')

@section('siteTitle', __('Login'))

@section('style')
    {{ Html::style('bower/bootstrap/dist/css/bootstrap.css') }}
    {{ Html::style('css/login/style_login.css') }}
@endsection
@section('content')
        <div class="row" id="pwd-container">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <section class="login-form">
                    <form role="login" method="POST" enctype="multipart/form-data" v-on:submit.prevent="login">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div  class="text-center">
                                <span v-for="error in formErrors">
                                    <span class="error text-danger">
                                        <h4>@{{ error }}</h4>
                                    </span>
                                </span>   
                            </div>
                        <input  name="email_or_phone" v-model="newItem.email_or_phone" class="form-control input-lg" placeholder="{{ trans('site.email_phone')}}"/>
                            <span v-if="formErrors['email_or_phone']" class="error text-danger">
                                @{{ formErrors['email_or_phone'][0] }}
                            </span>
                        <br>
                        <input type="password" class="form-control input-lg" v-model="newItem.password" name="password" placeholder="{{ trans('site.password')}}" />
                            <span v-if="formErrors['password']" class="error text-danger">
                                @{{ formErrors['password'][0] }}
                            </span>
                        <br>
                        <div class="pwstrength_viewport_progress"></div>
                        <button type="submit"  id = "button" name="go" class="btn btn-lg btn-primary btn-block">
                            {{ trans('site.login') }}
                         </button>
                        <div>
                            <a href="{{ route('site.resgiter') }}">{{ trans('site.create_account') }}</a> | 
                            <a href="#">{{ trans('site.reset_password') }}</a>
                        </div>
                    </form>

                    <div class="form-links">
                        <a href="#">{{ trans('site.web_hair') }}</a>
                    </div>
                </section>  
            </div>
            <div class="col-md-4"></div>
        </div>
@endsection
@section('script')
    {{ Html::script('sites_custom/js/login.js')}}
@endsection

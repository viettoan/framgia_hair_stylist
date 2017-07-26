@extends('sites.master')
@section('style')
    {{ Html::style('bower/bootstrap/dist/css/bootstrap.css') }}
    {{ Html::style('css/login/style_login.css') }}
@endsection
@section('content')
        <div class="row" id="pwd-container">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <section class="login-form">
                    <form method="POST" role="login">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="email" name="email" class="form-control input-lg" placeholder="{{ trans('site.email_phone')}}"/>
                        <input type="password" class="form-control input-lg" name="password" placeholder="{{ trans('site.password')}}" />
                        <div class="pwstrength_viewport_progress"></div>
                        <button type="submit" id = "button" name="go" class="btn btn-lg btn-primary btn-block"> {{ trans('site.sign_in') }}
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

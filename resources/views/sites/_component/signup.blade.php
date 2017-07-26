@extends('sites.master')

@section('style')
{{ Html::style('css/signup/style.css') }}
@endsection

@section('content')
<div class="row main">
    <div class="main-login main-center">
        <h1 class="text-center">{{ trans('site.resgiter') }}</h1>
        <form class="" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label for="email" class="cols-sm-2 control-label">{{ trans('site.mail') }}</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-envelope fa" aria-hidden="true"></i>
                        </span>
                        <input type="text" class="form-control" name="email" placeholder="{{ trans('site.enter_your_mail') }}"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="cols-sm-2 control-label">{{ trans('site.your_name') }}</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope fa" ></i></span>
                        <input type="text" class="form-control" name="name" placeholder="{{ trans('enter_your_name') }}"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="phone" class="cols-sm-2 control-label">{{ trans('site.phone') }}</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                        <input type="phone" class="form-control" name="phone" placeholder="{{ trans('site.your_phone_number') }}"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="cols-sm-2 control-label">{{ trans('site.password') }}</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                        <input type="password" class="form-control" name="password" placeholder="{{ trans('site.enter_your_password') }}"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="password_confirmation" class="cols-sm-2 control-label">
                    {{ trans('site.confirm_password') }}
                </label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-lock fa-lg" aria-hidden="true"></i>
                        </span>
                        <input type="password" class="form-control" name="password_confirmation"  placeholder="{{trans('site.confirm_password') }}"/>
                    </div>
                </div>
            </div>
            <div class="form-group ">
                <button type="submit" class="btn btn-lg btn-primary btn-block">{{ trans('site.resgiter') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection

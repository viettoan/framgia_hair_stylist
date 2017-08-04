@extends('sites.master')

@section('siteTitle', __('Register'))

@section('style')
{{ Html::style('css/signup/style.css') }}
@endsection

@section('content')
<div class="row main" id="resgiter">
    <div class="main-login main-center">
        <h1 class="text-center">{{ trans('site.resgiter') }}</h1>
        <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="createItem">
            <div class="form-group">
                <label for="email" class="cols-sm-2 control-label">{{ trans('site.mail') }}</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-envelope fa" aria-hidden="true  "></i>
                        </span>
                        <input type="text" class="form-control" name="email" v-model="newItem.email" placeholder="{{ trans('site.enter_your_mail') }}"/>
                    </div>
                    <div v-if="formErrors.length == 4">
                        <span v-if="formErrors['0']" class="error text-danger">
                            @{{ formErrors['0'] }}
                        </span>
                        <br>
                    </div>
                    <div v-if="formErrors.length == 2">
                        <span v-if="formErrors['0']" class="error text-danger">
                            @{{ formErrors['0'] }}
                        </span>
                        <br>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="cols-sm-2 control-label">{{ trans('site.your_name') }}</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope fa" ></i></span>
                        <input type="text" class="form-control" name="name" v-model="newItem.name" placeholder="{{ trans('enter_your_name') }}"/>
                    </div>
                        <span v-if="formErrors['2']" class="error text-danger">
                            @{{ formErrors['2'] }}
                        </span>
                        <br>
                </div>
            </div>
            <div class="form-group">
                <label for="phone" class="cols-sm-2 control-label">{{ trans('site.phone') }}</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                        <input type="number" class="form-control" name="phone"   v-model="newItem.phone" placeholder="{{ trans('site.your_phone_number') }}"/>
                    </div>
                    <div v-if="formErrors.length == 4">
                        <span v-if="formErrors['1']" class="error text-danger">
                            @{{ formErrors['1'] }}
                        </span>
                        <br>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="cols-sm-2 control-label">{{ trans('site.password') }}</label>
                <div class="cols-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                        <input type="password" class="form-control" name="password" v-model="newItem.password" placeholder="{{ trans('site.enter_your_password') }}"/>
                    </div>
                    <div v-if="formErrors.length == 4">
                        <span v-if="formErrors['3']" class="error text-danger">
                            @{{ formErrors['3'] }}
                        </span>
                        <br>
                    </div>
                    <div v-if="formErrors.length == 2">
                        <span v-if="formErrors['1']" class="error text-danger">
                            @{{ formErrors['1'] }}
                        </span>
                        <br>
                    </div>
                    <div v-if="formErrors.length == 1">
                        <span v-if="formErrors['0']" class="error text-danger">
                            @{{ formErrors['0'] }}
                        </span>
                        <br>
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
                        <input type="password" class="form-control" name="password_confirmation" v-model="newItem.password_confirmation" placeholder="{{trans('site.confirm_password') }}"/>
                    </div>
                </div>
            </div>
            <div class="form-group ">
                <button type="submit" class="btn btn-lg btn-primary btn-block">
                    {{ trans('site.resgiter') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
    {{ Html::script('js/sites/register.js')}}
@endsection

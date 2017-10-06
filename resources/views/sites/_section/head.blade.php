<nav class="navbar navbar-default navbar-fixed-top" id="fh5co-header">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
            </button>
            <a class="navbar-brand" href="#myPage"><img src="{{ asset('logo/cutmypic.png') }}" id="image_logo"></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#myPage"><i class="fa fa-home" aria-hidden="true"></i>{{ __('HOME') }}</a></li>
                <li><a href="#band">{{ __('SERVICE')}} </a></li>
                <li><a href="#tour">{{ __('ABOUT') }}</a></li>
                <li><a href="#contact">{{ __('STYLIST') }}</a></li>
                <li><a href="{{ route('site.login') }}" v-if="!users.id">{{ __('LOGIN') }}</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <img src="{{ asset('logo/user.png') }}" id="avatar_user" v-if="users.avatar == ''">
                        <img src="{{ asset('logo/user.png') }}" id="avatar_user" v-if="users.avatar">
                    </a>
                    <ul class="dropdown-menu">
                        <li v-if="users.name">
                            <a v-if="users.permission == 3" href="/admin/home" data-nav-section="login" >
                                <i class="fa fa-user-circle-o" aria-hidden="true"></i> @{{ users.name }}
                            </a>
                            <a v-else href="#" data-nav-section="login" >
                            <i class="fa fa-user-circle-o" aria-hidden="true"></i> @{{ users.name }}
                            </a>
                        </li>
                        <li v-if="users.name">
                            <a href="javascript:void(0)" v-on:click="logout" data-nav-section="login" >
                                <span>
                                    <i class="fa fa-sign-out" aria-hidden="true"></i>{{ trans('site.logout') }}
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<br>

<header class="main-header" id="header_admin">
    <a href="#" class="logo">
        <span class="logo-lg"><b>{{ __('Hair Salon ') }}</b></span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ __('Toggle navigation') }}</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src={{ asset('bower/AdminLTE/dist/img/user2-160x160.jpg') }} class="user-image" alt="User Image">
                        <span class="hidden-xs"> @{{ users.name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src={{ asset('bower/AdminLTE/dist/img/user2-160x160.jpg') }} class="img-circle" alt="User Image">
                            <p>
                                @{{ users.name }}
                                <small> @{{ users.email }}</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">
                                    {{__("admin.Profile")}}
                                </a>
                            </div>
                            <div class="pull-right">
                                <a href="javascript:void(0)" v-on:click="logout" class="btn btn-default btn-flat">{{ __('admin.Sign_out') }}</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

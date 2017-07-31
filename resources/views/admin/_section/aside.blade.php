<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src={{ asset('bower/AdminLTE/dist/img/user2-160x160.jpg') }} class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ __('Alexander Pierce') }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> {{ __('Online') }}</a>
            </div>
        </div>
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <ul class="sidebar-menu">
            <li class="header">{{ __('MAIN NAVIGATION') }}</li>
            <li class=" treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                        <span>{{ __('Dashboard') }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active">
                        <a href="index.html"><i class="fa fa-circle-o"></i> {{ __('Dashboard v1') }}
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-table"></i> <span>{{ __('Manager') }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href={{ asset('admin/manager_customer')  }}><i class="fa fa-circle-o"></i>
                            {{ __('Manager Customer') }}
                        </a>
                    </li>
                    <li>
                        <a href={{ asset('admin/manager_booking') }}><i class="fa fa-circle-o"></i>
                            {{ __('Manager Booking') }}
                        </a>
                    </li>
                    <li>
                        <a href={{ asset('admin/manager_service') }}><i class="fa fa-circle-o"></i>
                            {{ __('Manager Sevirce') }}
                        </a>
                    </li>
                </ul>
            <li><a href="#"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
            <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
        </ul>
    </section>
</aside>

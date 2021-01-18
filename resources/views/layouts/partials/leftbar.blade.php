<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="{{ route('home') }}" class="waves-effect waves-primary{{ request()->is('home') ? ' active' : '' }}">
                        <span class="menu-icon"><i class="far fa-home"></i></span>
                        <span class="menu-item-title"> Home </span>
                        <span class="menu-arrow"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('issuelists.index') }}" class="waves-effect waves-primary{{ request()->is('issuelists') ? ' active' : '' }}">
                        <span class="menu-icon"><i class="far fa-home"></i></span>
                        <span class="menu-item-title"> {{ __('Issuelists')  }} </span>
                        <span class="menu-arrow"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('email.bounces') }}" class="waves-effect waves-primary{{ request()->is('email.bounces') ? ' active' : '' }}">
                        <span class="menu-icon"><i class="far fa-envelope"></i></span>
                        <span class="menu-item-title"> {{ __('Email bounces')  }} </span>
                        <span class="menu-arrow"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('email.servers') }}" class="waves-effect waves-primary{{ request()->is('email.servers') ? ' active' : '' }}">
                        <span class="menu-icon"><i class="far fa-server"></i></span>
                        <span class="menu-item-title"> {{ __('Email servers')  }} </span>
                        <span class="menu-arrow"></span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('users.index') }}"
                       class="waves-effect waves-primary{{ request()->is('users/*') ? ' active' : '' }}">
                        <span class="menu-icon"><i class="far fa-user-crown"></i></span>
                        <span class="menu-item-title"> {{ __('Users') }} </span>
                        <span class="menu-arrow"></span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('departments.index') }}"
                       class="waves-effect waves-primary{{ request()->is('Departments/*') ? ' active' : '' }}">
                        <span class="menu-icon"><i class="far fa-building"></i></span>
                        <span class="menu-item-title"> {{ __('Departments') }} </span>
                        <span class="menu-arrow"></span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('epics.index') }}"
                       class="waves-effect waves-primary{{ request()->is('Epics/*') ? ' active' : '' }}">
                        <span class="menu-icon"><i class="fa fa-cog"></i></span>
                        <span class="menu-item-title"> {{ __('Default Epics/Tasks') }} </span>
                        <span class="menu-arrow"></span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('quotations.create') }}"
                       class="waves-effect waves-primary{{ request()->is('Quotation/create/*') ? ' active' : '' }}">
                        <span class="menu-icon"><i class="fa fa-plus-square"></i></span>
                        <span class="menu-item-title"> {{ __('New quotations') }} </span>
                        <span class="menu-arrow"></span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('projects.index') }}"
                       class="waves-effect waves-primary{{ request()->is('Project/*') ? ' active' : '' }}">
                        <span class="menu-icon"><i class="fa fa-university"></i></span>
                        <span class="menu-item-title"> {{ __('Projects') }} </span>
                        <span class="menu-arrow"></span>
                    </a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="user-detail">
        <span class="user-info-span">
            <h5 class="m-t-0 m-b-0">{{ Auth::check() ? Auth::user()->name : '' }}</h5><br>
        </span>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="mdi mdi-power-settings"></i> {{ __('Logout') }}
        </a>
    </div>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>

<ul class="nav navbar-nav">
    @if(Auth::check())

        @permission(['view-territory'])
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Territory <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{{ route('territory.index') }}">Territory List</a></li>
            </ul>
        </li>
        @endpermission

        @permission(['view-target'] and false)
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Target <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{{ route('target.index') }}">Territory List</a></li>
            </ul>
        </li>
        @endpermission

        @permission(['view-employee'])
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Employee <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{{ route('employee.index') }}">Employee List</a></li>
                <li><a href="{{ route('emp.dept') }}">Department</a></li>
                <li><a href="{{ route('emp.desi') }}">Designation</a></li>
            </ul>
        </li>
        @endpermission

        @permission(['view-product'])
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Product <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{{ route('product.index') }}">Product List</a></li>
                <li><a href="{{ route('product.category') }}">Product Category</a></li>
                <li><a href="{{ route('product.unit') }}">Product Unit</a></li>
            </ul>
        </li>
        @endpermission

        @permission(['view-customer'])
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Customer <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{{ route('customer.index') }}">Customer List</a></li>
                <li><a href="{{ route('customer.category') }}">Customer Category</a></li>
                <li><a href="{{ route('customer.type') }}">Customer Type</a></li>
            </ul>
        </li>
        @endpermission

        @permission(['view-stakeholder'])
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Stakeholder Settings <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{{ route('stakeholder.index') }}">Stakeholder List</a></li>
            </ul>
        </li>
        @endpermission

        @permission(['view-user'])
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Settings <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{{ route('user.index') }}">User</a></li>
                <li><a href="{{ route('role.index') }}">Role</a></li>
                @role('sysadmin')
                <li><a href="{{ route('permission.index') }}">Permission</a></li>
                @endrole
            </ul>
        </li>
        @endpermission
    @endif

</ul>

<!-- Right Side Of Navbar -->
<ul class="nav navbar-nav navbar-right">
    <!-- Authentication Links -->
    @if (Auth::guest())
        <li><a href="{{ route('login') }}">Login</a></li>
    @else

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <ul class="dropdown-menu" role="menu">
                <li><a href="{{route('profile')}}">Profile</a></li>
                <li>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </li>
    @endif
</ul>
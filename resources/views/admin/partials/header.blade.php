<nav class="navbar navbar-expand bg-navbar dashboard-topbar mb-4">
    <button id="sidebarToggleTop" class="btn rounded-circle mr-3">
        <i class="la la-bars"></i>
    </button>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown border-left pl-3 ml-4">
            <a class="nav-link dropdown-toggle after-none" href="#" id="userDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="user-thumb user-thumb-sm position-relative">
                    <img src="{{asset('images/avatar default.png')}}" alt="author-image">
                    <div class="status-indicator bg-success"></div>
                </div>
                <span class="ml-2 small font-weight-medium d-none d-lg-inline">{{auth()->user()->name ?? "Guest"}}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right animated--grow-in py-2"
                 aria-labelledby="userDropdown">
                <a class="dropdown-item text-color font-size-15" href="#">
                    <i class="la la-user mr-2 text-gray font-size-18"></i>
                    Profile
                </a>
                <a class="dropdown-item text-color font-size-15" href="{{route('admin.organization.index')}}">
                    <i class="la la-plus-circle mr-2 text-gray font-size-18"></i>
                    Add Listing
                </a>
                <a class="dropdown-item text-color font-size-15" href="{{route('admin.logout')}}">
                    <i class="la la-power-off mr-2 text-gray font-size-18"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav><!-- end dashboard-topbar -->

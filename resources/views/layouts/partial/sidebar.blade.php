  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
      <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="{{config('app.name')}} Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{config('app.name')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('dist/img/Omidjan Zazai.jpeg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{route('home')}}" class="nav-link {{ session('menu') == 'Dashboard' ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          
          <li class="nav-item {{ session('menu') == 'Configuration' ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ session('menu') == 'Configuration' ? 'active' : '' }}">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Configuration
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if (Auth::user()->hasAccessDomain('Country'))
              <li class="nav-item">
                <a href="{{route('country.index')}}" class="nav-link {{ session('sub-menu') == 'Country' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Country</p>
                </a>
              </li>
              @endif
              @if (Auth::user()->hasAccessDomain('Province'))
              <li class="nav-item">
                <a href="{{route('province.index')}}" class="nav-link {{ session('sub-menu') == 'Province' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Province</p>
                </a>
              </li>
              @endif
              @if (Auth::user()->hasAccessDomain('District'))
              <li class="nav-item">
                <a href="{{route('district.index')}}" class="nav-link {{ session('sub-menu') == 'District' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>District</p>
                </a>
              </li>
              @endif
              @if (Auth::user()->hasAccessDomain('Village'))
              <li class="nav-item">
                <a href="{{route('village.index')}}" class="nav-link {{ session('sub-menu') == 'Village' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Village</p>
                </a>
              </li>
              @endif
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{route('donor.index')}}" class="nav-link {{ session('menu') == 'Donors' ? 'active' : '' }}">
              <i class="nav-icon fas fa-award"></i>
              <p>
                Donors
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('ministry.index')}}" class="nav-link {{ session('menu') == 'Ministries' ? 'active' : '' }}">
              <i class="nav-icon fas fa-dungeon"></i>
              <p>
                Ministries
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('un_agencies.index')}}" class="nav-link {{ session('menu') == 'UN Agencies' ? 'active' : '' }}">
              <i class="nav-icon fas fa-underline"></i>
              <p>
                UN Agencies
              </p>
            </a>
          </li>
          
          <li class="nav-item {{ session('menu') == '' ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ session('menu') == '' ? 'active' : '' }}">
              <i class="nav-icon fas fa-igloo"></i>
              <p>
                NGOs
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if (Auth::user()->hasAccessDomain('Inernational NGOs'))
              <li class="nav-item">
                <a href="{{route('user-show')}}" class="nav-link {{ session('sub-menu') == 'Inernational NGOs' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inernational NGOs</p>
                </a>
              </li>
              @endif
              @if (Auth::user()->hasAccessDomain('Local NGOs'))
              <li class="nav-item">
                <a href="{{route('user-show')}}" class="nav-link {{ session('sub-menu') == 'Local NGOs' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Local NGOs</p>
                </a>
              </li>
              @endif
            </ul>
          </li>

          <li class="nav-item {{ session('menu') == 'User Management' ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ session('menu') == 'User Management' ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                User Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if (Auth::user()->hasAccessDomain('All Users'))
              <li class="nav-item">
                <a href="{{route('user-show')}}" class="nav-link {{ session('sub-menu') == 'All Users' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Users</p>
                </a>
              </li>
              @endif
              @if (Auth::user()->hasAccessDomain('Register New User'))
              <li class="nav-item">
                <a href="{{route('create-user')}}" class="nav-link {{ session('sub-menu') == 'register' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Register New User</p>
                </a>
              </li>
              @endif
              @if (Auth::user()->hasAccessDomain('User Jobs'))
              <li class="nav-item">
                <a href="{{route('user.jobs')}}" class="nav-link {{ session('sub-menu') == 'User Jobs' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User Jobs</p>
                </a>
              </li>
              @endif
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
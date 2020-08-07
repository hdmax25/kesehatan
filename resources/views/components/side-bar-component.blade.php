<aside class="main-sidebar sidebar-dark-danger elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link navbar-danger">
    <img src="{{ asset('dist/img/logo2.png') }}"
         alt="AdminLTE Logo"
         class="brand-image img-circle elevation-1"
         style="opacity: .8">
    <span class="brand-text font-weight-light"><strong>INKA</strong> Multi Solusi</span>
  </a>

  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ Auth::user()->image ? asset('dist/img/user/'. Auth::user()->image) : asset('dist/img/avatar5.png') }}" class="img-circle elevation-2" alt="User Image">
        {{-- <img src="{{ asset('dist/img/avatar5.png') }}" class="img-circle elevation-2" alt="User Image"> --}}
      </div>
      <div class="info">
        <a href="{{ route('user.show', Auth::user()->id) }}" class="d-block text-wrap">{{ \Illuminate\Support\Facades\Auth::user()->name }}</a>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('home') }}" class="nav-link {{ request()->is(['home', 'home/*']) ? 'active' : '' }}">
            @if (Auth::user()->role == 3)
              <i class="nav-icon fas fa-heartbeat"></i>
              <p>
                Data Kesehatan
              </p>
            @else
              <i class="nav-icon fas fa-home"></i>
              <p>
                Home
              </p>
            @endif
          </a>
        </li>
        @if (Auth::user()->role !== 3)
          <li class="nav-item has-treeview {{ request()->is(['report', 'report/*']) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is(['report', 'report/*']) ? 'active' : '' }}">
              <i class="nav-icon fa far fa-copy"></i>
              <p>
                Report
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('report.index') }}" class="nav-link {{ request()->is('report') ? 'active' : '' }}">
                <i class="nav-icon fas fa-file"></i>
                  <p>
                    Report
                  </p>
                </a>
              </li>
              @admin
              <li class="nav-item">
                <a href="{{ route('report.daily') }}" class="nav-link {{ request()->is('report/daily') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-file"></i>
                  <p>
                    Daily
                  </p>
                </a>
              </li>
              @endadmin
              <li class="nav-item">
                <a href="{{ route('report.export') }}" class="nav-link {{ request()->is('export') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-file-excel"></i>
                  <p>
                    Excel
                  </p>
                </a>
              </li>
            </ul>
          </li>
        @endif
        @admin
          <li class="nav-item has-treeview {{ request()->is(['user', 'user/*']) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is(['user', 'user/*']) ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Pegawai
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('user.index') }}" class="nav-link {{ request()->is(['user', 'user/edit/*']) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                    Daftar Pegawai
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('user.create') }}" class="nav-link {{ request()->is('user/create') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-user-plus"></i>
                  <p>
                    Tambah Pegawai
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('department.index') }}" class="nav-link {{ request()->is('department') ? 'active' : '' }}">
              <i class="nav-icon fa fa-building"></i>
              <p>
                Divisi
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('penyakit.index') }}" class="nav-link {{ request()->is('penyakit') ? 'active' : '' }}">
              <i class="nav-icon fas fa-heartbeat"></i>
              <p>
                Kondisi
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('site.index') }}" class="nav-link {{ request()->is('site') ? 'active' : '' }}">
              <i class="nav-icon fa fa-map-marker-alt"></i>
              <p>
                Sites
              </p>
            </a>
          </li>
        @endadmin
        @if (Auth::user()->role !== 1)
          <li class="nav-item">
            <a href="{{ route('absent.show', Auth::user()->id) }}" class="nav-link {{ request()->is('absent/show/*') ? 'active' : '' }}"> 
              <i class="nav-icon far fa-clock"></i>
              <p>
                Presence
              </p>
            </a>
          </li>
        @endif
        @if (Auth::user()->role !== 3)
          <li class="nav-item">
            <a href="{{ route('absent.report') }}" class="nav-link {{ request()->is('absent/report') ? 'active' : '' }}"> 
              <i class="nav-icon fas fa-file"></i>
              <p>
                Presence Report
              </p>
            </a>
          </li>
        @endif
        <li class="nav-item has-treeview {{ request()->is(['leave', 'leave/*']) ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is(['leave', 'leave/*']) ? 'active' : '' }}">
            <i class="nav-icon fa fa-envelope"></i>
            <p>
              Leave Request
            </p>
            <i class="right fas fa-angle-left"></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('leave.create') }}" class="nav-link {{ request()->is('leave/create') ? 'active' : '' }}"> 
                <i class="nav-icon fas fa-paper-plane"></i>
                <p>
                  Request
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('leave.index') }}" class="nav-link {{ request()->is('leave') ? 'active' : '' }}"> 
                <i class="nav-icon fa fa-envelope"></i>
                <p>
                  Request List
                </p>
              </a>
            </li>
            @admin
            <li class="nav-item">
              <a href="{{ route('leave.report') }}" class="nav-link {{ request()->is('leave/report') ? 'active' : '' }}"> 
                <i class="nav-icon fas fa-file"></i>
                <p>
                  Report
                </p>
              </a>
            </li>
            @endadmin
          </ul>
        </li>
        <li class="nav-item">
          <a href="{{ route('user.show', Auth::user()->id) }}" class="nav-link {{ request()->is('user/show*') ? 'active' : '' }}"> 
            <i class="nav-icon fas fa-user"></i>
            <p>
              Profile
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="nav-link">
            <i class="nav-icon fas fa-power-off"></i>
            <p>
              Logout
            </p>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
          </form>
        </li>
      </ul>
    </nav>
  </div>
</aside>
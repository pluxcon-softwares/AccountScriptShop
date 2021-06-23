<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ ($settings->site_logo == 'no_image.png') ? asset('storage/site_logo/'.$settings->site_logo) : asset('images/category/no_image.png') }}" alt="{{ $settings->site_name }}" class="brand-image img-circle elevation-3" style="">
      <span class="brand-text font-weight-light">{{ $settings->site_name }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('images/profile_pic.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::guard('admin')->user()->username }}</a>
        </div>

      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">

        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

            <li class="nav-item">
            <a href="{{route('admin.dashboard')}}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                </p>
            </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-book"></i>
                  <p>
                    Catalog
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                  <li class="nav-item">
                    <a href="{{ route('admin.products') }}" class="nav-link"><i class="far fa-dot-circle nav-icon"></i>
                    <p>Products</p>
                    </a>
                </li>
                  <li class="nav-item">
                    <a href="{{route('admin.categories')}}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Section</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="{{route('admin.subcategories')}}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Category</p>
                    </a>
                  </li>
                </ul>
              </li>

              <!--<div class="nav-header"></div>-->

              <li class="nav-item"><a href="{{route('admin.orders')}}" class="nav-link"><i class="fas fa-truck-moving"></i> <p>Orders</p></a></li>
              <li class="nav-item"><a href="{{route('admin.purchases')}}" class="nav-link"><i class="fas fa-shopping-cart"></i> <p>Purchases</p></a></li>

              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                    Users
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                  <li class="nav-item">
                    <a href="{{route('admin.admin-account')}}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Admins</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="{{route('admin.user-account')}}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Users</p>
                    </a>
                  </li>
                </ul>
              </li>

            <li class="nav-item"><a href="{{ route('admin.tickets') }}" class="nav-link"><i class="fas fa-ticket-alt"></i> <p>Support</p></a></li>
            <li class="nav-item"><a href="{{route('admin.message-board')}}" class="nav-link"><i class="fa fa-comments"></i> <p>Message Board</p></a></li>

            <li class="nav-item"><a href="{{ route('admin.rules') }}" class="nav-link"><i class="fa fa-flag"></i> <p>Rules</p></a></li>

            <li class="nav-item"><a href="{{ route('admin.settings') }}" class="nav-link"><i class="fa fa-cog"></i> <p>Settings</p></a></li>

            <li class="nav-item"><a href="{{route('admin.logout')}}" class="nav-link"><i class="fas fa-power-off"></i> Logout</a></li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

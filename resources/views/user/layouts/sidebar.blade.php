<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
      <img src="{{ asset('images/darkrule_site_logo.png') }}" alt="Darkrule Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Darkrule</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('images/profile_pic.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->username }}</a>
        </div>
        <div class="info">
            <a href="{{route('profile')}}" class="d-block"> | Profile</a>
          </div>
      </div>

      <div class="user-panel">
        <div class="image">&nbsp;</div>
        <div class="info">
            <a href="{{route('logout')}}"><span class="fas fa-power-off"></span> Logout</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">

        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

            <li class="nav-item">
            <a href="{{route('home')}}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                </p>
            </a>
            </li>

            <li class="nav-header">PRODUCTS</li>

            @if (isset($mainCategories))
                @foreach ($mainCategories as $category)
                <li class="nav-item">
                    <a href="{{route('products', ['id' => $category->id])}}" class="nav-link">
                        <i class="nav-icon far fa-dot-circle"></i>
                        <p>{{$category->category_name}}</p>
                    </a>
                </li>
                @endforeach
            @endif

            <li class="nav-item">
                <a href="{{ route('purchases') }}" class="nav-link">
                    <i class="nav-icon fas fa-shopping-cart"></i> <p>My Purchases</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('add.money') }}" class="nav-link">
                    <i class="nav-icon fas fa-piggy-bank"></i> <p>Add Money</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('tickets') }}" class="nav-link">
                    <i class="nav-icon fas fa-ticket-alt"></i> <p>Support</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('rules') }}" class="nav-link">
                    <i class="nav-icon fas fa-flag"></i> <p>Rules</p>
                </a>
            </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

<nav class="main-header navbar navbar-expand-md navbar-light navbar-dark">
  <div class="container">
    <a href="{{ config('app.url') }}" class="navbar-brand">

      <img src="{{ $settings->site_logo ? asset('storage/site_logo/'.$settings->site_logo) : asset('images/category/no_image.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{ ($settings->site_name) ? $settings->site_name : config('app.name') }}</span>
    </a>

    <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse order-3" id="navbarCollapse">
      <!-- Left navbar links -->
      <ul class="navbar-nav">

        <li class="nav-item dropdown">
          <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle"><i class="fas fa-home"></i> Shop</a>
          @if($data['categories'])
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              @foreach ($data['categories'] as $cat)
                <li><a href="{{ route('user.products.by.category',['category_id'=>$cat['id']]) }}" class="dropdown-item">{{ $cat['category_name'] }} </a></li>
              @endforeach
            </ul>
          @endif
        </li>

        <li class="nav-item">
          <a href="{{ route('purchases') }}" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i> My Purchases
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('add.money') }}" class="nav-link">
              <i class="nav-icon fas fa-piggy-bank"></i> Add Money
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('tickets') }}" class="nav-link">
              <i class="nav-icon fas fa-ticket-alt"></i> Support
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('rules') }}" class="nav-link">
              <i class="nav-icon fas fa-flag"></i> Rules
          </a>
        </li>
      </ul>

    </div>
    <!-- Right navbar links -->
    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item" id="count_cart">
        <a class="nav-link" href="{{ route('cart') }}">
          <i class="fas fa-shopping-cart"></i>
          <span class="badge badge-danger">0</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('tickets') }}">
          <i class="fas fa-ticket-alt"></i>
          <span class="badge badge-danger">{{ $ticketReplies ? $ticketReplies : 0 }}</span>
        </a>
      </li>

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item">
        <a class="nav-link" href="{{ route('profile') }}">
          <i class="fas fa-user"></i> Profile
        </a>

      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}" role="button">
          <i class="fas fa-power-off"></i> Logout
        </a>
      </li>
    </ul>
  </div>
</nav>

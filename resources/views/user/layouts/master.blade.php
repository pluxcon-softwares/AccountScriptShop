<html style="height: auto;" lang="en"><head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $settings->site_name }}</title>

  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body style="height: auto;" class="dark-mode layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  @include('user.layouts.header')
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="min-height: 892px;">
    
    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row justify-content-center">

          @yield('content')
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  
  
  

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright © 2014-<?php echo date('Y') ?> <a href="{{ config('app.url') }}">{{ ($settings->site_name) ? $settings->site_name : config('app.name') }}</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script src="{{ asset('js/app.js') }}"></script>
<script>
  $(function(){
    //count items in cart
    function countCart()
    {
      var countCartEl = $('#count_cart span');
      countCartEl.empty();
      $.ajax({
        url: '/cart/count/items',
        method: 'GET',
        success:(res)=>{
          `${(res.countCartItems) ? countCartEl.text(res.countCartItems) : countCartEl.text(0)}`;
        }
      });
    }
    countCart();
  });
</script>
@yield('extra_script')
</body>
</html>
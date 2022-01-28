<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $settings->site_name }} @if(isset($title)) {{ $title }} @endif </title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition dark-mode sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  @include('admin.layouts.header')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('admin.layouts.sidebar')
  <!-- End of Main Sidebar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        @include('admin.partials.top_widgets')
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="content-fluid">
          @yield('content')
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014 - <?php echo date('Y') ?> <a href="{{ config('app.url') }}">{{ $settings->site_name }}</a>.</strong>
    All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script src="{{ asset('js/app.js') }}"></script>

@yield('extra_script')

</body>
</html>

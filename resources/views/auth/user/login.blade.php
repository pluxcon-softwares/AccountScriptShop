
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
      @if(isset($settings))
        {{  $settings->site_name }} | Log in
      @else
        CCAutoShop
      @endif
    </title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<?php
if(isset($settings))
{
    if(isset($settings->page_background)){
        $bgImage = $settings->page_background;
    }else {
        $bgImage = 'default_bg.png';
    }
}
?>
<body class="hold-transition dark-mode login-page" style="background: url('/storage/bg_image/{{ $bgImage }}') no-repeat;
background-position:center; background-size:cover;">
<div class="login-box">
  <div class="login-logo">
    <img src="{{ $settings->site_logo ? '/storage/site_logo/'.$settings->site_logo : '/images/category/no_image.png' }}" alt="site-logo" style="border-radius: 50%; width: 50px;">
    <a href="#"><b>{{ $settings->site_name? $settings->site_name : 'CCAutoshop' }}</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">

      <h4 class="login-box-msg">Member Login</h4>

      <form action="{{route('authenticate')}}" method="POST">
        @csrf

      @if(session()->has('error'))
        <p style="font-size: 14px; color: yellow; text-align:center;">{{ session('error') }}</p>
      @endif

    @if(session()->has('success'))
    <p style="font-size: 14px; color: yellow; text-align:center;">{{ session('success') }}</p>
    @endif

      <div class="input-group mb-3">
        <input type="text" name="email" class="form-control" placeholder="Email" />
        <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        @if($errors->has('email'))
        <div class="col-12">
          <p style="font-size: 12px; color: yellow;">{{ $errors->first('email') }}</p>
        </div>
        @endif
      </div>

      <div class="input-group mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" />
        <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
        </div>
        @if($errors->has('password'))
        <div class='col-12'><p style="font-size: 12px; color: yellow;">{{ $errors->first('password') }}</p></div>
        @endif
      </div>

      <div class="mt-2">
        <p style="font-size: 12px; text-align:center;">Please type the Number EXACTLY like in number box</p>
      </div>

      <div class="row">

        <div class="col-md-5 col-xs-5">
            <?php
                $captchaImage = null;
                for($i = 0; $i < 5; $i++){  $captchaImage .= mt_rand(0, 9);}
            ?>
            <input type="text" class="form-control" value="{{ $captchaImage }}" disabled />
            <input type="hidden" class="form-control" value="{{ $captchaImage }}" name="captcha_image" />
        </div>

        <div class="col-md-7">
            <input type="text" class="form-control" placeholder="Enter CAPTCHA" name="captcha_text" />
        </div>

        @if(session()->has('captcha_error'))
        <div>
            <p style="text-align: center; text-align: center; color: yellow">{{ session('captcha_error') }}</p>
        </div>
        @endif

        @if($errors->has('captcha_text'))
        <p style="font-size: 12px; text-align: center; color: yellow;">{{ $errors->first('captcha_text') }}</p>
        @endif

        <div class="clearfix"></div>

     </div>

      <div class="mb-3 mt-3">
        <button type="submit" class="btn btn-warning fa-pull-right">Log in</button>
      </div>

    </form>


      <p class="mb-1">
        <!-- <a href="#">I forgot my password</a> -->
      </p>
      <p class="mb-0">
        <a href="{{ route('create') }}" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

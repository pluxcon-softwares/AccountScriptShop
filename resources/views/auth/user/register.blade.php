
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $settings->site_name }} | Create New Account</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="hold-transition dark-mode login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="{{ ($settings->site_logo == 'no_image.png') ? asset('storage/site_logo/'.$settings->site_logo) : asset('images/category/no_image.png') }}" alt="site-logo" style="border-radius: 50%; width: 50px;">
    <a href="#"><b>{{ $settings->site_name }}</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">

      <h4 class="login-box-msg">Create new account</h4>

      <form action="{{ route('store') }}" method="POST" id="registerForm">
        @csrf

      <div class="form-group">
        <input type="text" name="username" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" placeholder="Username">
        <div class="invalid-feedback" style="color:#ffffff; font-size:12px; margin-top:-10px;">
            {{$errors->first('username')}}
        </div>
      </div>

      <div class="form-group">
        <input type="text" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="Email">
        <div class="invalid-feedback" style="color:#ffffff; font-size:12px; margin-top:-10px;">
            {{$errors->first('email')}}
        </div>
      </div>

      <div class="form-group">
        <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Password">
        <div class="invalid-feedback" style="color:#ffffff; font-size:12px; margin-top:-10px;">
          {{$errors->first('password')}}
        </div>
      </div>

      <div>
        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
      </div>

      <div class="form-group">
        <div class="row">

          <div class="form-group">
            
          </div>
          <p style="font-size: 12px; text-align:center;">Please type the Number EXACTLY like in the image</p>
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

           </div>
      </div>

      <div>
        @if(session()->has('captcha_error'))
        <p style="text-align: center; color: red; text-align: center;">{{ session('captcha_error') }}</p>
        @endif

      @if($errors->has('captcha_text'))
            <p style="font-size: 12px; color: red; text-align: center;">{{ $errors->first('captcha_text') }}</p>
      @endif

      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-block btn-success">Register</button>
      </div>

      <div class="form-group" style="text-align: center">
        <h6>Already have account? >> <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Login</a></h6>
      </div>

    </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

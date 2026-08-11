<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{config('app.name')}}</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->

  <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}">

<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v3/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v3/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v3/fonts/iconic/css/material-design-iconic-font.min.css')}}">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v3/vendor/animate/animate.css')}}">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v3/vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v3/vendor/animsition/css/animsition.min.css')}}">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v3/vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v3/vendor/daterangepicker/daterangepicker.css')}}">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v3/css/util.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v3/css/main.css')}}">
<!--===============================================================================================-->
  <style type="text/css">
    .merah{
      background: red;
    }

    .wrap-input100 {
      position: relative;
    }

    .password-toggle {
      position: absolute;
      right: 18px;
      top: 22px;
      z-index: 10;
      border: 0;
      background: transparent;
      color: rgba(255, 255, 255, 0.85);
      font-size: 18px;
      cursor: pointer;
      padding: 6px;
      line-height: 1;
    }

    .password-toggle:hover,
    .password-toggle:focus {
      color: #fff;
      outline: none;
    }

    #password {
      padding-right: 48px;
    }
  </style>
</head>
<body>

  <div class="limiter">
    <div class="container-login100" style="background-image: url('assets/login-v3/images/bg-01.jpg');">
      <div class="wrap-login100">
        <form class="login100-form validate-form" autocomplete="off" method="GET" action="{{ url('login') }}">
          {{ csrf_field() }}
         <!--  <span class="login100-form-logo">
            <i class="zmdi zmdi-landscape"></i>
          </span> -->
          {{-- <div class="login100-form-title p-b-34 p-t-27"> --}}
            {{-- <img src="{{asset('assets/atonergi.png')}}" width="256px" height="64px"> --}}
              {{-- <h2>DompetQu</h2>
          </div> --}}

          <span class="login100-form-title p-b-34 p-t-27">
            {{config('app.name')}}
          </span>

          <div class="wrap-input100 validate-input" data-validate = "Enter Username">
            <input required="" class="input100" autocomplete="off" value="" type="text" name="username" id="username" placeholder="Username" autofocus="">
            <span class="focus-input100" data-placeholder="&#xf207;"></span>
            @if (session('username'))
              <div class="red"  style="color: red"><b>Username Tidak Ada</b></div>
            @endif
          </div>
          <div class="wrap-input100 validate-input" data-validate="Enter password">
            <input required="" class="input100" autocomplete="off" value="" type="password" name="password" id="password" placeholder="Password">
            <span class="focus-input100" data-placeholder="&#xf191;"></span>
            <button type="button" class="password-toggle" id="togglePassword" aria-label="Tampilkan password" title="Tampilkan password">
              <i class="fa fa-eye" id="togglePasswordIcon"></i>
            </button>
            @if (session('password'))
            <div class="red"  style="color: red"><b>Password Yang Anda Masukan Salah</b></div>
            @endif
          </div>

          {{-- <div class="text-center p-t-90">
             <a class="txt1" href="#">
               Forgot Password?
             </a>
           </div> --}}

          {{-- <div class="contact100-form-checkbox text-center"> --}}
            {{-- <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember">
            <label class="label-checkbox100" for="ckb1"> --}}
              {{-- Belom punya akun?, <a href="{{url('/register')}}" style="color: white;">Register now!</a>
            </label>
          </div> --}}
          <div class="container-login100-form-btn">
            <button type="submit" class="login100-form-btn">
              Login
            </button>
          </div>


        </form>
      </div>
    </div>
  </div>


  <div id="dropDownSelect1"></div>

<!--===============================================================================================-->
  <script src="{{asset('assets/login-v3/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
  <script src="{{asset('assets/login-v3/vendor/animsition/js/animsition.min.js')}}"></script>
<!--===============================================================================================-->
  <script src="{{asset('assets/login-v3/vendor/bootstrap/js/popper.js')}}"></script>
  <script src="{{asset('assets/login-v3/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
  <script src="{{asset('assets/login-v3/vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
  <script src="{{asset('assets/login-v3/vendor/daterangepicker/moment.min.js')}}"></script>
  <script src="{{asset('assets/login-v3/vendor/daterangepicker/daterangepicker.js')}}"></script>
<!--===============================================================================================-->
  <script src="{{asset('assets/login-v3/vendor/countdowntime/countdowntime.js')}}"></script>
<!--===============================================================================================-->
  <script src="{{asset('assets/login-v3/js/main.js')}}"></script>

</body>
</html>
<script type="text/javascript">
window.onload = function(e){
  $('#username').val(null);
  $('#password').val(null);
}

$('#togglePassword').on('click', function () {
  var passwordInput = $('#password');
  var icon = $('#togglePasswordIcon');
  var isHidden = passwordInput.attr('type') === 'password';

  passwordInput.attr('type', isHidden ? 'text' : 'password');
  icon.toggleClass('fa-eye', !isHidden);
  icon.toggleClass('fa-eye-slash', isHidden);
  $(this).attr('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
  $(this).attr('title', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
});
</script>

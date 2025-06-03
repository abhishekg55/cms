<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CMS || Login</title>

    <!-- Global stylesheets -->
    <link href="{{ asset('assets/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <style type="text/css">
        .login-page {
            background-image: url("{{ asset('assets/images/login_bg.jpg') }}");
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body class="bg-dark login-page">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">

                <!-- Content area -->
                <div class="content d-flex justify-content-center align-items-center">

                    <!-- Login card -->
                    <form class="login-form" id="login_form" method="POST" action="{{ route('login') }}" novalidate>
                        @csrf
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <h5 class="mb-0">Login to your account</h5>
                                    <span class="d-block text-muted">Enter your credentials below</span>
                                </div>

                                @if ($errors->has('email') || $errors->has('password'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('email') }} <br>
                                    {{ $errors->first('password') }}
                                </div>
                                @endif

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <div class="form-control-feedback form-control-feedback-start">
                                        <input type="email" class="form-control" placeholder="Enter Email ID"
                                            name="email" required="required" value="{{ old('email') }}" autofocus>
                                        <div class="form-control-feedback-icon">
                                            <i class="icon-user text-muted"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="form-control-feedback form-control-feedback-start input-group">
                                        <input type="password" class="form-control password"
                                            value="{{ old('password') }}" class="form-control" placeholder="Password"
                                            name="password" required="required">
                                        <div class="form-control-feedback-icon">
                                            <i class="icon-lock2 text-muted"></i>
                                        </div>
                                        <button class="btn btn-light changePasswordStyle" type="button">
                                            <i class="icon-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <label class="form-check">
                                        <input type="checkbox" name="remember" class="form-check-input" checked>
                                        <span class="form-check-label">Remember</span>
                                    </label>

                                    <a href="login_password_recover.html" class="ms-auto">{{ __('Forgot password?')
                                        }}</a>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-pink rounded-pill w-100">
                                        <i class="icon-arrow-right14 position-right"></i>
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /login card -->

                </div>
                <!-- /content area -->

            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

    <!-- Core JS files -->
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{ asset('assets/js/app.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function(){

			$('.changePasswordStyle').click(function(){
				$('.changePasswordStyle i').toggleClass('icon-eye icon-eye-blocked');
				var password = $('.password');
				if (password.attr("type") === "password") {
				    	password.attr("type", "text");
				} else {
				   	password.attr("type", "password");
				}
			});
		});
    </script>
</body>


</html>
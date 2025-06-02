<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Conatct Management System | Login</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Conatct Management System | Login" />
    <meta name="author" content="Abhishek Gupta" />
    <meta name="description" content="Contact Management System" />
    <meta name="keywords" content="Contact Management System" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
        integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg=" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous" />

    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />

</head>


<body class="login-page bg-body-secondary">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h1 class="link-dark link-offset-2 link-opacity-100 link-opacity-50-hover">
                    <h1 class="mb-0"><b>Login</b></h1>
                </h1>
            </div>
            <div class="card-body login-card-body">
                <p class="login-box-msg">Enter Credential to start your session</p>
                @error('error')
                <div class="text-danger mb-2">{{ $message }}</div>
                @enderror
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group has-validation mb-1">
                                <span class="input-group-text" id="email"><span class="bi bi-envelope"></span></span>
                                <input id="email" type="email" name="email" class="form-control"
                                    value="{{ old('email') }}" placeholder="Email ID">
                            </div>
                            @error('email')
                            <div class="text-danger mb-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group has-validation mb-1">
                                <span class="input-group-text" id="password"><span
                                        class="bi bi-lock-fill"></span></span>
                                <input id="password" type="password" name="password" class="form-control"
                                    value="{{ old('password') }}" placeholder="Password">
                            </div>
                            @error('password')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="row mt-4">
                        <div class="col-8 d-inline-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" value="1"
                                    id="remember" />
                                <label class="form-check-label" for="remember"> Remember Me </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Sign In</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
        integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

    <script src="{{ asset('js/adminlte.js') }}"></script>

</body>

</html>
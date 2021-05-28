<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>
            @yield('title_prefix', config('adminlte.title_prefix', ''))
            @yield('title', config('adminlte.title', 'AdminLTE 3'))
            @yield('title_postfix', config('adminlte.title_postfix', ''))
        </title>
        <link rel="apple-touch-icon" sizes="57x57" href="icon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="icon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="icon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="icon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="icon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="icon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="icon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="icon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="icon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="icon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="icon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="icon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="icon/favicon-16x16.png">
        <link rel="manifest" href="icon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="icon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

        <!-- Bootstrap core CSS -->

        <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            html,
            body {
            height: 100%;
            }

            body {
            display: -ms-flexbox;
            display: -webkit-box;
            display: flex;
            -ms-flex-align: center;
            -ms-flex-pack: center;
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: center;
            justify-content: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
            }

            .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
            }
            .form-signin .checkbox {
            font-weight: 400;
            }
            .form-signin .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 16px;
            }
            .form-signin .form-control:focus {
            z-index: 2;
            }
            .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            }
            .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            }
        </style>

      </head>
    <body class="text-center" style="background: #6f7cc9;">
        <form class="form-signin" style="background: white;" method="POST">
            <img style="border-radius:10px;" src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" alt="" width="100px">
            <h1 class="h3 mb-3 font-weight-normal">Please Login</h1>
            @csrf
            <div class="form-group has-error has-feedback">
                <label for="inputEmail" class="sr-only">Email address</label>
                <input name="email" type="email" id="inputEmail" class="form-control  {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="Email address" required="" autofocus="">
                @if($errors->has('email'))
                <div class="invalid-feedback" style="text-align: start;">
                    <strong>{{ $errors->first('email') }}</strong>
                </div>
                @endif
            </div>
            <input type="password" id="inputPassword" name="password" class="form-control mt-3 {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Password" required="" autocomplete="on">
            @if($errors->has('password'))
                <div class="invalid-feedback" style="text-align: start;">
                    <strong>{{ $errors->first('password') }}</strong>
                </div>
            @endif
            <button class="mt-3 btn btn-lg btn-primary btn-block" type="submit">Login</button>

        </form>
    </body>
</html>

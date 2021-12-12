<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <meta name="MobileOptimized" content="width" />
        <meta name="HandheldFriendly" content="true" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <style>div#sliding-popup, div#sliding-popup .eu-cookie-withdraw-banner, .eu-cookie-withdraw-tab {background: #318dde} div#sliding-popup.eu-cookie-withdraw-wrapper { background: transparent; } #sliding-popup h1, #sliding-popup h2, #sliding-popup h3, #sliding-popup p, #sliding-popup label, #sliding-popup div, .eu-cookie-compliance-more-button, .eu-cookie-compliance-secondary-button, .eu-cookie-withdraw-tab { color: #ffffff;} .eu-cookie-withdraw-tab { border-color: #ffffff;}</style>
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <link rel="shortcut icon" href="https://e-recruitment.unitar.org/themes/custom/unitar_hr/favicon.ico" type="image/vnd.microsoft.icon" />

        <title>{{env('APP_NAME')}} | Log in</title>
        <link rel="stylesheet" media="all" href="{{asset('assets/login/css_YKGR2O-mHz-x_jAUBEB4WXY3nC7HZKE1JYCL5Vn0dKk.css')}}" />
        <link rel="stylesheet" media="all" href="{{asset('assets/login/css_HRphcDt12SrFauP_Wod0-z1KL7meoriGwXu4D4i3UY4.css')}}" />
        {{-- <link rel="stylesheet" media="all" href="http://fonts.googleapis.com/css?family=Roboto|Roboto+Condensed:700" /> --}}
    </head>
    <body class="layout-no-sidebars page-user-login navbar-fixed path-user">
        <div class="dialog-off-canvas-main-canvas" data-off-canvas-main-canvas>
            <div id="root-wrapper">
                <div id="page" class="login-page" style="background-image: url({{asset('assets/login/login-bg.jpg')}});">
                    <div id="main-wrapper">
                    <div class="container">
                        <div id="main" class="page-content">
                        <div class="card">
                            <div class="login-left">
                            <div class="container-fluid">
                                <div class="text-center login-logo">
                                    <section class="region region-site-branding">
                                        <div class="site-logo">
                                        <a href="#" title="" rel="home">
                                            <img src="https://e-recruitment.unitar.org/themes/custom/unitar_hr/logo.svg" alt="">
                                        </a>
                                        </div>
                                    </section>
                                </div>
                                <div id="block-unitar-hr-content" class="block block-system block-system-main-block">  
                                    <div class="content">
                                        <form class="user-login-form" data-drupal-selector="user-login-form" action="{{ route('login') }}" method="post" id="user-login-form" accept-charset="UTF-8">
                                            @csrf
                                            <h2>
                                                <fieldset id="edit-title" class="js-form-item js-form-type-item form-type-item js-form-item-title form-item-title form-no-label form-group">
                                                    Login
                                                </fieldset>
                                            </h2>

                                            <fieldset class="js-form-item js-form-type-textfield form-type-textfield js-form-item-name form-item-name form-group">
                                                <label for="edit-name" class="js-form-required form-required">Username</label>
                                                <input autocorrect="none" autocapitalize="none" spellcheck="false" autofocus="autofocus" data-drupal-selector="edit-name" aria-describedby="edit-name--description" type="text" id="edit-name" name="email" value="" size="60" maxlength="60" class="form-text @error('email') is-invalid @enderror required form-control" required="required" aria-required="true" />

                                                <small id="edit-name--description" class="description text-muted">
                                                    Enter your email address or username.
                                                </small>
                                            </fieldset>

                                            <fieldset class="js-form-item js-form-type-password form-type-password js-form-item-pass form-item-pass form-group">
                                                <label for="edit-pass" class="js-form-required form-required">Password</label>
                                                <input data-drupal-selector="edit-pass" aria-describedby="edit-pass--description" type="password" id="edit-pass" name="password" size="60" maxlength="128" class="form-text @error('password') is-invalid @enderror required form-control" required="required" aria-required="true" />

                                                <small id="edit-pass--description" class="description text-muted">
                                                    Enter the password that accompanies your email address.
                                                </small>
                                            </fieldset>

                                            <div data-drupal-selector="edit-actions" class="form-actions js-form-wrapper form-group" id="edit-actions">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    
                                                        <label class="form-check-label" for="remember">
                                                            {{ __('Remember Me') }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <button type="submit" name="op" class="button js-form-submit form-submit btn btn-primary">Log in</button>
                                            </div>
                                            <div data-drupal-selector="edit-links" id="edit-links" class="js-form-wrapper form-group">
                                                <a href="{{ route('password.request') }}" title="Send password reset instructions via email." class="request-password-link" data-drupal-selector="edit-request-password" id="edit-request-password">Reset your password</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            </div>

                            <div class="login-right">
                            <div class="container-fluid">
                                <div class="featured-logo">
                                    <a href="#" title="UNITAR">
                                        <img src="https://e-recruitment.unitar.org/themes/custom/unitar_hr/logo.svg" alt="UNITAR">
                                    </a>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

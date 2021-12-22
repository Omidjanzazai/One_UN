<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <meta name="MobileOptimized" content="width" />
        <meta name="HandheldFriendly" content="true" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        
        <title>{{config('app.name')}} | Log in</title>
        <link rel="shortcut icon" href="{{asset(config('app.logo'))}}"/>
        
        <link rel="stylesheet" media="all" href="{{asset('assets/login/css_YKGR2O-mHz-x_jAUBEB4WXY3nC7HZKE1JYCL5Vn0dKk.css')}}" />
        <link rel="stylesheet" media="all" href="{{asset('assets/login/css_HRphcDt12SrFauP_Wod0-z1KL7meoriGwXu4D4i3UY4.css')}}" />
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
                                <div class="text-center logo">
                                    <section class="region region-site-branding">
                                        <div class="site-logo">
                                        <a href="#" title="" rel="home">
                                            <img src="{{asset(config('app.logo'))}}" alt="">
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
                                                <label class="js-form-required form-required">Username <span style="color: red; font-weight: 900; font-size: 16px;">*</span></label>
                                                <input autofocus="autofocus" type="text" name="email" maxlength="60" class="@error('email') is-invalid @enderror form-control" required="required" autocorrect="none" autocapitalize="none" spellcheck="false"/>

                                                <small id="edit-name--description" class="description text-muted">
                                                    Enter your email address or username.
                                                </small>
                                            </fieldset>

                                            <fieldset class="js-form-item js-form-type-password form-type-password js-form-item-pass form-item-pass form-group">
                                                <label class="js-form-required form-required">Password <span style="color: red; font-weight: 900; font-size: 16px;">*</span></label>
                                                <input type="password" name="password" maxlength="128" class="@error('password') is-invalid @enderror form-control" required="required"/>

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
                                    <a href="#" title="logo">
                                        <img src="{{asset(config('app.logo'))}}" alt="logo">
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

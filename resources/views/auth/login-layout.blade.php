<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6
Version: 4.6
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>WASA-LAND</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
    {{--    <link href="{{asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />--}}
    <link href="{{asset('assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {{--<link href="{{asset('assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />--}}
    {{--<link href="{{asset('assets/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />--}}
<!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{asset('assets/global/css/components.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
    {{--    <link href="{{asset('assets/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css" />--}}
<!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{asset('assets/pages/css/login-4.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico" />

    {{--<link href="{{asset('assets/pages/css/profile.min.css')}}" rel="stylesheet" type="text/css" />--}}

    <style type="text/css">
        body, html{
            height: 100%;
        }
        .overlay{
            overflow: hidden;
            height: 100%;
            background: rgba(0, 0, 0, 0.8) /* Green background with 30% opacity */
        }

        .login .logo{
            margin-top: 20px;
        }
        .profile-logo img {
            float: none;
            margin: 0 auto;
            -webkit-border-radius: 50% !important;
            -moz-border-radius: 50% !important;
            border-radius: 50% !important;
        }
        .content{
            width:675px !important;
        }
    </style>

</head>
<!-- END HEAD -->

<body class="login">

<div class="overlay">

    <!-- BEGIN LOGO -->
    <div class="logo">
        <a href="{{ url('/') }}">
            <img width="200px" src="{{asset('img/sslwireless.png')}}" alt="" />
        </a>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN LOGIN -->
    <div class="content">
        <!-- BEGIN LOGIN FORM -->


        <form class="login-form" method="POST" action="{{ url('/login') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="profile-logo">
                    <div id="image">
                        <img src="{{url('logo.png')}}" class="img-responsive" alt="" width="100px" >

                    </div>
                </div>
            </div>
            <h2 style="color:white;text-align:center;font-weight:bold;">{{config('app.name')}}</h2>

            <div style="width:375px;margin: auto;">
                @if(session('success_new'))
                        <p class="alert alert-success">{{ session('success_new') }}</p>
                @endif
                {{-- <h3 class="form-title">Login to your account</h3> --}}
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Enter any OfficeId and password. </span>
                </div>
                @include('errorOrSuccess')
                @if(session('status'))
                    <p class="alert alert-success">{{ session('status') }}</p>
                @endif
                <div class="form-group {{ $errors->has('office_id') ? ' has-error' : '' }}">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label">Office Id</label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <input autocomplete="off" id="office_id" type="text" class="form-control placeholder-no-fix" name="office_id" value="{{ old('office_id') }}" placeholder="Enter Office ID">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Password</label>
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                        <input autocomplete="off" id="password" type="password" class="form-control placeholder-no-fix" name="password" placeholder="Enter Password">
                    </div>
                </div>
                <div class="form-actions" style="padding-bottom: 0px;">
                    <label class="rememberme mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="remember" value="1" /> Remember me
                        <span></span>
                    </label>
                    <button type="submit" class="btn green pull-right"> Login </button>
                </div>

                <div class="forget-password">
                    <h4>Forgot your password ?</h4>
                    <p>Click
                        <a href="javascript:;" id="forget-password"> here </a> to reset your password. </p>
                </div>

            </div>
            
        </form>
        <!-- END LOGIN FORM -->
        <!-- BEGIN FORGOT PASSWORD FORM -->
        {{-- <form class="forget-form" action="index.html" method="post"> --}}
        <form class="forget-form"  method="POST" action="{{ url('/password/email') }}">
            {{ csrf_field() }}
            <h3>Forget Password ?</h3>
            <p> Enter your e-mail address below to reset your password. </p>
            <div class="form-group">
                <div class="input-icon">
                    <i class="fa fa-envelope"></i>
                    {{-- <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> --}}
                    <input autocomplete="off" type="email" class="form-control placeholder-no-fix" placeholder="Email" name="email" value="{{ old('email') }}">
                </div>
            </div>
            <div class="form-actions">
                <button type="button" id="back-btn" class="btn red btn-outline">Back </button>
                <button type="submit" class="btn green pull-right"> Submit </button>
            </div>
        </form>
        <!-- END FORGOT PASSWORD FORM -->

        <!-- END REGISTRATION FORM -->
    </div>
</div>
<!--[if lt IE 9]>
<script src="{{asset('assets/global/plugins/respond.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/excanvas.min.js')}}" type="text/javascript"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{asset('assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/js.cookie.min.js')}}" type="text/javascript"></script>
{{--<script src="{{asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>--}}
{{--<script src="{{asset('assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>--}}
{{--<script src="{{asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>--}}
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
{{--<script src="{{asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js')}}" type="text/javascript"></script>--}}
{{--<script src="{{asset('assets/global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>--}}
<script src="{{asset('assets/global/plugins/backstretch/jquery.backstretch.min.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
{{--<script src="{{asset('assets/global/scripts/app.min.js')}}" type="text/javascript"></script>--}}
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{asset('assets/pages/scripts/login-4.min.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->
<script type="text/javascript">
    $.backstretch([
        "{{asset('assets/pages/media/bg/1.jpg')}}",
        "{{asset('assets/pages/media/bg/2.jpg')}}",
        "{{asset('assets/pages/media/bg/3.jpg')}}",
    ], {duration: 500, fade: 600});
</script>
</body>

</html>
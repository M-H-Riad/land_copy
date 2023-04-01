<!DOCTYPE html>
<!--
Author: SSL WIRELESS
Website: http://www.sslwireless.com/
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>WASA-LAND{{--{{config('app.name')}}--}}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/global/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- BEGIN PAGE LEVEL PLUGINS -->

    <link href="{{ URL::asset('assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/global/plugins/typeahead/typeahead.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- END GLOBAL MANDATORY STYLES -->

    <link href="{{ URL::asset('assets/global/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/global/plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ URL::asset('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ URL::asset('assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->

    <link href="{{ URL::asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{ URL::asset('assets/layouts/layout4/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/layouts/layout4/css/themes/default.min.css') }}" rel="stylesheet" tye="text/css" id="style_color" />

    <link href="{{ URL::asset('assets/layouts/layout4/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    
    @yield('cdn')

@stack('css')
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico" /> </head>

{{--<link href="{{ URL::asset('custom/css/animate.min.css') }}" rel="stylesheet" type="text/css"           />--}}


<script src="{{ URL::asset('assets/global/plugins/jquery.min.js') }}"  type="text/javascript"></script>
<!-- END HEAD -->
<link href="{{ URL::asset('custom/css/common.css') }}" rel="stylesheet" type="text/css" />

<style type="text/css">
    .page-header.navbar {
        background: white !important;
    }
</style>
{{--<link href="{{ URL::asset('css/custom.css') }}" rel="stylesheet" type="text/css" />--}}

    <link href="{{ URL::asset('css/custom-payroll.css') }}" rel="stylesheet" type="text/css" />


<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">

<!-- BEGIN HEADER -->
@include('main_layouts.head')
<!-- END HEADER -->

<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"> </div>
<!-- END HEADER & CONTENT DIVIDER -->
<!-- BEGIN CONTAINER -->
<div class="page-container animated bounceInUp">

    <!-- BEGIN SIDEBAR -->

@include('main_layouts.nav.admin')

<!-- END SIDEBAR -->

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">

            <!-- BEGIN PAGE BASE CONTENT -->

        @yield('content')

        <!-- END PAGE BASE CONTENT -->
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->

    <!-- BEGIN QUICK SIDEBAR -->
@include('main_layouts.toggle')
<!-- END QUICK SIDEBAR -->

</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer animated bounceInUp">
    <div class="page-footer-inner"> <?php date('Y'); ?> &copy;
        <a target="_blank" href="http://sslwireless.com">SSL Wireless</a> &nbsp;|&nbsp;
        All right reserved
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>
<!-- END FOOTER -->
<!--change Password modal-->
@include('main_layouts.change_password')
        <!--[if lt IE 9]>
<script src="{{ URL::asset('assets/global/plugins/respond.min.js') }}"></script>
<script src="{{ URL::asset('assets/global/plugins/excanvas.min.js') }}"></script>
<![endif]-->
<script src="{{ URL::asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>

<!-- BEGIN CORE PLUGINS -->
<script src="{{ URL::asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}"  type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/js.cookie.min.js') }}"  type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"  type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/jquery.blockui.min.js') }}"  type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"  type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/jquery.input-ip-address-control-1.0.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset('assets/global/plugins/datatables/datatables.min.js') }}"  type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}"  type="text/javascript"></script>

<script src="{{ URL::asset('assets/global/plugins/ladda/spin.min.js') }}"  type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/ladda/ladda.min.js') }}"  type="text/javascript"></script>

<script src="{{ URL::asset('assets/global/plugins/bootbox/bootbox.min.js') }}"  type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>

<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{ URL::asset('assets/global/scripts/app.min.js') }}"  type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<script src="{{URL::asset('assets/pages/scripts/form-input-mask.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/pages/scripts/table-datatables-responsive.min.js') }}"  type="text/javascript"></script>
<script src="{{ URL::asset('assets/pages/scripts/ui-buttons.min.js') }}"  type="text/javascript"></script>

<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{ URL::asset('assets/layouts/layout4/scripts/layout.min.js') }}"  type="text/javascript"></script>
<script src="{{ URL::asset('assets/layouts/layout4/scripts/demo.min.js') }}"  type="text/javascript"></script>
<script src="{{ URL::asset('assets/layouts/global/scripts/quick-sidebar.min.js') }}"  type="text/javascript"></script>
<script src="{{URL::asset('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->

<link href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />

<script src="{{ URL::asset('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>

<script src="{{ URL::asset('custom/js/highlight-nav.js') }}"  type="text/javascript"></script>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{URL::asset('assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/pages/scripts/components-bootstrap-tagsinput.min.js')}}" type="text/javascript"></script>

<script src="{{URL::asset('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/pages/scripts/ui-confirmations.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/jquery-loading/loadingoverlay.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('custom/js/loading_gif.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
<script src='https://cdn.rawgit.com/pguso/jquery-plugin-circliful/master/js/jquery.circliful.min.js'></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>




<script type="text/javascript">
    $(".select2").select2();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script type="text/javascript">
    var url = "{{url('/')}}";
    var  site_path = "{{url('/')}}";
</script>
@yield('scripts')
@stack('scripts')
</body>
</html>

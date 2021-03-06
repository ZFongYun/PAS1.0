<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <title>@yield('title')</title>

    <!-- Custom box css -->
    <link href="{{ URL::asset('../plugins/custombox/dist/custombox.min.css') }}" rel="stylesheet">

    <!-- Date picker css -->
    <link href="{{ URL::asset('../plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">

    <!-- Time picker css -->
    <link href="{{ URL::asset('../plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ URL::asset('assets/js/modernizr.min.js') }}"></script>

</head>

<body class="fixed-left">

<!-- Begin page -->
<div id="wrapper">

    @include('teacher_frontend.layouts.header')
    @include('teacher_frontend.layouts.sidebar')

    @yield('content')

</div>
<!-- END wrapper -->

<script>
    var resizefunc = [];
</script>




<!-- jQuery  -->
<script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/detect.js') }}"></script>
<script src="{{ URL::asset('assets/js/fastclick.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.slimscroll.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.blockUI.js') }}"></script>
<script src="{{ URL::asset('assets/js/waves.js') }}"></script>
<script src="{{ URL::asset('assets/js/wow.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.nicescroll.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.scrollTo.min.js') }}"></script>

<!-- Modal-Effect -->
<script src="{{ URL::asset('../plugins/custombox/dist/custombox.min.js') }}"></script>

<!-- App js -->
<script src="{{ URL::asset('assets/js/jquery.core.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.app.js') }}"></script>

<!-- Plugins Js -->
<script src="{{ URL::asset('../plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ URL::asset('../plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    // Date Picker
    jQuery('#datepicker').datepicker();
    jQuery('#datepicker-upload').datepicker();

    // Time Picker
    jQuery('#timepicker-start').timepicker({
        showMeridian : false
    });

    jQuery('#timepicker-end').timepicker({
        showMeridian : false
    });

    jQuery('#timepicker-upload').timepicker({
        showMeridian : false
    });
</script>

</body>
</html>

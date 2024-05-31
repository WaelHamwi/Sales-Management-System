<title>@yield('title')</title>
<!-- plugins:css -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
<link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}?v=1.0">
<link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}?v=1.0">

@if(App::currentLocale() == 'ar')
<link rel="stylesheet" href="{{ asset('assets/css/theme-rtl.css') }}?v=1.0">
<link rel="stylesheet" href="{{ asset('assets/css/alertify.rtl.min.css') }}?v=1.0">
@else
<link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}?v=1.0">
<link rel="stylesheet" href="{{ asset('assets/css/alertify.min.css') }}?v=1.0">
@endif
<link rel="stylesheet" href="{{ asset('assets/css/style-min.css') }}?v=1.0">
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}?v=1.0">

<!-- DataTables Bootstrap CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-table.css') }}?v=1.0">

<!-- bench mark fontAwsome -->
<link rel="stylesheet" href="{{ asset('assets/css/fontawsome.css') }}?v=1.0">
<link rel="stylesheet" href="{{ asset('assets/css/fontawsome.min.css') }}?v=1.0">
<link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}?v=1.0">
<link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}?v=1.0">

<!-- dropzone Bootstrap CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/dropzone.scss') }}?v=1.0">

<!-- select2 CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/select.css') }}?v=1.0">

<!-- daterangepicker CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}?v=1.0">

@yield('css')
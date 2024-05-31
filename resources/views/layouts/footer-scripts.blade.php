<!-- Your custom scripts -->
<script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}?v=1.0"></script>
<script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}?v=1.0"></script>
<script src="{{ asset('assets/js/jquery.cookie.js') }}?v=1.0" type="text/javascript"></script>
<script src="{{ asset('assets/js/off-canvas.js') }}?v=1.0"></script>
<script src="{{ asset('assets/js/hoverable-collapse.js') }}?v=1.0"></script>
<script src="{{ asset('assets/js/misc.js') }}?v=1.0"></script>
<script src="{{ asset('assets/js/dashboard.js') }}?v=1.0"></script>
<script src="{{ asset('assets/js/todolist.js') }}?v=1.0"></script>
<script src="{{ asset('assets/js/notify.js') }}?v=1.0"></script>
<!-- Your custom scripts -->

<!-- ************** dropzone******************* -------------------->
<script src="{{ asset('assets/js/dropzone.min.js') }}?v=1.0"></script>
<script src="{{ asset('assets/js/dropzone-init.js') }}?v=1.0"></script>
<!-- ************** dropzone******************* -------------------->

<!-- ************** alertify******************* -------------------->
<script src="{{ asset('assets/js/alertify.js') }}?v=1.0"></script>
<script src="{{ asset('assets/js/alertify-init.js') }}?v=1.0"></script>
<!-- ************** alertify******************* -------------------->

<!--another bootstrap table-->
<script src="{{ asset('assets/js/bootstrap-table.js') }}?v=1.0"></script>
<script src="{{ asset('assets/js/bootstrap-table.min.js') }}?v=1.0"></script>
<script src="{{ asset('assets/js/bootstrapTable-init.js') }}?v=1.0"></script>
<!--another bootstrap table-->

@if(App::currentLocale() == 'ar')
<script src="{{ asset('assets/js/bootstrap-table-locale.min.js') }}?v=1.0"></script>
<script src="{{ asset('assets/js/bootstrap-table-locale-all.min.js') }}?v=1.0"></script>
@else
<script src="{{ asset('assets/js/bootstrap-table-en-US.min.js') }}?v=1.0"></script>
<script src="{{ asset('assets/js/bootstrap-table-en-US.min.js') }}?v=1.0"></script>
@endif

<!--js for the fontAwsome-->
<script src="{{ asset('assets/js/all.js') }}?v=1.0"></script>
<script src="{{ asset('assets/js/all.min.js') }}?v=1.0"></script>
<script src="{{ asset('assets/js/fontawesome.js') }}?v=1.0"></script>
<script src="{{ asset('assets/js/fontawesome.min.js') }}?v=1.0"></script>

<!--*********************select*****************-->
<script src="{{ asset('assets/js/select.js') }}?v=1.0"></script>
<!--*********************select*****************-->

<!--daterangepicker js-->
<script src="{{ asset('assets/js/daterangepicker.js') }}?v=1.0"></script>
<script src="{{ asset('assets/js/moment.min.js') }}?v=1.0"></script>
<script src="{{ asset('assets/js/daterangepicker-min.js') }}?v=1.0"></script>
<!--daterangepicker js-->

<!-- **********************************end of library js files***************************-->

<!--custom js-->
<script src="{{ asset('assets/js/custom.js') }}?v=1.0"></script>
<!--custom js-->

@yield('scripts')

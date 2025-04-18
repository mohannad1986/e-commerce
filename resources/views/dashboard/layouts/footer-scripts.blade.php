<!-- jQuery -->
{{-- <script src="plugins/jquery/jquery.min.js"></script> --}}
<script type="text/javascript" src="{{ URL::asset('assets/dashboard/plugins/jquery/jquery.min.js') }}"></script>

<!-- jQuery UI 1.11.4 -->
{{-- <script src="plugins/jquery-ui/jquery-ui.min.js"></script> --}}
<script type="text/javascript" src="{{ URL::asset('assets/dashboard/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
{{-- <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
<script type="text/javascript" src="{{ URL::asset('assets/dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
{{-- <script src="plugins/chart.js/Chart.min.js"></script> --}}
<script type="text/javascript" src="{{ URL::asset('assets/dashboard/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
{{-- <script src="plugins/sparklines/sparkline.js"></script> --}}
<script type="text/javascript" src="{{ URL::asset('assets/dashboard/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
{{-- <script src="plugins/jqvmap/jquery.vmap.min.js"></script> --}}
{{-- <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script> --}}
<script type="text/javascript" src="{{ URL::asset('assets/dashboard/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/dashboard/dashboard/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
{{-- <script src="plugins/jquery-knob/jquery.knob.min.js"></script> --}}
<script type="text/javascript" src="{{ URL::asset('assets/dashboard/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
{{-- <script src="plugins/moment/moment.min.js"></script> --}}
{{-- <script src="plugins/daterangepicker/daterangepicker.js"></script> --}}
<script type="text/javascript" src="{{ URL::asset('assets/dashboard/plugins/moment/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/dashboard/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
{{-- <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script> --}}
<script type="text/javascript" src="{{ URL::asset('assets/dashboard/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
{{-- <script src="plugins/summernote/summernote-bs4.min.js"></script> --}}
<script type="text/javascript" src="{{ URL::asset('assets/dashboard/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
{{-- <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script> --}}
<script type="text/javascript" src="{{ URL::asset('assets/dashboard/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
{{-- انتله جدا في النقطة هون معد عندك ملف بلاغنز  يس انت ماعندك ياه حذفو  --}}
{{-- <script src="dist/js/adminlte.js"></script> --}}
<script type="text/javascript" src="{{ URL::asset('assets/dashboard/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="dist/js/demo.js"></script> --}}
<script type="text/javascript" src="{{ URL::asset('assets/dashboard/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="dist/js/pages/dashboard.js"></script> --}}
<script type="text/javascript" src="{{ URL::asset('assets/dashboard/js/pages/dashboard.js') }}"></script>
{{-- -------------------- --}}
{{-- نسخ من النت للتعديل  --}}
<script type="text/javascript" src="{{ URL::asset('assets/dashboard/') }}"></script>
{{-- غملنا يلد وسميناه سكربتس  --}}
@yield('scripts')


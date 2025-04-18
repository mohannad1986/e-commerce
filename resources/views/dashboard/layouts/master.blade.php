<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <!-- Google Font: Source Sans Pro -->
 @include('dashboard.layouts.head')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  {{-- لوغو اول ما افتح الموقع  --}}
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('assets/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">

  </div>

  <!-- Navbar -->
   {{-- ----الماين هدر  --}}
   @include('dashboard.layouts.main-headerbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
 @include('dashboard.layouts.main-sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">@yield('title_page')</a></li>
              <li class="breadcrumb-item active">@yield('tiltle_page2')</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
     @yield('contant')
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 @include('dashboard.layouts.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

{{-- ------------ --}}
@include('dashboard.layouts.footer-scripts')
{{-- ---------- --}}

</body>
</html>

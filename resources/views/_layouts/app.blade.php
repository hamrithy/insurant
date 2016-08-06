<!DOCTYPE html>
<html lang="en">
<head>
    <!-- META SECTION -->
    <title>Joli Admin - Responsive Bootstrap Admin Template</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <link rel="icon" href="favicon.ico" type="image/x-icon"/>
    <!-- END META SECTION -->

    <!-- CSS INCLUDE -->
    <link rel="stylesheet" type="text/css" id="theme" href="{{ url('joli/css/theme-default.css') }}"/>
    <!-- EOF CSS INCLUDE -->
</head>
<body>

  <!-- START PAGE CONTAINER -->
  <div class="page-container">    

    <!-- START PAGE SIDEBAR -->
    @include('_partials.sidebar')
    <!-- END PAGE SIDEBAR -->

    <!-- PAGE CONTENT -->
    @include('_partials.page_content')
    <!-- END PAGE CONTENT -->
  </div>
  <!-- END PAGE CONTAINER -->

  <!-- MESSAGE BOX-->
  @include('_partials.message_box')
  <!-- END MESSAGE BOX-->

  <!-- START SCRIPTS -->
  @include('_scripts.joli_script')
  <script type="text/javascript" src="/js/app.js"></script>
  <!-- END SCRIPTS -->
</body>
</html>

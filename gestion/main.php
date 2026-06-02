<?php
session_start();
require(__DIR__ . "/require/util.php");
require(__DIR__ . "/require/transacciones.php");
validaSesionAdm();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Administrador de Contenidos</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.5 -->
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="css/font-awesome-4.3.0/css/font-awesome.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
<!-- Date Picker -->
<link rel="stylesheet" href="plugins/datepicker/datepicker3.css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="js/html5shiv.min.js"></script>
        <script src="js/respond.min.js"></script>
    <![endif]-->

<!-- jQuery 2.1.4 --> 
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script> 
<!-- jQuery UI 1.11.4 --> 
<script src="plugins/jQueryUI/jquery-ui.min.js"></script> 
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip --> 
<script>
      $.widget.bridge('uibutton', $.ui.button);
    </script> 
<!-- Bootstrap 3.3.5 --> 
<script src="bootstrap/js/bootstrap.min.js"></script> 

<script src="js/jquery.validate.js"></script> 
<script src="js/jquery.form.js"></script> 

<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>


</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?php include(__DIR__ . '/include/header.php')?>
  <!-- Left side column. contains the logo and sidebar -->
  <?php include(__DIR__ . '/include/menu.php')?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php
	  $page = (isset($_GET['page']) and trim($_GET['page'])!="") ? trim($_GET['page']) : 'dashboard';
      getPage($page);
	  ?>
  </div>
  <!-- /.content-wrapper -->
  <?php include(__DIR__ . '/include/footer.php')?>
</div>
<!-- ./wrapper --> 

<!-- Slimscroll --> 
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script> 
<!-- FastClick --> 
<script src="plugins/fastclick/fastclick.min.js"></script> 
<!-- AdminLTE App --> 
<script src="dist/js/app.min.js"></script>

<link rel="stylesheet" href="css/estilos.css">
<script src="js/javascript.js"></script> 


</body>
</html>

<?php
session_start();
require(__DIR__ . "/require/util.php");
validaSesionLogon();
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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="plugins/iCheck/square/blue.css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo text-center " > <a href="index" ><img src="img/logo.png"  alt="logo" class="img-responsive center"></a> </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Introduce tus datos de acceso</p>
    <form action="ajax" name="formLogueo" id="formLogueo" method="post">
      <input name="accion" type="hidden" value="sesion"/>
      <div class="form-group has-feedback">
        <input type="text" name="usuario" id="usuario" class="form-control required" placeholder="Usuario" >
        <span class="glyphicon glyphicon-user form-control-feedback"></span> </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control required" name="clave" id="clave" placeholder="Contraseña">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span> </div>
      <div class="row"><!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
          <div class="hidden alert"></div>
        </div>
        <!-- /.col --> 
      </div>
    </form>
  </div>
  <!-- /.login-box-body --> 
</div>
<!-- /.login-box --> 

<!-- jQuery 2.1.4 --> 
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script> 
<!-- Bootstrap 3.3.5 --> 
<script src="bootstrap/js/bootstrap.min.js"></script> 
<!-- iCheck --> 
<script src="plugins/iCheck/icheck.min.js"></script> 
<script src="js/jquery.validate.js"></script> 
<script src="js/jquery.form.js"></script>
<link rel="stylesheet" href="css/estilos.css">
<script src="js/javascript.js"></script> 
<script>
      $(function () { 
		var options = {beforeSubmit: showRequest, success: showResponseSesion};
		$("#formLogueo").validate({
			submitHandler: function (form) {
				$(form).ajaxSubmit(options);
			}
		});
	});
</script>
</body>
</html>

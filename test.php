<?php session_start(); ?>
<?php require('constants/index.php'); ?>
<?php require('helpers/index.php'); ?>

<?php
require_once("require/util.php");
require_once("require/transacciones.php");
$tipo = (isset($tipo)) ? $tipo : ($_GET['tipo'] ?? '');
$categoria = (isset($categoria)) ? $categoria : ($_GET['categoria'] ?? '');
$_SESSION['lecturaIDCitex'] = '';
?>

<?php $_PAGE_SLUG = getInfoPage('test', $_MENU); ?>
<?php $_COLOR = 'D71E79'; ?>
<?php include('parts/share/header.php'); ?>

<link href="./assets/css/test.css?v=<?php echo rand(); ?>" rel="stylesheet" type="text/css" />
<link href="./assets/css/test-mediaquery.css?v=<?php echo rand(); ?>" rel="stylesheet" type="text/css" />
<script src="./assets/js/jquery.validate.js"></script>
<script src="./assets/js/jquery.form.js"></script>
<script type="text/javascript" src="./assets/js/cronometro.js?v=<?php echo rand(); ?>"></script>
<script type="text/javascript" src="./assets/js/jquery.cookie.js"></script>

<div id="start" name="start">
  <?php include('parts/test/title.php'); ?>

  <?php if ($tipo != "" or $categoria != "") { ?>
  <div class="container">
    <div id="test-container">
      <div id="test-body">
        <?php
					if ($tipo != "cerebral") {
						include('include/inc.test.php');
					} else {
						include("cerebral/cerebral.php");
					}
					?>
      </div>
    </div>
  </div>
  <?php } else { ?>
  <?php include('parts/test/tests.php'); ?>
  <?php } ?>
</div>
<?php include('parts/share/contact.php'); ?>
<?php include('parts/share/footer.php'); ?>

<?php require( 'constants/index.php' ); ?>
<?php require( 'helpers/index.php' ); ?>

<?php $_PAGE_SLUG = getInfoPage('programas', $_MENU); ?>
<?php $_COLOR = '2997CE'; ?>
<?php include( 'parts/share/header.php' );?>
<script src="./assets/js/jquery.validate.js"></script>
<script src="./assets/js/jquery.form.js"></script>
<script src="./assets/js/cronometro.js"></script>
<?php include( 'parts/programas/intro.php' );?>
<?php include( 'parts/programas/cupos.php' );?>
<?php include( 'parts/programas/entrevista.php' );?>
<?php include( 'parts/programas/inteligencia.php' );?>
<?php include( 'parts/index/testList.php' );?>
<?php include( 'parts/programas/duracion.php' );?>
<?php include( 'parts/programas/siLeoInicial.php' );?>
<?php include( 'parts/programas/siLeoPro.php' );?>
<?php include( 'parts/programas/revolucionamos.php' );?>
<?php include( 'parts/programas/testimonios.php' );?>
<?php include( 'parts/programas/cuposLimitados.php' );?>
<?php include( 'parts/programas/inscribete.php' );?>
<?php include( 'parts/contacto/form2.php' );?>

<?php include( 'parts/programas/entrevista2.php' );?>
<?php include( 'parts/share/contact.php' );?>
<?php include( 'parts/share/footer.php' );?>
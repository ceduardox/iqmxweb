<?php require( 'constants/index.php' ); ?>
<?php require( 'helpers/index.php' ); ?>

<?php $_PAGE_SLUG = getInfoPage('contacto', $_MENU); ?>
<?php $_COLOR = '00FFFF'; ?>
<?php include( 'parts/share/header.php' );?>
<script src="./assets/js/jquery.validate.js"></script>
<script src="./assets/js/jquery.form.js"></script>
<script src="./assets/js/cronometro.js"></script>
<?php include( 'parts/contacto/title.php' );?>
<?php include( 'parts/contacto/form.php' );?>
<?php include( 'parts/contacto/form2.php' );?>
<?php include( 'parts/contacto/locales.php' );?>

<?php include( 'parts/share/footer.php' );?>
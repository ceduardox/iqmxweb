<?php require( 'constants/index.php' ); ?>
<?php require( 'helpers/index.php' ); ?>

<?php $_PAGE_SLUG = getInfoPage('programas', $_MENU); ?>
<?php $_COLOR = '2997CE'; ?>
<?php include( 'parts/share/header.php' );?>
<?php include( 'parts/programaInicial/intro.php' );?>
<?php include( 'parts/programaInicial/modulos.php' );?>
<?php include( 'parts/programaInicial/lograras.php' );?>
<br/>
<br/>
<?php include( 'parts/programas/tests.php' );?>
<br/>
<br/>
<?php include( 'parts/share/footer.php' );?>
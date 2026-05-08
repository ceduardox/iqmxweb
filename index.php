<?php require( 'constants/index.php' ); ?>
<?php require( 'helpers/index.php' ); ?>

<?php $_PAGE_SLUG = getInfoPage('index', $_MENU); ?>
<?php include( 'parts/share/header.php' );?>
<?php include( 'parts/index/intro.php' );?>
<?php include( 'parts/index/welcome.php' );?>
<?php include( 'parts/index/tests.php' );?>
<?php include( 'parts/index/testList.php' );?>
<?php include( 'parts/index/aprendeCasa.php' );?>
<?php include( 'parts/programas/testimonios.php' );?>
<br/>
<br/>
<?php include( 'parts/share/contact.php' );?>
<?php include( 'parts/share/footer.php' );?>
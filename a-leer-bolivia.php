<?php require ('constants/index.php'); ?>
<?php require ('helpers/index.php'); ?>


<?php $_PAGE_SLUG = getInfoPage('a-leer-bolivia', $_MENU); ?>
<?php $_COLOR = '2997CE'; ?>
<?php include ('parts/share/header.php'); ?>
<script src="./assets/js/jquery.validate.js"></script>
<script src="./assets/js/jquery.form.js"></script>

<link href='assets/css/a-leer-bolivia.css?v=<?php echo RAND() ?>' rel='stylesheet'>
<link href='assets/css/a-leer-bolivia.modal.css?v=<?php echo RAND() ?>' rel='stylesheet'>
<link href='assets/css/a-leer-bolivia.responsive.css?v=<?php echo RAND() ?>' rel='stylesheet'>
<script src="https://www.google.com/recaptcha/api.js?onload=recaptchaLoaded&render=explicit"></script>

<?php include ('parts/a-leer-bolivia/bienvenido.php'); ?>
<?php include ('parts/a-leer-bolivia/texto-imagen.php'); ?>
<?php include ('parts/a-leer-bolivia/objetivos.php'); ?>
<?php include ('parts/a-leer-bolivia/como-participar.php'); ?>
<?php include ('parts/a-leer-bolivia/cta-links.php'); ?>
<?php include ('parts/a-leer-bolivia/testimonios.php'); ?>
<?php include ('parts/a-leer-bolivia/colegios.php'); ?>
<?php include ('parts/a-leer-bolivia/auspiciadores.php'); ?>


<script>
function recaptchaLoaded() {

  document.querySelectorAll('.g-recaptcha').forEach((el, i) => {
    var widgetId = grecaptcha.render(el);
    el.setAttribute('data-grecaptcha-id', widgetId);
  });

}

document.getElementById("mybutton").addEventListener("click", (event) => {
  var widgetId = document.getElementById("mycaptcha").getAttribute('data-grecaptcha-id');
  grecaptcha.reset(widgetId);
});
</script>

<?php include ('parts/share/contact.php'); ?>
<?php include ('parts/share/footer.php'); ?>
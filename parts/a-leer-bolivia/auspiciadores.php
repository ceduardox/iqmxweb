<?php
require_once("require/util.php");
require_once("require/transacciones.php");
$obj = new ClssALeerBoliviaLogos();  

$rows = $obj -> lista('Auspiciador');
if($rows['total']!=0) { 
?>
<section id='auspiciadores'>
  <div class='container'>
    <div class='row'>
      <p>Auspiciadores</p>
    </div>
  </div>
  <div class='items'>
    <div class="logo-items">
      <div class="logo-item-track">
        <?php 
          foreach($rows['result'] as $row) {
        ?>
        <img class="item" src="<?php echo PATH_A_LEER_BOLIVIA_LOGOS.$row['image']; ?>" width='100%'
          alt='<?php echo $row['name']; ?>'>
        <?php 
          }
        ?>
      </div>
    </div>
</section>
<?php  
} 
?>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const trackAuspiciadores = document.querySelector('#auspiciadores .logo-item-track');
  const slidesAuspiciadores = document.querySelectorAll('#auspiciadores .logo-item-track .item');
  let cloneWidthAuspiciadores = 0;

  slidesAuspiciadores.forEach(slide => {
    const clone = slide.cloneNode(true);
    trackAuspiciadores.appendChild(clone);
    cloneWidthAuspiciadores += slide.offsetWidth;
  });

  let currentPositionAuspiciadores = 0;

  function moveSlideTrackAuspiciadores() {
    currentPositionAuspiciadores -= 2; // velocity
    if (currentPositionAuspiciadores < -cloneWidthAuspiciadores) {
      currentPositionAuspiciadores = 0;
    }
    trackAuspiciadores.style.transform = `translateX(${currentPositionAuspiciadores}px)`;
    requestAnimationFrame(moveSlideTrackAuspiciadores);
  }

  moveSlideTrackAuspiciadores();
});
</script>
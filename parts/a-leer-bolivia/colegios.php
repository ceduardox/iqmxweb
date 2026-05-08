<?php
require_once("require/util.php");
require_once("require/transacciones.php");
$obj = new ClssALeerBoliviaLogos();  

$rows = $obj -> lista('Colegio');
if($rows['total']!=0) { 
?>
<section id='colegios'>
  <div class='container'>
    <div class='row'>
      <p>Colegios</p>
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
  const trackColegios = document.querySelector('#colegios .logo-item-track');
  const slidesColegios = document.querySelectorAll('#colegios .logo-item-track .item');
  let cloneWidthColegios = 0;

  slidesColegios.forEach(slide => {
    const clone = slide.cloneNode(true);
    trackColegios.appendChild(clone);
    cloneWidthColegios += slide.offsetWidth;
  });

  let currentPositionColegios = 0;

  function moveSlideTrackColegios() {
    currentPositionColegios -= 2; // velocity
    if (currentPositionColegios < -cloneWidthColegios) {
      currentPositionColegios = 0;
    }
    trackColegios.style.transform = `translateX(${currentPositionColegios}px)`;
    requestAnimationFrame(moveSlideTrackColegios);
  }

  moveSlideTrackColegios();
});
</script>
<?php
require_once("require/configuracion.php");
require_once("require/util.php");
require_once("require/transacciones.php");
$obj = new ClssTestimonios();  
?>
<div id="testimonios" name="testimonios"></div>
<section id='programas-testimonios'>
  <div class='container'>
    <div class='row'>
      <div class='text col-md-8 order-2 order-md-1'>
        <div class='row items'>
          <?php 
	$rows = $obj -> lista();
	if($rows['total']!=0) {
		foreach($rows['result'] as $row) {
     ?>
          <div class='col-md-6 item'>
            <a href="javascript:void(0)" onclick="javascript:show($(this))" data-video="https://www.youtube.com/embed/<?php echo limpiaVideo($row['video'])?>" data-name="<?php echo $row['name']?>" >
              <img src="http://img.youtube.com/vi/<?php echo limpiaVideo($row['video'])?>/mqdefault.jpg" alt="">
              <h2><?php echo $row['name']?></h2>
              <span class="btn">VER VIDEO</span>
            </a>
          </div>
          <?php }
  } 
  ?>
        </div>
      </div>
      <div class='text col-md-4 order-1 order-md-2'>
        <h1><strong>TESTIMONIOS</strong></h1>
          <br />
        <div class="d-none d-xl-block">
          <img src="./assets/images/play-testimonios.png" alt="" />
          <br />
          <a href='https://www.youtube.com/watch?v=SfeIDOE-J40&list=PLtdx9pfclYlQ1af9GB54b8N5qZMNV19O2' target='_blank'
            class="btn btn-blue" title='VER TODOS LOS VIDEOS'>VER TODOS LOS VIDEOS</a>
        </div>
      </div>
    </div>
  </div>
</section> 

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <iframe  id="video" width="100%" height="315" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div> 
    </div>
  </div>
</div>
 
<script>
  var modal = $('#exampleModal');
  function show(e) {
    modal.find('.modal-title').html($(e).data("name"))
    var video = modal.find('.modal-body').find("#video")
    video.attr('src', $(e).data("video"));
    video.attr('title', $(e).data("name"));
    modal.modal('show')
  }
  
  modal.on('hide.bs.modal', function() {
    $("#video").attr('src', '');
  });
  modal.on('show.bs.modal', function() {
    //
  });

</script>
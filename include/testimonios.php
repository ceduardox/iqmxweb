<?php
require_once("require/util.php");
require_once("require/transacciones.php");
$objVideo = new ClssVideo();   
	$arrVideos = $objVideo -> video('testimonios');
?>
<style>
#player {
	margin-top: 1.5em
}
#player #video {
	float: left;
	width: 58%;
	margin-right: 20px
}
#player #playlist {
	float: right;
	width: 40%;
	border: 1px solid #CCC;
	overflow: scroll;
	overflow-x: hidden;
	height: 350px;
	background:#FFF
}
#player #playlist .item {
	border-bottom: 1px solid #CCC;
	padding: 8px;
	text-align: left;
	position: relative
}
#player #playlist .item.activo {
	background: #096199
}
#player #playlist .item:hover {
	background: #037BC7
}
#player #playlist .item.activo > a, #player #playlist .item:hover > a {
	color: #fff
}
#player #playlist .item:last-of-type {
	border-bottom: none
}
#player #playlist .item .imagen {
	float: left;
	width: 25%;
	line-height: 0px;
	margin-right: 10px
}
#player #playlist .item .imagen img {
	width: 100%
}
#player #playlist .item .nombre {
	float: left;
	width: 70%
}
#player #playlist .item a:after, #player #playlist .item:after {
	content: "";
	display: block;
	clear: both;
	visibility: hidden;
	height: 0;
}
section#testimonios {
	background: #F8F8F8
}
</style>
<section id="testimonios" class="seccionFull">
  <div class="container">
    <div class="row center">
      <h1 class="titulo">TESTIMONIOS</h1>
      <h2 class="subtitulo">Estas son las opiniones de nuestros usuarios</h2>
      <div id="player">
        <div id="video">
          <?php 
	 $v = ($arrVideos['total']!=0) ? limpiaVideo($arrVideos['result'][0]['video']) : 'uawnQ1C-U70';  
      ?>
          <iframe width="100%" height="350" frameborder="0" allowfullscreen="" src="https://www.youtube.com/embed/<?php echo $v?>">El navegador no soporta este objeto.</iframe>
        </div>
        <div id="playlist">
          <?php 
	if($arrVideos['total']!=0) {
		foreach($arrVideos['result'] as $arrVideo) {
			$v = limpiaVideo($arrVideo['video']);  
      ?>
          <div class="item"> <a href="javascript:void(0)" onClick="verVideoPlaylist(this,'<?php echo $v?>')" title="ver testimonio">
            <div class="imagen cargador"><img src="http://img.youtube.com/vi/<?php echo $v?>/mqdefault.jpg"  class="post-cargador"></div>
            <div class="nombre"><?php echo $arrVideo['referencia']?></div>
            </a> </div>
          <?php }
  }  
  ?>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
function verVideoPlaylist(obj,video) {
	$('#player #playlist').find('.item').removeClass('activo');
	$(obj).parent().addClass('activo');
	$('#player #video').find('iframe').attr('src','https://www.youtube.com/embed/'+video);
}
$(window).load(function(){
    cargarImagenes();
})
</script>

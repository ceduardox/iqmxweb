<?php
require_once("require/util.php");
require_once("require/transacciones.php");
$objContacto = new ClssContacto();   
$objContactos = $objContacto->lista();  
?>
<section id='contacto-locales'>
	<div class='container'>

		<?php foreach ($objContactos['result'] as $local ) {
        ?>
		<div class='content' style='background: <?php echo $local['color']; ?>'>
			<div class='row'>
				<div class='col-md-12'>
					<h2><strong><?php echo $local['nombre'];?></strong></h2>
				</div>
				<div class='col-md-6'>
					<img src="./img/contacto/<?php echo $local['imagen']; ?>" alt="<?php echo $local['nombre']; ?>" class='img-fluid' />
				</div>
				<div class='col-md-6'>
					<div class='block address'>
						<i class="fa fa-map-marker"></i>
						<div class='title'>DIRECCIÓN</div>
						<div class='detail'><?php echo nl2br($local['direccion']);
        ?></div>
                        <?php if(isset($local['urlMap'])) { ?>
							<div class='detail' style="margin-bottom: 10px"><a href="<?php echo $local['urlMap'];?>" target="_blank" style="font-size: 12px; text-decoration: none; background: #fff; padding: 4px 6px; border-radius: 4px;">Ver en Google Maps</a></div>
						<?php } ?>
					</div>
					<div class='block phone'>
						<i class="fa fa-phone"></i>
						<div class='title'>TELEFONO</div>
						<div class='detail'><?php echo $local['fono'];
        ?></div>
					</div>
					<div class='block email'>
						<i class="fa fa-envelope"></i>
						<div class='title'>EMAIL</div>
						<div class='detail'><?php echo $local['email'];
        ?></div>
					</div>
				</div>
			</div>
		</div>
		<?php }
        ?>
	</div>
</section>
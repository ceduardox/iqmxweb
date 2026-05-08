<div class="container">
	<div class="row">
		<div class="fila col-md-4">
			<div class="titulo">NI&Ntilde;OS</div>
			<?php 
	$arrRanking = $objRanking -> top($mes,$ANHO,$tipoRanking,$tipoTop,3);
	if($arrRanking['total']!=0) {
		$rst = $arrRanking['result'][0];
		$personasID .= $rst['persona_id'].",";
    ?>
			<div class="foto"><?php echo imagen(PATH_RANKING,$rst['foto'])?></div>
			<div class="nombre"><?php echo $rst['nombres']?> <?php echo $rst['apepa']?></div>
			<div class="edad"><?php echo $rst['edad']?> a&ntilde;os</div>
			<div class="ciudad"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $rst['ciudad']?></div>
			<div class="row valores">
				<div class="velocidad col-md-4"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $rst['velocidad']?></div>
				<div class="compresion col-md-4"><i class="fa fa-lightbulb-o" aria-hidden="true"></i> <?php echo $rst['comprension']?>%</div>
				<div class="modulo col-md-4"><i class="fa fa-book" aria-hidden="true"></i> <?php echo $rst['modulo']?></div>
			</div>
			<?php } else { ?>
			<div class="datos1"> No hay datos. </div>
			<div class="datos2">&nbsp; </div>
			<?php } ?>
		</div>
		<div class="fila col-md-4">
			<div class="titulo">ADOLESCENTES</div>
			<?php 
	$arrRanking = $objRanking -> top($mes,$ANHO,$tipoRanking,$tipoTop,2);
	if($arrRanking['total']!=0) {
		$rst = $arrRanking['result'][0];
		$personasID .= $rst['persona_id'].",";
    ?>
			<div class="foto"><?php echo imagen(PATH_RANKING,$rst['foto'])?></div>
			<div class="nombre"><?php echo $rst['nombres']?> <?php echo $rst['apepa']?></div>
			<div class="edad"><?php echo $rst['edad']?> a&ntilde;os</div>
			<div class="ciudad"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $rst['ciudad']?></div>
			<div class="row valores">
				<div class="velocidad col-md-4"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $rst['velocidad']?></div>
				<div class="compresion col-md-4"><i class="fa fa-lightbulb-o" aria-hidden="true"></i> <?php echo $rst['comprension']?>%</div>
					<div class="modulo col-md-4"><i class="fa fa-book" aria-hidden="true"></i> <?php echo $rst['modulo']?></div>
			</div>
			<?php } else { ?>
			<div class="datos1"> No hay datos. </div>
			<div class="datos2">&nbsp; </div>
			<?php } ?>
		</div>
		<div class="fila col-md-4">
			<div class="titulo">ADULTOS</div>
			<?php 
	$arrRanking = $objRanking -> top($mes,$ANHO,$tipoRanking,$tipoTop,1);
	if($arrRanking['total']!=0) {
		$rst = $arrRanking['result'][0];
		$personasID .= $rst['persona_id'].",";
    ?>
			<div class="foto"><?php echo imagen(PATH_RANKING,$rst['foto'])?></div>
			<div class="nombre"><?php echo $rst['nombres']?> <?php echo $rst['apepa']?></div>
			<div class="edad"><?php echo $rst['edad']?> a&ntilde;os</div>
			<div class="ciudad"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $rst['ciudad']?></div>
			<div class="row valores">
				<div class="velocidad col-md-4"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $rst['velocidad']?></div>
				<div class="compresion col-md-4"><i class="fa fa-lightbulb-o" aria-hidden="true"></i> <?php echo $rst['comprension']?>%</div>
					<div class="modulo col-md-4"><i class="fa fa-book" aria-hidden="true"></i> <?php echo $rst['modulo']?></div>
			</div>
			<?php } else { ?>
			<div class="datos1"> No hay datos. </div>
			<div class="datos2">&nbsp; </div>
			<?php } ?>
		</div>
	</div>
</div>
 
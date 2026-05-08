<section class="ranking-top">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Los mejores resultados <strong>obtenidos hasta ahora</strong></h1>
				<div class="tops">
					<?php  
	$tipoTop = 'top1'; 
	$tipoRanking = "";
  include( 'parts/ranking/inc.ranking.php' ); 
	$_SESSION['personasIDTop'] = ($tipoTop=='top1') ? $personasID : "";
?>
				</div>
			</div>
		</div>
	</div>
</section>
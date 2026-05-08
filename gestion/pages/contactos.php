<?php
extract( $_REQUEST );
?>
<style>

.sorted_table tr.placeholder {
    display: block;
    background: red;
    position: relative;
    margin: 0;
    padding: 0;
    border: none; }
.sorted_table tr.placeholder:before {
    content: "";
    position: absolute;
    width: 0;
    height: 0;
    border: 5px solid transparent;
    border-left-color: red;
    margin-top: -5px;
    left: -5px;
    border-right: none; }

#box-message { position: fixed; top: 48%; padding: 8px 50px; z-index: 999; background: green; color: #fff; left:48%; display: none}
    
</style>
<script src="js/jquery-sortable-min.js"></script>
<!-- Content Header (Page header) -->

<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="active">Contactos</li>
  </ol>
  <h1><i class="fa fa-map-marker"></i> Contactos <small>Listado de contactos</small> </h1>

  <button type="button" onclick="javascript:location.href='./report-contacto'"  class="btn btn-primary"  id="downloadBtn" name="btn-nuevo"  ><i class="fa fa-download"></i> Mensajes</button>
  
</section>
<?php
$pagina     = ( isset( $pagina ) ) ? $pagina : 1;
$cantidad   = 10;
$cls        = new ClssContacto();
$Paginacion = new Paginacion();
$paginado   = $Paginacion->pagina( $pagina, $cantidad );
$filas      = $Paginacion->registros( $cls->listar( '', $paginado, $cantidad ) );
?>

<!-- Main content -->

<section class="content ">
  <div class="box">
    <div class="box-body">
      <?php
if ( count( $filas ) > 0 ) {
    $registros = $cls->listar( '', NULL, NULL );
    $total     = $Paginacion->totalRegistros( $registros );
    $paginas   = $Paginacion->calcularPaginas( $total, $cantidad );
?>
     <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered  table-striped table-hover sorted_table">
        <thead>
          <tr>
            <th scope="col" class="text-center" width="3%" >Nº</th>
            <th scope="col"  >Nombre</th> 
            <th scope="col" class="text-center"  width="8%">Editar</th>
            <th scope="col" class="text-center" width="8%">Eliminar</th>
          </tr>
        </thead>
        <tbody>
          <?php
    $num = 0;
    foreach ( $filas as $row ) {
        $num++;
?>
         <tr data-id="<?php echo $row['id']; ?>" >
            <td class="text-center num"><?php echo ( ( $pagina * $cantidad ) + $num ) - $cantidad;?></td>
            <td class="text-uppercase" ><?php echo $row[ 'nombre' ];?> </td>
             
            <td class="text-center"><a href="page-contacto-<?php echo $row[ 'id' ];?>" title="ir a Editar" class="editar"><span>Editar</span></a></td>
            <td class="text-center"><a href="javascript:void(0)" onclick="eliminar(<?php echo $row[ 'id' ];?>, 'eliminarContacto')" title="Eliminar" class="eliminar"><span>Eliminar</span></a></td>
          </tr>
          <?php
    }
?>
       </tbody>
      </table>
    </div>
    <div class="box-footer clearfix">
      <?php
    echo $Paginacion->pintarPaginas( $paginas, $pagina, $total, $cantidad, 'page-contactos' );
?>
     <?php
} else {
    echo 'Aún no hay información registrada.';
}
?>
   </div>
  </div>
</section>


<!-- /.content --> 
<script>
	function isMobile() {
	   return (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ); 
	}

function setNumTable() {
    var table = $('table.sorted_table').find('tbody');
    var cta = 1;
    table.find('tr').each(function(){
        var row = $(this);
        row.find('.num').html(cta++);
    });
}

    $(function () {
		if(!isMobile()) {
			$('.sorted_table').sortable({
				containerSelector: 'table',
				itemPath: '> tbody',
				itemSelector: 'tr',
				vertical: true,
				placeholder: '<tr class="placeholder"/>',
				onDrop: function ($item, container, _super) {
					var data = $('.sorted_table').sortable("serialize").get();
					var jsonString = JSON.stringify(data, null, ' ');
	
					$('#box-message').fadeIn(100, function () {
						$('#box-message').html('Ordenando...');
					});
					$.post('ajax', {position: jsonString, accion: 'sortedContacto'}, function (data) {
						var obj = JSON.parse(data);
						if (obj['estado'] == false) {
							$('#box-message').fadeIn(100, function () {
								$('#box-message').html(obj['mensaje']);
							});
						} else {
							$('#box-message').fadeOut(100, function(){setNumTable();});
							
						}
					});
					_super($item, container);
				}
			});
		}
    });

</script>
<div id="box-message" >Ordenando...</div>
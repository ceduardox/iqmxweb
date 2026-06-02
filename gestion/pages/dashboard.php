<?php
$cls = new ClssTest();

$mensajes = $cls->listarResultado(array('MSJ'));
$lecturas = $cls->listarResultado(array('LECTURA'));
$razonamientos = $cls->listarResultado(array('RAZONA'));
$cerebrales = $cls->listarResultado(array('TEST_CER', 'TEST_CEREBRAL', 'TEST_CEREB'));

$recientes = array_slice(array_merge($mensajes, $lecturas, $razonamientos, $cerebrales), 0, 10);
usort($recientes, function ($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});
$recientes = array_slice($recientes, 0, 10);

function dashboardTipo($row)
{
    if ($row['restipo'] == 'MSJ') {
        return $row['reslect'];
    }
    if ($row['restipo'] == 'RAZONA') {
        return 'RAZONAMIENTO';
    }
    return $row['restipo'];
}
?>

<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li class="active">Dashboard</li>
  </ol>
  <h1>Dashboard</h1>
</section>

<section class="content">
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?php echo count($mensajes); ?></h3>
          <p>Mensajes de contacto</p>
        </div>
        <div class="icon"><i class="fa fa-envelope"></i></div>
        <a href="page-contacto_mensajes" class="small-box-footer">Ver mensajes <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?php echo count($lecturas); ?></h3>
          <p>Tests de lectura</p>
        </div>
        <div class="icon"><i class="fa fa-book"></i></div>
        <a href="./report-lectura" class="small-box-footer">Descargar reporte <i class="fa fa-download"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?php echo count($razonamientos); ?></h3>
          <p>Tests de razonamiento</p>
        </div>
        <div class="icon"><i class="fa fa-lightbulb-o"></i></div>
        <a href="./report-razonamiento" class="small-box-footer">Descargar reporte <i class="fa fa-download"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?php echo count($cerebrales); ?></h3>
          <p>Tests cerebrales</p>
        </div>
        <div class="icon"><i class="fa fa-pie-chart"></i></div>
        <a href="./report-cerebral" class="small-box-footer">Descargar reporte <i class="fa fa-download"></i></a>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-8">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Actividad reciente</h3>
        </div>
        <div class="box-body table-responsive">
          <?php if (count($recientes) > 0) { ?>
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th width="16%">Fecha</th>
                  <th width="18%">Tipo</th>
                  <th>Nombre</th>
                  <th width="22%">Email</th>
                  <th width="16%">Ciudad</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($recientes as $row) { ?>
                  <tr>
                    <td><?php echo $row['created_at']; ?></td>
                    <td><?php echo dashboardTipo($row); ?></td>
                    <td><?php echo str_replace('|', ' ', $row['resnom']); ?></td>
                    <td><?php echo $row['resmail']; ?></td>
                    <td><?php echo $row['resciud']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          <?php } else { ?>
            <p>A&uacute;n no hay actividad registrada.</p>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Accesos r&aacute;pidos</h3>
        </div>
        <div class="box-body">
          <p><a href="page-contacto_mensajes" class="btn btn-block btn-primary"><i class="fa fa-envelope"></i> Mensajes de contacto</a></p>
          <p><a href="./report-contacto" class="btn btn-block btn-default"><i class="fa fa-download"></i> Descargar mensajes</a></p>
          <p><a href="page-test_lectura" class="btn btn-block btn-default"><i class="fa fa-book"></i> Test de lectura</a></p>
          <p><a href="page-rankings" class="btn btn-block btn-default"><i class="fa fa-users"></i> Ranking</a></p>
        </div>
      </div>
    </div>
  </div>
</section>

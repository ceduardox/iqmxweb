<?php
extract($_REQUEST);

$month = isset($month) ? trim($month) : '';
$year = isset($year) ? trim($year) : '';
$dateFilter = array();
if ($month != '') {
    $dateFilter['month'] = $month;
}
if ($year != '') {
    $dateFilter['year'] = $year;
}

$cls = new ClssTest();
$filas = $cls->listarResultado(array('MSJ'), $dateFilter);
$meses = array(
    '1' => 'Enero',
    '2' => 'Febrero',
    '3' => 'Marzo',
    '4' => 'Abril',
    '5' => 'Mayo',
    '6' => 'Junio',
    '7' => 'Julio',
    '8' => 'Agosto',
    '9' => 'Septiembre',
    '10' => 'Octubre',
    '11' => 'Noviembre',
    '12' => 'Diciembre'
);
$yearActual = (int) date('Y');
?>

<section class="content-header">
  <ol class="breadcrumb">
    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>
    <li><a href="page-contactos">Contactos</a></li>
    <li class="active">Mensajes</li>
  </ol>
  <h1><i class="fa fa-envelope"></i> Mensajes <small>Formularios de contacto</small></h1>
</section>

<section class="content">
  <div class="box">
    <div class="box-header with-border">
      <form method="get" action="main" class="form-inline">
        <input type="hidden" name="page" value="contacto_mensajes">
        <div class="form-group">
          <label for="month">Mes</label>
          <select id="month" name="month" class="form-control">
            <option value="">Todos</option>
            <?php foreach ($meses as $key => $label) { ?>
              <option value="<?php echo $key; ?>" <?php echo ($month == $key) ? 'selected' : ''; ?>><?php echo $label; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="year">A&ntilde;o</label>
          <select id="year" name="year" class="form-control">
            <option value="">Todos</option>
            <?php for ($anio = $yearActual; $anio >= $yearActual - 10; $anio--) { ?>
              <option value="<?php echo $anio; ?>" <?php echo ($year == $anio) ? 'selected' : ''; ?>><?php echo $anio; ?></option>
            <?php } ?>
          </select>
        </div>
        <button type="submit" class="btn btn-default"><i class="fa fa-filter"></i> Filtrar</button>
        <a href="./report-contacto?month=<?php echo urlencode($month); ?>&year=<?php echo urlencode($year); ?>" class="btn btn-primary">
          <i class="fa fa-download"></i> Descargar Excel
        </a>
      </form>
    </div>
    <div class="box-body table-responsive">
      <?php if (count($filas) > 0) { ?>
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th width="4%" class="text-center">N&ordm;</th>
              <th width="13%">Fecha</th>
              <th width="13%">Tipo</th>
              <th>Nombres</th>
              <th width="16%">Email</th>
              <th width="12%">Tel&eacute;fono</th>
              <th width="12%">Ciudad</th>
              <th>Mensaje</th>
            </tr>
          </thead>
          <tbody>
            <?php $num = 1; foreach ($filas as $row) { ?>
              <tr>
                <td class="text-center"><?php echo $num++; ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td><?php echo $row['reslect']; ?></td>
                <td><?php echo str_replace('|', ' ', $row['resnom']); ?></td>
                <td><a href="mailto:<?php echo $row['resmail']; ?>"><?php echo $row['resmail']; ?></a></td>
                <td><?php echo $row['restele']; ?></td>
                <td><?php echo $row['resciud']; ?></td>
                <td><?php echo nl2br($row['rescom']); ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } else { ?>
        <p>A&uacute;n no hay mensajes registrados.</p>
      <?php } ?>
    </div>
  </div>
</section>

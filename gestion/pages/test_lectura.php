<?php

extract($_REQUEST);
?>

<!-- Content Header (Page header) -->



<section class="content-header">

  <ol class="breadcrumb">

    <li><a href="index"><i class="fa fa-home"></i> Inicio</a></li>

    <li class="active">Test de Lectura</li>

  </ol>

  <h1><i class="fa fa-book"></i> Test de Lectura <small>Listado de categorías</small> </h1>

  <div class="row mb-3">
    <div class="col-md-12">
      <form id="filterForm" class="form-inline">
        <div class="form-group mx-2">
          <label for="monthFilter">Mes:</label>
          <select class="form-control" id="monthFilter" name="month">
            <option value="01">Enero</option>
            <option value="02">Febrero</option>
            <option value="03">Marzo</option>
            <option value="04">Abril</option>
            <option value="05">Mayo</option>
            <option value="06">Junio</option>
            <option value="07">Julio</option>
            <option value="08">Agosto</option>
            <option value="09">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
          </select>
        </div>
        <div class="form-group mx-2">
          <label for="yearFilter">Año:</label>
          <select class="form-control" id="yearFilter" name="year">
            <?php
            $currentYear = date('Y');
            for ($year = 2022; $year <= $currentYear; $year++) {
              echo "<option value=\"$year\">$year</option>";
            }
            ?>
          </select>
        </div>
        <button type="button" onclick="downloadReport('report-lectura')" class="btn btn-primary" name="btn-nuevo"><i
            class="fa fa-download"></i> Test de Lectura</button>

        <button type="button" onclick="downloadReport('report-razonamiento')" class="btn btn-primary"
          name="btn-nuevo"><i class="fa fa-download"></i> Test de Razonamiento</button>

        <button type="button" onclick="downloadReport('report-cerebral')" class="btn btn-primary" name="btn-nuevo"><i
            class="fa fa-download"></i> Test Cerebral</button>
      </form>

    </div>
  </div>
  <script>
    function downloadReport(reportType) {
      const month = document.getElementById('monthFilter').value;
      const year = document.getElementById('yearFilter').value;
      let url = './' + reportType;

      if (month || year) {
        url += '?';
        if (month) url += 'month=' + month;
        if (month && year) url += '&';
        if (year) url += 'year=' + year;
      }

      location.href = url;
    }

    // Set selected values from URL parameters
    window.onload = function () {
      const urlParams = new URLSearchParams(window.location.search);
      const month = urlParams.get('month');
      const year = urlParams.get('year');

      if (month) document.getElementById('monthFilter').value = month;
      if (year) document.getElementById('yearFilter').value = year;
    }
  </script>

</section>

<?php

$pagina = (isset($pagina)) ? $pagina : 1;

$count = 10;

$cls = new ClssTest();

$Paginacion = new Paginacion();

$paginator = $Paginacion->pagina($pagina, $count);

$rows = $Paginacion->registros($cls->listarCategoria('', $paginator, $count));

?>



<!-- Main content -->

<section class="content ">

  <div class="box">

    <div class="box-body">

      <?php if (count($rows) > 0) {

        $registros = $cls->listarCategoria('', NULL, NULL);

        $total = $Paginacion->totalRegistros($registros);

        $paginas = $Paginacion->calcularPaginas($total, $count);

        ?>

        <table width="100%" border="0" cellspacing="0" cellpadding="0"
          class="table table-bordered table-striped table-hover">

          <thead>

            <tr>

              <th scope="col">Categoría</th>

              <th scope="col" class="text-center" width="8%">Tipo</th>

            </tr>

          </thead>

          <tbody>

            <?php foreach ($rows as $row) { ?>

              <tr>

                <td>
                  <?php echo $row['nombre']; ?>
                </td>

                <td class="text-center"><a href="page-test_lectura_tipos-<?php echo $row['id']; ?>" title="ir a Tipos"
                    class="entrar"><span>Entrar</span></a></td>

              </tr>

            <?php } ?>

          </tbody>

        </table>

      </div>

      <div class="box-footer clearfix">

        <?php

        echo $Paginacion->pintarPaginas($paginas, $pagina, $total, $count, 'page-test_lectura');

        ?>

      <?php } else {
        echo 'Aún no hay categorías registradas.';
      } ?>

    </div>

  </div>

</section>

<!-- /.content -->
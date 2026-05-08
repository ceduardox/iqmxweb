<?php
session_start();
require("../require/util.php");
require("../require/conecta.php");
require("../require/transacciones.php");
validaSesionAdm();

extract($_REQUEST);
require("../require/downloadDataExcel.php");

if (!isset($report) || empty($report) || !in_array($report, ['cerebral', 'lectura', 'razonamiento', 'contacto'])) {
  die('Error: report not found');
}

$cls = new ClssTest();

// Add date filter conditions
$dateFilter = [];
if (isset($_GET['month']) && !empty($_GET['month'])) {
  $dateFilter['month'] = $_GET['month'];
}
if (isset($_GET['year']) && !empty($_GET['year'])) {
  $dateFilter['year'] = $_GET['year'];
}

switch ($report) {
  case 'contacto':
    $data = $cls->listarResultado(['MSJ'], $dateFilter);
    $fields = ['deviceFrom' => 'Origen', 'resnom' => 'Nombres', 'edad' => 'Edad', 'resmail' => 'Email', 'restele' => 'Teléfono', 'resciud' => 'Ciudad', 'respais' => 'País', 'reslect' => 'Tipo', 'rescom' => 'Comentario', 'created_at' => 'Fecha'];
    break;
  case 'cerebral':
    $data = $cls->listarResultado(['TEST_CER', 'TEST_CEREBRAL', 'TEST_CEREB'], $dateFilter);
    $fields = ['deviceFrom' => 'Origen', 'resnom' => 'Nombres', 'edad' => 'Edad', 'resmail' => 'Email', 'restele' => 'Teléfono', 'resciud' => 'Ciudad', 'respais' => 'País', 'ressoy' => 'Nivel', 'rescarrera' => 'Carrera', 'ressemestre' => 'Semestre', 'resinstitucion' => 'Institución', 'reslect' => 'Tipo', 'rescom' => 'Comentario', 'created_at' => 'Fecha'];
    break;
  case 'razonamiento':
    $data = $cls->listarResultado(['RAZONA'], $dateFilter);
    $fields = ['deviceFrom' => 'Origen', 'resnom' => 'Nombres', 'edad' => 'Edad', 'resmail' => 'Email', 'restele' => 'Teléfono', 'resciud' => 'Ciudad', 'respais' => 'País', 'ressoy' => 'Nivel', 'rescarrera' => 'Carrera', 'ressemestre' => 'Semestre', 'resinstitucion' => 'Institución', 'rescat' => 'Persona', 'restmres' => 'Tiempo', 'rescomp' => 'Comprensión', 'rescom' => 'Comentario', 'created_at' => 'Fecha'];
    break;
  case 'lectura':
    $data = $cls->listarResultado(['LECTURA'], $dateFilter);
    $fields = ['deviceFrom' => 'Origen', 'resnom' => 'Nombres', 'edad' => 'Edad', 'resmail' => 'Email', 'restele' => 'Teléfono', 'resciud' => 'Ciudad', 'respais' => 'País', 'ressoy' => 'Nivel', 'rescarrera' => 'Carrera', 'ressemestre' => 'Semestre', 'resinstitucion' => 'Institución', 'restcat' => 'Persona', 'restipo' => 'Tipo', 'reslect' => 'Lectura', 'rescant' => 'Palabras', 'restime' => 'Tiempo lectura', 'restmres' => 'Tiempo respuesta', 'rescomp' => 'Comprensión', 'resvel' => 'Velocidad', 'rescom' => 'Comentario', 'created_at' => 'Fecha'];
    break;
  default:
    die('Error: report not found recognized');
}

?>
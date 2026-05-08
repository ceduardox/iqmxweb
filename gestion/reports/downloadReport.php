<?php
ini_set('memory_limit', '64M');
extract($_REQUEST);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $_GET['report'] . '-' . $_GET['month'] . '_' . $_GET['year'] . '-' . date('Y-m-d_H:i:s') . '.xls"');
header('Cache-Control: max-age=0');

require("downloadReportData.php");

function generateTable($data, $fields)
{
    $table = '<table id="data-table" border="1"><thead><tr>';
    foreach ($fields as $key => $value) {
        $table .= '<th>' . $value . '</th>';
    }
    $table .= '</tr></thead><tbody>';
    foreach ($data as $row) {
        $table .= '<tr>';
        foreach ($fields as $key => $value) {
            $table .= '<td>' . (isset($row[$key]) ? $row[$key] : '') . '</td>';
        }
        $table .= '</tr>';
    }
    $table .= '</tbody></table>';
    return $table;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?php echo $report . '-' . date('Y-m-d_H:i:s') ?></title>
</head>

<body>

    <?php echo generateTable($data, $fields); ?>

</body>

</html>
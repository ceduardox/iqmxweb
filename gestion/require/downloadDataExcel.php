<?php
function downloadDataExcel($data, $fieldsWithTitle, $filename = "export.xls", $delimiter=";") {
    header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    
    // Write header
    $headers = array_values($fieldsWithTitle); // Extract the titles for headers
    fputcsv($output, $headers, $delimiter);

    // Write data
    foreach($data as $row) {
        $line = [];
        foreach($fieldsWithTitle as $field => $title) {
            $line[] = isset($row[$field]) ? $row[$field] : '';
        }
        fputcsv($output, $line, $delimiter);
    }
    
    fclose($output);
    exit;
}
?>
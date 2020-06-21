<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

use frontend\models\Inscripcion;

$filename = "inscriptos.xls";
$fileType = 'Xls';
$file =  '../../template/inscriptos.xlsx';
$templateExcel  = IOFactory::load($file);

// este estilo de Border::BORDER_THICK  tiene un espesor mas grosor que BORDER_THICK,
// el  estilo de "Border::BORDER_XXX" es equivalente en excel a "todos los bordes"
$bordes = [
    'borders' => [
        'outline' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '0000'],
        ],
    ],
];


//////////////////////////////////////////////////////////////////////////////////////////////



$nombreEvento= $arrayEvento['nombre'];





foreach($listados as $obj){
    
        $templateExcel->setActiveSheetIndex($obj['index']);
        $templateExcel->getActiveSheet()->setTitle($obj['titulo']);

        $fila= $templateExcel->getActiveSheet()->setCellValue('B9', $nombreEvento);

        $fila= $templateExcel->getActiveSheet();
        $fila->setCellValue('I2', $arrayEvento['organizador'] );
        $fila->setCellValue('I3', $arrayEvento['inicio'] );
        $fila->setCellValue('I4', $arrayEvento['fin'] );
        $fila->setCellValue('I5', $arrayEvento['capacidad'] );
        $fila->setCellValue('I6', $arrayEvento['lugar'] );
        $fila->setCellValue('I7', $arrayEvento['modalidad'] );

        // $row: los datos son insertado a partir de la celda 10
        $row = 12;

        // $i: enumera la cantidad las celdas con registros
        $i = 1;

        foreach( $obj['lista'] as  $obj ) {
                $fila= $templateExcel->getActiveSheet();
                $fila->setCellValue('B'.$row, $i )->getStyle('B'.$row)->applyFromArray($bordes);
                $fila->setCellValue('C'.$row, $obj['user_apellido'])->getStyle('C'.$row)->applyFromArray($bordes);
                $fila->setCellValue('D'.$row, $obj['user_nombre'])->getStyle('D'.$row)->applyFromArray($bordes);
                $fila->setCellValue('E'.$row, $obj['user_dni'])->getStyle('E'.$row)->applyFromArray($bordes);
                $fila->setCellValue('F'.$row, $obj['user_pais'])->getStyle('F'.$row)->applyFromArray($bordes);
                $fila->setCellValue('G'.$row, $obj['user_provincia'])->getStyle('G'.$row)->applyFromArray($bordes);
                $fila->setCellValue('H'.$row, $obj['user_localidad'])->getStyle('H'.$row)->applyFromArray($bordes);
                $fila->setCellValue('I'.$row, $obj['user_email'])->getStyle('I'.$row)->applyFromArray($bordes);
                
                $i =$i +1;
                $row = $row + 1;
        }

}

/// guarda el archivo
$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter( $templateExcel, $fileType );
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
ob_end_clean();

$writer->save("php://output");

exit;

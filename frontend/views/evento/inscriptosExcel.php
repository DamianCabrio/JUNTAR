<?php

use frontend\models\Inscripcion;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;


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

$nombreEvento = $arrayEvento['nombre'];
$idEvento = $arrayEvento['idEvento'];


$nombreDelLibro = $idEvento."_Participantes_".$nombreEvento.".xls";

foreach($listados as $obj){
    
        $templateExcel->setActiveSheetIndex($obj['index']);

        $titulo= $obj['titulo'];
        $templateExcel->getActiveSheet()->setTitle( $titulo);

        $fila= $templateExcel->getActiveSheet()->setCellValue('B9', $nombreEvento);

    
        // Datos del Evento 
        $fila->setCellValue('k2', $arrayEvento['organizador'] );
        $fila->setCellValue('k3', date("d-m-Y", strtotime($arrayEvento['inicio']))  );
        $fila->setCellValue('k4', date("d-m-Y", strtotime($arrayEvento['fin'])) );
        $fila->setCellValue('k5', $arrayEvento['capacidad'] );
        $fila->setCellValue('k6', $arrayEvento['lugar'] );    
        $fila->setCellValue('k7', $arrayEvento['modalidad'] );

        // $row: los datos son insertado a partir de la fila 10
        $row = 12;

        // $i: enumera la cantidad las celdas con registros
        $i = 1;

        foreach( $obj['lista'] as  $obj ) {
                $fila= $templateExcel->getActiveSheet();
                $fila->setCellValue('B'.$row, $i )->getStyle('B'.$row)->applyFromArray($bordes);
                $fila->setCellValue('C'.$row, $obj['user_idInscripcion'])->getStyle('C'.$row)->applyFromArray($bordes);
               
                $fecha= "";

                if( $titulo=='Inscriptos'){
                    $fecha = date("d-m-Y", strtotime( $obj['user_fechaInscripcion'] ));
                }
                if( $titulo=='Preinscriptos'){
                    $fecha = date("d-m-Y", strtotime($obj['user_fechaPreInscripcion'] ));
                }

                $fila->setCellValue('D'.$row, $fecha )->getStyle('D'.$row)->applyFromArray($bordes);
                $fila->setCellValue('E'.$row, $obj['user_apellido'])->getStyle('E'.$row)->applyFromArray($bordes);
                $fila->setCellValue('F'.$row, $obj['user_nombre'])->getStyle('F'.$row)->applyFromArray($bordes);
                $fila->setCellValue('G'.$row, $obj['user_dni'])->getStyle('G'.$row)->applyFromArray($bordes);
                $fila->setCellValue('H'.$row, $obj['user_pais'])->getStyle('H'.$row)->applyFromArray($bordes);
                $fila->setCellValue('I'.$row, $obj['user_provincia'])->getStyle('I'.$row)->applyFromArray($bordes);
                $fila->setCellValue('J'.$row, $obj['user_localidad'])->getStyle('J'.$row)->applyFromArray($bordes);
                $fila->setCellValue('K'.$row, $obj['user_email'])->getStyle('K'.$row)->applyFromArray($bordes);
                
                $i =$i +1;
                $row = $row + 1;
        }

}

/// Me posiciono en la hoja Inscriptos
$templateExcel->setActiveSheetIndex(1);

/// guarda el archivo
$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter( $templateExcel, $fileType );
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$nombreDelLibro .'"');
ob_end_clean();

$writer->save("php://output");

exit;

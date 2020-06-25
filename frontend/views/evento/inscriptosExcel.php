<?php

use frontend\models\Inscripcion;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;


$fileType = 'Xls';
$file =  '../../template/inscriptos.ods';
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


$nombreDelLibro = $idEvento."_Participantes_".$nombreEvento.".ods";

$lista1[]= $listados[0];
$lista1[]= $listados[1];

foreach($lista1 as $obj){
    
    $fila= $templateExcel->setActiveSheetIndex($obj['index']);

        $titulo= $obj['titulo'];

        $fila->getStyle('B9:J9')->applyFromArray($bordes);
        $fila->setCellValue('B9', $nombreEvento.': '.$titulo)->getStyle('B9')->applyFromArray($bordes);


        
        $fila->getStyle('B11:J11')->applyFromArray($bordes);

        // Datos del Evento 
        $fila->setCellValue('J2', $arrayEvento['organizador'] );
        $fila->setCellValue('J3', date("d-m-Y", strtotime($arrayEvento['inicio']))  );
        $fila->setCellValue('J4', date("d-m-Y", strtotime($arrayEvento['fin'])) );
        $fila->setCellValue('J5', $arrayEvento['capacidad'] );
        $fila->setCellValue('J6', $arrayEvento['lugar'] );
        $fila->setCellValue('J7', $arrayEvento['modalidad'] );

        // $row: los datos son insertado a partir de la fila 10
        $row = 12;

        // $i: enumera la cantidad las celdas con registros
        $i = 1;

        foreach( $obj['lista'] as  $obj ) {
                $fila= $templateExcel->getActiveSheet();
                $fila->setCellValue('B'.$row, $i )->getStyle('B'.$row)->applyFromArray($bordes);
               
                $fecha= "";

                if( $titulo=='Inscriptos'){
                    $fecha = date("d-m-Y", strtotime( $obj['user_fechaInscripcion'] ));
                }
                if( $titulo=='Preinscriptos'){
                    $fecha = date("d-m-Y", strtotime($obj['user_fechaPreInscripcion'] ));
                }

                $fila->setCellValue('C'.$row, $fecha )->getStyle('C'.$row)->applyFromArray($bordes);
                $fila->setCellValue('D'.$row, $obj['user_apellido'])->getStyle('D'.$row)->applyFromArray($bordes);
                $fila->setCellValue('E'.$row, $obj['user_nombre'])->getStyle('E'.$row)->applyFromArray($bordes);
                $fila->setCellValue('F'.$row, $obj['user_dni'])->getStyle('F'.$row)->applyFromArray($bordes);
                $fila->setCellValue('G'.$row, $obj['user_pais'])->getStyle('G'.$row)->applyFromArray($bordes);
                $fila->setCellValue('H'.$row, $obj['user_provincia'])->getStyle('H'.$row)->applyFromArray($bordes);
                $fila->setCellValue('I'.$row, $obj['user_localidad'])->getStyle('I'.$row)->applyFromArray($bordes);
                $fila->setCellValue('J'.$row, $obj['user_email'])->getStyle('J'.$row)->applyFromArray($bordes);
                
                $i =$i +1;
                $row = $row + 1;
        }

}




$lista2[]= $listados[2];
$lista2[]= $listados[3];

foreach($lista2 as $obj){
    
    $fila= $templateExcel->setActiveSheetIndex($obj['index']);

        $titulo= $obj['titulo'];

        $fila->getStyle('B9:J9')->applyFromArray($bordes);
        $fila->setCellValue('B9', $nombreEvento.': '.$titulo)->getStyle('B9')->applyFromArray($bordes);


        
        $fila->getStyle('B11:I11')->applyFromArray($bordes);

        // Datos del Evento 
        $fila->setCellValue('I2', $arrayEvento['organizador'] );
        $fila->setCellValue('I3', date("d-m-Y", strtotime($arrayEvento['inicio']))  );
        $fila->setCellValue('I4', date("d-m-Y", strtotime($arrayEvento['fin'])) );
        $fila->setCellValue('I5', $arrayEvento['capacidad'] );
        $fila->setCellValue('I6', $arrayEvento['lugar'] );
        $fila->setCellValue('I7', $arrayEvento['modalidad'] );

        // $row: los datos son insertado a partir de la fila 10
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





/// Me posiciono en la hoja Inscriptos
$templateExcel->setActiveSheetIndex(1);

/// guarda el archivo
$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter( $templateExcel, $fileType );
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$nombreDelLibro .'"');
ob_end_clean();

$writer->save("php://output");

exit;

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


    
$fila= $templateExcel->setActiveSheetIndex(0);

$fila->getStyle('B9:K9')->applyFromArray($bordes);
$fila->setCellValue('B9', $nombreEvento)->getStyle('B9')->applyFromArray($bordes);

        
$fila->getStyle('B11:K11')->applyFromArray($bordes);

// Datos del Evento 
$fila->setCellValue('k2', $arrayEvento['organizador'] );
$fila->setCellValue('k3', date("d-m-Y", strtotime($arrayEvento['inicio']))  );
$fila->setCellValue('k4', date("d-m-Y", strtotime($arrayEvento['fin'])) );
$fila->setCellValue('k5', $arrayEvento['capacidad'] );
$fila->setCellValue('k6', $arrayEvento['lugar'] );
$fila->setCellValue('k7', $arrayEvento['modalidad'] );

// $row: los datos son insertado a partir de la fila 10
$row = 12;

// $i: enumera la cantidad las filas de la tabla

$i = 1;


foreach( $participantes as  $dato ) {
                 
         $fila->setCellValue('B'.$row, $i )->getStyle('B'.$row)->applyFromArray($bordes);
         $fila->setCellValue('C'.$row, obtenerEstado( $dato['user_estado'])  )->getStyle('C'.$row)->applyFromArray($bordes);
         $fila->setCellValue('D'.$row, obtenerFecha($dato))->getStyle('D'.$row)->applyFromArray($bordes);
         $fila->setCellValue('E'.$row, $dato['user_apellido'])->getStyle('E'.$row)->applyFromArray($bordes);
         $fila->setCellValue('F'.$row, $dato['user_nombre'])->getStyle('F'.$row)->applyFromArray($bordes);
         $fila->setCellValue('G'.$row, $dato['user_dni'])->getStyle('G'.$row)->applyFromArray($bordes);
         $fila->setCellValue('H'.$row, $dato['user_pais'])->getStyle('H'.$row)->applyFromArray($bordes);
         $fila->setCellValue('I'.$row, $dato['user_provincia'])->getStyle('I'.$row)->applyFromArray($bordes);
         $fila->setCellValue('J'.$row, $dato['user_localidad'])->getStyle('J'.$row)->applyFromArray($bordes);
         $fila->setCellValue('K'.$row, $dato['user_email'])->getStyle('K'.$row)->applyFromArray($bordes);
                
        $i =$i +1;
        $row = $row + 1;
 }










/// guarda el archivo
$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter( $templateExcel, $fileType );
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$nombreDelLibro .'"');
ob_end_clean();

$writer->save("php://output");

exit;


function obtenerFecha($estado){    

    $obtener= "";

    if( $estado['user_estado']==1){ $obtener = date("d-m-Y", strtotime( $estado['user_fechaPreInscripcion'])); }
    if( $estado['user_estado']==2){ $obtener = date("d-m-Y", strtotime( $estado['user_fechaInscripcion'] )); }

    return $obtener;
}

function obtenerEstado($estado){    

    $obtener= "";

    if( $estado==1 ){ $obtener = "preinscripto"; }
    if( $estado==2 ){ $obtener = "inscripto"; }
    if( $estado==3 ){ $obtener= "anulado"; }      
    if( $estado==4 ){ $obtener= "acreditado";}

    return $obtener;
}
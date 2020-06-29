<?php

    use frontend\models\Inscripcion;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Style\Fill;
    use PhpOffice\PhpSpreadsheet\Cell\DataType;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Border;


    $fileType = 'Ods';

    $templateExcel  = $spreadsheet = new Spreadsheet();

    $nombreDelLibro = $datosDelEvento['idEvento']."_Participantes_".$datosDelEvento['idEvento'].".ods";

        
    $fila= $templateExcel->setActiveSheetIndex(0);
    $fila->setCellValue('B9', $datosDelEvento['idEvento']);

     
    // Datos del Evento 
    
    $fila->setCellValueByColumnAndRow( 10, 2, $datosDelEvento['organizador'] );
    $fila->setCellValueByColumnAndRow( 10, 3, 'Inicio: '.date("d-m-Y", strtotime($datosDelEvento['inicio']))  );
    $fila->setCellValueByColumnAndRow( 10, 4, 'Fin: '. date("d-m-Y", strtotime($datosDelEvento['fin'])) );
    $fila->setCellValueByColumnAndRow( 10, 5, 'Capacidad: '. $datosDelEvento['capacidad'] );
    $fila->setCellValueByColumnAndRow( 10, 6, 'Lugar: '.$datosDelEvento['lugar'] );
    $fila->setCellValueByColumnAndRow( 10, 7, 'Modalidad: '. $datosDelEvento['modalidad'] );

    $row = 12;    // $row: los datos son insertado a partir de la fila 10

    $i = 1;    // $i: enumera la cantidad las filas de la tabla


    // Encabezado  datos del usuario

    $fila->setCellValueByColumnAndRow( 1, 11,'#');
    $fila->setCellValueByColumnAndRow( 2, 11,'Estado');
    $fila->setCellValueByColumnAndRow( 3, 11,'Fecha');
    $fila->setCellValueByColumnAndRow( 4, 11,'Apellido');
    $fila->setCellValueByColumnAndRow( 5, 11,'Nombre');
    $fila->setCellValueByColumnAndRow( 6, 11,'Dni');
    $fila->setCellValueByColumnAndRow( 7, 11,'Pais');
    $fila->setCellValueByColumnAndRow( 8, 11,'Provincia');
    $fila->setCellValueByColumnAndRow( 9, 11,'Localidad');
    $fila->setCellValueByColumnAndRow( 10, 11,'Email');

    // Encabezado  preguntas del Usurio
    $i= 11;
    foreach($preguntas as $pregunta){
        $fila->setCellValueByColumnAndRow( $i, 11, $pregunta['descripcion'] );
        $i++;
    }



    ///// listado de los datos de los usuarios inscripto a un evento
    $i=1;

    $row = 12;// $row: los datos son insertado a partir de la fila 12
    foreach( $listaRepuesta as  $datos ) {
        $unParticipante= $datos['unParticipante'];
                    
        $fila->setCellValueByColumnAndRow( 1, $row, $i );
        $fila->setCellValueByColumnAndRow( 2, $row, obtenerEstado( $unParticipante) );
        $fila->setCellValueByColumnAndRow( 3, $row, obtenerFecha($unParticipante) );
        $fila->setCellValueByColumnAndRow( 4, $row, $unParticipante['user_apellido'] );
        $fila->setCellValueByColumnAndRow( 5, $row, $unParticipante['user_nombre'] );
        $fila->setCellValueByColumnAndRow( 6, $row, $unParticipante['user_dni'] );
        $fila->setCellValueByColumnAndRow( 7, $row, $unParticipante['user_pais'] );
        $fila->setCellValueByColumnAndRow( 8, $row, $unParticipante['user_provincia'] );
        $fila->setCellValueByColumnAndRow( 9, $row, $unParticipante['user_localidad'] );
        $fila->setCellValueByColumnAndRow( 10,$row, $unParticipante['user_email'] );
            
        $j= 11;
        $respuestas= $datos['respuestas'];
        $url_archivo ="";
        $url_descarga= "";
        foreach( $respuestas as  $dato2 ) {
                if($dato2['pregunta_tipo'] ==3){
                    /// ../../../eventos/formularios/archivos/ 
                    $url_archivo = str_replace("../../../", "", $dato2['respuesta_user']);
                    $url_descarga= 'http://juntar.test/'.$url_archivo;

                    $fila->setCellValueByColumnAndRow($j, $row, str_replace(' ','',$url_descarga) );
                    // ej:  http://juntar.test/eventos/formularios/archivos/Captura.png
                }else{
                    $fila->setCellValueByColumnAndRow($j, $row, $dato2['respuesta_user']);
                }
     
            $j++;
        }
                    
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

    function obtenerEstado($dato){    
 
        $obtener= "";

        if( $dato['user_estado'] == 0 ){ $obtener = "preinscripto"; }
        if( $dato['user_estado'] == 1 && $dato['user_acreditacion'] == 0 ){ $obtener = "inscripto"; }
        if( $dato['user_estado'] == 1 && $dato['user_acreditacion'] == 1 ){ $obtener= "acreditado"; }      
        if( $dato['user_estado'] == 2 ){ $obtener= "anulado";}

        return $obtener;
    }


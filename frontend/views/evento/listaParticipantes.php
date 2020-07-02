<?php

    use frontend\models\Inscripcion;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Style\Fill;
    use PhpOffice\PhpSpreadsheet\Cell\DataType;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use yii\helpers\Html;
    use yii\helpers\Url;





    $template =  new Spreadsheet();

    $nombreDelLibro = $datosDelEvento['idEvento']."_Participantes_".$datosDelEvento['idEvento'];

        
    $fila= $template->setActiveSheetIndex(0);

     
    // Datos del Evento 
    if($extension=='ods'){
        $fila->setCellValueByColumnAndRow( 10, 2, $datosDelEvento['organizador'] );
        $fila->setCellValueByColumnAndRow( 10, 3, 'Inicio: '.date("d-m-Y", strtotime($datosDelEvento['inicio']))  );
        $fila->setCellValueByColumnAndRow( 10, 4, 'Fin: '. date("d-m-Y", strtotime($datosDelEvento['fin'])) );
        $fila->setCellValueByColumnAndRow( 10, 5, 'Capacidad: '. $datosDelEvento['capacidad'] );
        $fila->setCellValueByColumnAndRow( 10, 6, 'Lugar: '.$datosDelEvento['lugar'] );
        $fila->setCellValueByColumnAndRow( 10, 7, 'Modalidad: '. $datosDelEvento['modalidad'] );
    }

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
        $fila->setCellValueByColumnAndRow( $i, 11, mb_convert_encoding( $pregunta['descripcion'] , 'UTF-8' )  );
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
        $fila->setCellValueByColumnAndRow( 4, $row, mb_convert_encoding( $unParticipante['user_apellido'], 'UTF-8' )  );
        $fila->setCellValueByColumnAndRow( 5, $row, mb_convert_encoding( $unParticipante['user_nombre'], 'UTF-8' ) );
        $fila->setCellValueByColumnAndRow( 6, $row, mb_convert_encoding( $unParticipante['user_dni'], 'UTF-8' )  );
        $fila->setCellValueByColumnAndRow( 7, $row, mb_convert_encoding( $unParticipante['user_pais'], 'UTF-8' ) );
        $fila->setCellValueByColumnAndRow( 8, $row, mb_convert_encoding( $unParticipante['user_provincia'], 'UTF-8' )  );
        $fila->setCellValueByColumnAndRow( 9, $row, mb_convert_encoding( $unParticipante['user_localidad'], 'UTF-8' ));
        $fila->setCellValueByColumnAndRow( 10,$row, mb_convert_encoding( $unParticipante['user_email'], 'UTF-8' ));
            
        $j= 11;
        $respuestas= $datos['respuestas'];
        $url_archivo ="";
        $url_descarga= "";
        foreach( $respuestas as  $dato2 ) {
                if($dato2['pregunta_tipo'] ==3){
                   $url_descarga = Url::base('') . $dato2['respuesta_user'];

                    $fila->setCellValueByColumnAndRow($j, $row, $url_descarga );
                }else{
                    $fila->setCellValueByColumnAndRow($j, $row, mb_convert_encoding( Html::encode($dato2['respuesta_user']), 'UTF-8' ));
                }
     
            $j++;
        }
                    
        $i =$i +1;
        $row = $row + 1;
    }

    if($extension== 'csv'){          
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($template);
        $writer->setDelimiter(';');
     // $writer->setEnclosure('');
     // $writer->setSheetIndex(0);
        $nombreDelLibro= $nombreDelLibro.'.csv';
     } 

     if($extension == 'ods') {
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Ods($template);
        $nombreDelLibro = $nombreDelLibro.'.ods';
     }

    /// guarda el archivo
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'. $nombreDelLibro .'"');
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


<?php

function descargaCategorizados(){

$conexion=new mysqli("localhost","test","winston123456","res_gleads");


   // $conexion = new mysqli('localhost','root','','test',3306);
  if (mysqli_connect_errno()) {
      printf("La conexión con el servidor de base de datos falló: %s\n", mysqli_connect_error());
      exit();
  }

$conexion->set_charset("utf8"); 

date_default_timezone_set('America/Santiago');

//$hoy = date("Y-m-d H:i:s");     
$hoy = date("Y-m-d");   

  $consulta = "
    SELECT idRepuesta,idPuente,idRespuestaEncuesta,idInmobiliaria,
    idProyecto,idUser,idPais,fechaPuntos
    FROM zz_glead_respuestas 
    LIMIT 10
    ";


  $resultado = $conexion->query($consulta);
  if($resultado->num_rows > 0 ){
            

    if (PHP_SAPI == 'cli')
      die('Este archivo solo se puede ver desde un navegador web');

    /** Se agrega la libreria PHPExcel */
    require_once 'lib/PHPExcel/PHPExcel.php';

    // Se crea el objeto PHPExcel
    $objPHPExcel = new PHPExcel();

    // Se asignan las propiedades del libro
    $objPHPExcel->getProperties()->setCreator("TGA") //Autor
               ->setLastModifiedBy("TGA") //Ultimo usuario que lo modificó
               ->setTitle("Reporte Excel con PHP y MySQL")
               ->setSubject("Reporte Excel con PHP y MySQL")
               ->setDescription("Reporte EURO")
               ->setKeywords("Reporte EURO")
               ->setCategory("Reporte EURO");

    $tituloReporte = "Reporte Global";
    $titulosColumnas = array(
'idRepuesta',
'idPuente',
'idRespuestaEncuesta',
'idInmobiliaria',
'idProyecto',
'idUser',
'idPais',
'fechaPuntos'
);
    
$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('A1:D1');        
// Se agregan los titulos del reporte
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1',  $tituloReporte)
->setCellValue('A3',  $titulosColumnas[0])
->setCellValue('B3',  $titulosColumnas[1])
->setCellValue('C3',  $titulosColumnas[2])
->setCellValue('D3',  $titulosColumnas[3])
->setCellValue('E3',  $titulosColumnas[4])
->setCellValue('F3',  $titulosColumnas[5])
->setCellValue('G3',  $titulosColumnas[6])             
->setCellValue('H3',  $titulosColumnas[7]);
           
    
    //Se agregan los datos al reporte
    $i = 4;
    while ($fila = $resultado->fetch_array()) {

      $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$i,  $fila['idRepuesta'])
        ->setCellValue('B'.$i,  $fila['idPuente'])
        ->setCellValue('C'.$i,  $fila['idRespuestaEncuesta'])
        ->setCellValue('D'.$i, $fila['idInmobiliaria'])
        ->setCellValue('E'.$i, ($fila['idProyecto']))
        ->setCellValue('F'.$i, ucfirst($fila['idUser']))
        ->setCellValue('G'.$i, ($fila['idPais']))
            ->setCellValue('H'.$i, ($fila['fechaPuntos']));
 
      $i++;

  
    }

    $estiloTituloReporte = array(
          'font' => array(
            'name'      => 'Verdana',
              'bold'      => true,
              'italic'    => false,
                'strike'    => false,
                'size'      => 11,
              'color'     => array(
              'rgb'       => 'FFFFFF'
                  )
            ),
          'fill' => array(
        'type'  => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('argb' => 'FF220835')
      ),
            'borders' => array(
                'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_NONE                    
                )
            ), 
            'alignment' =>  array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
              'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'rotation'   => 0,
              'wrap'          => TRUE
        )
        );

    $estiloTituloColumnas = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => true,                          
                'color'     => array(
                    'rgb' => '000000'
                )
        ));
      
    $estiloInformacion = new PHPExcel_Style();
    $estiloInformacion->applyFromArray(
      array(
              'font' => array(
                'name'      => 'Arial',               
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'fill'  => array(
        'type'    => PHPExcel_Style_Fill::FILL_SOLID,
        //'color'   => array('argb' => 'FFd9b7f4')
      ),
            'borders' => array(
                'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                  'color' => array(
                    'rgb' => '3a2a47'
                    )
                )             
            )
        ));
     
    $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($estiloTituloReporte);
    $objPHPExcel->getActiveSheet()->getStyle('A3:AM3')->applyFromArray($estiloTituloColumnas);    
    //$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:AM".($i-1));
        
    for($i = 'A'; $i <= 'H'; $i++){
      $objPHPExcel->setActiveSheetIndex(0)      
        ->getColumnDimension($i)->setAutoSize(TRUE);
    }
    
    // Se asigna el nombre a la hoja
    $objPHPExcel->getActiveSheet()->setTitle('Hoja 1');

    // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
    $objPHPExcel->setActiveSheetIndex(0);
    // Inmovilizar paneles 
    //$objPHPExcel->getActiveSheet(0)->freezePane('A4');
    $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

    // Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Reporte_EURO('.$hoy.').xls"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
    
  }
  else{
    print_r('No hay resultados para mostrar');
  }
}

?>
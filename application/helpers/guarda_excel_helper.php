<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

function descargaCategorizados($idInmo,$idProy,$fInicio,$fFinal){

date_default_timezone_set('America/Santiago');

$hoy = date("Y-m-d");   

$CI =& get_instance();
$CI->load->model('Model_welcome');
$resultado = $CI->Model_welcome->getCatModelFull($idInmo,$idProy,$fInicio,$fFinal);


  if($resultado->num_rows() > 0 ){

  //Se agrega la libreria PHPExcel */
    require_once 'lib/PHPExcel/PHPExcel.php';

    // Se crea el objeto PHPExcel
    $objPHPExcel = new PHPExcel();

    // Se asignan las propiedades del libro
    $objPHPExcel->getProperties()->setCreator("TGA") //Autor
               ->setLastModifiedBy("TGA") //Ultimo usuario que lo modificó
               ->setTitle("Reporte idInmobiliaria")
               ->setSubject("Reporte Excel con PHP y MySQL")
               ->setDescription("Reporte idInmobiliaria")
               ->setKeywords("Reporte idInmobiliaria")
               ->setCategory("Reporte idInmobiliaria");

    
    $titulogleads   = "G-Leads";
    $tituloReporte4 = $titulogleads." es parte de la familia de servicios de TGA";
    $tituloReporte5 = "(562) 2233 4658)";
    $tituloReporte6 = "Alfredo Barros Errazuriz 1900, OF 204";
    $tituloReporte7 = "Providencia | Santiago";
    $tituloReporte8 = "Chile";


    $titulosColumnas = array(
'idRepuesta',
'Inmobiliaria',
'Proyecto',
'FechaPuntos',
'Intervalo',
'Cliente',
'Correo',
'rut',
'donde',
'Mejor'
);
/*    
$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('A1:D1'); */ 
// Se agregan los titulos del reporte
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('F4',  $tituloReporte4)
->setCellValue('F5',  $tituloReporte5)
->setCellValue('F6',  $tituloReporte6)
->setCellValue('F7',  $tituloReporte7)
->setCellValue('F8',  $tituloReporte8)
->setCellValue('A13',  $titulosColumnas[0])
->setCellValue('B13',  $titulosColumnas[1])
->setCellValue('C13',  $titulosColumnas[2])
->setCellValue('D13',  $titulosColumnas[3])
->setCellValue('E13',  $titulosColumnas[4])
->setCellValue('F13',  $titulosColumnas[5])
->setCellValue('G13',  $titulosColumnas[6]) 
->setCellValue('H13',  $titulosColumnas[7])    
->setCellValue('I13',  $titulosColumnas[8])                
->setCellValue('J13',  $titulosColumnas[9]);
           
    
    //Se agregan los datos al reporte
    $i = 14;

    foreach ($resultado->result() as $row)
{

     $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$i,  $row->idRepuesta)
        ->setCellValue('B'.$i,  $row->nombre)
        ->setCellValue('C'.$i,  $row->Proyecto)
        ->setCellValue('D'.$i,  $row->FechaPuntos)
        ->setCellValue('E'.$i,  $row->Intervalo)
        ->setCellValue('F'.$i,  $row->Cliente)
        ->setCellValue('G'.$i,  $row->Correo)
        ->setCellValue('H'.$i,  $row->rut)
        ->setCellValue('I'.$i,  $row->donde)
        ->setCellValue('J'.$i,  $row->mejor);
     $i++;   
}
$inmobiliaria=$row->Inmobiliaria;

   $estiloTituloReporte = array(
          'font' => array(
            'name'      => 'Verdana',
              'bold'      => true,
              'italic'    => false,
                'strike'    => false,
                'size'      => 11,
              'color'     => array(
              'rgb'       => '000000'
                  )
            ),
          'fill' => array(
        'type'  => PHPExcel_Style_Fill::FILL_SOLID,
       'color' => array('rgb' => 'FFFFFF')
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
        ),
          'alignment' =>  array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
          'rotation'   => 0,
          'wrap'          => TRUE
          ),
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
        );


        $estiloTitulogleads = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => true,                          
                'color'     => array(
                    'rgb' => '990000'
                )
        ));

          $titulogleadsNegritas = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => true,                          
                'color'     => array(
                    'rgb' => '000000'
                ),
                'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation'   => 0,
                'wrap'          => TRUE
                )
        ));

          $titulogleads = array(
            'font' => array(
                'name'      => 'Calibri',  
                 'bold'      => false,                                  
                'color'     => array(
                    'rgb' => '000000'
                ),
                'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation'   => 0,
                'wrap'          => TRUE
                )
        ));

        $todoContenido = array(
            'font' => array(
                'name'      => 'Calibri',  
                 'bold'      => false,                                  
                'color'     => array(
                    'rgb' => '000000'
                )
    ),   
              'borders' => array(
              'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
  )
        ));
      

    $objPHPExcel->getActiveSheet()
    ->getStyle('A1:J12')->applyFromArray($estiloTituloReporte);
    $objPHPExcel->getActiveSheet()
    ->getStyle('A13:J13')->applyFromArray($estiloTituloColumnas);  
    $objPHPExcel->getActiveSheet()
    ->getStyle('F5:F8')->applyFromArray($titulogleads);  
      $objPHPExcel->getActiveSheet()
    ->getStyle('F4')->applyFromArray($titulogleadsNegritas);    

     $objPHPExcel->getActiveSheet()
    ->getStyle('A14:J'.--$i.'')->applyFromArray($todoContenido);  


//BORDER

/*
BORDER_DASHDOT
BORDER_DASHDOTDOT
BORDER_DASHED
BORDER_DOTTED
BORDER_DOUBLE
BORDER_HAIR
BORDER_MEDIUM
BORDER_MEDIUMDASHDOT
BORDER_MEDIUMDASHDOTDOT
BORDER_MEDIUMDASHED
BORDER_NONE
BORDER_SLANTDASHDOT
BORDER_THICK
BORDER_THIN
*/

//imagen


      $objDrawing = new PHPExcel_Worksheet_Drawing();
      $objDrawing->setName('imgNotice');
      $objDrawing->setDescription('Noticia');
      $img = 'img/G-Leads.png'; // Provide path to your logo file
      $objDrawing->setPath($img);
     // $objDrawing->setOffsetX(200);    // setOffsetX works properly
     // $objDrawing->setOffsetY(172);  //setOffsetY has no effect
      $objDrawing->setCoordinates('C3');
 //    $objDrawing->setWeight(52); // logo height
     $objDrawing->setHeight(55); // logo height
     // $objDrawing->setWidthAndHeight(125,400);
   // $objDrawing->setResizeProportional(true);
       $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());








        
    for($i = 'A'; $i <= 'J'; $i++){
      $objPHPExcel->setActiveSheetIndex(0)      
        ->getColumnDimension($i)->setAutoSize(TRUE);
    }
    
    // Se asigna el nombre a la hoja
    $objPHPExcel->getActiveSheet()->setTitle('Categorizados');

    // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
    $objPHPExcel->setActiveSheetIndex(0);
    // Inmovilizar paneles 
    //$objPHPExcel->getActiveSheet(0)->freezePane('A4');
   // $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

    // Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)

    // We'll be outputting an excel file 
 //   header('Content-type: application/vnd.ms-excel'); // It will be called file.xls 
   // header('Content-Disposition: attachment; filename="file.xls"'); // Write file to the browser 

  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="categorizados_'.$inmobiliaria.'_'.$fInicio.'_'.$fFinal.'.xls"');
  header('Cache-Control: max-age=0');

//SET IN $ xlsName name de XLSX con extensión. Ejemplo: $ xlsName = 'teste.xlsx';
/*$objPHPExcel = new PHPExcel(); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$xlsName.'"'); 
header('Cache-Control: max-age=0'); $objWriter->save('php://output');

//SET IN $ xlsName name de XLS con extensión. Ejemplo: $ xlsName = 'teste.xls';
$objPHPExcel = new PHPExcel(); 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$xlsName.'"');
header('Cache-Control: max-age=0'); $objWriter->save('php://output'); 
*/
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
    
  }else{
    print_r('No hay resultados para mostrar');
  }

}


function descargaPromesa($idInmo,$idProy,$fInicio,$fFinal){

date_default_timezone_set('America/Santiago');

$hoy = date("Y-m-d");   

$CI =& get_instance();
$CI->load->model('Model_welcome');
$resultado = $CI->Model_welcome->getPromesas($idInmo,$idProy,$fInicio,$fFinal);


  if($resultado->num_rows() > 0 ){
    require_once 'lib/PHPExcel/PHPExcel.php';
    $objPHPExcel = new PHPExcel();

    // Se asignan las propiedades del libro
    $objPHPExcel->getProperties()->setCreator("TGA") //Autor
               ->setLastModifiedBy("TGA") //Ultimo usuario que lo modificó
               ->setTitle("Reporte Promesas")
               ->setSubject("Reporte Promesas")
               ->setDescription("Reporte Promesas")
               ->setKeywords("Reporte Promesas")
               ->setCategory("Reporte Promesas");

    $titulogleads   = "G-Leads";
    $tituloReporte4 = $titulogleads." es parte de la familia de servicios de TGA";
    $tituloReporte5 = "(562) 2233 4658)";
    $tituloReporte6 = "Alfredo Barros Errazuriz 1900, OF 204";
    $tituloReporte7 = "Providencia | Santiago";
    $tituloReporte8 = "Chile";

    $titulosColumnas = array(
'idPromesaIn',
'idInmobiliaria',
'idUser',
'ejecutivo',
'email',
'nombre',
'rut',
'fechaPromesa',
'fechaGuardado',
'idProyecto',
'nombreP',
'programa',
'donde'
);
    

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('F4',  $tituloReporte4)
->setCellValue('F5',  $tituloReporte5)
->setCellValue('F6',  $tituloReporte6)
->setCellValue('F7',  $tituloReporte7)
->setCellValue('F8',  $tituloReporte8)
->setCellValue('A13',  $titulosColumnas[0])
->setCellValue('B13',  $titulosColumnas[1])
->setCellValue('C13',  $titulosColumnas[2])
->setCellValue('D13',  $titulosColumnas[3])
->setCellValue('E13',  $titulosColumnas[4])
->setCellValue('F13',  $titulosColumnas[5])
->setCellValue('G13',  $titulosColumnas[6]) 
->setCellValue('H13',  $titulosColumnas[7])    
->setCellValue('I13',  $titulosColumnas[8])  
->setCellValue('J13',  $titulosColumnas[9])  
->setCellValue('K13',  $titulosColumnas[10])    
->setCellValue('L13',  $titulosColumnas[11])               
->setCellValue('M13',  $titulosColumnas[12]);
           
    //Se agregan los datos al reporte
    $i = 14;

    foreach ($resultado->result() as $row)
{

     $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$i,  $row->idPromesaIn)
        ->setCellValue('B'.$i,  $row->idInmobiliaria)
        ->setCellValue('C'.$i,  $row->idUser)
        ->setCellValue('D'.$i,  $row->ejecutivo)
        ->setCellValue('E'.$i,  $row->email)
        ->setCellValue('F'.$i,  $row->nombre)
        ->setCellValue('G'.$i,  $row->rut)
        ->setCellValue('H'.$i,  $row->fechaPromesa)
        ->setCellValue('I'.$i,  $row->fechaGuardado)
        ->setCellValue('J'.$i,  $row->idProyecto)
        ->setCellValue('K'.$i,  $row->nombreP)
        ->setCellValue('L'.$i,  $row->programa)
        ->setCellValue('M'.$i,  $row->donde);
     $i++;   
}

$inmobiliaria=$row->Inmobiliaria;

   $estiloTituloReporte = array(
          'font' => array(
            'name'      => 'Verdana',
              'bold'      => true,
              'italic'    => false,
                'strike'    => false,
                'size'      => 11,
              'color'     => array(
              'rgb'       => '000000'
                  )
            ),
          'fill' => array(
        'type'  => PHPExcel_Style_Fill::FILL_SOLID,
       'color' => array('rgb' => 'FFFFFF')
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
        ),
          'alignment' =>  array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
          'rotation'   => 0,
          'wrap'          => TRUE
          ),
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
        );


        $estiloTitulogleads = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => true,                          
                'color'     => array(
                    'rgb' => '990000'
                )
        ));

          $titulogleadsNegritas = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => true,                          
                'color'     => array(
                    'rgb' => '000000'
                ),
                'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation'   => 0,
                'wrap'          => TRUE
                )
        ));

          $titulogleads = array(
            'font' => array(
                'name'      => 'Calibri',  
                 'bold'      => false,                                  
                'color'     => array(
                    'rgb' => '000000'
                ),
                'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation'   => 0,
                'wrap'          => TRUE
                )
        ));

        $todoContenido = array(
            'font' => array(
                'name'      => 'Calibri',  
                 'bold'      => false,                                  
                'color'     => array(
                    'rgb' => '000000'
                )
    ),   
              'borders' => array(
              'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
  )
        ));
      

    $objPHPExcel->getActiveSheet()
    ->getStyle('A1:M12')->applyFromArray($estiloTituloReporte);
    $objPHPExcel->getActiveSheet()
    ->getStyle('A13:M13')->applyFromArray($estiloTituloColumnas);  
    $objPHPExcel->getActiveSheet()
    ->getStyle('F5:F8')->applyFromArray($titulogleads);  
      $objPHPExcel->getActiveSheet()
    ->getStyle('F4')->applyFromArray($titulogleadsNegritas);    

     $objPHPExcel->getActiveSheet()
    ->getStyle('A14:M'.--$i.'')->applyFromArray($todoContenido);   

    //imagen

    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('imgNotice');
    $objDrawing->setDescription('Noticia');
    $img = 'img/G-Leads.png';
    $objDrawing->setPath($img);
    $objDrawing->setCoordinates('C3');
    $objDrawing->setHeight(55); // logo height
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        
    for($i = 'A'; $i <= 'M'; $i++){
      $objPHPExcel->setActiveSheetIndex(0)      
        ->getColumnDimension($i)->setAutoSize(TRUE);
    }
    
    $objPHPExcel->getActiveSheet()->setTitle('Promesas');
    $objPHPExcel->setActiveSheetIndex(0);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="promesas_'.$inmobiliaria.'_'.$fInicio.'_'.$fFinal.'.xls"');
  header('Cache-Control: max-age=0');


    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
    
  }else{
    print_r('No hay resultados para mostrar');
  }
}


function descargaCotizaciones($idInmo,$idProy,$fInicio,$fFinal){

date_default_timezone_set('America/Santiago');

$hoy = date("Y-m-d");   

$CI =& get_instance();
$CI->load->model('Model_welcome');
$resultado = $CI->Model_welcome->getCot($idInmo,$idProy,$fInicio,$fFinal);


  if($resultado->num_rows() > 0 ){

    require_once 'lib/PHPExcel/PHPExcel.php';

    $objPHPExcel = new PHPExcel();

    $objPHPExcel->getProperties()->setCreator("TGA") //Autor
               ->setLastModifiedBy("TGA") //Ultimo usuario que lo modificó
               ->setTitle("Reporte Inmobiliaria")
               ->setSubject("Reporte Excel Cotizaciones")
               ->setDescription("Reporte Inmobiliaria")
               ->setKeywords("Reporte Inmobiliaria")
               ->setCategory("Reporte Inmobiliaria");

   
    $titulogleads   = "G-Leads";
    $tituloReporte4 = $titulogleads." es parte de la familia de servicios de TGA";
    $tituloReporte5 = "(562) 2233 4658)";
    $tituloReporte6 = "Alfredo Barros Errazuriz 1900, OF 204";
    $tituloReporte7 = "Providencia | Santiago";
    $tituloReporte8 = "Chile";

    $titulosColumnas = array(
'idCategorizar',
'Inmobiliaria',
'idProyecto',
'Proyecto',
'FechaCotizacion',
'Cliente',
'rut',
'email',
'fono',
'idPortal',
'portal',
'dondeviene',
'programa',
'comentario'
);
    
$objPHPExcel->setActiveSheetIndex(0)

->setCellValue('F4',  $tituloReporte4)
->setCellValue('F5',  $tituloReporte5)
->setCellValue('F6',  $tituloReporte6)
->setCellValue('F7',  $tituloReporte7)
->setCellValue('F8',  $tituloReporte8)
->setCellValue('A13',  $titulosColumnas[0])
->setCellValue('B13',  $titulosColumnas[1])
->setCellValue('C13',  $titulosColumnas[2])
->setCellValue('D13',  $titulosColumnas[3])
->setCellValue('E13',  $titulosColumnas[4])
->setCellValue('F13',  $titulosColumnas[5])
->setCellValue('G13',  $titulosColumnas[6]) 
->setCellValue('H13',  $titulosColumnas[7])    
->setCellValue('I13',  $titulosColumnas[8])  
->setCellValue('J13',  $titulosColumnas[9])  
->setCellValue('K13',  $titulosColumnas[10])      
->setCellValue('L13',  $titulosColumnas[11])    
->setCellValue('M13',  $titulosColumnas[12])              
->setCellValue('N13',  $titulosColumnas[13]);
           
    
    //Se agregan los datos al reporte
    $i = 14;

    foreach ($resultado->result() as $row)
{

     $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$i,  $row->idCategorizar)
        ->setCellValue('B'.$i,  utf8_decode($row->Inmobiliaria))
        ->setCellValue('C'.$i,  $row->idProyecto)
        ->setCellValue('D'.$i,  utf8_decode($row->Proyecto))
        ->setCellValue('E'.$i,  $row->FechaCotizacion)
        ->setCellValue('F'.$i,  utf8_decode($row->Cliente))
        ->setCellValue('G'.$i,  utf8_decode($row->rut))
        ->setCellValue('H'.$i,  utf8_decode($row->email))
        ->setCellValue('I'.$i,  utf8_decode($row->fono))
        ->setCellValue('J'.$i,  $row->idPortal)
        ->setCellValue('K'.$i,  $row->portal)
        ->setCellValue('L'.$i,  utf8_decode($row->dondeviene))
        ->setCellValue('M'.$i,  utf8_decode($row->programa))
        ->setCellValue('N'.$i,  utf8_decode($row->comentario));
     $i++;   
}
$inmobiliaria=$row->Inmobiliaria;

  $estiloTituloReporte = array(
          'font' => array(
            'name'      => 'Verdana',
              'bold'      => true,
              'italic'    => false,
                'strike'    => false,
                'size'      => 11,
              'color'     => array(
              'rgb'       => '000000'
                  )
            ),
          'fill' => array(
        'type'  => PHPExcel_Style_Fill::FILL_SOLID,
       'color' => array('rgb' => 'FFFFFF')
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
        ),
          'alignment' =>  array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
          'rotation'   => 0,
          'wrap'          => TRUE
          ),
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
        );


        $estiloTitulogleads = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => true,                          
                'color'     => array(
                    'rgb' => '990000'
                )
        ));

          $titulogleadsNegritas = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => true,                          
                'color'     => array(
                    'rgb' => '000000'
                ),
                'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation'   => 0,
                'wrap'          => TRUE
                )
        ));

          $titulogleads = array(
            'font' => array(
                'name'      => 'Calibri',  
                 'bold'      => false,                                  
                'color'     => array(
                    'rgb' => '000000'
                ),
                'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation'   => 0,
                'wrap'          => TRUE
                )
        ));

        $todoContenido = array(
            'font' => array(
                'name'      => 'Calibri',  
                 'bold'      => false,                                  
                'color'     => array(
                    'rgb' => '000000'
                )
    ),   
              'borders' => array(
              'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
  )
        ));
      

    $objPHPExcel->getActiveSheet()
    ->getStyle('A1:N12')->applyFromArray($estiloTituloReporte);
    $objPHPExcel->getActiveSheet()
    ->getStyle('A13:N13')->applyFromArray($estiloTituloColumnas);  
    $objPHPExcel->getActiveSheet()
    ->getStyle('F5:F8')->applyFromArray($titulogleads);  
      $objPHPExcel->getActiveSheet()
    ->getStyle('F4')->applyFromArray($titulogleadsNegritas);    

     $objPHPExcel->getActiveSheet()
    ->getStyle('A14:N'.--$i.'')->applyFromArray($todoContenido);   


//imagen

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('imgNotice');
$objDrawing->setDescription('Noticia');
$img = 'img/G-Leads.png'; // Provide path to your logo file
$objDrawing->setPath($img);
$objDrawing->setCoordinates('C3');
$objDrawing->setHeight(55); // logo height
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        
    for($i = 'A'; $i <= 'N'; $i++){
      $objPHPExcel->setActiveSheetIndex(0)      
        ->getColumnDimension($i)->setAutoSize(TRUE);
    }
    



    $objPHPExcel->getActiveSheet()->setTitle('Cotizaciones');
    $objPHPExcel->setActiveSheetIndex(0);

  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="cotizaciones_'.$inmobiliaria.'_'.$fInicio.'_'.$fFinal.'.xls"');
  header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
    
  }else{
    print_r('No hay resultados para mostrar');
  }
}


function descargaConsultas($idInmo,$idProy,$fInicio,$fFinal){

date_default_timezone_set('America/Santiago');

$hoy = date("Y-m-d");   

$CI =& get_instance();
$CI->load->model('Model_welcome');
$resultado = $CI->Model_welcome->getConsultas($idInmo,$idProy,$fInicio,$fFinal);


  if($resultado->num_rows() > 0 ){

    require_once 'lib/PHPExcel/PHPExcel.php';

    $objPHPExcel = new PHPExcel();

    $objPHPExcel->getProperties()->setCreator("TGA") //Autor
               ->setLastModifiedBy("TGA") //Ultimo usuario que lo modificó
               ->setTitle("Reporte Excel Consultas")
               ->setSubject("Reporte Excel Consultas")
               ->setDescription("Reporte Excel Consultas")
               ->setKeywords("Reporte Excel Consultas")
               ->setCategory("Reporte Excel Consultas");

   
    $titulogleads   = "G-Leads";
    $tituloReporte4 = $titulogleads." es parte de la familia de servicios de TGA";
    $tituloReporte5 = "(562) 2233 4658)";
    $tituloReporte6 = "Alfredo Barros Errazuriz 1900, OF 204";
    $tituloReporte7 = "Providencia | Santiago";
    $tituloReporte8 = "Chile";

    $titulosColumnas = array(
'idConsultas',
'idInmobiliaria',
'Inmobiliaria',
'FechaConsulta',
'Proyecto',
'Cliente',
'email',
'fono',
'rut',
'donde',
'estado',
'mensaje'
);
    
$objPHPExcel->setActiveSheetIndex(0)

->setCellValue('F4',  $tituloReporte4)
->setCellValue('F5',  $tituloReporte5)
->setCellValue('F6',  $tituloReporte6)
->setCellValue('F7',  $tituloReporte7)
->setCellValue('F8',  $tituloReporte8)
->setCellValue('A13',  $titulosColumnas[0])
->setCellValue('B13',  $titulosColumnas[1])
->setCellValue('C13',  $titulosColumnas[2])
->setCellValue('D13',  $titulosColumnas[3])
->setCellValue('E13',  $titulosColumnas[4])
->setCellValue('F13',  $titulosColumnas[5])
->setCellValue('G13',  $titulosColumnas[6]) 
->setCellValue('H13',  $titulosColumnas[7])    
->setCellValue('I13',  $titulosColumnas[8])  
->setCellValue('J13',  $titulosColumnas[9])  
->setCellValue('K13',  $titulosColumnas[10])                   
->setCellValue('L13',  $titulosColumnas[11]);
           
    
    //Se agregan los datos al reporte
    $i = 14;

    foreach ($resultado->result() as $row)
{

     $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$i,  $row->idConsultas)
        ->setCellValue('B'.$i,  $row->idInmobiliaria)
        ->setCellValue('C'.$i,  $row->Inmobiliaria)
        ->setCellValue('D'.$i,  $row->FechaConsulta)
        ->setCellValue('E'.$i,  $row->Proyecto)
        ->setCellValue('F'.$i,  $row->Cliente)
        ->setCellValue('G'.$i,  $row->email)
        ->setCellValue('H'.$i,  $row->fono)
        ->setCellValue('I'.$i,  $row->rut)
        ->setCellValue('J'.$i,  $row->donde)
        ->setCellValue('K'.$i,  $row->estado)
        ->setCellValue('L'.$i,  $row->mensaje);
     $i++;   
}
$inmobiliaria=$row->Inmobiliaria;

  $estiloTituloReporte = array(
          'font' => array(
            'name'      => 'Verdana',
              'bold'      => true,
              'italic'    => false,
                'strike'    => false,
                'size'      => 11,
              'color'     => array(
              'rgb'       => '000000'
                  )
            ),
          'fill' => array(
        'type'  => PHPExcel_Style_Fill::FILL_SOLID,
       'color' => array('rgb' => 'FFFFFF')
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
        ),
          'alignment' =>  array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
          'rotation'   => 0,
          'wrap'          => TRUE
          ),
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
        );


        $estiloTitulogleads = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => true,                          
                'color'     => array(
                    'rgb' => '990000'
                )
        ));

          $titulogleadsNegritas = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => true,                          
                'color'     => array(
                    'rgb' => '000000'
                ),
                'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation'   => 0,
                'wrap'          => TRUE
                )
        ));

          $titulogleads = array(
            'font' => array(
                'name'      => 'Calibri',  
                 'bold'      => false,                                  
                'color'     => array(
                    'rgb' => '000000'
                ),
                'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation'   => 0,
                'wrap'          => TRUE
                )
        ));

        $todoContenido = array(
            'font' => array(
                'name'      => 'Calibri',  
                 'bold'      => false,                                  
                'color'     => array(
                    'rgb' => '000000'
                )
    ),   
              'borders' => array(
              'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
  )
        ));
      

    $objPHPExcel->getActiveSheet()
    ->getStyle('A1:L12')->applyFromArray($estiloTituloReporte);
    $objPHPExcel->getActiveSheet()
    ->getStyle('A13:L13')->applyFromArray($estiloTituloColumnas);  
    $objPHPExcel->getActiveSheet()
    ->getStyle('F5:F8')->applyFromArray($titulogleads);  
      $objPHPExcel->getActiveSheet()
    ->getStyle('F4')->applyFromArray($titulogleadsNegritas);    

     $objPHPExcel->getActiveSheet()
    ->getStyle('A14:L'.--$i.'')->applyFromArray($todoContenido);   


//imagen

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('imgNotice');
$objDrawing->setDescription('Noticia');
$img = 'img/G-Leads.png'; // Provide path to your logo file
$objDrawing->setPath($img);
$objDrawing->setCoordinates('C3');
$objDrawing->setHeight(55); // logo height
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        
    for($i = 'A'; $i <= 'N'; $i++){
      $objPHPExcel->setActiveSheetIndex(0)      
        ->getColumnDimension($i)->setAutoSize(TRUE);
    }
    
    $objPHPExcel->getActiveSheet()->setTitle('Consultas');
    $objPHPExcel->setActiveSheetIndex(0);

  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="consultas'.$inmobiliaria.'_'.$fInicio.'_'.$fFinal.'.xls"');
  header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
    
  }else{
    print_r('No hay resultados para mostrar');
  }
}

function descargaGestionesCot($idInmo,$idProy,$fInicio,$fFinal){

date_default_timezone_set('America/Santiago');

$hoy = date("Y-m-d");   

$CI =& get_instance();
$CI->load->model('Model_welcome');
$resultado = $CI->Model_welcome->getGestCot($idInmo,$idProy,$fInicio,$fFinal);


  if($resultado->num_rows() > 0 ){

    require_once 'lib/PHPExcel/PHPExcel.php';

    $objPHPExcel = new PHPExcel();

    $objPHPExcel->getProperties()->setCreator("TGA") //Autor
               ->setLastModifiedBy("TGA") //Ultimo usuario que lo modificó
               ->setTitle("Reporte Excel Gestiones Cot")
               ->setSubject("Reporte Excel Gestiones Cot")
               ->setDescription("Reporte Excel Gestiones Cot")
               ->setKeywords("Reporte Excel Gestiones Cot")
               ->setCategory("Reporte Excel Gestiones Cot");

   
    $titulogleads   = "G-Leads";
    $tituloReporte4 = $titulogleads." es parte de la familia de servicios de TGA";
    $tituloReporte5 = "(562) 2233 4658)";
    $tituloReporte6 = "Alfredo Barros Errazuriz 1900, OF 204";
    $tituloReporte7 = "Providencia | Santiago";
    $tituloReporte8 = "Chile";

    $titulosColumnas = array(
'idGestionProMaster',
'idCategorizar',
'Inmobiliaria',
'Ejecutivo',
'FechaGestion',
'fechacotizacion',
'Dif',
'tipo',
'TipoDeAccion',
'opcion',
'email',
'Cliente',
'rut',
'fono',
'idProyectos',
'Proyecto',
'portal',
'dondeviene',
'comentario'
);
    
$objPHPExcel->setActiveSheetIndex(0)

->setCellValue('F4',  $tituloReporte4)
->setCellValue('F5',  $tituloReporte5)
->setCellValue('F6',  $tituloReporte6)
->setCellValue('F7',  $tituloReporte7)
->setCellValue('F8',  $tituloReporte8)
->setCellValue('A13',  $titulosColumnas[0])
->setCellValue('B13',  $titulosColumnas[1])
->setCellValue('C13',  $titulosColumnas[2])
->setCellValue('D13',  $titulosColumnas[3])
->setCellValue('E13',  $titulosColumnas[4])
->setCellValue('F13',  $titulosColumnas[5])
->setCellValue('G13',  $titulosColumnas[6]) 
->setCellValue('H13',  $titulosColumnas[7])    
->setCellValue('I13',  $titulosColumnas[8])  
->setCellValue('J13',  $titulosColumnas[9])  
->setCellValue('K13',  $titulosColumnas[10])
->setCellValue('L13',  $titulosColumnas[11])  
->setCellValue('M13',  $titulosColumnas[12])  
->setCellValue('N13',  $titulosColumnas[13])  
->setCellValue('O13',  $titulosColumnas[14])  
->setCellValue('P13',  $titulosColumnas[15])  
->setCellValue('Q13',  $titulosColumnas[16])  
->setCellValue('R13',  $titulosColumnas[17])                  
->setCellValue('S13',  $titulosColumnas[18]);
           
    
    //Se agregan los datos al reporte
    $i = 14;

    foreach ($resultado->result() as $row)
{

     $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$i,  $row->idGestionProMaster)
        ->setCellValue('B'.$i,  $row->idCategorizar)
        ->setCellValue('C'.$i,  $row->Inmobiliaria)
        ->setCellValue('D'.$i,  $row->Ejecutivo)
        ->setCellValue('E'.$i,  $row->FechaGestion)
        ->setCellValue('F'.$i,  $row->fechacotizacion)
        ->setCellValue('G'.$i,  $row->Dif)
        ->setCellValue('H'.$i,  $row->tipo)
        ->setCellValue('I'.$i,  $row->TipoDeAccion)
        ->setCellValue('J'.$i,  $row->opcion)
        ->setCellValue('K'.$i,  $row->email)
        ->setCellValue('L'.$i,  utf8_decode($row->Cliente))
        ->setCellValue('M'.$i,  $row->rut)
        ->setCellValue('N'.$i,  $row->fono)
        ->setCellValue('O'.$i,  $row->idProyectos)
        ->setCellValue('P'.$i,  $row->Proyecto)
        ->setCellValue('Q'.$i,  $row->portal)
        ->setCellValue('R'.$i,  $row->dondeviene)
        ->setCellValue('S'.$i,  $row->comentario);
     $i++;   
}
$inmobiliaria=$row->Inmobiliaria;

  $estiloTituloReporte = array(
          'font' => array(
            'name'      => 'Verdana',
              'bold'      => true,
              'italic'    => false,
                'strike'    => false,
                'size'      => 11,
              'color'     => array(
              'rgb'       => '000000'
                  )
            ),
          'fill' => array(
        'type'  => PHPExcel_Style_Fill::FILL_SOLID,
       'color' => array('rgb' => 'FFFFFF')
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
        ),
          'alignment' =>  array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
          'rotation'   => 0,
          'wrap'          => TRUE
          ),
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
        );


        $estiloTitulogleads = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => true,                          
                'color'     => array(
                    'rgb' => '990000'
                )
        ));

          $titulogleadsNegritas = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => true,                          
                'color'     => array(
                    'rgb' => '000000'
                ),
                'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation'   => 0,
                'wrap'          => TRUE
                )
        ));

          $titulogleads = array(
            'font' => array(
                'name'      => 'Calibri',  
                 'bold'      => false,                                  
                'color'     => array(
                    'rgb' => '000000'
                ),
                'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation'   => 0,
                'wrap'          => TRUE
                )
        ));

        $todoContenido = array(
            'font' => array(
                'name'      => 'Calibri',  
                 'bold'      => false,                                  
                'color'     => array(
                    'rgb' => '000000'
                )
    ),   
              'borders' => array(
              'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
  )
        ));
      

    $objPHPExcel->getActiveSheet()
    ->getStyle('A1:S12')->applyFromArray($estiloTituloReporte);
    $objPHPExcel->getActiveSheet()
    ->getStyle('A13:S13')->applyFromArray($estiloTituloColumnas);  
    $objPHPExcel->getActiveSheet()
    ->getStyle('F5:F8')->applyFromArray($titulogleads);  
      $objPHPExcel->getActiveSheet()
    ->getStyle('F4')->applyFromArray($titulogleadsNegritas);    

     $objPHPExcel->getActiveSheet()
    ->getStyle('A14:S'.--$i.'')->applyFromArray($todoContenido);   


//imagen

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('imgNotice');
$objDrawing->setDescription('Noticia');
$img = 'img/G-Leads.png'; // Provide path to your logo file
$objDrawing->setPath($img);
$objDrawing->setCoordinates('C3');
$objDrawing->setHeight(55); // logo height
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        
    for($i = 'A'; $i <= 'S'; $i++){
      $objPHPExcel->setActiveSheetIndex(0)      
        ->getColumnDimension($i)->setAutoSize(TRUE);
    }
    
    $objPHPExcel->getActiveSheet()->setTitle('Gestiones Cot');
    $objPHPExcel->setActiveSheetIndex(0);

  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="gestionesCot_'.$inmobiliaria.'_'.$fInicio.'_'.$fFinal.'.xls"');
  header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
    
  }else{
    print_r('No hay resultados para mostrar');
  }
}


function descargaGestionesCat($idInmo,$idProy,$fInicio,$fFinal){

date_default_timezone_set('America/Santiago');

$hoy = date("Y-m-d");   

$CI =& get_instance();
$CI->load->model('Model_welcome');
$resultado = $CI->Model_welcome->getGestCat($idInmo,$idProy,$fInicio,$fFinal);


  if($resultado->num_rows() > 0 ){

    require_once 'lib/PHPExcel/PHPExcel.php';

    $objPHPExcel = new PHPExcel();

    $objPHPExcel->getProperties()->setCreator("TGA") //Autor
               ->setLastModifiedBy("TGA") //Ultimo usuario que lo modificó
               ->setTitle("Reporte Excel Gestiones Cat")
               ->setSubject("Reporte Excel Gestiones Cat")
               ->setDescription("Reporte Excel Gestiones Cat")
               ->setKeywords("Reporte Excel Gestiones Cat")
               ->setCategory("Reporte Excel Gestiones Cat");

   
    $titulogleads   = "G-Leads";
    $tituloReporte4 = $titulogleads." es parte de la familia de servicios de TGA";
    $tituloReporte5 = "(562) 2233 4658)";
    $tituloReporte6 = "Alfredo Barros Errazuriz 1900, OF 204";
    $tituloReporte7 = "Providencia | Santiago";
    $tituloReporte8 = "Chile";

    $titulosColumnas = array(
'idGestionProMaster',
'idRespuesta',
'Inmobiliaria',
'tipo',
'Ejecutivo',
'TipoDeAccion',
'idOpcion',
'opcion',
'email',
'Cliente',
'rut',
'FechaGestion',
'Fechapuntos',
'Dif',
'Intervalo',
'Proyecto',
'donde',
'principal',
'portal',
'dondeviene',
'Consulta',
'programa',
'comentario'
);
    
$objPHPExcel->setActiveSheetIndex(0)

->setCellValue('F4',  $tituloReporte4)
->setCellValue('F5',  $tituloReporte5)
->setCellValue('F6',  $tituloReporte6)
->setCellValue('F7',  $tituloReporte7)
->setCellValue('F8',  $tituloReporte8)
->setCellValue('A13',  $titulosColumnas[0])
->setCellValue('B13',  $titulosColumnas[1])
->setCellValue('C13',  $titulosColumnas[2])
->setCellValue('D13',  $titulosColumnas[3])
->setCellValue('E13',  $titulosColumnas[4])
->setCellValue('F13',  $titulosColumnas[5])
->setCellValue('G13',  $titulosColumnas[6]) 
->setCellValue('H13',  $titulosColumnas[7])    
->setCellValue('I13',  $titulosColumnas[8])  
->setCellValue('J13',  $titulosColumnas[9])  
->setCellValue('K13',  $titulosColumnas[10])
->setCellValue('L13',  $titulosColumnas[11])  
->setCellValue('M13',  $titulosColumnas[12])  
->setCellValue('N13',  $titulosColumnas[13])  
->setCellValue('O13',  $titulosColumnas[14])  
->setCellValue('P13',  $titulosColumnas[15])  
->setCellValue('Q13',  $titulosColumnas[16])  
->setCellValue('R13',  $titulosColumnas[17])  
->setCellValue('S13',  $titulosColumnas[18])  
->setCellValue('T13',  $titulosColumnas[19])  
->setCellValue('U13',  $titulosColumnas[20]) 
->setCellValue('V13',  $titulosColumnas[21])                  
->setCellValue('W13',  $titulosColumnas[22]);
           
    
    //Se agregan los datos al reporte
    $i = 14;

    foreach ($resultado->result() as $row)
{

     $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$i,  $row->idGestionProMaster)
        ->setCellValue('B'.$i,  $row->idRepuesta)
        ->setCellValue('C'.$i,  $row->Inmobiliaria)
        ->setCellValue('D'.$i,  $row->tipo)
        ->setCellValue('E'.$i,  $row->Ejecutivo)
        ->setCellValue('F'.$i,  $row->TipoDeAccion)
        ->setCellValue('G'.$i,  $row->idOpcion)
        ->setCellValue('H'.$i,  $row->opcion)
        ->setCellValue('I'.$i,  $row->email)
        ->setCellValue('J'.$i,  $row->Cliente)
        ->setCellValue('K'.$i,  $row->rut)
        ->setCellValue('L'.$i,  $row->FechaGestion)
        ->setCellValue('M'.$i,  $row->fechapuntos)
        ->setCellValue('N'.$i,  $row->Dif)
        ->setCellValue('O'.$i,  $row->Intervalo)
        ->setCellValue('P'.$i,  $row->Proyecto)
        ->setCellValue('Q'.$i,  $row->donde)
        ->setCellValue('R'.$i,  $row->principal)
        ->setCellValue('S'.$i,  $row->portal)
        ->setCellValue('T'.$i,  $row->dondeviene)
        ->setCellValue('U'.$i,  $row->Consulta)
        ->setCellValue('V'.$i,  $row->programa)
        ->setCellValue('W'.$i,  $row->comentario);
     $i++;   
}
$inmobiliaria=$row->Inmobiliaria;

  $estiloTituloReporte = array(
          'font' => array(
            'name'      => 'Verdana',
              'bold'      => true,
              'italic'    => false,
                'strike'    => false,
                'size'      => 11,
              'color'     => array(
              'rgb'       => '000000'
                  )
            ),
          'fill' => array(
        'type'  => PHPExcel_Style_Fill::FILL_SOLID,
       'color' => array('rgb' => 'FFFFFF')
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
        ),
          'alignment' =>  array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
          'rotation'   => 0,
          'wrap'          => TRUE
          ),
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
        );


        $estiloTitulogleads = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => true,                          
                'color'     => array(
                    'rgb' => '990000'
                )
        ));

          $titulogleadsNegritas = array(
            'font' => array(
                'name'      => 'Calibri',
                'bold'      => true,                          
                'color'     => array(
                    'rgb' => '000000'
                ),
                'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation'   => 0,
                'wrap'          => TRUE
                )
        ));

          $titulogleads = array(
            'font' => array(
                'name'      => 'Calibri',  
                 'bold'      => false,                                  
                'color'     => array(
                    'rgb' => '000000'
                ),
                'alignment' =>  array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation'   => 0,
                'wrap'          => TRUE
                )
        ));

        $todoContenido = array(
            'font' => array(
                'name'      => 'Calibri',  
                 'bold'      => false,                                  
                'color'     => array(
                    'rgb' => '000000'
                )
    ),   
              'borders' => array(
              'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
  )
        ));
      

    $objPHPExcel->getActiveSheet()
    ->getStyle('A1:W12')->applyFromArray($estiloTituloReporte);
    $objPHPExcel->getActiveSheet()
    ->getStyle('A13:W13')->applyFromArray($estiloTituloColumnas);  
    $objPHPExcel->getActiveSheet()
    ->getStyle('F5:F8')->applyFromArray($titulogleads);  
      $objPHPExcel->getActiveSheet()
    ->getStyle('F4')->applyFromArray($titulogleadsNegritas);    

     $objPHPExcel->getActiveSheet()
    ->getStyle('A14:W'.--$i.'')->applyFromArray($todoContenido);   


//imagen

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('imgNotice');
$objDrawing->setDescription('Noticia');
$img = 'img/G-Leads.png'; // Provide path to your logo file
$objDrawing->setPath($img);
$objDrawing->setCoordinates('C3');
$objDrawing->setHeight(55); // logo height
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        
    for($i = 'A'; $i <= 'W'; $i++){
      $objPHPExcel->setActiveSheetIndex(0)      
        ->getColumnDimension($i)->setAutoSize(TRUE);
    }
    
    $objPHPExcel->getActiveSheet()->setTitle('Gestiones Cat');
    $objPHPExcel->setActiveSheetIndex(0);

  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="gestionesCat_'.$inmobiliaria.'_'.$fInicio.'_'.$fFinal.'.xls"');
  header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
    
  }else{
    print_r('No hay resultados para mostrar');
  }
}





?>
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

    $tituloReporte = "Reporte Global";
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
->setCellValue('H3',  $titulosColumnas[7])    
->setCellValue('I3',  $titulosColumnas[8])                
->setCellValue('J3',  $titulosColumnas[9]);
           
    
    //Se agregan los datos al reporte
    $i = 4;

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
     
    $objPHPExcel->getActiveSheet()
    ->getStyle('A1:D1')->applyFromArray($estiloTituloReporte);
    $objPHPExcel->getActiveSheet()
    ->getStyle('A3:AM3')->applyFromArray($estiloTituloColumnas);    


        
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

    // We'll be outputting an excel file 
 //   header('Content-type: application/vnd.ms-excel'); // It will be called file.xls 
   // header('Content-Disposition: attachment; filename="file.xls"'); // Write file to the browser 

  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="Reporte_GLOBAL('.$hoy.').xls"');
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

?>
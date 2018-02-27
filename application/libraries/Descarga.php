<?php
require_once 'lib/PHPExcel/PHPExcel.php';
date_default_timezone_set('America/Santiago');


class Descarga{

public $tituloReporte4 = "G-Leads es parte de la familia de servicios de TGA";
public $tituloReporte5 = "(562) 2233 4658)";
public $tituloReporte6 = "Alfredo Barros Errazuriz 1900, OF 204";
public $tituloReporte7 = "Providencia | Santiago";
public $tituloReporte8 = "Chile";

public $img = 'img/G-Leads.png';

public $hoy;

public $objDrawing;
public $objPHPExcel;
public $CI;

   function __construct() { 

          $this->hoy= date("Y-m-d"); 
          $this->objPHPExcel = new PHPExcel();
          $this->objDrawing = new PHPExcel_Worksheet_Drawing();
          $this->objDrawing->setName('imgNotice');
          $this->objDrawing->setDescription('Noticia');
          $this->objDrawing->setPath($this->img);
          $this->objDrawing->setCoordinates('C3');
          $this->objDrawing->setHeight(55);
          $this->objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());


    $this->objPHPExcel->getProperties()->setCreator("TGA") //Autor
           ->setLastModifiedBy("TGA") //Ultimo usuario que lo modificó
           ->setTitle("Reporte Excel Consultas")
           ->setSubject("Reporte Excel Consultas")
           ->setDescription("Reporte Excel Consultas")
           ->setKeywords("Reporte Excel Consultas")
           ->setCategory("Reporte Excel Consultas");

           $this->CI =& get_instance();
           $this->CI->load->model('Model_welcome');
   }


function descargaConsultas($idInmo,$idProy,$fInicio,$fFinal){


$resultado = $this->CI->Model_welcome->getConsultas($idInmo,$idProy,$fInicio,$fFinal);


  if($resultado->num_rows() > 0 ){

$titulosColumnas = array('idConsultas','idInmobiliaria','Inmobiliaria','FechaConsulta','Proyecto','Cliente','email','fono','rut','donde','estado','mensaje');
    
$this->objPHPExcel->setActiveSheetIndex(0)

->setCellValue('F4',  $this->tituloReporte4)
->setCellValue('F5',  $this->tituloReporte5)
->setCellValue('F6',  $this->tituloReporte6)
->setCellValue('F7',  $this->tituloReporte7)
->setCellValue('F8',  $this->tituloReporte8)
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

     $this->objPHPExcel->setActiveSheetIndex(0)
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

require "estilosDescarga.php";

$this->objPHPExcel->getActiveSheet()->getStyle('A1:L12')->applyFromArray($estiloTituloReporte);
$this->objPHPExcel->getActiveSheet()->getStyle('A13:L13')->applyFromArray($estiloTituloColumnas);
$this->objPHPExcel->getActiveSheet()->getStyle('A14:L'.--$i.'')->applyFromArray($todoContenido);


    for($i = 'A'; $i <= 'L'; $i++){
      $this->objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
    }
    
    $this->objPHPExcel->getActiveSheet()->setTitle('Consultas');

  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="consultas_'.$inmobiliaria.'_'.$fInicio.'_'.$fFinal.'.xls"');
  header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
    
  }else{
    print_r('No hay resultados para mostrar');
  }
}


function descargaCategorizados($idInmo,$idProy,$fInicio,$fFinal){


$resultado = $this->CI->Model_welcome->getCatModelFull($idInmo,$idProy,$fInicio,$fFinal);


  if($resultado->num_rows() > 0 ){

    $titulosColumnas = array('idRepuesta','Inmobiliaria','Proyecto','FechaPuntos','Intervalo','Cliente','Correo','rut','donde','Mejor');
    
$this->objPHPExcel->setActiveSheetIndex(0)
->setCellValue('F4',  $this->tituloReporte4)
->setCellValue('F5',  $this->tituloReporte5)
->setCellValue('F6',  $this->tituloReporte6)
->setCellValue('F7',  $this->tituloReporte7)
->setCellValue('F8',  $this->tituloReporte8)
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

     $this->objPHPExcel->setActiveSheetIndex(0)
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

require "estilosDescarga.php";

$this->objPHPExcel->getActiveSheet()->getStyle('A1:J12')->applyFromArray($estiloTituloReporte);
$this->objPHPExcel->getActiveSheet()->getStyle('A13:J13')->applyFromArray($estiloTituloColumnas);
$this->objPHPExcel->getActiveSheet()->getStyle('A14:J'.--$i.'')->applyFromArray($todoContenido);



    for($i = 'A'; $i <= 'J'; $i++){
      $this->objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
    }
    
    $this->objPHPExcel->getActiveSheet()->setTitle('Categorizados');

  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="categorizados_'.$inmobiliaria.'_'.$fInicio.'_'.$fFinal.'.xls"');
  header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
    
  }else{
    print_r('No hay resultados para mostrar');
  }
}







    
   
	} 


?>
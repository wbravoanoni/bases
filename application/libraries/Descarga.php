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

public $objDrawing;

function descargaConsultas($idInmo,$idProy,$fInicio,$fFinal){

$this->objDrawing = new PHPExcel_Worksheet_Drawing();
$this->objDrawing->setName('imgNotice');
$this->objDrawing->setDescription('Noticia');

$this->objDrawing->setPath($this->img);
$this->objDrawing->setCoordinates('C3');
$this->objDrawing->setHeight(55); // logo height


date_default_timezone_set('America/Santiago');

$hoy = date("Y-m-d");   

$CI =& get_instance();
$CI->load->model('Model_welcome');
$resultado = $CI->Model_welcome->getConsultas($idInmo,$idProy,$fInicio,$fFinal);


  if($resultado->num_rows() > 0 ){


    $objPHPExcel = new PHPExcel();

    $objPHPExcel->getProperties()->setCreator("TGA") //Autor
               ->setLastModifiedBy("TGA") //Ultimo usuario que lo modificó
               ->setTitle("Reporte Excel Consultas")
               ->setSubject("Reporte Excel Consultas")
               ->setDescription("Reporte Excel Consultas")
               ->setKeywords("Reporte Excel Consultas")
               ->setCategory("Reporte Excel Consultas");

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

require("estilosDescarga");

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

$this->objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        
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


    
   
	} 


?>
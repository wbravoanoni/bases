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


    $this->objPHPExcel->getProperties()->setCreator("G-Leads") //Autor
           ->setLastModifiedBy("G-Leads") //Ultimo usuario que lo modificó
           ->setTitle("Reporte Excel G-Leads")
           ->setSubject("Reporte Excel G-Leads")
           ->setDescription("Reporte Excel G-Leads")
           ->setKeywords("Reporte Excel G-Leads")
           ->setCategory("Reporte Excel G-Leads");

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


function descargaCotizaciones($idInmo,$idProy,$fInicio,$fFinal){


$resultado = $this->CI->Model_welcome->getCot($idInmo,$idProy,$fInicio,$fFinal);


  if($resultado->num_rows() > 0 ){

$titulosColumnas = array('idCategorizar','Inmobiliaria','idProyecto','Proyecto','FechaCotizacion','Cliente','rut','email','fono','idPortal','portal','dondeviene','programa','comentario');
    
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
->setCellValue('L13',  $titulosColumnas[11])    
->setCellValue('M13',  $titulosColumnas[12])              
->setCellValue('N13',  $titulosColumnas[13]);
           
    
    //Se agregan los datos al reporte
    $i = 14;

    foreach ($resultado->result() as $row)
{

     $this->objPHPExcel->setActiveSheetIndex(0)
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

require "estilosDescarga.php";

$this->objPHPExcel->getActiveSheet()->getStyle('A1:N12')->applyFromArray($estiloTituloReporte);
$this->objPHPExcel->getActiveSheet()->getStyle('A13:N13')->applyFromArray($estiloTituloColumnas);
$this->objPHPExcel->getActiveSheet()->getStyle('A14:N'.--$i.'')->applyFromArray($todoContenido);



    for($i = 'A'; $i <= 'N'; $i++){
      $this->objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
    }
    
    $this->objPHPExcel->getActiveSheet()->setTitle('Cotizaciones');

  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="cotizaciones_'.$inmobiliaria.'_'.$fInicio.'_'.$fFinal.'.xls"');
  header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
    
  }else{
    print_r('No hay resultados para mostrar');
  }
}


function descargaPromesas($idInmo,$idProy,$fInicio,$fFinal){


$resultado = $this->CI->Model_welcome->getPromesas($idInmo,$idProy,$fInicio,$fFinal);


  if($resultado->num_rows() > 0 ){

$titulosColumnas = array('idPromesaIn','idInmobiliaria','idUser','ejecutivo','email',
'nombre','rut','fechaPromesa','fechaGuardado','idProyecto','nombreP','programa','donde');
    
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
->setCellValue('L13',  $titulosColumnas[11])               
->setCellValue('M13',  $titulosColumnas[12]);
           
    
    //Se agregan los datos al reporte
    $i = 14;

    foreach ($resultado->result() as $row)
{

     $this->objPHPExcel->setActiveSheetIndex(0)
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

require "estilosDescarga.php";

$this->objPHPExcel->getActiveSheet()->getStyle('A1:M12')->applyFromArray($estiloTituloReporte);
$this->objPHPExcel->getActiveSheet()->getStyle('A13:M13')->applyFromArray($estiloTituloColumnas);
$this->objPHPExcel->getActiveSheet()->getStyle('A14:M'.--$i.'')->applyFromArray($todoContenido);



    for($i = 'A'; $i <= 'M'; $i++){
      $this->objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
    }
    
    $this->objPHPExcel->getActiveSheet()->setTitle('Promesas');

  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="promesas_'.$inmobiliaria.'_'.$fInicio.'_'.$fFinal.'.xls"');
  header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
    
  }else{
    print_r('No hay resultados para mostrar');
  }
}


function descargaGestionesCat($idInmo,$idProy,$fInicio,$fFinal){


$resultado = $this->CI->Model_welcome->getGestCat($idInmo,$idProy,$fInicio,$fFinal);


  if($resultado->num_rows() > 0 ){

$titulosColumnas = array('idGestionProMaster','idRespuesta','Inmobiliaria','tipo',
'Ejecutivo','TipoDeAccion','idOpcion','opcion','email','Cliente','rut','FechaGestion',
'Fechapuntos','Dif','Intervalo','Proyecto','donde','principal','portal','dondeviene',
'Consulta','programa','comentario');

 
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

     $this->objPHPExcel->setActiveSheetIndex(0)
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

require "estilosDescarga.php";

$this->objPHPExcel->getActiveSheet()->getStyle('A1:W12')->applyFromArray($estiloTituloReporte);
$this->objPHPExcel->getActiveSheet()->getStyle('A13:W13')->applyFromArray($estiloTituloColumnas);
$this->objPHPExcel->getActiveSheet()->getStyle('A14:W'.--$i.'')->applyFromArray($todoContenido);



    for($i = 'A'; $i <= 'W'; $i++){
      $this->objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
    }
    
    $this->objPHPExcel->getActiveSheet()->setTitle('Gestiones Cat');

  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="gestionesCat_'.$inmobiliaria.'_'.$fInicio.'_'.$fFinal.'.xls"');
  header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
    
  }else{
    print_r('No hay resultados para mostrar');
  }
}


function descargaGestionesCot($idInmo,$idProy,$fInicio,$fFinal){


$resultado = $this->CI->Model_welcome->getGestCot($idInmo,$idProy,$fInicio,$fFinal);


  if($resultado->num_rows() > 0 ){

$titulosColumnas = array('idGestionProMaster','idCategorizar','Inmobiliaria',
'Ejecutivo','FechaGestion','fechacotizacion','Dif','tipo','TipoDeAccion',
'opcion','email','Cliente','rut','fono','idProyectos','Proyecto','portal',
'dondeviene','comentario');

 
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

     $this->objPHPExcel->setActiveSheetIndex(0)
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

require "estilosDescarga.php";

$this->objPHPExcel->getActiveSheet()->getStyle('A1:S12')->applyFromArray($estiloTituloReporte);
$this->objPHPExcel->getActiveSheet()->getStyle('A13:S13')->applyFromArray($estiloTituloColumnas);
$this->objPHPExcel->getActiveSheet()->getStyle('A14:S'.--$i.'')->applyFromArray($todoContenido);



    for($i = 'A'; $i <= 'S'; $i++){
      $this->objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
    }
    
    $this->objPHPExcel->getActiveSheet()->setTitle('Gestiones Cot');

  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="gestionesCot_'.$inmobiliaria.'_'.$fInicio.'_'.$fFinal.'.xls"');
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
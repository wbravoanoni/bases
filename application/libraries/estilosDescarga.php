<?php
 $estiloTituloReporte = array(
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

$this->objPHPExcel->getActiveSheet()->getStyle('F5:F8')->applyFromArray($titulogleads);
$this->objPHPExcel->getActiveSheet()->getStyle('F4')->applyFromArray($titulogleadsNegritas);
 
?>
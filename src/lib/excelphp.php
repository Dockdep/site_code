<?php


class excelphp
{
    /**
     *
     * @return array
     */

    function getData($ar_data,$filename)
    {

        error_reporting(E_ALL);

// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
// Set properties
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
// Add some data
        $objPHPExcel->setActiveSheetIndex(0); // устанавливаем номер рабочего документа
        $aSheet = $objPHPExcel->getActiveSheet(); // получаем объект рабочего документа
        $writer_i=1;
        foreach($ar_data as $ar){ // читаем массив
            $j=0;
            foreach($ar as $val){
                $aSheet->setCellValueByColumnAndRow($j,$writer_i,$val); // записываем данные массива в ячейку
                $j++;
            }
            $writer_i++;
        }
        $objPHPExcel->getActiveSheet()->setTitle('Home');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
// Save Excel 2007 file
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save(STORAGE_PATH.'temp/'.$filename);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        // читаем файл и отправляем его пользователю
        readfile(STORAGE_PATH.'temp/'.$filename);
        unlink(STORAGE_PATH.'temp/'.$filename);
        exit;

    }

    function getErrors()
    {
        return $this->_errors;
    }
}
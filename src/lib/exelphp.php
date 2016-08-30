<?php


class exelphp
{

    protected $_object, $_reader, $_sheets, $_supplier, $_fields, $file, $maxRows, $name;
    private $_errors = array();
    const CHUNK_SIZE = 5000;
    /**
     * Переменные статистики
     */

    /**
     * @var fvMemCache
     */
    protected $messenger;
    protected $rate;
    protected $result;

    public    $total,    /* Всего рядов в таблице */
        $good = 0,     /*уже есть, обновляем*/
        $bad = 0,      /*еще нет, создали, сохранили*/
        $ugly = 0;    /*ошибка сохранения */

    /**
     * @param $file - Эксель-файл
     * @param $supplierId - ИД поставщика
     * @param $maxRows
     * @param $id
     */


    function __construct()
    {

        $this->_reader = PHPExcel_IOFactory::createReader(PHPExcel_IOFactory::identify('exeldb.xlsx'));
        if (method_exists($this->_reader, "setReadDataOnly"))
            $this->_reader->setReadDataOnly(true);
        $this->file = 'exeldb.xlsx';
        $this->name = $this->file;


    }


    /**
     *
     * @return array
     */

    function getRows()
    {
        $this->_object = $this->_reader->load($this->file);

        foreach ($this->_object->getSheetNames() as $index => $sheetName)
            $this->_sheets[$index] = $sheetName;

        foreach ($this->_sheets as $idx => $sheet) {
            /**
             * @var PHPExcel_Worksheet $activeSheet
             */
            $objWorksheet = $this->_object->getSheet($idx);

            $highestRow = $objWorksheet->getHighestRow();
            $highestColumn = $objWorksheet->getHighestColumn();

            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            for ($row = 0; $row <= $highestRow; ++$row) {
                for ($col = 0; $col <= $highestColumnIndex; ++$col) {
                    $val = $objWorksheet->getCellByColumnAndRow($col, $row);
                    if(substr($val,0,1) === '=' ) {
                        $this->result[$row][$col] = ceil($val->getCalculatedValue());
                    } else {
                        $this->result[$row][$col] = $val->getValue();
                    }
                }
            }
        }

        unset($this->_object);


        return $this->result;


    }

    function getErrors()
    {
        return $this->_errors;
    }
}
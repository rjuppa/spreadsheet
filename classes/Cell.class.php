<?php


class Cell extends BaseCell
{
    private $_isFormula = FALSE;
    private $_formula;
    private $_range;

    public function __construct(Sheet $sheet, $address) {

        parent::__construct($sheet, $address);
        //$this->_range = new RangeCell($sheet, $address, $address);
    }

    public static function create(Sheet $sheet, $address){
        return new Cell($sheet, $address);
    }

    public function setFormula($formula, CellRange $range)
    {
        $this->_formula = $formula;
        $this->_range = $range;
        $this->_isFormula = TRUE;
    }

    public function unsetFormula()
    {
        $this->_formula = null;
        $this->_range = null;
        $this->_isFormula = FALSE;
    }

    public function getFormula()
    {
        return $this->_formula;
    }

    public function getRange()
    {
        return $this->_range;
    }

    //--------------- override methods
    // gets empty cell
    public function clear() {
        $this->_value = 0;
        $this->unsetFormula();
    }

    // set cell
    public function setValue($newval){
        if( is_numeric($newval) ){
            //set numeric value
            $this->_value = $newval;
            $this->unsetFormula();
        }
        else{
            //set formula  =SUM(A4:F8)
            $newval = '='.$newval;
            list($operation, $start, $end) = $this->parse_input($newval);
            $this->_formula = $operation;
            $this->_range = new RangeCell( $this->_sheet, $start, $end );
            $this->_isFormula = TRUE;
        }
    }

    // returns number
    public function getValue()
    {
        if( $this->_isFormula ){
            return $this->_range->calculate($this->_formula);
        }
        else{
            return parent::getValue();
        }
    }

    // returns string
    public function getValueFormated(){
        return number_format((float)$this->getValue(), 2, '.', '');
    }


    private function parse_input($newval){
        //                                       input =>  "=SUM(A4:F8)"
        if( $newval && $newval[0] === '='){
            $b1 = strpos($newval, '(');
            $b2 = strpos($newval, ')');
            $c = strpos($newval, ':');
            if( ($b1>0) && ($b1<$c) && ($c<$b2) ){
                $len = $b1 - 1;
                $formula = substr($newval, 1, $len);
                $len = $b2 - $b1;
                $range = substr($newval, $b1+1, $len-1);
                $arr = explode(":", $range);
                return array(strtoupper($formula), $arr[0], $arr[1]);
            }
        }
        return null;
    }

}
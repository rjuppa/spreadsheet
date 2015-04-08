<?php


class RangeCell {
    private $_topLeftCell;    //starts from 0...15
    private $_bottomRightCell;    //starts from 0...15
    protected $_sheet;

    public function __construct(Sheet $sheet, $topLeftAddress, $bottomRightAddress) {
        if( !$sheet )
            throw new Exception('Null reference argument.');

        $this->_sheet = $sheet;
        $c1 = Cell::create($this->_sheet, $topLeftAddress);
        $c2 = Cell::create($this->_sheet, $bottomRightAddress);

        if( $c1->getPosX() > $c2->getPosX() || $c1->getPosY() > $c2->getPosY() )
            throw new Exception('Invalid range addresses.');

        $this->_sheet = $sheet;
        $this->_topLeftCell = Cell::create($this->_sheet, $topLeftAddress);
        $this->_bottomRightCell = Cell::create($this->_sheet, $bottomRightAddress);
    }

    public function __toString() {
        return '[' . $this->_topLeftCell->getName() . ':' . $this->_bottomRightCell->getName() . ']';
    }

    //returns all non empty values from current range
    public function getValues() {
        $startX = $this->_topLeftCell->getPosX();
        $endX = $this->_bottomRightCell->getPosX();
        $startY = $this->_topLeftCell->getPosY();
        $endY = $this->_bottomRightCell->getPosY();
        $values = array();
        for( $y=$startY; $y<=$endY; $y++){
            for( $x=$startX; $x<=$endX; $x++){
                $value = $this->_sheet->readCellByPos($x, $y);
                if( $value !== null ){
                    array_push($values, $value);
                }
            }
        }
        return $values;
    }

    //calculate operation on current range
    public function calculate($operation) {
        $values = $this->getValues();
        $operation = strtoupper($operation);
        switch($operation){
            case "SUM": return array_sum($values);
            case "MIN": return min($values);
            case "MAX": return max($values);
        }
        throw new Exception('Invalid operation.');
    }


}
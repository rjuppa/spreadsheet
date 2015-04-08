<?php


class Sheet {
    private $_matrix;

    public function __construct() {
        $this->_matrix = array();
    }

    public function createCell($address){
        return new Cell($this, $address);
    }

    public function createRange($topLeftAddress, $bottomRightAddress){
        return new RangeCell($this, $topLeftAddress, $bottomRightAddress);
    }

    public function command($line){
        if( $line ){
            $arr = explode('=', $line);
            if( count($arr) == 2 ){

                $address = preg_replace("/[^a-zA-Z0-9]/", "", $arr[0]);
                $value = preg_replace("/[^a-zA-Z0-9(:).]/", "", $arr[1]);
                $this->setCell($address, $value);
            }
            else{
                throw new Exception('CLI input error. ('.$line.')');
            }
        }
    }

    // Set cell
    public function setCell($address, $value)
    {
        if( !$address )
            throw new Exception('Invalid cell address.');

        if( !$value )
            $value = 0;

        $cell = new Cell($this, $address);
        $cell->setValue($value);
        $x = $cell->getPosX();
        $y = $cell->getPosY();
        $this->_matrix[$x][$y] = $cell;
    }

    //get cell by position
    public function getCellByPos($pos_x, $pos_y){
        if ( isset($this->_matrix[$pos_x][$pos_y])) {
            $obj = $this->_matrix[$pos_x][$pos_y];
            if( $obj ){
                if ($obj instanceof Cell) {
                    return $obj;
                }
            }
        }
        return null;
    }

    //get cell value by position
    public function readCellByPos($pos_x, $pos_y){
        $cell = $this->getCellByPos($pos_x, $pos_y);
        if( $cell ){
            if ($cell instanceof Cell) {
                return $cell->getValue();
            }
        }
        return null;
    }

    //print cell value by position
    public function printCellByPos($pos_x, $pos_y){
        $cell = $this->getCellByPos($pos_x, $pos_y);
        if( $cell ){
            if ($cell instanceof Cell) {
                return $cell->getValueFormated();
            }
        }
        return '';
    }

    //get cell value by address
    public function readCell($address){
        $fooCell = new Cell($this, $address);
        $pos_x = $fooCell->getPosX();
        $pos_y = $fooCell->getPosY();
        return $this->readCellByPos($pos_x, $pos_y);
    }

    //print cell value by address
    public function printCell($address){
        $fooCell = new Cell($this, $address);
        $pos_x = $fooCell->getPosX();
        $pos_y = $fooCell->getPosY();
        $cell = $this->getCellByPos($pos_x, $pos_y);
        if( $cell ){
            if ($cell instanceof Cell) {
                return $cell->getValueFormated();
            }
        }
        return '';
    }


    public function renderSheet(){
        $html = '<table border="1"><td>&nbsp;</td>';
        for( $x=0; $x<8; $x++){
            $html .= '<td>&nbsp; ' . chr(65+$x). ' &nbsp;</td>';
        }


        for( $y=0; $y<10; $y++){
            $html .= '<tr>';
            $html .= '<td>&nbsp; ' . ($y+1) . ' &nbsp;</td>';
            for( $x=0; $x<8; $x++){
                $cell = $this->getCellByPos($x, $y);
                $html .= $this->renderCell($cell);
            }
            $html .= '</tr>';
        }
        $html .= '</table>';
        return $html;
    }

    private function renderCell($cell){
        if( !$cell ){
            return '<td>&nbsp; &nbsp;</td>';
        }
        else{
            return '<td>&nbsp; ' . $cell->getValueFormated() . ' &nbsp;</td>';
        }

    }


}
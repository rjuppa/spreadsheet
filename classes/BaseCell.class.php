<?php

class BaseCell {
    protected $_pos_X;    //starts from 0...7
    protected $_pos_Y;    //starts from 0...9
    protected $_coord_X;  //starts from A...H
    protected $_coord_Y;  //starts from 1...10
    protected $_value = 0;
    protected $_sheet;

    public static $POSITIONS_X = 'ABCDEFGHI';

    // create a cell('C4')
    public function __construct(Sheet $sheet, $address) {
        if( !$sheet )
            throw new Exception('Null reference argument.');

        if( !$address )
            throw new Exception('Invalid cell position.');

        $address = strtoupper($address);
        list ($x, $y) = $this->getPosition($address);
        $this->_pos_X = $x;
        $this->_pos_Y = $y;
        $this->_coord_X = strval(self::$POSITIONS_X[$x]);
        $this->_coord_Y = strval($y+1);
        $this->_sheet = $sheet;
    }

    public static function create(Sheet $sheet, $address){
        return new BaseCell($sheet, $address);
    }

    // parse coords from position string
    protected function getPosition($address)
    {
        $x = strtoupper(substr($address, 0, 1));
        $y = substr($address, 1);
        $pos_x = strpos(self::$POSITIONS_X, $x);
        $pos_y = (int)$y;
        if ( $pos_x < 0 || $pos_x > 7)  //0-7
            throw new Exception('Invalid cell position. => ' . $address);

        if ($pos_y <= 0 || $pos_y > 10) //1-10
            throw new Exception('Invalid cell position. => ' . $address);

        $pos_y = $pos_y - 1;
        return array($pos_x, $pos_y);
    }

    // print value of cell
    public function __toString(){
        return '[' . $this->_coord_X . $this->_coord_Y . ']';
//        if( $this->_value == 0 ) {
//            return '';
//        }
//        else{
//            return $this->_value;
//        }
    }

    public function getPosX(){
        return $this->_pos_X;
    }

    public function getPosY(){
        return $this->_pos_Y;
    }

    public function getName(){
        return '[' . $this->_coord_X . $this->_coord_Y . ']';
    }

    // gets empty cell
    public function clear() {
        $this->_value = 0;
    }

    public function setValue($newval){
        if( !is_numeric($newval) )
            throw new Exception('Invalid cell value.');

        $this->_value = $newval;
    }

    // returns number
    public function getValue(){
        return $this->_value;
    }

    // returns string
    public function getValueFormated(){
        return number_format((float)$this->getValue(), 2, '.', '');
    }


}
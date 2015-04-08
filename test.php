<?php
require_once(dirname(__FILE__) . '/simpletest/autorun.php');

function my_autoloader($class) {
    include 'classes/' . $class . '.class.php';
}

spl_autoload_register('my_autoloader');

class TestOfCell extends UnitTestCase {
    private $sheet;


    public function __construct() {
        $this->sheet = new Sheet();
    }


    function test_Create_Cell1() {
        $cell = $this->sheet->createCell('D3');
        $this->assertIdentical($cell->getName(), '[D3]');
    }


    function test_Create_Cell2() {
        $this->expectException(new Exception('Invalid cell position. => D31'));
        $cell = $this->sheet->createCell('D31');
    }

    function test_Create_Cell3() {
        $this->expectException(new Exception('Invalid cell position. => D0'));
        $cell = $this->sheet->createCell('D0');
    }

    function test_Create_Cell4() {
        $this->expectException(new Exception('Invalid cell position. => R3'));
        $cell = $this->sheet->createCell('R3');
    }

    function test_Create_Cell5() {
        $this->expectException(new Exception('Invalid cell position. => DD7'));
        $cell = $this->sheet->createCell('Dd7');
    }

    function test_Cell_Set_Value() {
        $cell = $this->sheet->createCell('f4');
        $cell->setValue(47);
        $this->assertIdentical($cell->getValue(), 47);
    }

    function test_Cell_Get_Value() {
        $cell = $this->sheet->createCell('f4');
        $cell->setValue(1.23);
        $this->assertIdentical($cell->getValue(), 1.23);
    }

    function test_Cell_Get_Value_Formated() {
        $cell = $this->sheet->createCell('f4');
        $cell->setValue(1.23);
        $this->assertIdentical($cell->getValueFormated(), '1.23');
    }

    function test_Cell_Get_Value_Formated2() {
        $cell = $this->sheet->createCell('f4');
        $cell->setValue(1.2);
        $this->assertIdentical($cell->getValueFormated(), '1.20');
    }

    function test_Cell_Get_Value_Formated3() {
        $cell = $this->sheet->createCell('f4');
        $cell->setValue(1);
        $this->assertIdentical($cell->getValueFormated(), '1.00');
    }

    function test_Cell_Get_Empty() {
        $cell = $this->sheet->createCell('f4');
        $cell->setValue(1.23);
        $cell->clear();
        $this->assertIdentical($cell->getValue(), 0);
    }
}

class TestOfCommands extends UnitTestCase
{
    private $sheet;

    public function __construct()
    {
        $this->sheet = new Sheet();
    }


    function test_Set_Cell1()
    {
        $this->sheet->command('c5=1.3');
        $this->assertIdentical($this->sheet->printCell('C5'), '1.30');
    }

    function test_Set_Cell2()
    {
        $this->sheet->command('c5=100');
        $this->assertIdentical($this->sheet->printCell('C5'), '100.00');
    }

    function test_Set_Cell3()
    {
        $this->sheet->command('c5=0.123');
        $this->assertIdentical($this->sheet->printCell('C5'), '0.12');
    }

    function test_Sum()
    {
        $this->sheet->command('c1=1');
        $this->sheet->command('c2=1');
        $this->sheet->command('c3=1.23');
        $this->sheet->command('c4=10');
        $this->sheet->command('c5=sum(c1:d4)');
        $this->assertIdentical($this->sheet->printCell('C5'), '13.23');
    }

    function test_Min()
    {
        $this->sheet->command('c1=1');
        $this->sheet->command('c2=1');
        $this->sheet->command('c3=1.23');
        $this->sheet->command('c4=10');
        $this->sheet->command('c5=min(c1:d4)');
        $this->assertIdentical($this->sheet->printCell('C5'), '1.00');
    }

    function test_Max()
    {
        $this->sheet->command('c1=1');
        $this->sheet->command('c2=1');
        $this->sheet->command('c3=1.23');
        $this->sheet->command('c4=10');
        $this->sheet->command('c5=max(c1:d4)');
        $this->assertIdentical($this->sheet->printCell('C5'), '10.00');
    }
}
?>
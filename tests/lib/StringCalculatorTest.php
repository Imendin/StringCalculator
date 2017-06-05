<?php

use PHPUnit\Framework\TestCase;
require '.\src\lib\StringCalculator.php';

class StringCalculatorTest extends TestCase{
    
    private $stringCalculator;

    protected function setUp()
    {
        $this->stringCalculator = new StringCalculator();
    }

    public function testAdd()
    {
        $this->assertEquals(0, $this->stringCalculator->Add(""), "Chyba scitani: 0 + 0 != 0");
        $this->assertEquals(1, $this->stringCalculator->Add("1"), "Chyba scitani: 1 + 0 != 1");
        $this->assertEquals(3, $this->stringCalculator->Add("1,2"), "Chyba scitani: 1 + 2 != 3");
    }
    public function testAddAmount()
    {
        $this->assertEquals(6, $this->stringCalculator->Add("1,2,3"), "Chyba scitani: 1 + 2 + 3 != 6");
    }
    public function testAddLine()
    {
        $this->assertEquals(6, $this->stringCalculator->Add("1,2\n3"), "Chyba scitani: 1 + 2 + 3 != 6");
        $this->assertEquals('not', $this->stringCalculator->Add("1,\n"), 'Chyba scitani: 1,\n != not');
    }
    public function testAddSep()
    {
        $this->assertEquals(6, $this->stringCalculator->Add("//;\n1;2\n3"), "Chyba scitani: 1 + 2 + 3 != 6"); 
    }
     public function testAddNegace()
    {
        $this->assertEquals("negatives not allowed ", $this->stringCalculator->Add("1,2\n-3"), "Chyba scitani: 1 + 2 + (-3) != negatives not allowed ");
        $this->assertEquals("negatives not allowed -1, -3, ", $this->stringCalculator->Add("-1,2\n-3"), "Chyba scitani: (-1) + 2 + (-3) != negatives not allowed -1, -3, "); 
    }
}
?>
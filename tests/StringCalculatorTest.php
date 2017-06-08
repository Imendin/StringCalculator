<?php

use PHPUnit\Framework\TestCase;
use Calculator\StringCalculator;

class StringCalculatorTest extends TestCase{

    protected $stringCalculator;

    protected function setUp()
    {
        $this->stringCalculator = new StringCalculator();
    }

    public function testSumNumbers()
    {
        $this->assertSum(0, "");
        $this->assertSum(1, "1");
        $this->assertSum(3, "1,2");
    }
    public function testSumNumbersAmount()
    {
        $this->assertSum(6, "1,2,3");
    }
    public function testSumNumbersLine()
    {
        $this->assertSum(6, "1,2\n3");
    }
    public function testSumNumbersSep()
    {
        $this->assertSum(6, "//;\n1;2\n3");
    }
    public function testSumNumbersLongAndMoreSepar()
    {
        $this->assertSum(6, "//[***]\n1***2\n3");
        $this->assertSum(8, "//[***][--]\n1***2\n3--2");
    }
    public function testSumNumbersBiggest1000()
    {
        $this->assertSum(6, "1,2\n3,1001");
    }
    
    public function testNegative()
    {
        $this->expectException(Exception::class);
        $this->stringCalculator->sumNumbers("1,2\n-3");
        $this->expectException(Exception::class);
        $this->stringCalculator->sumNumbers("-1,2\n-3");
    }
    public function testTwoDelimiters()
    {
        $this->expectException(Exception::class);
        $this->stringCalculator->sumNumbers("1,\n");
    }
    
    public function assertSum($need, $get){
        $this->assertSame($need, $this->stringCalculator->sumNumbers($get)); 
    }
}
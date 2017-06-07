<?php

use PHPUnit\Framework\TestCase;

class StringCalculatorTest extends TestCase{

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
        $this->assertSum('not', "1,\n");
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
    
    public function testException()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(StringCalculator::sumNumbers("1,2\n-3"));
        throw new Exception('Exception-message: ');
    }
    public function testExceptionTwo()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(StringCalculator::sumNumbers("-1,2\n-3"));
        throw new Exception('Exception-message: ');
    }
    public function assertSum($need, $get){
        $this->assertSame($need, StringCalculator::sumNumbers($get)); 
    }
}
?>
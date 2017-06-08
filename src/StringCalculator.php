<?php

namespace Calculator;

    class StringCalculator {
        public function sumNumbers(string $numbers)
        {
            $delimiter = new Delimiters();
            $validator = new Validator();

            $del = $delimiter->getDelimiters($numbers);
            if(strpos($numbers, "//") !== false){
                $numbers = substr($numbers, strpos($numbers, "\n"));
            }
            $validator->validationsTwoDelimiters($numbers, $del);

            $numbers = $delimiter->partitionNumbersToArray($numbers);
            $validator->validationsNegativeNumbers($numbers);

            $numbers = array_filter($numbers, function($num){
                return $num <= 1000;
            });

            //if can sum individually numbers then do it
            if($result = array_sum($numbers));
            return (int)$result;
        }
    }
    class Validator{
        public function validationsTwoDelimiters($setString, $delimiters)
        {
            //change all delimiters to one type and exception for two and more delimiters behind
            if(strpos(str_replace(
                array_merge($delimiters, array("\n")), ",", $setString), ",,") !== false){                   
                throw new \Exception("Two delimiters behind not allowed!");
            }
        }
        public function validationsNegativeNumbers($setString)
        {
            //load only negative numbers to variable
            $negativeNumbers = array_filter($setString, function($num){
                return $num < 0;
            });
            //if count of negative numbers is biggest than 0 send exception
            if(count($negativeNumbers) > 0){
                throw new \Exception(
                    "Negatives not allowed! " . 
                    (count($negativeNumbers) > 1 ? implode(", ", $negativeNumbers) : "")
                );
            }
        }
    }
    class Delimiters{

        private $delimiters;
        private $settingText;

        public function __construct($delimiter = array(","))
        {
            $this->delimiters = $delimiter;
        }
        public function getDelimiters(
            $setString, 
            $delimiterBracketLeft = "[", 
            $delimiterBracketRight = "]", 
            $delimiterSettingStart = "//",
            $delimeterSettingEnd = "\n"
        ) {
            if(strpos($setString,  $delimiterSettingStart)  !== false){    
                $this->delimiters = $this->loadDelimiters(
                    $setString, 
                    $delimiterBracketLeft, 
                    $delimiterBracketRight, 
                    $delimeterSettingEnd
                );
            }
            return $this->delimiters;
        }
        public function partitionNumbersToArray($setString, $delimiter = ",")
        {
            $setString = str_replace(array_merge($this->delimiters, array("\n")), $delimiter, $setString);
            return explode($delimiter, $setString);
        }
        private function loadDelimiters(
            $setString, 
            $delimiterBracketLeft = "[", 
            $delimiterBracketRight = "]", 
            $delimeterSettingEnd = "\n"
        ) {
            $setString = explode($delimeterSettingEnd, $setString); //distributions from text delimiters  
            if (strpos($setString[0], $delimiterBracketLeft) !== false){
                return $this->makeListOfDelimiters($setString[0], $delimiterBracketLeft, $delimiterBracketRight);
            }
            return array(substr($setString[0], 2, strlen($setString[0]) - 2)); //only one distributor without brackets
        }
        private function makeListOfDelimiters( 
            $setString, 
            $delimiterBracketLeft = "[", 
            $delimiterBracketRight = "]"
        ) {
            $setString = str_replace(
                array($delimiterBracketLeft, 
                $delimiterBracketRight), 
                ",", 
                $setString
            ); //change all distributors to one distributor
            $delimiters = explode(",", $setString); //distribution of distributors
            return $delimiters;
        }
    }
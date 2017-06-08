<?php

namespace Calculator;

    class StringCalculator {
        public function sumNumbers(string $numbers)
        {
            $delimiter = new Delimiters();
            $validator = new Validator();

            $delimiter->setDelimiters($numbers);
            $del = $delimiter->getDelimiters();
            $numbers = $delimiter->removeDelimitersFromText($numbers);
            $validator->validationsTwoDelimiters($numbers, $del);

            $numbers = $delimiter->partitionNumbersToArray($numbers);
            $validator->validationsNegativeNumbers($numbers);
            $numbers = $this->removeBiggerNumbers($numbers, 1000);

            //if can sum individually numbers then do it
            if($result = array_sum($numbers));
            return (int)$result;
        }
        private function removeBiggerNumbers($setString, $max)
        {
            return array_filter($setString, function($num) use ($max){
                return $num <= $max;
            });
        }
    }
    class Validator{
        public function validationsTwoDelimiters($setString, $delimiters)
        {
            //change all delimiters to one type
            $setString = str_replace(
                array_merge($delimiters, array("\n")), 
                ",", 
                $setString
            );
            //exception for two and more delimiters behind
            if(strpos($setString, ",,") !== false){                   
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
                    (count($negativeNumbers) > 1 ? 
                        implode(", ", $negativeNumbers) : 
                        ""
                    )
                );
            }
        }
    }
    class Delimiters{

        private $delimiters;
        private $settingText;
        private $mustRemove = false;

        public function __construct($delimiter = array(","))
        {
            $this->delimiters = $delimiter;
        }
        public function setDelimiters(
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
                $this->mustRemove = true;
            }
        }
        public function getDelimiters(){
            return $this->delimiters;
        }
        public function removeDelimitersFromText(
            $setString,  
            $delimiterBracketLeft = "[", 
            $delimiterBracketRight = "]", 
            $delimiterSettingStart = "//",
            $delimeterSettingEnd = "\n"
        ) {
            if(!$this->mustRemove){
                return $setString;
            }
            if(count($this->delimiters) > 1){
                return str_replace(
                    (
                        $delimiterSettingStart . 
                        $this->getAllDelimitersAsOneStringWithBrackets(
                            $delimiterBracketLeft, 
                            $delimiterBracketRight
                        ) . 
                        $delimeterSettingEnd
                    ), 
                    "", 
                    $setString
                );
            }
            return str_replace(
                (
                    $delimiterSettingStart . 
                    $this->delimiters[0] . 
                    $delimeterSettingEnd
                ), 
                "", 
                $setString
            );
        }
        public function partitionNumbersToArray($setString, $delimiter = ",")
        {
            $setString = str_replace(
                array_merge($this->delimiters, array("\n")), 
                $delimiter, 
                $setString
            );
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
                return $this->makeListOfDelimiters(
                    $setString[0], 
                    $delimiterBracketLeft, 
                    $delimiterBracketRight
                );
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
        private function getAllDelimitersAsOneStringWithBrackets( 
            $delimiterBracketLeft = "[", 
            $delimiterBracketRight = "]"
        ) {
            return implode("", array_filter(
                $this->delimiters, 
                function($delimiter) use (
                    $delimiterBracketLeft, 
                    $delimiterBracketRight
                ){
                    return $delimiterBracketLeft . $delimiter . $delimiterBracketRight;
                }
            ));
        }
    }
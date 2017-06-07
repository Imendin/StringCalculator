<?php

namespace Calculator;

    class StringCalculator {
        public function sumNumbers(string $numbers)
        {
            $result = "0";
            $sep = array();
            $negace = "";

            //if exist this("//") in text
            if(strpos($numbers, "//")  !== false){
                $sep = $this->getDelimiters($numbers);
            }
            if($sep == array())
                $sep[0] = ",";
            $saveNums = $numbers;

            //work with individually delimiters
            foreach($sep as $separ){
                //exception for two and more delimiters behind
                if(strpos($numbers, $separ."\n") !== false || strpos($numbers, "\n".$separ) !== false || strpos($numbers, "\n\n") !== false || strpos($numbers, $separ . $separ) !== false) 
                    return 'not';
                $saveNums = implode("\n",explode($separ, $saveNums)); //replace commas with lines
            }
            $saveNums = explode("\n", $saveNums); //distribution numbers
            $number = 0;

            //negation control
            $negativeNumbers = array_filter($saveNums, function($num){
                return $num < 0;
            });
            if(count($negativeNumbers) > 0){
                throw new \Exception(
                    "negatives not allowed " . 
                    (count($negativeNumbers) > 1 ? implode(", ", $negativeNumbers) : "")
                );
            }

            //remove numbers bigger than 1000 control
            $saveNums = array_filter($saveNums, function($num){
                return $num <= 1000;
            });

            //if can sum individually numbers then do it
            if($result = array_sum($saveNums));
            return (int)$result;
        }

        private function getDelimiters(&$numbers){
            $saveNums = explode("\n", $numbers); //distributions from text delimiters      
            if (strpos($saveNums[0], "[") !== false){
                return $this->getListOfDelimiter($saveNums, $numbers);
            }
            $sep[0] = substr($saveNums[0], 2, strlen($saveNums[0]) - 2); //only one distributor without brackets
            $numbers = str_replace(("//" . $sep[0] . "\n"), "", $numbers); //remove from text setting delimiters
            return $sep;
        }

        private function getListOfDelimiter($saveNums, &$numbers){
            $saveNums = explode("[", $saveNums[0]); //distribution of distributors
            $sep = array(); 
            foreach($saveNums as $sav){
                $sep[] = str_replace("]", "", $sav); //remove from distributors ending bracket
            }
            $numbers = str_replace(("//" . $this->getAllDelimitersAsOneStringWithBrackets($sep) . "\n"), "", $numbers); //remove from text setting delimiters
            return $sep;
        }

        private function getAllDelimitersAsOneStringWithBrackets($sep)
        {
            $result = "";
            foreach($sep as $separ){
                $result .= "[" . $separ . "]";
            }
            return $result;
        }
    }
?>
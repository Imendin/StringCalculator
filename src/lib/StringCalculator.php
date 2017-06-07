<?php

    class StringCalculator {
        public function sumNumbers(string $numbers)
        {
            $result = "0";
            $sep = array();
            $negace = "";
            try{
                //if exist this("//") in text
                if(strpos($numbers, "//") !== false){
                    //distributions from text delimiters
                    $saveNums = explode("\n", $numbers);
                    //if exist bracket for longer delimiters
                    if (strpos($saveNums[0], "[") !== false){
                        //distribution of distributors
                        $saveNums = explode("[", $saveNums[0]); 
                        foreach($saveNums as $sav){
                            //remove from distributors ending bracket
                            $sep[] = str_replace("]", "", $sav);
                        }
                        //remove from text setting delimiters
                        $numbers = str_replace(("//" . StringCalculator::getAllDelimiters($sep) . "\n"), "", $numbers);
                    }else{
                        //only one distributor without brackets
                        $sep[0] = substr($saveNums[0], 2, strlen($saveNums[0]) - 2);
                        //remove from text setting delimiters
                        $numbers = str_replace(("//" . $sep[0] . "\n"), "", $numbers);
                    }
                }
                //if not find delimiters
                if($sep == array())
                    $sep[0] = ",";
                $saveNums = $numbers;
                //work with individually delimiters
                foreach($sep as $separ){
                    //exception for two and more delimiters behind
                    if(strpos($numbers, $separ."\n") !== false || strpos($numbers, "\n".$separ) !== false || strpos($numbers, "\n\n") !== false || strpos($numbers, $separ . $separ) !== false)
                        return 'not';
                    //replace commas with lines
                    $saveNums = implode("\n",explode($separ, $saveNums));
                }
                //distribution numbers
                $saveNums = explode("\n", $saveNums);
                $number = 0;
                //negation control
                foreach($saveNums as $num){
                    //if number is negative
                    if($num < 0){
                        //if it is first negative
                        if($result === "0"){
                            $result = "negatives not allowed ";
                        } 
                        $negace .= $num . ", "; 
                    } 
                    //if number is bigger than 1000 then this number is ignored
                    if($num > 1000){
                    unset($saveNums[$number]);
                    }
                    $number ++;
                }
                //it sends exception message if numbers are negative
                if(strpos($result, "negatives not allowed") !== false){
                    //view negative numbers if numbers count is bigger than 1
                    if(count(explode(",", $negace)) > 2){
                        $result .= $negace;
                    }
                    throw new Exception($result);
                }
                //if can sum individually numbers then do it
                if($result = array_sum($saveNums));
                return (int)$result;
            }catch(Exception $e){
                return $e->getMessage();
            }
        }
        //it takes delimiters and it makes one text of them
        private function getAllDelimiters($sep, $one = false)
        {
            $result = "";
            //if it is one or more
            if(!$one){
                foreach($sep as $separ){
                    $result .= "[" . $separ . "]";
                }
            }else{
                foreach($sep as $separ){
                    $result .= $separ;
                } 
            }
            return $result;
        }
    }
?>
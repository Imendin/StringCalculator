<?php
    class StringCalculator {
        public function Add(string $numbers)
        {
            $result = "0";
            $sep = array();
            $negace = "";
            //pokud v textu je //
            if(strpos($numbers, "//") !== false){
                //separuje z textu separátor
                $saveNums = explode("\n", $numbers);
                if (strpos($saveNums[0], "[") !== false){
                    $saveNums = explode("[", $saveNums[0]); 
                    foreach($saveNums as $sav){
                        $sep[] = str_replace("]", "", $sav);
                    }
                    //odendá z textu nastavení separátoru
                    $numbers = str_replace(("//" . $this->separators($sep) . "\n"), "", $numbers);
                }else{
                    $sep[0] = substr($saveNums[0], 2, strlen($saveNums[0]) - 2);
                    //odendá z textu nastavení separátoru
                    $numbers = str_replace(("//" . $sep[0] . "\n"), "", $numbers);
                }
            }
            if($sep == array())
                $sep[0] = ",";
            $saveNums = $numbers;
            foreach($sep as $separ){
                //vyjímka pro dva a více rozdělovačů za sebou
                if(strpos($numbers, $separ."\n") !== false || strpos($numbers, "\n".$separ) !== false || strpos($numbers, "\n\n") !== false || strpos($numbers, $separ . $separ) !== false)
                    return 'not';
                //nahradí čárky řádkami
                $saveNums = implode("\n",explode($separ, $saveNums));
            }
            //rozdělí jednotlivá čísla
            $saveNums = explode("\n", $saveNums);
            $number = 0;
            //kontrola negace
            foreach($saveNums as $num){
                //pokud je záporné
                if($num < 0){
                    //pokud je to první zápor
                    if($result === "0"){
                        $result = "negatives not allowed ";
                    } 
                    $negace .= $num . ", "; 
                } 
                if($num > 1000){
                   unset($saveNums[$number]);
                }
                $number ++;
            }
            if($result === "0"){
                //pokud lze sečíst jednotlivé čísla tak to udělá
                if($result = array_sum($saveNums));
                return (int)$result;
            }else{
                //pokud existuje více záporných čísel než jedno
                if(count(explode(",", $negace)) > 2){
                    $result .= $negace;
                }
                return $result;
            }
        }

        private function separators($sep, $one = false)
        {
            $result = "";
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
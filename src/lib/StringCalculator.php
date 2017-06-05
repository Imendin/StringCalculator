<?php
    class StringCalculator {
        public function Add(string $numbers)
        {
            $result = "0";
            $sep = ",";
            $negace = "";
            //pokud v textu je //
            if(($pos = strpos($numbers, "//")) !== false){
                //separuje z textu separátor
                $saveNums = explode("\n", $numbers);
                $sep = substr($saveNums[0], 2, strlen($saveNums[0]) - 2);
                //odendá z textu nastavení separátoru
                $numbers = str_replace(("//" . $sep . "\n"), "", $numbers);
            }
            //vyjímka pro dva a více rozdělovačů za sebou
            if(strpos($numbers, $sep."\n") !== false || strpos($numbers, "\n".$sep) !== false || strpos($numbers, "\n\n") !== false || strpos($numbers, $sep.$sep) !== false)
                return 'not';
            //nahradí čárky řádkami a následně rozdělí jednotlivá čísla
            $saveNums = implode("\n",explode($sep, $numbers));
            $saveNums = explode("\n", $saveNums);
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
    }
?>
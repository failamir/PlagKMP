<?php

namespace App\Http\Controllers;

class CheckFile
{
    public function __construct()
    {
    }

    public function check($input, $sample) {
        $input = explode(' ', $input);
        $sample = explode(' ', $sample);
        $result = array_intersect($input, $sample);
        print_r($sample);
        /*$keyE = 0;
        $str = '';
        foreach ($result as $key => $value) {
            $keyS = $value;
            if($keyS == $keyE || $keyE == 0){
                $str = $str . $value . ' ';
            }else{
                $str = '<br />' . $str . $value;
            }
            $keyE = $keyS + 1;
        }
        echo $str;*/
    }


}

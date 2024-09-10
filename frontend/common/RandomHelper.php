<?php
namespace frontend\common;


class RandomHelper
{
     public static function get_random_number($length=8)
     {  
        return rand(pow(10,($length-1)), pow(10,$length)-1);
     }
     public static function get_random($length = 8) 
     {  
        $min = pow(10 , ($length - 1));
        $max = pow(10, $length) - 1;
        return rand($min, $max);
     }  
}

<?php


namespace App\Services;

class ServiceInverse
{
    public function inversePhrase($str){
        return strrev($str);
    }
}
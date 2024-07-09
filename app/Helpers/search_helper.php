<?php

if(!function_exists("is_arabic_text")){
    function is_arabic_text($keyword){
        preg_match("/[ا-ء]/" , $keyword , $matches);
        if(sizeof($matches) > 0)
        return true;
        else return false;
    }
}
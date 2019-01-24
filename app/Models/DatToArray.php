<?php

namespace App\Models;

class DatToArray{
    public static function dataExtraction($contents){

      $sales = [];

      foreach($contents as $content){
        $content = str_replace("\r\n", "", $content);
        $content_exploded = explode(",", $content);
        
        if($content_exploded[0] == 003){
            $content = str_replace(" ", "", $content);
            $data_sale = stristr(stristr($content, '['), ']', true);
            $data_sale = substr($data_sale, 1);
            $data_sale = explode(",", $data_sale);
            $pos_open = strpos($content, '[');
            $pos_close = strpos($content, ']');
            $content = substr_replace($content, "", $pos_open, $pos_close-$pos_open+1);
            $content_exploded = explode(",", $content);
            $content_exploded[2] = $data_sale;
        }

        array_push($sales, $content_exploded);
      }

      return $sales;
    }
}
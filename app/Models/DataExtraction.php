<?php

namespace App\Models;

use Storage;
use File;

class DataExtraction{

  public static function getFiles(){
    $homedir = getHomepath();
    $dir_in = Storage::disk('input')->getAdapter()->getPathPrefix();
    $dir_out = Storage::disk('output')->getAdapter()->getPathPrefix();
    $files_in = File::files($dir_in);
    $files_out = File::files($dir_out);
    $datfiles_in = [];
    $datfiles_out = [];

    foreach($files_in as $file_in){
        if($file_in->getExtension() == 'dat'){
            $filename = $file_in->getFilename();
            array_push($datfiles_in, $filename);
        }
    }

    foreach($files_out as $file_out){
        if($file_out->getExtension() == 'dat'){
            $filename = $file_out->getFilename();
            array_push($datfiles_out, $filename);
        }
    }

    return [$datfiles_in, $datfiles_out];
  }

  public static function datToArray($contents){

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

  public static function customers($contents){
    $customers = 0;
    foreach($contents as $files){
      foreach($files as $file){
        if($file[0] == 002){
          $customers++;
        }
      }
    }
    return $customers;
  }

  public static function salesmans($contents){
    $salesmans = 0;
    foreach($contents as $files){
      foreach($files as $file){
        if($file[0] == 001){
          $salesmans++;
        }
      }
    }
    return $salesmans;
  }

  public static function salesmansAvarageSalary($contents){
    $salesmansAvarageSalary = 0;
    $salesmans = 0;
    foreach($contents as $files){
      foreach($files as $file){
        if($file[0] == 001){
          $salesmansAvarageSalary += $file[3];
          $salesmans++;
        }
      }
    }
    $salesmansAvarageSalary = $salesmansAvarageSalary / $salesmans;
    return $salesmansAvarageSalary;
  }

  public static function expensiveSaleId($contents){
    $expensiveSale = 0;
    $expensiveSaleId = 0;
    foreach($contents as $files){
      foreach($files as $file){
        if($file[0] == 003){
          $saleValue = 0;
          foreach($file[2] as $itens){
            $item = explode("-", $itens);
            $val = (float) getNumbersFromString($item[2]);
            $saleValue += $val;
          }
          if($saleValue > $expensiveSale){
            $expensiveSale = $saleValue;
            $expensiveSaleId = $file[1]; 
          }
        }
      }
    }
    return $expensiveSaleId;
  }

  public static function worstSeller($contents){
    $sellers = [];
    $worstSell = [];
    $worstSeller = null;
    foreach($contents as $files){
      foreach($files as $file){
        if($file[0] == 003){
          $saleValue = 0;
          foreach($file[2] as $itens){
            $item = explode("-", $itens);
            $val = (float) getNumbersFromString($item[2]);
            $saleValue += $val;
          }
          if(array_key_exists($file[3], $sellers))
          {
            $sellers[$file[3]] += $saleValue;
          }
          else{
            $sellers += [$file[3] => $saleValue];
          }
        }
      }
    }
    $worstSeller = array_search(min($sellers), $sellers);

    return $worstSeller;
  }
}
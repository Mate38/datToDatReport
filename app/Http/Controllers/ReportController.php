<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataExtraction;
use File;
use PDF;

class ReportController extends Controller
{
    public function report()
    {
        $homedir = getHomepath();
        $dir = realpath($homedir.'/data/in');
        $files = File::files($dir);
        $data = [];

        foreach($files as $file){
            if($file->getExtension() == 'dat'){
                $contents = file($file->getPathname());
                $data_file = DataExtraction::datToArray($contents);
                array_push($data, $data_file);
            }
        }

        $salesmans = DataExtraction::salesmans($data);
        $customers = DataExtraction::customers($data);
        $salesmansAvarageSalary = DataExtraction::salesmansAvarageSalary($data);
        $expensiveSaleId = DataExtraction::expensiveSaleId($data);
        $worstSeller = DataExtraction::worstSeller($data);

        $code = view('reports.sales', compact('salesmans','customers','salesmansAvarageSalary','expensiveSaleId','worstSeller'))->render();  
        $pdf = PDF::loadHtml($code);
        
        return $pdf->stream();
    }
}


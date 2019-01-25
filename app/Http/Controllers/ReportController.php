<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataExtraction;
use File;
use PDF;
use Storage;
use DateTime;

class ReportController extends Controller
{
    public function report()
    {
        $homedir = getHomepath();
        $dir_in = realpath($homedir.'/data/in');
        $dir_out = realpath($homedir.'/data/out/');
        $files = File::files($dir_in);
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

        $output = $customers.','.$salesmans.','.$salesmansAvarageSalary.','.$expensiveSaleId.','.$worstSeller;
        $now = new DateTime();
        $filename = $now->format('j-M-Y_H.i.s');

        // file_put_contents($dir_out.'/'.$filename.'.done.dat', $output);
        Storage::disk('output')->put($filename.'.done.dat', $output);

        $code = view('reports.sales', compact('salesmans','customers','salesmansAvarageSalary','expensiveSaleId','worstSeller'))->render();  
        $pdf = PDF::loadHtml($code);
        
        return $pdf->stream();
    }
}


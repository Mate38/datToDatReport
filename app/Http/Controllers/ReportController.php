<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataExtraction;
use File;
use PDF;
use Storage;
use DateTime;
use Redirect;

class ReportController extends Controller
{
    public function dataProcess()
    {
        $dir_in = Storage::disk('input')->getAdapter()->getPathPrefix();
        $files = File::files($dir_in);
        $data = [];

        foreach($files as $file){
            if($file->getExtension() == 'dat'){
                $contents = file($file->getPathname());
                $data_file = DataExtraction::datToArray($contents);
                array_push($data, $data_file);
            }
        }

        $customers = DataExtraction::customers($data);
        $salesmans = DataExtraction::salesmans($data);
        $salesmansAvarageSalary = DataExtraction::salesmansAvarageSalary($data);
        $expensiveSaleId = DataExtraction::expensiveSaleId($data);
        $worstSeller = DataExtraction::worstSeller($data);

        $output = $customers.','.$salesmans.','.$salesmansAvarageSalary.','.$expensiveSaleId.','.$worstSeller;
        $now = new DateTime();
        $filename = $now->format('j-M-Y_H.i.s');

        Storage::disk('output')->put($filename.'.done.dat', $output);

        return Redirect::to('/');
    }

    public function report($file)
    {
        $data_file = Storage::disk('output')->get($file);
        $data = explode(",", $data_file);

        $customers = $data[0];
        $salesmans = $data[1];
        $salesmansAvarageSalary = $data[2];
        $expensiveSaleId = $data[3];
        $worstSeller = $data[4];

        $code = view('reports.sales', compact('salesmans','customers','salesmansAvarageSalary','expensiveSaleId','worstSeller'))->render();  
        $pdf = PDF::loadHtml($code);
        
        return $pdf->stream();
    }
}


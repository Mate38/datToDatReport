<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DatToArray;

class IndexController extends Controller
{
    public function index()
    { 
        $filename = 'teste.dat';

        try
        {
            $contents = file(storage_path($filename));
            //dd($contents);
        }
        catch (Illuminate\Contracts\Filesystem\FileNotFoundException $exception)
        {
            die("The file doesn't exist");
        }

        $data = DatToArray::dataExtraction($contents);

        dd($data);

        return view('index', compact('data'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DatToArray;

use File;

class IndexController extends Controller
{
    public function index()
    {
        $homedir = getHomepath();
        $files = File::files(realpath($homedir.'/data/in'));
        $data = [];

        // dd($files);

        foreach($files as $file){
            if($file->getExtension() == 'dat'){
                $contents = file(storage_path($file->getFilename()));
                $data_file = DatToArray::dataExtraction($contents);
                array_push($data, $data_file);
            }
        }

        // dd($data);

        return view('index', compact('data','files'));
    }
}

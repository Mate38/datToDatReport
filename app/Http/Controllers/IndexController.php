<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataExtraction;
use File;

class IndexController extends Controller
{
    public function index()
    {
        $homedir = getHomepath();
        $dir = realpath($homedir.'/data/in');
        $files = File::files($dir);
        $datfiles = [];

        foreach($files as $file){
            if($file->getExtension() == 'dat'){
                $filename = $file->getFilename();
                array_push($datfiles, $filename);
            }
        }

        return view('index')->with('files', $datfiles);
    }
}

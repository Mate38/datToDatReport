<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataExtraction;
use File;

class IndexController extends Controller
{
    public function index()
    {
        $datfiles = $this->getFiles();

        return view('index')->with('files', $datfiles);
    }

    public function upload(Request $request)
    {
        $file = $request->file('file');

        // dd($file->getClientOriginalExtension());

        if (empty($file)) {
            abort(400, 'Nenhum arquivo foi enviado.');
        }

        $filename = $file->getClientOriginalName();

        $file->storeAs('', $filename, 'input');

        $datfiles = $this->getFiles();

        return view('index')->with('files', $datfiles);
    }

    private function getFiles(){
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

        return $datfiles;
    }
}

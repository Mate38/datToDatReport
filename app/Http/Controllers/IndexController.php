<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataExtraction;
use File;
use Validator;

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

        $v = Validator::make($request->all(), [
            'file' => 'required|file|max:10000',
        ]);
        
        if($v->fails() || $file->getClientOriginalExtension() != 'dat') {
            return back()->with('message', 'Problemas para carragar o arquivo, confira as especificações!');
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

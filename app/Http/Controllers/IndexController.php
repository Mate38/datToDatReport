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

        return view('index',['files_in'=> $datfiles[0], 'files_out' => $datfiles[1]]);
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
        $dir_in = realpath($homedir.'/data/in');
        $dir_out = realpath($homedir.'/data/out');
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
}

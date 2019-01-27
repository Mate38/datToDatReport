<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataExtraction;
use File;
use Validator;
use Storage;
use Redirect;

class IndexController extends Controller
{
    public function index()
    {
        $datfiles = DataExtraction::getFiles();

        return view('index',['files_in'=> $datfiles[0], 'files_out' => array_reverse($datfiles[1])]);
    }

    public function upload(Request $request)
    {
        $v = Validator::make($request->all(), [
                'files.*' => 'required|max:20000'
        ]);

        if($v->fails()) {
            return back()->with('message', 'Problemas para carragar o arquivo, confira as especificações!');
        }

        $files = $request->file('files');

        foreach($files as $file){
            
            if($v->fails() || $file->getClientOriginalExtension() != 'dat') {
                return back()->with('message', 'Problemas para carragar o arquivo, confira as especificações!');
            }

            $filename = $file->getClientOriginalName();

            $file->storeAs('', $filename, 'input');
        }

        return Redirect::to('/');
    }

    public function delete($file)
    {
        Storage::disk('input')->delete($file);

        $datfiles = DataExtraction::getFiles();

        return Redirect::to('/');
    }
}

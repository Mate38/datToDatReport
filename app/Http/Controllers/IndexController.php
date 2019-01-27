<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataExtraction;
use File;
use Validator;
use Storage;

class IndexController extends Controller
{
    public function index()
    {
        $datfiles = DataExtraction::getFiles();

        return view('index',['files_in'=> $datfiles[0], 'files_out' => array_reverse($datfiles[1])]);
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

        $datfiles = DataExtraction::getFiles();

        return view('index',['files_in'=> $datfiles[0], 'files_out' => array_reverse($datfiles[1])]);
    }

    public function delete($file)
    {
        Storage::disk('input')->delete($file);

        $datfiles = DataExtraction::getFiles();

        return view('index',['files_in'=> $datfiles[0], 'files_out' => $datfiles[1]]);
    }
}

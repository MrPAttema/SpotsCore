<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class MediaController extends Controller
{
    public function __construct() {

        $this->middleware('auth');
    }

    public function upload(Request $request) {

        $file = $request->file();

        if ($request->hasFile('photo')) {
            $file = $request->file();
            $path = $request->photo->store('images');
            dd($path);
        } else {
            echo "faal";
        }

	}
}

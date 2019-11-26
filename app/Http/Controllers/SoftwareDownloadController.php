<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SoftwareDownloadController extends Controller
{
    

    public function software_download($name)
    {       
        
        $path = public_path('download/'. $name);
        
        return response()->file($path);

    }

   
}

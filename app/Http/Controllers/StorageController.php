<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function save(Request $request){

    
      if ($request->hasFile('image')){

        $path = $request->image->store('referencias-image');
        return $path;
      }
      else
      {
        return "Seleccione un archivos";
      } 
     
    }
}

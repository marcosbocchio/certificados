<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function save(Request $request){

    
      if ($request->hasFile('image')){

       // $path = $request->image->store('referencias-image');
          $path = Storage::disk('public')->put('referencias-image',$request->file('image'));  
    
        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      } 
     
    }
}

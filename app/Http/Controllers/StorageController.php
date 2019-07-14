<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function saveReferencia(Request $request){

    
      if ($request->hasFile('image')){

       // $path = $request->image->store('referencias-image');
          $path = Storage::disk('local')->put('referencias-image',$request->file('image'));  
    
        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      } 
     
    }

    public function saveDocumento(Request $request){

     
      if ($request->hasFile('documento')){

       // $path = $request->image->store('referencias-image');
          $path = Storage::disk('local')->put('documentaciones',$request->file('documento'));  
    
        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      } 
     
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function saveReferencia(Request $request){

    
      if ($request->hasFile('image')){
      
          $path = Storage::disk('public')->put('referencias',$request->file('image'));  
    
        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      } 
     
    }

    public function saveDocumento(Request $request){

     
      if ($request->hasFile('documento')){

      
          $path = Storage::disk('public')->putFile('documentaciones',$request->file('documento'));  
    
        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      } 
     
    }

    public function saveLogoCliente(Request $request){

     
      if ($request->hasFile('logo-cliente')){

      
          $path = Storage::disk('public')->putFile('logos-clientes',$request->file('logo-cliente'));  
    
        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      } 
     
    }

    public function saveFirmaDigital(Request $request){

     
      if ($request->hasFile('firma-digital')){

      
          $path = Storage::disk('public')->putFile('firmas-digitales',$request->file('firma-digital'));  
    
        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      } 
     
    }
}

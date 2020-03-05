<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{

   /* ver con tiempo usar esta funcion para todos los archivos */

    public function storage(Request $request){
    
      if ($request->hasFile('archivo')){
      
          $path = Storage::disk('public')->put($request->path_storage,$request->file('archivo'));  
    
        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      } 
     
    }

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

    public function saveLogoContratista(Request $request){

     
      if ($request->hasFile('logo-contratista')){

      
          $path = Storage::disk('public')->putFile('logos-contratistas',$request->file('logo-contratista'));  
    
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

    public function savePlacas(Request $request){

     
      if ($request->hasFile('placas')){

      
          $path = Storage::disk('public')->putFile('placas',$request->file('placas'));  
    
        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      } 
     
    }

    public function saveCalibraciones(Request $request){

     
      if ($request->hasFile('archivo')){

      
          $path = Storage::disk('public')->putFile('calibraciones_us',$request->file('archivo'));  
    
        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      } 
     
    }

    public function saveIndicacionesUs(Request $request){

     
      if ($request->hasFile('archivo')){

      
          $path = Storage::disk('public')->putFile('indicaciones_us',$request->file('archivo'));  
    
        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      } 
     
    }

    public function saveinformesImportados(Request $request){

     
      if ($request->hasFile('archivo')){

      
          $path = Storage::disk('public')->putFile('informes_importados',$request->file('archivo'));  
    
        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      } 
     
    }
}

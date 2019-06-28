<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function save(Request $request){

       // Verificamos si hay un file con nombre avatar
      if ($request->hasFile('image')) {
        // Si es así , almacenamos en la carpeta public/avatars
        // esta estará dentro de public/defaults/
        $url = $request->image->store('imagenes');
        
        return "llego la imagen";
    }
      return "Noo Llego una imagen";
    }
}

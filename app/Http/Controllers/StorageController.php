<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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

          $path = Storage::disk('public')->putFile('storage/referencias',$request->file('image'));

        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      }

    }

    public function saveDocumento(Request $request){


      if ($request->hasFile('documento')){


          $path = Storage::disk('public')->putFile('storage/documentaciones',$request->file('documento'));

        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      }

    }

    public function saveLogoCliente(Request $request){


      if ($request->hasFile('logo-cliente')){


          $path = Storage::disk('public')->putFile('storage/logos-clientes',$request->file('logo-cliente'));

        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      }

    }

    public function saveLogoContratista(Request $request){


      if ($request->hasFile('logo-contratista')){


          $path = Storage::disk('public')->putFile('storage/logos-contratistas',$request->file('logo-contratista'));

        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      }

    }

    public function saveFirmaDigital(Request $request){


      if ($request->hasFile('firma-digital')){


          $path = Storage::disk('public')->putFile('storage/firmas-digitales',$request->file('firma-digital'));

        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      }

    }

    public function savePlacasRi(Request $request){


      if ($request->hasFile('archivo')){


          $path = Storage::disk('public')->putFile('storage/placas_ri',$request->file('archivo'));

        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      }

    }

    public function savePlacasUs(Request $request){


      if ($request->hasFile('archivo')){


          $path = Storage::disk('public')->putFile('storage/placas_us',$request->file('archivo'));

        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      }

    }

    public function saveCalibraciones(Request $request){


      if ($request->hasFile('archivo')){


          $path = Storage::disk('public')->putFile('storage/calibraciones_us',$request->file('archivo'));

        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      }

    }

    public function saveIndicacionesUs(Request $request){


      if ($request->hasFile('archivo')){


          $path = Storage::disk('public')->putFile('storage/indicaciones_us',$request->file('archivo'));

        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      }

    }

    public function saveinformesImportados(Request $request){


      if ($request->hasFile('archivo')){


          $path = Storage::disk('public')->putFile('storage/informes_importados',$request->file('archivo'));

        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      }

    }

    public function saveDocumentosEscaneados(Request $request){


      if ($request->hasFile('archivo')){


          $path = Storage::disk('public')->putFile('storage/documentos_escaneados',$request->file('archivo'));

        return $path;
      }
      else
      {
        return "Seleccione un archivo";
      }

    }
    public function saveDocumentosVideos(Request $request)
    {
        if ($request->hasFile('archivo')){

            $path = Storage::disk('public')->putFile('storage/documentos_videos',$request->file('archivo'));

          return $path;
        }
        else
        {
          return "Seleccione un archivo";
        }
    }

    public function saveModelos3D(Request $request)
    {
        if ($request->hasFile('archivo')){
            $file = $request->file('archivo')->getClientOriginalName();
            $extension = $request->file('archivo')->getClientOriginalExtension();
            $fileName = $file.'.'.$extension;
            $path = Storage::disk('public')->putFileAs('storage/modelos_3d',$request->file('archivo'),$file );

            return $path;
        }
        else
        {
          return "Seleccione un archivo";
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VideoCategory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;
use Illuminate\Support\Facades\Auth;


class VideosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:Sistemas|C_visualiza_cursos'],['only' => ['multimediaHome']]);
        $this->middleware(['role_or_permission:Sistemas|C_visualiza_cursos'],['only' => ['multimediaSubcategoria']]);
    }

    public function multimediaHome(){

        $user = auth()->user();
        $header_titulo = "";
        $header_descripcion ="";
        $categoriasSup = collect();

        if($user->hasPermissionTo('C_visualiza_total')){
            $categoriasSup = VideoCategory::CategoriasSuperiores()->get();
            Log::debug("entro en C_visualiza_total ");
        }
        else if($user->hasPermissionTo('C_visualiza_acotado')){
            $categoriasSup = VideoCategory::CategoriasSuperiores()->Acotadas()->get();
        }

        Log::debug("Videos: " . $categoriasSup);

        $resultados = collect();
        for ($i=0; $i < $categoriasSup->count(); $i++){

            if($user->hasPermissionTo('C_visualiza_total')){
               
                $subCategorias = $categoriasSup[$i]->videos_categories()->get();
            }
            else if($user->hasPermissionTo('C_visualiza_acotado')){
                $subCategorias = $categoriasSup[$i]->videos_categories()->Acotadas()->get();
            }
            $resultados->push([
                'nombreCategoria' => $categoriasSup[$i]->title,
                'subcategorias' => $subCategorias
            ]);
        }
       
        return view('videos.multimedia_home', compact('user','header_titulo','header_descripcion', 'resultados'));
    }

    public function multimediaSubcategoria($id){
        $user = auth()->user();

        $header_titulo = "VIDEOS";
        $header_descripcion =" ";

        $resultados = collect();

        $subcategoria = VideoCategory::find($id);

        //Si el usuario no tiene acceso a una categoria, tampoco
        //deberia tener acceso a sus subcategorias
        //(podria entrar via link)
        $categoria = $subcategoria->parent()->first();
        if($categoria->acotado_sn &&  !$user->hasPermissionTo('C_visualiza_total')){
            return view('videos.multimedia_subcategoria', compact('user','header_titulo','header_descripcion', 'resultados'));
        }

        if($subcategoria->acotado_sn &&  !$user->hasPermissionTo('C_visualiza_total')){
            return view('videos.multimedia_subcategoria', compact('user','header_titulo','header_descripcion', 'resultados'));
        }

        if($user->hasPermissionTo('C_visualiza_total')){
            $secciones = $subcategoria->Secciones()->get();
        }
        else if($user->hasPermissionTo('C_visualiza_acotado')){
            $secciones = $subcategoria->Secciones()->Acotadas()->get();
        }

        for ($i=0; $i < $secciones->count(); $i++){
            $resultados->push([
                'nombreSeccion' => $secciones[$i]->title,
                'videos' => $secciones[$i]->videos()->get()
            ]);
        }

        return view('videos.multimedia_subcategoria', compact('user','header_titulo','header_descripcion', 'resultados'));
    }

    public function getVideosCategoria($id) {

        $subcategoria = VideoCategory::find($id);
        $secciones = $subcategoria->videos()->get();
        return $secciones;
    }

}

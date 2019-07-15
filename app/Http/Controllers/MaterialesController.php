<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Materiales\MaterialesRepository;
use App\Materiales;
use App\User;


class MaterialesController extends Controller
{
    Protected $materiales;

    public function __construct(MaterialesRepository $materialesRepository)
    {
      $this->materiales = $materialesRepository;
    }

    public function index()
    {   
         return  $this->materiales->getAll();

    }

    public function callView()
    {   
        $user = auth()->user()->name;
        $header_titulo = "Materiales";
        $header_descripcion ="Alta | Baja | Modificación";      
        return view('materiales',compact('user','header_titulo','header_descripcion'));

    }

    public function store(Request $request){

      $request->validate([

        'descripcion'  => 'required |unique:materiales'
      
      ]);

      $this->materiales->create($request->all()) ;      

    }

    public function destroy($id){

      $material = $this->materiales->find($id);    
      $material->delete();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Materiales\MaterialesRepository;

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
        $User = auth()->user()->name;      
        return view('materiales',compact('User'));

    }

    public function store(Request $request){


     $this->users->create($request) ;

    }

    public function destroy($id){

      $this->materiales->delete($id);
    }
}
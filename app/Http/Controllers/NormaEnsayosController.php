<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\NormaEnsayos\NormaEnsayosRepository;
use App\NormaEnsayos;
use App\User;

class NormaEnsayosController extends Controller
{

    Protected $normaEnsayo;

    public function __construct(NormaEnsayosRepository $normaEnsayosRepository)
    {
      $this->normaEnsayo = $normaEnsayosRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  $this->normaEnsayo->getAll();
    }

    public function paginate(Request $request){

        return NormaEnsayos::orderBy('id','DESC')->paginate(10);
  
     }

    public function callView()
    {   
        $user = auth()->user()->name; 
        $header_titulo = "Normas Ensayos";
        $header_descripcion ="Alta | Baja | Modificación";  
        return view('norma-ensayos',compact('user','modelo','header_titulo','header_descripcion'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

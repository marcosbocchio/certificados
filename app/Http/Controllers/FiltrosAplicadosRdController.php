<?php

namespace App\Http\Controllers;

use App\FiltrosAplicadosRd;
use Illuminate\Http\Request;

class FiltrosAplicadosRdController extends Controller
{
    public function index()
    {
        return FiltrosAplicadosRd::orderBy('descripcion', 'ASC')->get();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $descripcion = trim($request->input('descripcion'));
        $registro = FiltrosAplicadosRd::firstOrCreate(['descripcion' => $descripcion]);
        return response()->json($registro, 201);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

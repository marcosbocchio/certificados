<?php

namespace App\Http\Controllers;

use App\SoftwaresAdquisicionRd;
use Illuminate\Http\Request;

class SoftwaresAdquisicionRdController extends Controller
{
    public function index()
    {
        return SoftwaresAdquisicionRd::orderBy('descripcion', 'ASC')->get();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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

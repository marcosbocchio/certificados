<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Generatrices;

class GeneratricesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Generatrices::all();
    }

}

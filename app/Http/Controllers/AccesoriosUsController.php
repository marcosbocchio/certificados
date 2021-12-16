<?php

namespace App\Http\Controllers;

use App\AccesoriosUs;
use Illuminate\Http\Request;

class AccesoriosUsController extends Controller
{
    public function index() {

        return AccesoriosUs::all();
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Informe;
use App\MetodoEnsayos;

class PdfInformesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)    {
      
        $informe = Informe::where('id', '=', $id)->first();
        $metodo_ensayo = MetodoEnsayos::where('id', '=', $informe->metodo_ensayo_id)->first();        
      
        switch ($metodo_ensayo->metodo) {
            case 'RI':
                 return redirect()->route('pdfInformeRi',array('id' => $id));
                 break;   
            case 'PM':
                return redirect()->route('pdfInformePm',array('id' => $id));
                break;         
            case 'LP':
                return redirect()->route('pdfInformeLp',array('id' => $id));
                break;
        }         

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

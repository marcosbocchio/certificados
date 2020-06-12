<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TecnicaDistancias;
use App\Tecnicas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TecnicaDistanciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function DistanciasDiametro($tecnica_id,$diametro,$espesor,$foco){

        DB::enableQueryLog();

        $tecnica = Tecnicas::find($tecnica_id);

        $diametro_exterior = DB::select('call DistanciasDiametro(?)',array($diametro));

        Log::debug("distancia fuente pelicula " . $diametro_exterior[0]->distancia_fuente_peliculas);
        Log::debug("foco " . $foco);
        Log::debug("espesor " . $espesor);
        Log::debug("tecnica formula : " . $tecnica->formula);

        switch (trim($tecnica->formula)) {

            case 'DistanciaFuentePelicula_SSA':

                $dfp = DB::select("select DistanciaFuentePelicula_SSA(?) as valor", array($diametro_exterior[0]->distancia_fuente_peliculas));
                Log::debug("dfp " . $dfp[0]->valor);
                break;

            case 'DistanciaFuentePelicula_SSB':
                $dfp = DB::select("select DistanciaFuentePelicula_SSB(?,?) as valor", array($diametro_exterior[0]->distancia_fuente_peliculas,$espesor));
                Log::debug("dfp " . $dfp[0]->valor);
                break;
            
            case 'DistanciaFuentePelicula_SSC':

                $dfp = DB::select("select DistanciaFuentePelicula_SSC(?,?) as valor", array($foco,$espesor));
                Log::debug("dfp " . $dfp[0]->valor);
                break;

            case 'DistanciaFuentePelicula_DSD':
                $dfp = DB::select("select DistanciaFuentePelicula_DSD(?) as valor", array($diametro_exterior[0]->distancia_fuente_peliculas));
                Log::debug("dfp " . $dfp[0]->valor);
                break;

            case 'DistanciaFuentePelicula_DSE':
                $dfp = DB::select("select DistanciaFuentePelicula_DSE(?) as valor", array($diametro_exterior[0]->distancia_fuente_peliculas));
                Log::debug("dfp " . $dfp[0]->valor);
                break;

            case 'DistanciaFuentePelicula_DDF':
                $dfp = DB::select("select DistanciaFuentePelicula_DDF(?,?) as valor", array($diametro_exterior[0]->distancia_fuente_peliculas,$foco));
                Log::debug("dfp " . $dfp[0]->valor);
                break;

            case 'DistanciaFuentePelicula_DDG':
                $dfp = DB::select("select DistanciaFuentePelicula_DDG(?,?) as valor", array($diametro_exterior[0]->distancia_fuente_peliculas,$foco));
                Log::debug("dfp " . $dfp[0]->valor);
                break;
        }

         
         return $dfp;

    }


    public function DistanciasDiametroChapa($tecnica_id,$medida){

        $tecnica = Tecnicas::find($tecnica_id);

        $medidas = explode('x',$medida);
        $alto = $medidas[0];
        $ancho = $medidas[1];

        $dfp = DB::select("select DistanciaFuentePelicula_CHAPA(?,?) as valor", array($alto,$ancho));

        return $dfp;
    }


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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Ots\OtsRepository;
use Illuminate\Support\Collection as Collection;
use App\Ots;
use App\Clientes;
use App\Contactos;
use App\Epps;
use App\Riegos;
use Illuminate\Support\Facades\DB;
use App\OtServicios;
use App\User;
use App\Provincias;
use App\Localidades;

class OtsController extends Controller
{
    Protected $ot;

    public function __construct(OtsRepository $otRepository)
    {
      $this->ot = $otRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accion = 'create';      
        $user = auth()->user()->name;
        $header_titulo = "Orden de trabajo";
        $header_descripcion ="Crear";  
        return view('ots.index', compact('user','accion','header_titulo','header_descripcion'));
        
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
        return $this->ot->store($request);
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
        $header_titulo = "Orden de trabajo";
        $header_descripcion ="Editar";      
        $accion = 'edit';      
        $user = auth()->user()->name;
        $ot = $this->ot->find($id);
        $cliente = Clientes::find($ot->cliente_id);
        
      
        $ot_servicios = DB::select('select
                                    servicios.id as id,
                                    servicios.descripcion as servicio,
                                    norma_ensayos.descripcion as norma_ensayo,
                                    norma_ensayos.id as norma_ensayo_id,
                                    metodo_ensayos.metodo as metodo,
                                    norma_evaluaciones.descripcion as norma_evaluacion,
                                    norma_evaluaciones.id as norma_evaluacion_id,
                                    ot_servicios.cantidad as cantidad_servicios,
                                    ot_servicios.cant_max_placas as cantidad_placas,
                                    ot_referencias.descripcion as observaciones,
                                    ot_referencias.path1 as path1,
                                    ot_referencias.path2 as path2,
                                    ot_referencias.path3 as path3,
                                    ot_referencias.path4 as path4
                                    
                                    from ot_servicios
                                    inner join servicios on 
                                    servicios.id = ot_servicios.servicio_id
                                    left join ot_referencias on
                                    ot_referencias.id = ot_servicios.ot_referencia_id
                                    inner join norma_ensayos on
                                    norma_ensayos.id = ot_servicios.norma_ensayo_id
                                    inner join norma_evaluaciones on
                                    norma_evaluaciones.id = ot_servicios.norma_evaluacion_id
                                    inner join metodo_ensayos on
                                    servicios.metodo_ensayo_id = metodo_ensayos.id
                                    inner join ots on
                                    ot_servicios.ot_id=ots.id 
                                    where
                                    ots.id=:id',['id' => $ot->id ]);
        $ot_productos = DB::select('select 
                                    productos.id as id,
                                    productos.descripcion as producto,
                                    medidas.descripcion as medida,
                                    medidas.id as medida_id,
                                    productos.unidades_medida_id as unidad_medida_id,
                                    unidades_medidas.codigo as unidad_medida_codigo,
                                    ot_productos.cantidad as cantidad_productos,
                                    ot_referencias.descripcion as observaciones,
                                    ot_referencias.path1 as path1,
                                    ot_referencias.path2 as path2,
                                    ot_referencias.path3 as path3,
                                    ot_referencias.path4 as path4
                                    
                                    from productos
                                    inner join ot_productos on
                                    ot_productos.producto_id = productos.id
                                    left join ot_referencias on
                                    ot_referencias.id = ot_productos.ot_referencia_id
                                    inner join medidas on
                                    medidas.id = ot_productos.medida_id
                                    inner join unidades_medidas on
                                    medidas.unidades_medida_id = unidades_medidas.id
                                    inner join ots on
                                    ots.id = ot_productos.ot_id and
                                    ots.id=:id',['id' => $ot->id ]);
        $ot_epps = DB::select('select 
                                    epps.id,
                                    epps.descripcion 
                                    from epps
                                    inner join ot_epps on
                                    epps.id = ot_epps.epp_id
                                    inner join ots on
                                    ot_epps.ot_id = ots.id
                                    Where 
                                    ots.id =:id',['id' => $ot->id ]);
        $ot_riesgos = DB::select('select 
                                    riesgos.id,
                                    riesgos.descripcion
                                    from riesgos
                                    inner join ot_riesgos on
                                    riesgos.id = ot_riesgos.riesgo_id
                                    inner join ots on
                                    ot_riesgos.ot_id = ots.id
                                    Where 
                                    ots.id =:id',['id' => $ot->id ]);

        $ot_calidad_placas = DB::select('select 

                                        tipo_peliculas.id,
                                        tipo_peliculas.codigo ,
                                        tipo_peliculas.descripcion,
                                        tipo_peliculas.fabricante                                      

                                        
                                        from ot_calidad_placas
                                        inner join tipo_peliculas on
                                        tipo_peliculas.id =ot_calidad_placas.tipo_pelicula_id
                                        inner join ots on
                                        ots.id = ot_calidad_placas.ot_id	
                                        Where 
                                        ots.id =:id',['id' => $ot->id ]);

        
      
        $ot_servicios = Collection::make($ot_servicios);
        $ot_calidad_placas = Collection::make($ot_calidad_placas);
        $ot_productos = Collection::make($ot_productos);
        $ot_epps = Collection::make($ot_epps);
        $ot_riesgos = Collection::make($ot_riesgos);
        $ot_contacto1 = Contactos::find($ot->contacto1_id);
        $ot_contacto2 = Contactos::find($ot->contacto2_id);
        $ot_contacto3 = Contactos::find($ot->contacto3_id);
        
        $ot_localidad = Localidades::find($ot->localidad_id);
        $ot_provincia = Provincias::find($ot_localidad->provincia_id);
       
        
        if ($ot_contacto2 == null)
                $ot_contacto2 = new Contactos();
        if ($ot_contacto3 == null)
                $ot_contacto3 = new Contactos();

        return view('ots.edit',compact('ot',
                                        'cliente',
                                        'user',
                                        'ot_servicios',
                                        'ot_calidad_placas',
                                        'ot_productos',
                                        'ot_epps',
                                        'ot_riesgos',
                                        'accion',
                                        'ot_contacto1',
                                        'ot_contacto2',
                                        'ot_contacto3',
                                        'ot_provincia',
                                        'ot_localidad',
                                        'header_titulo',
                                        'header_descripcion'));
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
        return $this->ot->updateOt($request,$id);
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

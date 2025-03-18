<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\OtsRequest;
use App\Repositories\Ots\OtsRepository;
use Illuminate\Support\Collection as Collection;
use App\Ots;
use App\Clientes;
use App\Contratistas;
use App\Contactos;
use App\Epps;
use App\Riegos;
use Illuminate\Support\Facades\DB;
use App\OtServicios;
use App\User;
use App\Provincias;
use App\Localidades;
use Illuminate\Support\Facades\Auth;
use \stdClass;
use \carbon;
use App\Informe;
use App\OtTipoSoldaduras;

class OtsController extends Controller
{
    Protected $ot;

    public function __construct(OtsRepository $otRepository)
    {

     $this->middleware(['role_or_permission:Sistemas|O_alta'],['only' => ['create','edit']]);
      $this->ot = $otRepository;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            $user_id = null;

            if (Auth::check())
            {
                $user_id = Auth::id();
                $user = Auth::user();
           }
            $tipoUsuario =  $user->cliente_id ? 'CLIENTE' : 'ENOD';
            $filtro = $request->search;
            return ots:: whereRaw('CASE :tipoUsuario WHEN "ENOD" THEN 1=1
                            ELSE ots.id IN (Select ot_id FROM ot_usuarios_clientes where user_id = :user_id)
                            END',[$tipoUsuario,$user_id])
                            ->join('clientes','clientes.id','=','ots.cliente_id')
                            ->selectRaw('ots.*,DATE_FORMAT(ots.fecha,"%d/%m/%Y")as fecha_formateada')
                            ->with('cliente')
                            ->otfiltro($filtro)
                            ->orderBy('id','DESC')
                            ->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $accion = 'create';
        $user = auth()->user();
        $header_titulo = "Orden de trabajo";
        $header_descripcion ="Crear";
        return view('ots.index', compact('user','accion','header_titulo','header_descripcion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OtsRequest $request)
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
        $user = auth()->user();
        $ot = $this->ot->find($id);
        $cliente = Clientes::find($ot->cliente_id);
        $contratista = Contratistas::find($ot->contratista_id);

        $ot_servicios = (new OtServiciosController)->show($ot->id);
        $ot_productos = (new OtProductosController)->show($ot->id);
        $ot_epps = (new OtEppsController)->show($ot->id);
        $ot_riesgos = (new OtRiesgosController)->show($ot->id);
        $ot_calidad_placas = (new OtCalidadPlacasController)->show($ot->id);

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
        $responsable_ot = User::find($ot->responsable_ot_id);


        if ($ot_contacto2 == null)
                $ot_contacto2 = new Contactos();
        if ($ot_contacto3 == null)
                $ot_contacto3 = new Contactos();
       if ($contratista == null)
           $contratista = new Contratistas();

        return view('ots.edit',compact('ot',
                                        'cliente',
                                        'contratista',
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
                                        'responsable_ot',
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
    public function update(OtsRequest $request, $id)
    {
        return $this->ot->updateOt($request,$id);
    }

    public function firmar($ot_id){

        $user_id = null;

        if (Auth::check())
        {
             $user_id = $userId = Auth::id();
        }

        $ot = Ots::findOrFail($ot_id);
        $ot->firma =  $user_id;
        $ot->estado = 'ACTIVA';
        $ot->fecha_firma = Carbon::now();
        $ot->save();

        return $ot;

    }

    public function cerrar($ot_id){

        $user_id = null;

        if (Auth::check())
        {
             $user_id = $userId = Auth::id();
        }

        $ot = Ots::findOrFail($ot_id);
        $ot->estado = 'CERRADA';
        $ot->fecha_cierre = Carbon::now();
        $ot->save();

        return $ot;

    }

    public function getObras($ot_id)
    {
        return Informe::where('ot_id', $ot_id)
            ->select('informes.obra')
            ->distinct()
            ->orderBy('obra', 'asc')
            ->get();
    }
    

    public function getObrasTipoSoldaduras($ot_id){

        return OtTipoSoldaduras::where('ot_id',$ot_id)->select('obra')->distinct()->get();

    }

    public function getComponentes($ot_id,$obra){

        $obra = str_replace('--','/',$obra);
        return Informe::where('ot_id',$ot_id)
        ->where('obra',$obra)
        ->select('informes.componente')
        ->distinct()
        ->orderBy('informes.componente','asc')
        ->get();
    }
}

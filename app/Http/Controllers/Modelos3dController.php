<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Modelos3DRequest;
use Illuminate\Support\Facades\DB;
use Exception as Exception;
use App\Modelos3D;
use App\User;
use Illuminate\Support\Str;
use Image;
use Illuminate\Support\Facades\Storage;

class Modelos3dController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  Modelos3D::orderBy('codigo','DESC')->get();

    }

    public function paginate(Request $request){

        return Modelos3D::orderBy('codigo','DESC')->paginate(10);

      }

    public function callView()
    {
      $user = auth()->user();
      $header_titulo = "Modelos 3D";
      $header_descripcion ="Alta | Baja | Modificación";
      return view('modelos-3d',compact('user','header_titulo','header_descripcion'));

    }

    public function Viewer($modelo_id)
    {

      $modelo_3d = Modelos3D::findOrFail($modelo_id);

      $user = auth()->user();
      $header_titulo = "Modelos 3D ";
      $header_descripcion ="Visualizador";
      return view('modelos-3d-viewer',compact('user','header_titulo','header_descripcion','modelo_3d'));

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
    public function store(Modelos3DRequest $request)
    {
        $modelo_3d = new Modelos3D;

          DB::beginTransaction();
          try {

              $this->saveModelo3D($request,$modelo_3d);
              DB::commit();

          } catch (Exception $e) {

              DB::rollback();
              throw $e;

          }
     }

     public function saveModelo3D($request,$modelo_3d){

        $base64_image = $request['snapshot_base64'];
        $png_url = "image-".time().".png";
        $path = public_path().'/storage/modelos_3d/' . $png_url;
        Image::make(file_get_contents($base64_image))->save($path);

        $modelo_3d->codigo = $request['codigo'];
        $modelo_3d->descripcion = $request['descripcion'];
        $modelo_3d->path = $request['path'];
        $modelo_3d->path_imagen = 'storage/modelos_3d/' . $png_url ;
        $modelo_3d->save();

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
    public function update(Modelos3DRequest $request, $id){

        $modelo_3d = Modelos3D::find($id);

          DB::beginTransaction();
          try {
              $this->saveModelo3D($request,$modelo_3d);
              DB::commit();

            } catch (Exception $e) {

              DB::rollback();
              throw $e;

            }
      }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modelo3d = Modelos3D::find($id);
        $modelo3d->delete();
    }
}

<?php

namespace App\Http\Controllers;
use App\Http\Requests\PermisoRequest;
use Illuminate\Http\Request;
use App\Permissions;
use Illuminate\Support\Facades\DB;

class PermissionsController extends Controller
{
  public function __construct()
  {
    $this->middleware(['role_or_permission:Super Admin|permisos']);
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  Permissions::orderBy('name','ASC')->get();
    }

    public function paginate(Request $request){
      
  
        return Permissions::orderBy('name','ASC')->paginate(10);
    
    }
    
    public function callView()
    
    {   
        $user = auth()->user(); 
        $header_titulo = "Permisos";
        $header_descripcion ="Alta | Baja | Modificación";  
        return view('permisos',compact('user','header_titulo','header_descripcion'));

    }

    public function store(PermisoRequest $request){


        $permiso = new Permissions;   
    
        DB::beginTransaction();
        try { 
    
            $this->savePermiso($request,$permiso);
            DB::commit(); 
    
          } catch (Exception $e) {
      
            DB::rollback();
            throw $e;      
            
          }
       
    
      }

      public function update(PermisoRequest $request, $id){

        $permiso = Permissions::find($id);     
      
          DB::beginTransaction();
          try {
              $this->savePermiso($request,$permiso);            
              DB::commit(); 
      
            } catch (Exception $e) {
        
              DB::rollback();
              throw $e;      
              
            }
      }

      public function savePermiso($request,$permiso){

        $permiso->name = $request['name'];
        $permiso->guard_name = $request['guard_name'];
        $permiso->save();
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();   
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Permiso = Permissions::find($id);
        $Permiso->delete();
    }
}

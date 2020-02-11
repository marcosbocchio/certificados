<?php

namespace App\Http\Controllers;
use App\Http\Requests\RolRequest;
use Illuminate\Http\Request;
use App\Roles;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;


class RolesController extends Controller
{

  public function __construct()
  {
    $this->middleware(['role_or_permission:Super Admin|M_roles'],['only' => ['callView']]);  
    $this->middleware(['role_or_permission:Super Admin|M_roles_edita'],['only' => ['store','update']]);  
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return  Roles::all();
    }

    public function paginate(Request $request){
      
  
      return Roles::with('permisos')->orderBy('id','DESC')->paginate(10);
  
     }
   
    public function callView()

    {   
        $user = auth()->user(); 
        $header_titulo = "Roles";
        $header_descripcion ="Alta | Baja | Modificación";  
        return view('roles',compact('user','header_titulo','header_descripcion'));

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
   

    public function store(RolRequest $request){


        $rol = new Roles;   
    
        DB::beginTransaction();
        try { 
    
            $this->saveRol($request,$rol);
            $this->saveRol_permisos($rol,$request->permisos);
            DB::commit(); 
    
          } catch (Exception $e) {
      
            DB::rollback();
            throw $e;      
            
          }
       
    
      }

      public function update(RolRequest $request, $id){

        $rol = Roles::find($id);     
      
          DB::beginTransaction();
          try {
              $this->saveRol($request,$rol);  
              $this->saveRol_permisos($rol,$request->permisos);          
              DB::commit(); 
      
            } catch (Exception $e) {
        
              DB::rollback();
              throw $e;      
              
            }
      }

      public function saveRol($request,$rol){

        $rol->name = $request['name'];
        $rol->guard_name = $request['guard_name'];
        $rol->save();

      }

      public function saveRol_permisos($rol,$permisos){

       $rol = Role::findByName($rol->name,$rol->guard_name);        
       $rol->syncPermissions($permisos);
       app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

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
        $rol = Roles::find($id);
        $rol->delete();
    }
}

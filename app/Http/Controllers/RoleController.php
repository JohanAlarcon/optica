<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use App\Permission;
use App\Form;
use App\PermissionRole;
use App\Http\Requests\roleFormRequest;
use App\Http\Requests\roleEditFormRequest;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
   
    
    public function __construct(){ //Este constructor nos garantiza que el formulario se muestre siempre y cuando se este logueado
   
        $this->middleware('auth');
       
        
    }
    
    public function permisosBotones(){
        
        $id_formulario = 3; //Roles
        
        $botones = DB::table('permission_roles')
        ->select(DB::raw("permission_id"))
        ->whereRaw('role_id = (SELECT role_id FROM role_user WHERE user_id ='.auth()->id().')')
        ->where('form_id','=',$id_formulario)
        ->pluck('permission_id')->toArray();
        
        return $botones;
    }
    
    public function index(Request $request){
        
       $permissions   = Permission::all();
       $forms         = Form::all();
       
       $botones = $this-> permisosBotones();
       
       if($request->ajax())  return $this->showTable();
       
       return view('roles.index',['permissions'=>$permissions,'forms'=>$forms,'botones'=>$botones,'action'=>url('roles')]);
        
    }
    
    public function showTable(){
         
        $botones = $this-> permisosBotones();
    
        //Posicion del array donde se encuentra la opcion de 'Eliminar'
        $permissions = !isset($botones[2]) ? '' : $botones[2];   
        
        $roles = DB::table('roles')
        ->select(DB::raw("id,name, descripcion, DATE_FORMAT(created_at,'%Y-%m-%d') AS created_at, '$permissions' AS permissions, 'roles' AS ruta,(SELECT GROUP_CONCAT(user_id) FROM role_user WHERE role_id = roles.id) AS user_rol"))
        ->where('deleted_at', '=', NULL)
        ->get();
        
        return DataTables::of($roles)
        
        ->addColumn('action', 'actions')
        ->rawColumns(['imagen','action'])
        ->make(true);
     
   }
    
    public function saveDetalles($formularios,$permisos,$role_id){
        
        for ($i=0;$i < count($formularios);$i++) {  
        
            for ($j=0;$j < count($permisos);$j++) {   
                                                    
                $permissionRole                = new PermissionRole(); 	
        
                $permissionRole->role_id       =  $role_id;
                $permissionRole->permission_id =  $permisos[$j];
                $permissionRole->form_id       =  $formularios[$i];
                
                $permissionRole -> save();
        
            }
            
        }
        
    }
    
   
    public function store(Request $request){
        
        DB::beginTransaction();
        
      try {
            
            $role           = new Role();
            
            $role->name             = request('name');
            
            $role->descripcion      = request('descripcion');
            
            $role->usuario_registra = auth()->id();
            
            $role -> save();
            
            $this->saveDetalles($request->form,$request->permission,$role->id);
            
            DB::commit();
            
            return redirect('roles')->with('message','Registrado con exito'); 
           
        }catch (\Throwable $e) {
            
            DB::rollback();
            
            return redirect()->back()->withErrors(['Error' => $e->getMessage()]);
            
        }

       
       
    }

    
    public function show($id){
        
        //
    }

   
    public function edit($id,Request $request){
        
        try {
                
            $role        = role::findOrFail($id);
            
            $permissions = Permission::all();
            $forms       = Form::all(); 
            
            $permissions_selected = DB::table('permission_roles')
            ->select(DB::raw("permission_id"))
            ->where('role_id', '=', $id)->groupBy('permission_id')->pluck('permission_id')->toArray();
            
            $forms_selected      = DB::table('permission_roles')
            ->select(DB::raw("form_id"))
            ->where('role_id', '=', $id)->groupBy('form_id')->pluck('form_id')->toArray();
            
            if($request->ajax()) return $this->showTable();
            
            $botones = $this-> permisosBotones();
            
            return view('roles.index', ['role'=>$role,'permissions'=>$permissions,'forms'=>$forms,'permissions_selected'=>$permissions_selected,'botones'=>$botones,'forms_selected'=>$forms_selected,'action'=>route('roles.update',$role->id)] );
        
        } catch (\Throwable $e) {
                
            return redirect()->back()->withErrors(['Error' => $e->getMessage()]);
        
        }  
       
    }

    
    public function update(Request $request, $id){ 
                                                  
        try {
            
            $rol            = role::findOrFail($id);
                            
            $permissionRole = PermissionRole::where('role_id', $id);
            
            $rol->name              = $request->get('name');
            $rol->descripcion       = $request->get('descripcion');
            $rol->usuario_actualiza = auth()->id();
            
            $rol->update();
        
            $permissionRole->delete();
            
            $this->saveDetalles($request->form,$request->permission,$id);
            
            $request->session()->flash('message','Actualizado con exito'); 
            
            return $this->index($request);
        
        } catch (\Throwable $e) {
                    
            return redirect()->back()->withErrors(['Error' => $e->getMessage()]);
        
        }  
       
    }

    
    public function destroy($id)
    {
       try {
            
        $permissionRole = PermissionRole::where('role_id', $id);
        
        $permissionRole->delete();
            
        $role = role::findOrFail($id);
        
        $role->delete();
        
        return redirect('/roles')->with('message','Eliminado con exito');
       
      } catch (\Throwable $e) {
                    
        return redirect('/roles')->withErrors(['Error' => $e->getMessage()]);
    
      }  
       
    }
}

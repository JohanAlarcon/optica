<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Http\Requests\UserFormRequest;
use App\Http\Requests\UserEditFormRequest;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct(){ //Este constructor nos garantiza que el formulario se muestre siempre y cuando se este logueado
   
        $this->middleware('auth');
        
    }
    
    
    public function permisosBotones(){
        
        $id_formulario = 2; //Usuarios
        
        $botones = DB::table('permission_roles')
        ->select(DB::raw("permission_id"))
        ->whereRaw('role_id = (SELECT role_id FROM role_user WHERE user_id ='.auth()->id().')')
        ->where('form_id','=',$id_formulario)
        ->pluck('permission_id')->toArray();
        
        return $botones;
    }
    
    public function showTable(){
        
           $botones = $this-> permisosBotones();
        
            //Posicion del array donde se encuentra la opcion de 'Eliminar'
           $permissions = !isset($botones[2]) ? '' : $botones[2];   
            
           $users = DB::table('users')
           ->select(DB::raw("id,name, email, imagen, password, DATE_FORMAT(created_at,'%Y-%m-%d') AS created_at,(SELECT r.name FROM roles r WHERE r.id = (SELECT ru.role_id FROM role_user ru WHERE ru.user_id = users.id)) AS rol,'$permissions' AS permissions, 'usuarios' AS ruta, 'UserController' AS controlador"))
           ->where('deleted_at', '=', NULL)
           ->get();
           
           return DataTables::of($users)
           
           ->addColumn('imagen', function($user){
               
               if(empty($user->imagen)){
                   
                return '<a href="'.asset('imagenes/user-indefinido.png').'" target="_blank"><img src="'.asset('imagenes/user-indefinido.png').'" width="50" height="50" /></a>';
                    
               }
               
                   return '<a href="'.asset('imagenes/'.$user->imagen).'" target="_blank"><img src="'.asset('imagenes/'.$user->imagen).'" width="50" height="50" /></a>';
               
           })
           
           ->addColumn('action', 'actions')
           ->rawColumns(['imagen','action'])
           ->make(true);
        
    }
    
    public function index(Request $request)
    {
       
        $roles  = Role::all();
        
        $botones = $this-> permisosBotones();
        
        if($request->ajax()) return $this->showTable();
        
        return view('usuarios.index',['roles'=>$roles,'botones'=>$botones,'action'=>url('usuarios')]);
     
    }

   
    public function store(UserFormRequest $request)
    {
        
        $usuario = new User();
        
        $usuario->name                =request('name');
        $usuario->email               =request('email');
        $usuario->usuario_registra    = auth()->id();
        $usuario->password            =bcrypt(request('password'));
       
        if($request->hasFile('imagen')){
            
            $file = $request->imagen;
            $file->move(public_path().'/imagenes',$file->getClientOriginalName());
            $usuario->imagen = $file->getClientOriginalName();
            
            //getClientOriginalName : Es el nombre del archivo
            
        }
        
        $usuario->save();
        
        $usuario->asignarRol($request->get('rol'));
        
        return redirect('/usuarios')->with('message','Registrado con exito'); 
    }



    public function edit($id,Request $request)
    {
        
       $user    = User::findOrFail($id);
       $roles   = Role::all(); 
       $botones = $this-> permisosBotones();
       
      if($request->ajax())  return $this->showTable();
       
       return view('usuarios.index', ['user'=>$user,'roles'=>$roles,'botones'=>$botones,'action'=>route('usuarios.update',$user->id)] );
       
    }

   
    public function update(UserEditFormRequest $request, $id)
    {
        
        $this->validate(request(),['email'=>['required','email','max:255','unique:users,email,'.$id]]);
        
        $usuario = User::findOrFail($id);
        
        $usuario->name              = $request->get('name');
        $usuario->email             = $request->get('email');
        $usuario->usuario_actualiza = auth()->id();
        
        if($request->hasFile('imagen')){
            
            $file = $request->imagen;
            $file->move(public_path().'/imagenes',$file->getClientOriginalName());
            $usuario->imagen = $file->getClientOriginalName();
            
            //getClientOriginalName : Es el nombre del archivo
            
        }
        
        $pass = $request->get('password');
        
        if($pass!=null){
            
        $usuario->password = bcrypt( $request->get('password') );
        
        }else{
            
            unset($usuario->password);
            
        }
        
        //Actualizar rol
        
        /* 
        
        Modificamos esta parte para que actualice roles de usuarios
        Si tiene rol actualizamos el rol
        si no tiene rol le asignamos un rol 
        
         */
        
        $role = $usuario->roles;
        
        if(count($role)>0){
            
            $role_id = $role[0]->id;
            
            User::find($id)->roles()->updateExistingPivot($role_id,['role_id'=>$request->get('rol')]);
        }else{
            
            $usuario->asignarRol($request->get('rol'));
        
        }
        
       
       $usuario->update();
       
       $request->session()->flash('message','Actualizado con exito'); 
            
       return $this->index($request);
       
       
    }

  
    public function destroy($id)
    {
       $usuario = User::findOrFail($id);
       
       $usuario->delete();
       
       return redirect('/usuarios')->with('message','Eliminado con exito');
       
    }
}

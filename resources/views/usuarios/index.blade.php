
@extends('layouts.app')


@section('content')


<div class="container">
   
    <div class="alert alert-dark" role="alert" align="center">
    
        <h3 class="modal-title mx-auto"><i class="fas fa-users"></i>&emsp;Usuarios</h3>
        
    </div>  
      
    <div class="row">
        
          
            @if(session('message')) 
          
                <div class="col-sm-12">
            
                    <div class="alert alert-success" align="center"> 
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fas fa-check-circle"></i>&emsp;{{ session('message') }}  
                    </div> 
                
                </div> 
            
            @endif
            
            @if($errors->any())
            
            <div class="col-sm-12">

                <div class="alert alert-danger" align="center">

                    <ul>

                        @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>
            
            </div>

            @endif
            
         
    </div>

    <form action= "{{$action}}" method="POST" enctype="multipart/form-data" id="form-users">
        
        @if(isset($user))@method('PATCH')@endif
        
        @csrf

        <div class="row">

            <div class="form-group col-md-6"> 

                <label>Nombre (*)</label>
                
                <input type="text" name="name" class="form-control" value="@if(isset($user)){{$user->name}} @endif"   placeholder="Nombre" required>

            </div>

            <div class="form-group col-md-6">

                <label>Email (*)</label>
                <input type="email" name="email" class="form-control" value="@if(isset($user)){{$user->email}} @endif"  placeholder="Email" required>

            </div>


        </div>

        <div class="row">

            <div class="form-group col-md-6">

                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" placeholder="Contraseña">

            </div>

            <div class="form-group col-md-6">

                <label>Confirme Contraseña</label>
                <input type="password" name="password_confirmation" class="form-control"
                    placeholder="Confirme Contraseña">

            </div>


        </div>

        <div class="row">

            <div class="form-group col-md-6">

                <label>Rol (*)</label>
                
                <select class="form-control" name="rol" required>
                    
                  <option value="NULL" selected disabled>Elige un rol para este usuario</option>
                 @foreach ($roles as $role)
                 
                    @if(isset($user))
            
                        
                        @if ($role->name == str_replace(array('["','"]'),'',$user->tieneRol()))
                            
                        <option value="{{$role->id}}" selected>{{$role->name}}</option>
                    
                        @else
                        
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        
                        @endif
                    
                    @else
                    
                    <option value="{{$role->id}}">{{$role->name}}</option>
                    
                    @endif
                    
                 @endforeach
                    
                </select>


            </div>

            <div class="form-group col-md-6">

                <label>Imagen</label>
                <input type="file" name="imagen" class="form-control">
                
                @if(isset($user))
                
                    @if($user->imagen != '')
                    
                        <img src={{asset('imagenes/'.$user->imagen)}}  alt="{{$user->imagen}}" height="50px" width="50px">
                
                    @endif
              
                @endif

            </div>


        </div>
        
        <br>
        
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="btn-group">
                
                 @if (in_array(1, $botones))
                    
                    <button type="submit" id="guardar"    class="btn btn-success" @if(isset($user))disabled @endif><i class="fas fa-save"></i>&emsp;Guardar</button>
                 
                 @endif
                 
                @if (in_array(2, $botones))
                  
                    <button type="submit" id="actualizar" class="btn btn-primary" @if(!isset($user))disabled @endif><i class="far fa-edit"></i>&emsp;Actualizar</button>
                  
                 @endif
                  
                  <button type="button"  class="btn btn-secondary reset"><i class="fas fa-sync"></i>&emsp;Limpiar</button> 

                </div>
            </div>
        </div>
        
        <br>
       
    </form>
</div>

<br>

<div class="container">
    
    <div class="alert alert-dark" role="alert" align="center">
    
        <h5 class="modal-title mx-auto"><i class="fas fa-list"></i>&emsp;Lista de usuarios registrados </h5>
        
    </div>


    <table class="table table-border data-table display responsive nowrap" style="width:100%">
        <thead>
            <tr>
              
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col">Fecha creacion</th>
                <th scope="col">Rol</th>
                <th scope="col">Imagen</th>
                <th scope="col" width="100px">Opciones</th>
            </tr>
        </thead>
        <tbody>
          
        </tbody>
    </table>


</div>

<script src="{{ asset('js/usuarios.js') }}"></script>

@endsection


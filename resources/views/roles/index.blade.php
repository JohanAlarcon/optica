
@extends('layouts.app')


@section('content')


<div class="container">
   
    <div class="alert alert-dark" role="alert" align="center">
    
        <h3 class="modal-title mx-auto"> <i class="fas fa-user-tag"></i>&emsp;Roles y permisos</h3>
        
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
        
        @if(isset($role))@method('PATCH')@endif
        
        @csrf

        <div class="row">

            <div class="form-group col-md-6"> 

                <label>Nombre (*)</label>
                
                <input type="text" name="name" class="form-control" value="@if(isset($role)){{$role->name}} @endif"   placeholder="Nombre" required>

            </div>

            <div class="form-group col-md-6">

                <label>Descripcion (*)</label>
                
                <textarea name="descripcion" id="descripcion" class="form-control" cols="30"  required>@if(isset($role)){{$role->descripcion}} @endif</textarea>

            </div>


        </div>

        <div class="row">

            <div class="form-group col-md-6">

                <label>Permisos (*)</label>
                
                <select class="form-control select2" multiple="multiple" name="permission[]" required>
                    
                   @foreach ($permissions as $permission)
                   
                    @if (isset($permissions_selected))
                    
                        @if (in_array($permission->id, $permissions_selected))
                            
                        <option value="{{$permission->id}}" selected>{{$permission->name}}</option>
                            
                        @else
                        
                        <option value="{{$permission->id}}">{{$permission->name}}</option>
                            
                        @endif
                        
                    @else
                    
                        <option value="{{$permission->id}}">{{$permission->name}}</option>
                        
                    @endif
                      
                   @endforeach
                      
                  </select>

            </div>
            <div class="form-group col-md-6">

                <label>Formularios (*)</label>
                
                <select class="form-control select2" multiple="multiple" name="form[]" required>
                    
                    @foreach ($forms as $form)
                    
                        @if (isset($forms_selected))
                        
                        
                            @if (in_array($form->id, $forms_selected))
                            
                            <option value="{{$form->id}}" selected>{{$form->name}}</option>
                            
                            @else
                        
                            <option value="{{$form->id}}">{{$form->name}}</option>
                            
                            @endif
                            
                            
                        @else
                        
                            <option value="{{$form->id}}">{{$form->name}}</option>
                            
                        @endif
                       
                    @endforeach
                       
                   </select>
               

            </div>


        </div>
        
        <br>
        
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="btn-group">
                    
                 <button type="submit" id="guardar"    class="btn btn-success" @if(isset($role))disabled @endif><i class="fas fa-save"></i>&emsp;Guardar</button>
                  
                  <button type="submit" id="actualizar" class="btn btn-primary" @if(!isset($role))disabled @endif><i class="far fa-edit"></i>&emsp;Actualizar</button>
                  
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
    
        <h5 class="modal-title mx-auto"><i class="fas fa-list"></i>&emsp;Lista de roles registrados </h5>
        
    </div>


    <table class="table table-border data-table display responsive nowrap" style="width:100%">
        <thead>
            <tr>
              
                <th scope="col">Nombre</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Fecha creacion</th>
                <th scope="col" width="100px">Opciones</th>
            </tr>
        </thead>
        <tbody>
          
        </tbody>
    </table>


</div>

<script src="{{ asset('js/roles.js') }}"></script>

@endsection


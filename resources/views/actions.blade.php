

   @include('modal-delete')
  
            
    <a href="{{route($ruta.'.edit',$id)}}"><button type="button" data-toggle="tooltip" title="Editar"
            class="btn btn-primary btn-sm"><i class="far fa-edit"></i></button></a>
            
        @if ($permissions == 3) {{-- Valida el permiso de eliminar  --}}
        
            @switch($ruta)
            
            @case('usuarios')
            
                @if (auth()->id() != $id)  {{-- Valida que no puede eiminarse el mismo usuario que se encuentra logueado  --}}
                
                    <button type="submit" class="btn btn-danger btn-sm" data-target="#delete-{{$id}}" data-toggle="modal" data-toggle="tooltip" title="Eliminar"><i class="far fa-trash-alt"></i>
            
                @endif
                
            @break
        
            @case('roles')
            
                @if (!in_array(auth()->id(), (explode(",", $user_rol)))) {{-- Valida que no puede eiminarse el mismo usuario que se encuentra registrado con el rol  --}}
                    
                    <button type="submit" class="btn btn-danger btn-sm" data-target="#delete-{{$id}}" data-toggle="modal" data-toggle="tooltip" title="Eliminar"><i class="far fa-trash-alt"></i>

                @endif
                
            @break
        
            @default
            
                <button type="submit" class="btn btn-danger btn-sm" data-target="#delete-{{$id}}" data-toggle="modal" data-toggle="tooltip" title="Eliminar"><i class="far fa-trash-alt"></i>
                
            @endswitch
 
        @endif
  
  
    </button>


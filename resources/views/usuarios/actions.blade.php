

   @include('usuarios.modal-delete')
            
    <a href="{{route('usuarios.edit',$id)}}"><button type="button"
            class="btn btn-primary btn-sm"><i class="far fa-edit"></i></button></a>
 
  
    <button type="submit" class="btn btn-danger btn-sm" data-target="#delete-{{$id}}" data-toggle="modal" ><i class="far fa-trash-alt"></i>
    </button>




   @include('roles.modal-delete')
            
    <a href="{{route('roles.edit',$id)}}"><button type="button"
            class="btn btn-primary btn-sm"><i class="far fa-edit"></i></button></a>
 
        
    @if (auth()->id() != $id)
        
        <button type="submit" class="btn btn-danger btn-sm" data-target="#delete-{{$id}}" data-toggle="modal" ><i class="far fa-trash-alt"></i>
    
    @endif
  
    </button>


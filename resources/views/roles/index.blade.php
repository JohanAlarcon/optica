@extends('layouts.app')

@section('content')

<div class="container">

<div class="row">

    <div class="col-md-6 mx-auto">

        <h2>Roles de usuario
        
        @include('roles.modal')
        
      </h2>

        <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
              </tr>
            </thead>
            <tbody>
            
            @foreach ($roles as $rol)
            
              <tr>
              
                <th scope="row">{{$rol->id}}</th>
                <td>{{$rol->name}}</td>
              
              </tr>
              
              @endforeach
            
            </tbody>
          </table>
      
    </div>
  
</div>
  
</div>

    
@endsection
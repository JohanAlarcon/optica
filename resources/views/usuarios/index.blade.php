
@extends('layouts.app')


@section('content')

<div class="container">
    <h2>Lista de usuarios registrados <a href="usuarios/create"><button type="button"
                class="btn btn-success float-right">Agregar usuario</button></a></h2>


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


@endsection


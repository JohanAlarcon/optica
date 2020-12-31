<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notas;

class NotasController extends Controller
{
   
   
   public function __construct(){ //Este constructor nos garantiza que el formulario se muestre siempre y cuando se este logueado
   
      $this->middleware('auth');
     
      
  }
   
   
   public function index(){
       
    $notas = Notas::all();
    
    return view('notas.todas.index',['notas' => $notas->where('user_id',auth()->id())]);
    
   }
   
   
   public function edit($id){
    
    return view('notas.todas.edit',['nota' => Notas::findOrFail($id)]);
    
   }
   
   public function update(Request $request,$id){
      
      $nota = Notas::findOrFail($id);
      
      $nota->titulo = $request->get('titulo');
      
      $nota->texto  = $request->get('texto');
      
      $nota->update();
    
      return redirect('notas/todas');
      
   }
   
   public function store(Request $request){
       
    $nota = new Notas;
    
    $nota->titulo   = request('titulo');
    $nota->texto    = request('texto');
    $nota->user_id  = auth()->id(); // para toma el id de el usuario que se encuentra logueado actualmente
    
    $nota->save();
    
    return redirect('notas/todas');
       
       
   }
   
   public function destroy($id){
       
      $nota = Notas::findOrFail($id);
      
      $nota->delete();
    
      return redirect('notas/todas');
       
   }
   
   public function favoritas(){
    return view('notas.favoritas');
   }
   
   public function archivadas(){
    return view('notas.archivadas');
   }
   
}

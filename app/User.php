<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail 
{
    use Notifiable;
    use SoftDeletes; //Implementamos 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function roles(){
        
        return $this->belongsToMany(Role::class)->withTimestamps(); // withTimestamps -> sirve para crear el create_at y update_at de manera automatica
        
    }
    
    public function asignarRol($role){
        
        $this->roles()->sync($role,false);
        
    }
    
    public function tieneRol(){
        
       return $this->roles->flatten()->pluck('name')->unique();
        
    }
}

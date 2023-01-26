<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'apaterno',
        'amaterno',
        'genero',
        'telefono',
        'fecha_nacimiento',
        'ocupacion',
        'user_image',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Uno a muchos notificaciones
    public function getNotifications(){
        return $this->hasMany('App\Models\Notifications');
    }

    public function getOcupacion(){
        return $this->hasOne(Ocupaciones::class, 'id', 'ocupacion');
    }

    public function generales(){
        return $this->hasOne(Generales::class, 'id', 'cliente_id');
    }

    public function getNotificationsdata(){
        return $this->hasMany(Notifications::class, 'user_id');
    }

    public function favorites(){
        return $this->hasOne(Contactos::class, 'usuario_id');
    }
}

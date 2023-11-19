<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class Cliente extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $fillable = ['nome', 'email', 'telefone', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected $table = 'clientes';
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}

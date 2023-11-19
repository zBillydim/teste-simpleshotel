<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = ['data_checkin', 'data_checkout', 'quarto_id', 'cliente_id'];
    protected $tabble = 'reserva';
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function reservasPorCliente($clienteId)
    {
        return $this->where('cliente_id', $clienteId)->get();
    }
}

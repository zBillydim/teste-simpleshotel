<?php

namespace App\Models;

use App\Http\Requests\ReservarRequest;
use Illuminate\Database\Eloquent\Model;

class Quarto extends Model
{
    protected $fillable = ['numero', 'capacidade', 'preco_diaria', 'disponivel'];

    // Relacionamento com as reservas
    public function reservar(ReservarRequest $request)
    {
        $reserva = Reserva::create([
            'data_checkin' => $request->data_checkin,
            'data_checkout' => $request->data_checkout,
            'quarto_id' => $this->id,
            'cliente_id' => $request->cliente_id,
        ]);

        return $reserva;
    }
}

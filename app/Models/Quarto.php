<?php

namespace App\Models;

use App\Http\Requests\ReservarRequest;
use Illuminate\Database\Eloquent\Model;

class Quarto extends Model
{
    protected $fillable = ['numero', 'capacidade', 'preco_diaria', 'disponivel'];

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
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
    public static function listarQuartosDisponiveisPorData($data)
    {
        return self::whereDoesntHave('reservas', function ($query) use ($data) {
            $query->whereDate('data_checkin', '<=', $data)
                ->whereDate('data_checkout', '>=', $data);
        })->get();
    }
}

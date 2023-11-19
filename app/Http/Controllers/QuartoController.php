<?php

namespace App\Http\Controllers;
use App\Http\Requests\QuartoRequest;
use App\Http\Requests\ReservarRequest;
use App\Models\Quarto;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class QuartoController extends Controller
{
    /**
     * Summary of index
     * @param \App\Http\Requests\QuartoRequest $request
     * @return void
     */
    public function CriaQuarto(QuartoRequest $request){
        $quarto = Quarto::create([
            "numero" => $request->numero,
            "capacidade" => $request->capacidade,
            "preco_diaria" => $request->preco_diaria,
            "disponivel" => $request->disponivel,
        ]);
        if(!$quarto){
            return response()->json(['err' => 'erro'], 400);
        }
        return response()->json(['Success' => 'Quarto criado com sucesso', 'id' => $quarto->id], 201);

    }
    /**
     * Summary of ListarDisponiveis
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function ListarDisponiveis()
    {
        if (Redis::exists('quartos_disponiveis')) {
            $quartosDisponiveis = json_decode(Redis::get('quartos_disponiveis'), true);
            return response()->json(['quartos_disponiveis' => $quartosDisponiveis], 200);
        }
        $quartos = Quarto::where('disponivel', true)->get();
        Redis::set('quartos_disponiveis', json_encode($quartos));
        Redis::expire('quartos_disponiveis', 60*60); // 1 hora de cache
        return response()->json(['quartos_disponiveis' => $quartos], 200);
        }
    /**
     * Summary of ReservarQuarto
     * @param \App\Http\Requests\ReservarRequest $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function ReservarQuarto(ReservarRequest $request){
        $quarto = Quarto::find($request->id);
        if(!$quarto->disponivel){
            return response()->json(['err'=> 'Esse quarto não esta disponível'], 400);
        }
        $reserva = $quarto->reservar($request);
        if(!$reserva){
            return response()->json(['err'=> 'erro ao reservar'], 400);
        }        
        return response()->json(['Success' => 'Reserva concluida com sucesso', 'data' => $reserva], 201);
    }

}

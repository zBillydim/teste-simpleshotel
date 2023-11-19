<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    /**
     * Summary of index
     * @return void
     */
    public function index(){
        $user = Auth::user();
        try{
            $clientes = Cliente::where('id', '<>', $user->id)->get();
            return response()->json(['success' => $clientes], 200);
        }catch(\Exception $e){
            return response()->json(['err' => $e], 400);        
        }
    }
}

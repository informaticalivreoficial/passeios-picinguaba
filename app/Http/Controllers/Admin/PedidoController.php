<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::orderBy('created_at', 'DESC')->paginate(30);
        return view('admin.pedidos.index', [
            'pedidos' => $pedidos
        ]);
    } 

    public function show($id)
    {
        $pedido = Pedido::where('id', $id)->first();
        return view('admin.pedidos.show', [
            'pedido' => $pedido
        ]);
    } 
}

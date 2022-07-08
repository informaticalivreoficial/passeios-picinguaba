<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\{  
    Configuracoes,  
    Embarcacao,
    Parceiro,
    Passeio,
    Pedido,
    User
};

class ClienteController extends Controller
{
    public function login()
    {
        if(Session()->has('cliente')){
            return redirect()->route('web.passeios');
        }
        $Configuracoes = Configuracoes::where('id', '1')->first();
        //Parceiros
        $parceiros = Parceiro::orderBy('views', 'DESC')->available()->limit(6)->get();
        //Embarcações
        $embarcacoes = Embarcacao::orderBy('created_at', 'DESC')->available()->get();

        $head = $this->seo->render('Meus Passeios Login - ' . $Configuracoes->nomedosite ?? 'Informática Livre',
            'Meus Passeios Login - ' . $Configuracoes->nomedosite,
            route('web.login'),
            Storage::url($Configuracoes->metaimg)
        );

        return view('web.cliente.login',[
            'head' => $head,
            'parceiros' => $parceiros,
            'embarcacoes' => $embarcacoes
        ]);
    }

    public function loginValidate(Request $request)
    {
        if(empty($request->cpf)){
            $json = "<strong>ERRO</strong> por favor preecha o seu CPF!"; 
            return response()->json(['error' => $json]);
        }
        
        if(\App\Helpers\Renato::validaCPF($request->cpf) == false){
            $json = "<strong>ERRO</strong> o CPF informado é inválido!"; 
            return response()->json(['error' => $json]);
        }

        $cpf = \App\Helpers\Renato::limpaCPF_CNPJ($request->cpf);        
        $cliente = User::where('cpf', $cpf)->where('client', 1)->first();

        if($request->session()->get('cliente')){
            $request->session()->pull('cliente', []);
        }
        $request->session()->put('cliente', [$cliente]);
        return response()->json([
            'redirect' => route('web.passeios')
        ]);
    }

    public function passeios(Request $request)
    {
        //$request->session()->pull('cliente', []);
        if(!$request->session()->has('cliente')){
            return redirect()->route('web.home');
        }
        $cliente = $request->session()->get('cliente');        
        $pedidos = Pedido::orderBy('created_at', 'DESC')->where('user_id', $cliente[0]['id'])->get();
        
        $Configuracoes = Configuracoes::where('id', '1')->first();
        //Parceiros
        $parceiros = Parceiro::orderBy('views', 'DESC')->available()->limit(6)->get();
        //Embarcações
        $embarcacoes = Embarcacao::orderBy('created_at', 'DESC')->available()->get();
        //$passeios = Passeio::

        $head = $this->seo->render('Meus Passeios - ' . $Configuracoes->nomedosite ?? 'Informática Livre',
            $Configuracoes->descricao ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.home'),
            Storage::url($Configuracoes->metaimg ?? 'https://informaticalivre.com/media/metaimg.jpg')
        ); 
        
        return view('web.cliente.meus-passeios',[
            'head' => $head,
            'pedidos' => $pedidos,
            'parceiros' => $parceiros,
            'embarcacoes' => $embarcacoes
        ]);
    }
}

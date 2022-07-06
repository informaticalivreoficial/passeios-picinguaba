<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Web\Compra;
use App\Mail\Web\CompraRetorno;
use Illuminate\Support\Facades\Storage;
use App\Models\{
    Configuracoes,
    Post,
    MPException,
    Passeio,
    Parceiro,
    Embarcacao,
    Pedido,
    User
};
use Illuminate\Support\Facades\Hash;
use MercadoPago;
use Carbon\Carbon;

class PagamentoController extends Controller
{
    public function comprar(Request $request, $passeio)
    {
        $Configuracoes = Configuracoes::where('id', '1')->first();
        //Parceiros
        $parceiros = Parceiro::orderBy('views', 'DESC')->available()->limit(6)->get();
        //Embarcações
        $embarcacoes = Embarcacao::orderBy('created_at', 'DESC')->available()->get();
        $paginas = Post::orderBy('created_at', 'DESC')->where('tipo', 'pagina')->postson()->get();
        $passeio = Passeio::where('id', $passeio)->available()->first();

        $head = $this->seo->render('Comprar passeio  ' . $passeio->roteiro->name ?? 'Informática Livre',
            'Comprar passeio  ' . $passeio->roteiro->name,
            route('web.passeios.comprar', ['passeio' => $passeio->id]),
            $passeio->roteiro->cover() ?? Storage::url($Configuracoes->metaimg)
        );

        return view('web.passeios.comprar', [
            'head' => $head,
            'paginas' => $paginas,
            'parceiros' => $parceiros,
            'embarcacoes' => $embarcacoes,
            'passeio' => $passeio
        ]);
    }

    public function carrinhocreate(Request $request)
    {
        if($request->nome == ''){
            $json = "Por favor preencha o campo <strong>Nome</strong>";
            return response()->json(['error' => $json]);
        }
        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            $json = "O campo <strong>Email</strong> está vazio ou não tem um formato válido!";
            return response()->json(['error' => $json]);
        }
        if(validaCPF($request->cpf) != true){
            $json = "O campo <strong>CPF</strong> está vazio ou não tem um formato válido!";
            return response()->json(['error' => $json]);
        }
        if($request->celular == ''){
            $json = "Por favor preencha o campo <strong>Celular</strong>";
            return response()->json(['error' => $json]);
        }
        if($request->datapasseio == ''){
            $json = "Por favor selecione uma <strong>Data</strong> para seu passeio!";
            return response()->json(['error' => $json]);
        }

        if($request->session()->get('cart')){
            $request->session()->pull('cart', []);
        }

        $request->session()->put('cart', [            
            'product_id'      => Hash::make($request->email),
            'id_passeio'      => $request->id_passeio,
            'cliente'         => $request->nome,
            'cliente_celular' => $request->celular,
            'email'           => $request->email,
            'cpf'             => $request->cpf,
            'qtd_adultos'     => $request->adultos,
            'qtd_zerocinco'   => $request->valor_v_zerocinco,
            'qtd_seisdoze'    => $request->valor_v_seisdoze,
            'data_passeio'    => $request->datapasseio,            
        ]);        

        return response()->json([
            'redirect' => route('web.passeios.meucarrinho')
        ]);
    }

    public function meuCarrinho(Request $request)
    {        
        $Configuracoes = Configuracoes::where('id', '1')->first();
        //Paginas
        $paginas = Post::orderBy('created_at', 'DESC')->where('tipo', 'pagina')->postson()->get();
        //Parceiros
        $parceiros = Parceiro::orderBy('views', 'DESC')->available()->limit(6)->get();
        //Embarcações
        $embarcacoes = Embarcacao::orderBy('created_at', 'DESC')->available()->get();
        if(!$request->session()->has('cart')){
            return redirect()->route('web.home');
        }
        
        $cart = $request->session()->get('cart');
        $passeio = Passeio::where('id', $cart['id_passeio'])->first();
        $head = $this->seo->render('Meu Carrinho',
            'Meu Carrinho de Compras',
            route('web.passeios.meucarrinho'),
            Storage::url($Configuracoes->metaimg ?? 'https://informaticalivre.com/media/metaimg.jpg')
        ); 

        return view('web.passeios.carrinho', [
            'head' => $head,
            'paginas' => $paginas,
            'parceiros' => $parceiros,
            'embarcacoes' => $embarcacoes,
            'passeio' => $passeio            
        ]);
    }

    public function paymentsend(Request $request, $slug)
    {
        $Configuracoes = Configuracoes::where('id', '1')->first();        
        MercadoPago\SDK::setAccessToken("TEST-487731692769092-092202-4831466b259a6d94e0f78edb65df113d-192815433");
                
        $payment = new MercadoPago\Payment();
        $payment->transaction_amount = (float)$request->transactionAmount;
        $payment->token = $request->token;
        $payment->description = $request->description;
        $payment->installments = (int)$request->installments;
        $payment->payment_method_id = $request->paymentMethodId;
        $payment->issuer_id = (int)$request->issuer;

        $payer = new MercadoPago\Payer();
        $payer->email = $request->email;
        $payer->identification = array(
            "type" => $request->docType,
            "number" => $request->docNumber
        );
        
        $payment->payer = $payer;
        $payment->save();
        
        $error = new MPException($payment);
        
        if($error->verifyTransaction()['class'] == 'success' || $error->verifyTransaction()['class'] == 'pending_contingency' || $error->verifyTransaction()['class'] == 'pending_review_manual'){
            $user = User::where('email', $request->email)->first();
           
            if(empty($user)){   
                //Cria Cliente
                $cliente = [
                    'name' => $request->name,
                    'cpf' => $request->docNumber,
                    'email' => $request->email,
                    'status' => 1,
                    'celular' => $request->celular,
                    'client' => 'on',
                    'password' => bcrypt($request->name.'0981'),
                    'remember_token' => \Illuminate\Support\Str::random(10),                    
                ];
                $clienteCreate = User::create($cliente);
                $clienteCreate->save();

                //Cria Pedido
                $pedido = [
                    'passeio_id' => $request->id_passeio,
                    'token' => \Illuminate\Support\Str::random(30),
                    'user_id' => $clienteCreate->id,
                    'id_gateway' => $payment->id,
                    'data_compra' => $request->data_compra,
                    'status' => 1,
                    'status_gateway' => $payment->status,
                    'valor' => $request->transactionAmount,
                    'description' => $request->description . '<br> 
                        Adutos: ' . $request->qtd_adultos . ' - ('.($request->qtd_adultos * $request->valor_adulto).')'.'<br>
                        Crianças de 0 a 5 anos: ' . $request->qtd_zerocinco . ' - ('.($request->qtd_zerocinco * substr(str_replace('.', '', str_replace(',', '.', $request->valorCri05)), 0, -2)).')'.'<br>
                        Crianças de 6 a 12 anos: ' . $request->qtd_seisdoze . ' - ('.($request->qtd_seisdoze * substr(str_replace('.', '', str_replace(',', '.', $request->valorCri06)), 0, -2)).')',
                    'total_passageiros' =>  $request->qtd_adultos + $request->qtd_zerocinco + $request->qtd_seisdoze   
                ];
                
                $pedidoCreate = Pedido::create($pedido);
                $pedidoCreate->save();
            }else{         
                
                //Cria Pedido
                $pedido = [
                    'passeio_id' => $request->id_passeio,
                    'token' => \Illuminate\Support\Str::random(30),
                    'user_id' => $user->id,
                    'id_gateway' => $payment->id,
                    'data_compra' => $request->data_compra,
                    'status' => 1,
                    'status_gateway' => $payment->status,
                    'valor' => $request->transactionAmount,
                    'description' => $request->description . '<br> 
                        Adutos: ' . $request->qtd_adultos . ' - ('.($request->qtd_adultos * $request->valor_adulto).')'.'<br>
                        Crianças de 0 a 5 anos: ' . $request->qtd_zerocinco . ' - ('.($request->qtd_zerocinco * substr(str_replace('.', '', str_replace(',', '.', $request->valorCri05)), 0, -2)).')'.'<br>
                        Crianças de 6 a 12 anos: ' . $request->qtd_seisdoze . ' - ('.($request->qtd_seisdoze * substr(str_replace('.', '', str_replace(',', '.', $request->valorCri06)), 0, -2)).')',
                    'total_passageiros' =>  $request->qtd_adultos + $request->qtd_zerocinco + $request->qtd_seisdoze   
                ];

                $pedidoCreate = Pedido::create($pedido);
                $pedidoCreate->save();

                //Cliente para o email
                $cliente = [
                    'name' => $user->name,
                    'cpf' => $request->docNumber,
                    'email' => $request->email,
                    'celular' => $request->celular                    
                ];
            }

            $data = [
                'status' => $payment->status,
                'passeio' => $request->description,
                'token' => $pedidoCreate->token,
                'data_passeio' => $request->data_compra,
                'qtd_adultos' => $request->qtd_adultos,
                'qtd_zerocinco' => $request->qtd_zerocinco,
                'qtd_seisdoze' => $request->qtd_seisdoze,
                'total_passageiros' =>  $request->qtd_adultos + $request->qtd_zerocinco + $request->qtd_seisdoze,
                'valor_adulto' => number_format(($request->valor_adulto * $request->qtd_adultos), 2, ',', '.'),
                'valorCri05' => $request->valorCri05,
                'valorCri06' => $request->valorCri06,
                'total' => number_format(($request->transactionAmount), 2, ',', '.'),
                'sitename' => $Configuracoes->nomedosite,
                'siteemail' => $Configuracoes->email,
            ];

            $request->session()->forget('cart');

            Mail::send(new Compra($data, $cliente));
            Mail::send(new CompraRetorno($data, $cliente));
        }

        return redirect()->route('web.passeios.payment')->with([
            'color' => $error->verifyTransaction()['class'], 'message' => $error->verifyTransaction()['message']
        ]);        
    }

    public function payment(Request $request)
    {
        $Configuracoes = Configuracoes::where('id', '1')->first();
        //Páginas
        $paginas = Post::orderBy('created_at', 'DESC')->where('tipo', 'pagina')->postson()->get();
        //Parceiros
        $parceiros = Parceiro::orderBy('views', 'DESC')->available()->limit(6)->get();
        //Embarcações
        $embarcacoes = Embarcacao::orderBy('created_at', 'DESC')->available()->get();

        $head = $this->seo->render('Comprar passeio',
            'Comprar passeio',
            route('web.passeios.payment'),
            Storage::url($Configuracoes->metaimg ?? 'https://informaticalivre.com/media/metaimg.jpg')
        );
        
        return view('web.passeios.payment', [
            'head' => $head,
            'paginas' => $paginas,
            'parceiros' => $parceiros,
            'embarcacoes' => $embarcacoes,
        ]);
    }
}

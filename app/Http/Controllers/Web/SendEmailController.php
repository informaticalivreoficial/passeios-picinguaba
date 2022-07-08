<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Web\ParceiroSend;
use App\Mail\Web\Atendimento;
use App\Mail\Web\AtendimentoRetorno;
use App\Models\Configuracoes;
use App\Models\Parceiro;

class SendEmailController extends Controller
{
    public function sendEmailParceiro(Request $request)
    {
        $Configuracoes = Configuracoes::where('id', '1')->first();
        $parceiro = Parceiro::where('id', $request->parceiro_id)->first();
        if($request->nome == ''){
            $json = "Por favor preencha o campo <strong>Nome</strong>";
            return response()->json(['error' => $json]);
        }
        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            $json = "O campo <strong>Email</strong> está vazio ou não tem um formato válido!";
            return response()->json(['error' => $json]);
        }
        if($request->mensagem == ''){
            $json = "Por favor preencha sua <strong>Mensagem</strong>";
            return response()->json(['error' => $json]);
        }
        if(!empty($request->bairro) || !empty($request->cidade)){
            $json = "<strong>ERRO</strong> Você está praticando SPAM!"; 
            return response()->json(['error' => $json]);
        }else{

            $data = [
                'sitename' => $parceiro->name,
                'siteemail' => $parceiro->email,
                'reply_name' => $request->nome,
                'reply_email' => $request->email,
                'mensagem' => $request->mensagem,
                'config_site_name' => $Configuracoes->nomedosite
            ];

            $parceiro->email_send_count = $parceiro->email_send_count + 1;
            $parceiro->save();
            
            Mail::send(new ParceiroSend($data));
            
            $json = 'Obrigado '.\App\Helpers\Renato::getPrimeiroNome($request->nome).' sua mensagem foi enviada para nosso parceiro <b>'.$parceiro->name.'</b> com sucesso!'; 
            return response()->json(['sucess' => $json]);
        }
    }

    public function sendEmail(Request $request)
    {
        $Configuracoes = Configuracoes::where('id', '1')->first();
        if($request->nome == ''){
            $json = "Por favor preencha o campo <strong>Nome</strong>";
            return response()->json(['error' => $json]);
        }
        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            $json = "O campo <strong>Email</strong> está vazio ou não tem um formato válido!";
            return response()->json(['error' => $json]);
        }
        if($request->mensagem == ''){
            $json = "Por favor preencha sua <strong>Mensagem</strong>";
            return response()->json(['error' => $json]);
        }
        if(!empty($request->bairro) || !empty($request->cidade)){
            $json = "<strong>ERRO</strong> Você está praticando SPAM!"; 
            return response()->json(['error' => $json]);
        }else{
            $data = [
                'sitename' => $Configuracoes->nomedosite,
                'siteemail' => $Configuracoes->email ?? $Configuracoes->email1,
                'siteemail_cc' => $Configuracoes->email1 ?? $Configuracoes->email,
                'reply_name' => $request->nome,
                'reply_email' => $request->email,
                'mensagem' => $request->mensagem
            ];

            $retorno = [
                'sitename' => $Configuracoes->nomedosite,
                'siteemail' => $Configuracoes->email,
                'reply_name' => $request->nome,
                'reply_email' => $request->email
            ];
            
            Mail::send(new Atendimento($data));
            Mail::send(new AtendimentoRetorno($retorno));
            
            $json = 'Obrigado '.\App\Helpers\Renato::getPrimeiroNome($request->nome).' sua mensagem foi enviada com sucesso!'; 
            return response()->json(['sucess' => $json]);
        }
    }
}

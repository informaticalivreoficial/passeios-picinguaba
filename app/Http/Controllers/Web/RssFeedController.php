<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Configuracoes;
use App\Models\{
    Post,
    Roteiro,
    Parceiro
};

class RssFeedController extends Controller
{
    public function feed()
    {
        //chama as configuracoes do site
        $Configuracoes = Configuracoes::where('id', '1')->first();
        $posts = Post::orderBy('created_at', 'DESC')->where('tipo', 'artigo')->postson()->limit(10)->get();
        $paginas = Post::orderBy('created_at', 'DESC')->where('tipo', 'pagina')->postson()->limit(10)->get();
        $roteiros = Roteiro::orderBy('created_at', 'DESC')->available()->limit(10)->get();
        $parceiros = Parceiro::orderBy('created_at', 'DESC')->available()->limit(10)->get();

        return response()->view('web.feed', [
            'posts' => $posts,
            'paginas' => $paginas,
            'roteiros' => $roteiros,
            'parceiros' => $parceiros,
            'Configuracoes' => $Configuracoes
        ])->header('Content-Type', 'application/xml');
        
    }
}

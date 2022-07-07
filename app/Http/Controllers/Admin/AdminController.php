<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Analytics;
use Spatie\Analytics\Period;
use App\Models\{
    CatPost,
    Embarcacao,
    Passeio,
    Roteiro,
    Parceiro,
    User,
    Pedido,
    Post
};

class AdminController extends Controller
{
    public function home()
    {
        //Users
        $time = User::where('admin', 1)->orWhere('editor', 1)->count();
        $usersAvailable = User::where('client', 1)->available()->count();
        $usersUnavailable = User::where('client', 1)->unavailable()->count();
        //Artigos
        $postsArtigos = Post::where('tipo', 'artigo')->count();
        $postsNoticias = Post::where('tipo', 'noticia')->count();
        $postsPaginas = Post::where('tipo', 'pagina')->count();
        $artigosTop = Post::orderBy('views', 'DESC')
                ->where('tipo', 'artigo')
                ->limit(6)
                ->postson()   
                ->get();
        $totalViewsArtigos = Post::orderBy('views', 'DESC')
                ->where('tipo', 'artigo')
                ->postson()
                ->limit(6)
                ->get()
                ->sum('views');
        $paginasTop = Post::orderBy('views', 'DESC')
                ->where('tipo', 'pagina')
                ->limit(6)
                ->postson()   
                ->get();
        $totalViewsPaginas = Post::orderBy('views', 'DESC')
                ->where('tipo', 'pagina')
                ->postson()
                ->limit(6)
                ->get()
                ->sum('views');

        //Parceiros
        $parceirosAvailable = Parceiro::available()->count();
        $parceirosUnavailable = Parceiro::unavailable()->count();
        $parceirosTotal = Parceiro::all()->count();
        //Parceiros Mais
        $parceirosTop = Parceiro::orderBy('views', 'DESC')
                ->limit(6)->available()->get();
        $totalviewsparceiros = Parceiro::orderBy('views', 'DESC')
                ->available()
                ->limit(6)
                ->get()
                ->sum('views');
        //Roteiros
        $roteirosAvailable = Roteiro::available()->count();
        $roteirosUnavailable = Roteiro::unavailable()->count();
        $roteirosTotal = Roteiro::all()->count();
        //Roteiros Mais
        $roteirosTop = Roteiro::orderBy('views', 'DESC')
                ->limit(6)->available()->get();
        $totalviewsroteiros = Roteiro::orderBy('views', 'DESC')
                ->available()
                ->limit(6)
                ->get()
                ->sum('views');  
        //Passeios
        $passeiosAvailable = Passeio::available()->count();
        $passeiosUnavailable = Passeio::unavailable()->count();
        $passeiosTotal = Passeio::all()->count();
        //Embarcações
        $embarcacoesAvailable = Embarcacao::available()->count();
        $embarcacoesUnavailable = Embarcacao::unavailable()->count();
        $embarcacoesTotal = Embarcacao::all()->count();
        //Pedidos
        $pedidosApproved = Pedido::approved()->count();
        $pedidosInprocess = Pedido::inprocess()->count();
        $pedidosRejected = Pedido::rejected()->count();

        //Analitcs
        $visitasHoje = Analytics::fetchMostVisitedPages(Period::days(1));
        $visitas365 = Analytics::fetchTotalVisitorsAndPageViews(Period::months(5));
        $top_browser = Analytics::fetchTopBrowsers(Period::months(5));

        $analyticsData = Analytics::performQuery(
            Period::months(5),
               'ga:sessions',
               [
                   'metrics' => 'ga:sessions, ga:visitors, ga:pageviews',
                   'dimensions' => 'ga:yearMonth'
               ]
         );     
         
        return view('admin.dashboard',[
            'time' => $time,
            'usersAvailable' => $usersAvailable,
            'usersUnavailable' => $usersUnavailable,
            //Artigos
            'postsArtigos' => $postsArtigos,
            'postsNoticias' => $postsNoticias,
            'postsPaginas' => $postsPaginas,
            'artigosTop' => $artigosTop,
            'artigostotalviews' => $totalViewsArtigos,
            //Roteiros
            'roteirosAvailable' => $roteirosAvailable,
            'roteirosUnavailable' => $roteirosUnavailable,
            'roteirosTotal' => $roteirosTotal,            
            'roteirosTop' => $roteirosTop,
            'totalviewsroteiros' => $totalviewsroteiros,
            //Parceiros
            'parceirosTop' => $parceirosTop,
            'totalviewsparceiros' => $totalviewsparceiros,
            //Passeios
            'passeiosAvailable' => $passeiosAvailable,
            'passeiosUnavailable' => $passeiosUnavailable,
            'passeiosTotal' => $passeiosTotal,
            //Embarcações
            'embarcacoesAvailable' => $embarcacoesAvailable,
            'embarcacoesUnavailable' => $embarcacoesUnavailable,
            'embarcacoesTotal' => $embarcacoesTotal,
            //Pedidos
            'pedidosApproved' => $pedidosApproved,
            'pedidosInprocess' => $pedidosInprocess,
            'pedidosRejected' => $pedidosRejected,
            //Analytics
            'visitasHoje' => $visitasHoje,
            //'visitas365' => $visitas365,
            'analyticsData' => $analyticsData,
            'top_browser' => $top_browser
        ]);
    }
}

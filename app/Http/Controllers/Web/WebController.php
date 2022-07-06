<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Web\Compra;
use App\Mail\Web\CompraRetorno;
use App\Models\Configuracoes;
use Illuminate\Support\Facades\Storage;
use App\Models\{
    Post,
    CatPost,
    Embarcacao,
    MPException,
    Newsletter,
    Roteiro,
    Passeio,
    Parceiro,
    Pedido,
    Slide,
    User
};
use Illuminate\Support\Facades\Hash;
use MercadoPago;
use Carbon\Carbon;

class WebController extends Controller
{
    
    public function home()
    {
        $Configuracoes = Configuracoes::where('id', '1')->first();
        $paginas = Post::orderBy('created_at', 'DESC')->where('tipo', 'pagina')->postson()->get();
        $artigos = Post::orderBy('created_at', 'DESC')->where('tipo', 'artigo')->postson()->limit(4)->get();
        $passeios = Passeio::orderBy('created_at', 'DESC')->available()->venda()->limit(6)->get();
        $roteiros = Roteiro::orderBy('created_at', 'DESC')->available()->get();
        //Parceiros
        $parceiros = Parceiro::orderBy('views', 'DESC')->available()->limit(6)->get();
        //Embarcações
        $embarcacoes = Embarcacao::orderBy('created_at', 'DESC')->available()->get();
        $slides = Slide::orderBy('created_at', 'DESC')->available()->where('expira', '>=', Carbon::now())->get();
        $head = $this->seo->render($Configuracoes->nomedosite ?? 'Informática Livre',
            $Configuracoes->descricao ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.home'),
            Storage::url($Configuracoes->metaimg ?? 'https://informaticalivre.com/media/metaimg.jpg')
        ); 

		return view('web.home',[
            'head' => $head,
            'artigos' => $artigos,
            'paginas' => $paginas,
            'passeios' => $passeios,
            'parceiros' => $parceiros,
            'embarcacoes' => $embarcacoes,
            'roteiros' => $roteiros,
            'slides' => $slides
		]);
    }

    public function reservarRoteiro(Request $request)
    {
        $roteiro = Roteiro::where('slug', $request->slug)->available()->first();
        $json = ([
            'redirect' => route('web.roteiro',['slug' => $roteiro->slug])
        ]);
        return response()->json($json);
    }

    public function artigo(Request $request)
    {
        $Configuracoes = Configuracoes::where('id', '1')->first();
        $paginas = Post::orderBy('created_at', 'DESC')->where('tipo', 'pagina')->postson()->get();
        $post = Post::where('slug', $request->slug)->where('tipo', 'artigo')->postson()->first();
        //Parceiros
        $parceiros = Parceiro::orderBy('views', 'DESC')->available()->limit(6)->get();
        //Embarcações
        $embarcacoes = Embarcacao::orderBy('created_at', 'DESC')->available()->get();
        
        $categorias = CatPost::orderBy('titulo', 'ASC')
            ->where('tipo', 'artigo')
            ->get();
        $postsMais = Post::orderBy('views', 'DESC')->where('id', '!=', $post->id)->limit(3)->postson()->get();
        
        $post->views = $post->views + 1;
        $post->save();

        $head = $this->seo->render($post->titulo . ' - Blog ' . $Configuracoes->nomedosite ?? 'Informática Livre',
            $post->titulo,
            route('web.blog.artigo', ['slug' => $post->slug]),
            $post->cover() ?? Storage::url($Configuracoes->metaimg)
        );

        return view('web.blog.artigo', [
            'head' => $head,
            'paginas' => $paginas,
            'post' => $post,
            'parceiros' => $parceiros,
            'embarcacoes' => $embarcacoes,
            'postsMais' => $postsMais,
            'categorias' => $categorias
        ]);
    }

    public function artigos()
    {
        $Configuracoes = Configuracoes::where('id', '1')->first();
        $paginas = Post::orderBy('created_at', 'DESC')->where('tipo', 'pagina')->postson()->get();
        $posts = Post::orderBy('created_at', 'DESC')->where('tipo', '=', 'artigo')->postson()->paginate(10);
        //Parceiros
        $parceiros = Parceiro::orderBy('views', 'DESC')->available()->limit(6)->get();
        //Embarcações
        $embarcacoes = Embarcacao::orderBy('created_at', 'DESC')->available()->get();
        $categorias = CatPost::orderBy('titulo', 'ASC')->where('tipo', 'artigo')->get();
        $head = $this->seo->render('Blog - ' . $Configuracoes->nomedosite ?? 'Informática Livre',
            'Blog - ' . $Configuracoes->nomedosite,
            route('web.blog.artigos'),
            Storage::url($Configuracoes->metaimg)
        );
        return view('web.blog.artigos', [
            'head' => $head,
            'paginas' => $paginas,
            'posts' => $posts,
            'parceiros' => $parceiros,
            'embarcacoes' => $embarcacoes,
            'categorias' => $categorias
        ]);
    }

    public function categoria(Request $request)
    {
        $Configuracoes = Configuracoes::where('id', '1')->first();
        $paginas = Post::orderBy('created_at', 'DESC')->where('tipo', 'pagina')->postson()->get();
        //Parceiros
        $parceiros = Parceiro::orderBy('views', 'DESC')->available()->limit(6)->get();
        //Embarcações
        $embarcacoes = Embarcacao::orderBy('created_at', 'DESC')->available()->get();
        $categoria = CatPost::where('slug', '=', $request->slug)->first();
        $categorias = CatPost::orderBy('titulo', 'ASC')
                    ->where('tipo', 'artigo')
                    ->where('id', '!=', $categoria->id)->get();
        $posts = Post::orderBy('created_at', 'DESC')->where('categoria', '=', $categoria->id)->postson()->paginate(15);
        $head = $this->seo->render($categoria->titulo . ' - Blog - ' . $Configuracoes->nomedosite ?? 'Informática Livre',
            $categoria->titulo . ' - Blog - ' . $Configuracoes->nomedosite,
            route('web.blog.categoria', ['slug' => $request->slug]),
            Storage::url($Configuracoes->metaimg)
        );
        
        return view('web.blog.categoria', [
            'head' => $head,
            'paginas' => $paginas,
            'posts' => $posts,
            'parceiros' => $parceiros,
            'embarcacoes' => $embarcacoes,
            'categoria' => $categoria,
            'categorias' => $categorias
        ]);
    }

    public function searchBlog(Request $request)
    {
        $Configuracoes = Configuracoes::where('id', '1')->first();
        $paginas = Post::orderBy('created_at', 'DESC')->where('tipo', 'pagina')->postson()->get();
        $filters = $request->only('filter');

        $posts = Post::where(function($query) use ($request){
            if($request->filter){
                $query->orWhere('titulo', 'LIKE', "%{$request->filter}%");
                $query->orWhere('content', 'LIKE', "%{$request->filter}%");
            }
        })->postson()->paginate(10);

        $head = $this->seo->render('Pesquisa por ' . $request->filter ?? 'Informática Livre',
            'Blog - ' . $Configuracoes->nomedosite,
            route('web.blog.artigos'),
            Storage::url($Configuracoes->metaimg)
        );
        
        return view('web.blog.artigos',[
            'head' => $head,
            'paginas' => $paginas,
            'posts' => $posts,
            'filters' => $filters
        ]);
    }

    public function roteiros()
    {
        $Configuracoes = Configuracoes::where('id', '1')->first();
        $paginas = Post::orderBy('created_at', 'DESC')->where('tipo', 'pagina')->postson()->get();
        $roteiros = Roteiro::orderBy('created_at', 'DESC')->available()->paginate(9);
        //Parceiros
        $parceiros = Parceiro::orderBy('views', 'DESC')->available()->limit(6)->get();
        //Embarcações
        $embarcacoes = Embarcacao::orderBy('created_at', 'DESC')->available()->get();
        $head = $this->seo->render('Roteiros - ' . $Configuracoes->nomedosite ?? 'Informática Livre',
            'Roteiros - ' . $Configuracoes->nomedosite,
            route('web.roteiros'),
            Storage::url($Configuracoes->metaimg)
        );
        return view('web.roteiros', [
            'head' => $head,
            'paginas' => $paginas,
            'parceiros' => $parceiros,
            'embarcacoes' => $embarcacoes,
            'roteiros' => $roteiros
        ]);
    }

    public function roteiro(Request $request)
    {
        $Configuracoes = Configuracoes::where('id', '1')->first();
        $paginas = Post::orderBy('created_at', 'DESC')->where('tipo', 'pagina')->postson()->get();
        $roteiro = Roteiro::where('slug', $request->slug)->available()->first(); 
        //Parceiros
        $parceiros = Parceiro::orderBy('views', 'DESC')->available()->limit(6)->get();
        //Embarcações
        $embarcacoes = Embarcacao::orderBy('created_at', 'DESC')->available()->get();
        $roteiro->views = $roteiro->views + 1;
        $roteiro->save();

        $passeios = Passeio::where('roteiro_id', $roteiro->id)->get();
        $pedidos = Pedido::all();

        $head = $this->seo->render($roteiro->name . ' - Roteiros ' . $Configuracoes->nomedosite ?? 'Informática Livre',
            $roteiro->name . ' - Roteiros ' . $Configuracoes->nomedosite,
            route('web.roteiro', ['slug' => $roteiro->slug]),
            $roteiro->cover() ?? Storage::url($Configuracoes->metaimg)
        );

        return view('web.roteiro', [
            'head' => $head,
            'paginas' => $paginas,
            'roteiro' => $roteiro,
            'passeios' => $passeios,
            'parceiros' => $parceiros,
            'embarcacoes' => $embarcacoes,
            'pedidos' => $pedidos
        ]);
    }
    
    public function voucher($token)
    {        
        $pedido = Pedido::where('token', $token)->first();
        $paginas = Post::orderBy('created_at', 'DESC')->where('tipo', 'pagina')->postson()->get();
        $Configuracoes = Configuracoes::where('id', '1')->first();
        $head = $this->seo->render('Voucher',
            'Voucher',
            route('web.passeios.voucher', ['token' => $pedido->token]),
            Storage::url($Configuracoes->metaimg ?? 'https://informaticalivre.com/media/metaimg.jpg')
        );

        return view('web.passeios.faturaprint', [
            'head' => $head,
            'paginas' => $paginas,
            'pedido' => $pedido
        ]);
    }
    
    public function atendimento()
    {
        $Configuracoes = Configuracoes::where('id', '1')->first();
        $paginas = Post::orderBy('created_at', 'DESC')->where('tipo', 'pagina')->postson()->get();
        //Parceiros
        $parceiros = Parceiro::orderBy('views', 'DESC')->available()->limit(6)->get();
        $head = $this->seo->render('Atendimento - ' . $Configuracoes->nomedosite,
            'Nossa equipe está pronta para melhor atender as demandas de nossos clientes!',
            route('web.atendimento'),
            Storage::url($Configuracoes->metaimg ?? 'https://informaticalivre.com/media/metaimg.jpg')
        );        

        return view('web.atendimento', [
            'head' => $head,
            'paginas' => $paginas,
            'Configuracoes' => $Configuracoes,            
            'parceiros' => $parceiros            
        ]);
    }

    public function embarcacoes()
    {
        $Configuracoes = Configuracoes::where('id', '1')->first();
        $paginas = Post::orderBy('created_at', 'DESC')->where('tipo', 'pagina')->postson()->get();
        $embarcacoes = Embarcacao::orderBy('created_at', 'DESC')->available()->paginate(9);
        //Parceiros
        $parceiros = Parceiro::orderBy('views', 'DESC')->available()->limit(6)->get();
        $head = $this->seo->render('Embarcações - ' . $Configuracoes->nomedosite ?? 'Informática Livre',
            'Embarcações - ' . $Configuracoes->nomedosite,
            route('web.embarcacoes'),
            Storage::url($Configuracoes->metaimg)
        );
        return view('web.embarcacoes.embarcacoes',[
            'head' => $head,
            'paginas' => $paginas,
            'parceiros' => $parceiros,
            'embarcacoes' => $embarcacoes
        ]);
    }

    public function embarcacao(Request $request)
    {
        $Configuracoes = Configuracoes::where('id', '1')->first();
        $paginas = Post::orderBy('created_at', 'DESC')->where('tipo', 'pagina')->postson()->get();
        $embarcacao = Embarcacao::where('slug', $request->slug)->first();
        $embarcacoes = Embarcacao::orderBy('created_at', 'DESC')->available()->paginate(9);
        //Parceiros
        $parceiros = Parceiro::orderBy('views', 'DESC')->available()->limit(6)->get();
        $embarcacao->views = $embarcacao->views + 1;
        $embarcacao->save();

        $head = $this->seo->render('Embarcação - ' . $embarcacao->name . ' - ' . $Configuracoes->nomedosite ?? 'Informática Livre',
            'Embarcação - ' . $embarcacao->name . ' - ' . $Configuracoes->nomedosite,
            route('web.embarcacao', ['slug' => $embarcacao->slug]),
            Storage::url($Configuracoes->metaimg)
        );
        return view('web.embarcacoes.embarcacao',[
            'head' => $head,
            'paginas' => $paginas,
            'parceiros' => $parceiros,
            'embarcacoes' => $embarcacoes,
            'embarcacao' => $embarcacao
        ]);
    }

    public function sendNewsletter(Request $request)
    {
        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            $json = "O campo <strong>Email</strong> está vazio ou não tem um formato válido!";
            return response()->json(['error' => $json]);
        }
        if(!empty($request->bairro) || !empty($request->cidade)){
            $json = "<strong>ERRO</strong> Você está praticando SPAM!"; 
            return response()->json(['error' => $json]);
        }else{   
            $validaNews = Newsletter::where('email', $request->email)->first();            
            if(!empty($validaNews)){
                Newsletter::where('email', $request->email)->update(['status' => 1]);
                $json = "Seu e-mail já está cadastrado!"; 
                return response()->json(['sucess' => $json]);
            }else{
                $NewsletterCreate = Newsletter::create($request->all());
                $NewsletterCreate->save();
                $json = "Obrigado Cadastrado com sucesso!"; 
                return response()->json(['sucess' => $json]);
            }            
        }
    }

    public function pagina(Request $request)
    {
        $Configuracoes = Configuracoes::where('id', '1')->first();
        $paginas = Post::orderBy('created_at', 'DESC')->where('tipo', 'pagina')->postson()->get();
        $pagina = Post::where('slug', $request->slug)->where('tipo', 'pagina')->first();

        $pagina->views = $pagina->views + 1;
        $pagina->save();

        $head = $this->seo->render($pagina->titulo . ' - ' . $Configuracoes->nomedosite ?? 'Informática Livre',
            $pagina->titulo . ' - ' . $Configuracoes->nomedosite,
            route('web.pagina', ['slug' => $pagina->slug]),
            $pagina->cover() ?? Storage::url($Configuracoes->metaimg)
        );

        return view('web.pagina',[
            'head' => $head,
            'paginas' => $paginas,
            'pagina' => $pagina
        ]);
    }

    public function politica()
    {
        $Configuracoes = Configuracoes::where('id', '1')->first();
        $paginas = Post::orderBy('created_at', 'DESC')->where('tipo', 'pagina')->postson()->get();
        //Parceiros
        $parceiros = Parceiro::orderBy('views', 'DESC')->available()->limit(6)->get();
        //Embarcações
        $embarcacoes = Embarcacao::orderBy('created_at', 'DESC')->available()->get();
        $head = $this->seo->render('Política de Privacidade - ' . $Configuracoes->nomedosite ?? 'Informática Livre',
            ' Política de Privacidade - ' . $Configuracoes->nomedosite,
            route('web.politica'),
            Storage::url($Configuracoes->metaimg)
        );

        return view('web.politica',[
            'head' => $head,
            'pagina' => $paginas,
            'parceiros' => $parceiros,
            'embarcacoes' => $embarcacoes
        ]);
    }

    public function parceiros()
    {
        $Configuracoes = Configuracoes::where('id', '1')->first();
        $parceiros = Parceiro::orderBy('created_at', 'DESC')->available()->paginate(12);
        //Embarcações
        $embarcacoes = Embarcacao::orderBy('created_at', 'DESC')->available()->get();
        $head = $this->seo->render('Parceiros - ' . $Configuracoes->nomedosite ?? 'Informática Livre',
            'Parceiros - ' . $Configuracoes->nomedosite,
            route('web.parceiros'),
            Storage::url($Configuracoes->metaimg)
        );

        return view('web.parceiros',[
            'head' => $head,
            'parceiros' => $parceiros,
            'embarcacoes' => $embarcacoes
        ]);
    }

    public function parceiro($slug)
    {
        $Configuracoes = Configuracoes::where('id', '1')->first();
        $parceiro = Parceiro::where('slug', $slug)->available()->first();
        $roteiros = Roteiro::orderBy('created_at', 'DESC')->limit(6)->get();
        //Embarcações
        $embarcacoes = Embarcacao::orderBy('created_at', 'DESC')->available()->get();
        $parceiro->views = $parceiro->views + 1;
        $parceiro->save();
        
        $head = $this->seo->render($parceiro->name . ' - ' . $Configuracoes->nomedosite ?? 'Informática Livre',
            $parceiro->name . ' - ' . $Configuracoes->nomedosite,
            route('web.parceiro',['slug' => $parceiro->slug]),
            $parceiro->metaimg() ?? Storage::url($Configuracoes->metaimg)
        );

        return view('web.parceiro',[
            'head' => $head,
            'parceiro' => $parceiro,
            'roteiros' => $roteiros,
            'embarcacoes' => $embarcacoes
        ]);
    }
}

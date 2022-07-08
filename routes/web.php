<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EmailController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CatPostController;
use App\Http\Controllers\Admin\PasseioController;
use App\Http\Controllers\Admin\RoteiroController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\EmbarcacaoController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\ParceiroController;
use App\Http\Controllers\Admin\PedidoController;
use App\Http\Controllers\Admin\SitemapController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Web\ClienteController;
use App\Http\Controllers\Web\RssFeedController;
use App\Http\Controllers\Web\WebController;
use App\Http\Controllers\Web\SendEmailController;
use App\Http\Controllers\Web\PagamentoController;

//use Illuminate\Mail\Markdown;

Route::group(['namespace' => 'Web', 'as' => 'web.'], function () {
    
    /** Página Inicial */   
    //Route::get('/', 'WebController@home')->name('home');
    Route::get('/', [WebController::class, 'home'])->name('home');
    Route::post('reservar-roteiro', [WebController::class, 'reservarRoteiro'])->name('roteiro.do'); 

    //** Página Destaque */
    Route::get('/destaque', 'WebController@spotlight')->name('spotlight');
    
    //** Página Inicial */
    Route::match(['post', 'get'], '/filtro', 'WebController@filter')->name('filter');

    //***************************** Cliente ********************************************/
    Route::get('/cliente/login', [ClienteController::class, 'login'])->name('login');
    Route::post('/cliente/login', [ClienteController::class, 'loginValidate'])->name('login.do');
    Route::get('/cliente/meus-passeios', [ClienteController::class, 'passeios'])->name('passeios');
   
    //**************************** Página Inicial ********************************************/
    Route::get('/atendimento', [WebController::class, 'atendimento'])->name('atendimento');
    Route::get('/sendEmail', [SendEmailController::class, 'sendEmail'])->name('sendEmail');
    Route::get('/sendNewsletter', [WebController::class, 'sendNewsletter'])->name('sendNewsletter');

    //****************************** Política de Privacidade ******************************/
    Route::get('/politica-de-privacidade', [WebController::class, 'politica'])->name('politica');

    //****************************** Páginas *********************************************/
    Route::get('/pagina/{slug}', [WebController::class, 'pagina'])->name('pagina');

    //****************************** Parceiros *********************************************/
    Route::get('/sendEmailParceiro', [SendEmailController::class, 'sendEmailParceiro'])->name('sendEmailParceiro');
    Route::get('/parceiro/{slug}', [WebController::class, 'parceiro'])->name('parceiro');
    Route::get('/parceiros', [WebController::class, 'parceiros'])->name('parceiros');

    //****************************** Blog ***********************************************/
    Route::get('/blog/artigo/{slug}', [WebController::class, 'artigo'])->name('blog.artigo');
    Route::get('/blog/categoria/{slug}', [WebController::class, 'categoria'])->name('blog.categoria');
    Route::get('/blog/artigos', [WebController::class, 'artigos'])->name('blog.artigos');
    Route::match(['get', 'post'],'/blog/pesquisar', [WebController::class, 'searchBlog'])->name('blog.searchBlog');

    //****************************** Notícias *******************************************/
    Route::get('/noticia/{slug}', 'WebController@noticia')->name('noticia');
    Route::get('/noticias', 'WebController@noticias')->name('noticias');

    //****************************** Roteiros *******************************************/
    Route::get('/roteiro/{slug}', [WebController::class, 'roteiro'])->name('roteiro');
    Route::get('/roteiros', [WebController::class, 'roteiros'])->name('roteiros');

    //****************************** Embarcações *******************************************/
    Route::get('/embarcacao/{slug}', [WebController::class, 'embarcacao'])->name('embarcacao');
    Route::get('/embarcacoes', [WebController::class, 'embarcacoes'])->name('embarcacoes');

    ///****************************** Passeios *******************************************/
    Route::get('/passeios/comprar/{passeio}', [PagamentoController::class, 'comprar'])->name('passeios.comprar');
    Route::get('/passeios/carrinhocreate', [PagamentoController::class, 'carrinhocreate'])->name('passeios.carrinhocreate');
    Route::get('/passeios/meu-carrinho', [PagamentoController::class, 'meuCarrinho'])->name('passeios.meucarrinho');
    Route::match(['post', 'get'], '/passeios/{slug}/Payment', [PagamentoController::class, 'paymentsend'])->name('passeios.paymentsend');
    Route::get('/passeios/payment', [PagamentoController::class, 'payment'])->name('passeios.payment');
    Route::get('/passeios/notifications', [WebController::class, 'notifications'])->name('passeios.notifications');
    Route::get('/passeios/voucher/{token}', [WebController::class, 'voucher'])->name('passeios.voucher');

    //****************************** Páginas *******************************************/
    Route::get('/pagina/{slug}', 'WebController@pagina')->name('pagina');
    Route::get('/paginas', 'WebController@paginas')->name('paginas');

    //** Pesquisa */
    Route::match(['post', 'get'], '/pesquisa', 'WebController@pesquisa')->name('pesquisa');

    //** FEED */    
    Route::get('feed', [RssFeedController::class, 'feed'])->name('feed');
    

});

Route::prefix('admin')->middleware('auth')->group( function(){

    //******************************* Newsletter *********************************************/
    Route::match(['post', 'get'], 'listas/padrao', [NewsletterController::class, 'padraoMark'])->name('listas.padrao');
    Route::get('listas/set-status', [NewsletterController::class, 'listaSetStatus'])->name('listas.listaSetStatus');
    Route::get('listas/delete', [NewsletterController::class, 'listaDelete'])->name('listas.delete');
    Route::delete('listas/deleteon', [NewsletterController::class, 'listaDeleteon'])->name('listas.deleteon');
    Route::put('listas/{id}', [NewsletterController::class, 'listasUpdate'])->name('listas.update');
    Route::get('listas/{id}/editar', [NewsletterController::class, 'listasEdit'])->name('listas.edit');
    Route::get('listas/cadastrar', [NewsletterController::class, 'listasCreate'])->name('listas.create');
    Route::post('listas/store', [NewsletterController::class, 'listasStore'])->name('listas.store');
    Route::get('listas', [NewsletterController::class, 'listas'])->name('listas');

    Route::put('listas/email/{id}', [NewsletterController::class, 'newsletterUpdate'])->name('listas.newsletter.update');
    Route::get('listas/email/{id}/edit', [NewsletterController::class, 'newsletterEdit'])->name('listas.newsletter.edit');
    Route::get('listas/email/cadastrar', [NewsletterController::class, 'newsletterCreate'])->name('lista.newsletter.create');
    Route::post('listas/email/store', [NewsletterController::class, 'newsletterStore'])->name('listas.newsletter.store');
    Route::get('listas/emails/categoria/{categoria}', [NewsletterController::class, 'newsletters'])->name('lista.newsletters');

    //******************* Slides ************************************************/
    Route::get('slides/set-status', [SlideController::class, 'slideSetStatus'])->name('slides.slideSetStatus');
    Route::get('slides/delete', [SlideController::class, 'delete'])->name('slides.delete');
    Route::delete('slides/deleteon', [SlideController::class, 'deleteon'])->name('slides.deleteon');
    Route::put('slides/{slide}', [SlideController::class, 'update'])->name('slides.update');
    Route::get('slides/{slide}/edit', [SlideController::class, 'edit'])->name('slides.edit');
    Route::get('slides/create', [SlideController::class, 'create'])->name('slides.create');
    Route::post('slides/store', [SlideController::class, 'store'])->name('slides.store');
    Route::get('slides', [SlideController::class, 'index'])->name('slides.index');
    
    //******************** Pedidos *********************************************/
    Route::get('pedidos/show/{id}', [PedidoController::class, 'show'])->name('pedidos.show');
    Route::get('pedidos', [PedidoController::class, 'index'])->name('pedidos.index');

    //******************** Parceiros *********************************************/
    Route::match(['post', 'get'], 'parceiros/fetchCity', [ParceiroController::class, 'fetchCity'])->name('parceiros.fetchCity');
    Route::get('parceiros/set-status', [ParceiroController::class, 'parceiroSetStatus'])->name('parceiros.parceiroSetStatus');
    Route::post('parceiros/image-set-cover', [ParceiroController::class, 'imageSetCover'])->name('parceiros.imageSetCover');
    Route::delete('parceiros/image-remove', [ParceiroController::class, 'imageRemove'])->name('parceiros.imageRemove');
    Route::delete('parceiros/deleteon', [ParceiroController::class, 'deleteon'])->name('parceiros.deleteon');
    Route::get('parceiros/delete', [ParceiroController::class, 'delete'])->name('parceiros.delete');
    Route::put('parceiros/{id}', [ParceiroController::class, 'update'])->name('parceiros.update');
    Route::get('parceiros/{id}/edit', [ParceiroController::class, 'edit'])->name('parceiros.edit');
    Route::get('parceiros/create', [ParceiroController::class, 'create'])->name('parceiros.create');
    Route::post('parceiros/store', [ParceiroController::class, 'store'])->name('parceiros.store');
    Route::get('parceiros', [ParceiroController::class, 'index'])->name('parceiros.index');

    //******************** Passeios *********************************************/
    Route::match(['post', 'get'], 'passeios/fetchCity', [PasseioController::class, 'fetchCity'])->name('passeios.fetchCity');
    Route::get('passeios/set-status', [PasseioController::class, 'passeioSetStatus'])->name('passeios.passeioSetStatus');
    Route::delete('passeios/deleteon', [PasseioController::class, 'deleteon'])->name('passeios.deleteon');
    Route::get('passeios/delete', [PasseioController::class, 'delete'])->name('passeios.delete');
    Route::put('passeios/{id}', [PasseioController::class, 'update'])->name('passeios.update');
    Route::get('passeios/{id}/edit', [PasseioController::class, 'edit'])->name('passeios.edit');
    Route::get('passeios/create', [PasseioController::class, 'create'])->name('passeios.create');
    Route::post('passeios/store', [PasseioController::class, 'store'])->name('passeios.store');
    Route::get('passeios', [PasseioController::class, 'index'])->name('passeios.index');

    //******************** Roteiros *********************************************/
    Route::match(['get', 'post'], 'roteiros/pesquisa', [RoteiroController::class, 'search'])->name('roteiros.search');
    Route::get('roteiros/marcadagua', [RoteiroController::class, 'imageWatermark'])->name('roteiros.marcadagua');
    Route::get('roteiros/set-status', [RoteiroController::class, 'roteiroSetStatus'])->name('roteiros.roteiroSetStatus');
    Route::match(['post', 'get'], 'roteiros/fetchCity', [RoteiroController::class, 'fetchCity'])->name('roteiros.fetchCity');
    Route::post('roteiros/image-set-cover', [RoteiroController::class, 'imageSetCover'])->name('roteiros.imageSetCover');
    Route::delete('roteiros/image-remove', [RoteiroController::class, 'imageRemove'])->name('roteiros.imageRemove');
    Route::delete('roteiros/deleteon', [RoteiroController::class, 'deleteon'])->name('roteiros.deleteon');
    Route::get('roteiros/delete', [RoteiroController::class, 'delete'])->name('roteiros.delete');
    Route::get('roteiros/qrcode', [RoteiroController::class, 'qrCode'])->name('roteiros.qrCode');
    Route::put('roteiros/{id}', [RoteiroController::class, 'update'])->name('roteiros.update');
    Route::get('roteiros/{id}/edit', [RoteiroController::class, 'edit'])->name('roteiros.edit');
    Route::get('roteiros/create', [RoteiroController::class, 'create'])->name('roteiros.create');
    Route::post('roteiros/store', [RoteiroController::class, 'store'])->name('roteiros.store');
    Route::get('roteiros', [RoteiroController::class, 'index'])->name('roteiros.index');

    //****************************** Embarcações *******************************************/
    Route::get('embarcacoes/set-status', [EmbarcacaoController::class, 'embarcacaoSetStatus'])->name('embarcacoes.embarcacaoSetStatus');
    Route::post('embarcacoes/image-set-cover', [EmbarcacaoController::class, 'imageSetCover'])->name('embarcacoes.imageSetCover');
    Route::delete('embarcacoes/image-remove', [EmbarcacaoController::class, 'imageRemove'])->name('embarcacoes.imageRemove');
    Route::delete('embarcacoes/deleteon', [EmbarcacaoController::class, 'deleteon'])->name('embarcacoes.deleteon');
    Route::get('embarcacoes/delete', [EmbarcacaoController::class, 'delete'])->name('embarcacoes.delete');
    Route::get('embarcacoes/qrcode', [EmbarcacaoController::class, 'qrCode'])->name('embarcacoes.qrCode');
    Route::put('embarcacoes/{id}', [EmbarcacaoController::class, 'update'])->name('embarcacoes.update');
    Route::get('embarcacoes/{id}/edit', [EmbarcacaoController::class, 'edit'])->name('embarcacoes.edit');
    Route::get('embarcacoes/create', [EmbarcacaoController::class, 'create'])->name('embarcacoes.create');
    Route::post('embarcacoes/store', [EmbarcacaoController::class, 'store'])->name('embarcacoes.store');
    Route::get('/embarcacoes', [EmbarcacaoController::class, 'index'])->name('embarcacoes.index');

    //******************** Sitemap *********************************************/
    Route::get('gerarxml', [SitemapController::class, 'gerarxml'])->name('admin.gerarxml');

    //******************** Configurações ***************************************/
    Route::match(['post', 'get'], 'configuracoes/fetchCity', [ConfigController::class, 'fetchCity'])->name('configuracoes.fetchCity');
    Route::put('configuracoes/{config}', [ConfigController::class, 'update'])->name('configuracoes.update');
    Route::get('configuracoes', [ConfigController::class, 'editar'])->name('configuracoes.editar');

    //********************* Categorias para Posts *******************************/
    Route::get('categorias/delete', [CatPostController::class, 'delete'])->name('categorias.delete');
    Route::delete('categorias/deleteon', [CatPostController::class, 'deleteon'])->name('categorias.deleteon');
    Route::put('categorias/posts/{id}', [CatPostController::class, 'update'])->name('categorias.update');
    Route::get('categorias/{id}/edit', [CatPostController::class, 'edit'])->name('categorias.edit');
    Route::match(['post', 'get'],'posts/categorias/create/{catpai}', [CatPostController::class, 'create'])->name('categorias.create');
    Route::post('posts/categorias/store', [CatPostController::class, 'store'])->name('categorias.store');
    Route::get('posts/categorias', [CatPostController::class, 'index'])->name('categorias.index');

    //********************** Blog ************************************************/
    Route::get('posts/set-status', [PostController::class, 'postSetStatus'])->name('posts.postSetStatus');
    Route::get('posts/delete', [PostController::class, 'delete'])->name('posts.delete');
    Route::delete('posts/deleteon', [PostController::class, 'deleteon'])->name('posts.deleteon');
    Route::post('posts/image-set-cover', [PostController::class, 'imageSetCover'])->name('posts.imageSetCover');
    Route::delete('posts/image-remove', [PostController::class, 'imageRemove'])->name('posts.imageRemove');
    Route::put('posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::get('posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('posts/store', [PostController::class, 'store'])->name('posts.store');
    Route::post('posts/categoriaList', [PostController::class, 'categoriaList'])->name('posts.categoriaList');
    Route::get('posts/artigos', [PostController::class, 'index'])->name('posts.artigos');
    Route::get('posts/noticias', [PostController::class, 'index'])->name('posts.noticias');
    Route::get('posts/paginas', [PostController::class, 'index'])->name('posts.paginas');

    //*********************** Email **********************************************/
    Route::get('email/suporte', [EmailController::class, 'suporte'])->name('email.suporte');
    Route::match(['post', 'get'], 'email/enviar-email', [EmailController::class, 'send'])->name('email.send');
    Route::post('email/sendEmail', [EmailController::class, 'sendEmail'])->name('email.sendEmail');
    Route::match(['post', 'get'], 'email/success', [EmailController::class, 'success'])->name('email.success');

    //*********************** Usuários *******************************************/
    Route::match(['get', 'post'], 'usuarios/pesquisa', [UserController::class, 'search'])->name('users.search');
    Route::match(['post', 'get'], 'usuarios/fetchCity', [UserController::class, 'fetchCity'])->name('users.fetchCity');
    Route::delete('usuarios/deleteon', [UserController::class, 'deleteon'])->name('users.deleteon');
    Route::get('usuarios/set-status', [UserController::class, 'userSetStatus'])->name('users.userSetStatus');
    Route::get('usuarios/delete', [UserController::class, 'delete'])->name('users.delete');
    Route::get('usuarios/time', [UserController::class, 'team'])->name('users.team');
    Route::get('usuarios/view/{id}', [UserController::class, 'show'])->name('users.view');
    Route::put('usuarios/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('usuarios/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::get('usuarios/create', [UserController::class, 'create'])->name('users.create');
    Route::post('usuarios/store', [UserController::class, 'store'])->name('users.store');
    Route::get('usuarios', [UserController::class, 'index'])->name('users.index');

    Route::get('/', [AdminController::class, 'home'])->name('home');
});

Auth::routes();

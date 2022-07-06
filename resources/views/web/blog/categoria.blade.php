@extends('web.master.master')

@section('content')

<div class="slider-area ">    
    <div class="single-slider slider-height2 d-flex align-items-center" data-background="{{$configuracoes->gettopodosite()}}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2>Blog - {{$categoria->titulo}}</h2>
                        <p><a href="{{route('web.home')}}" class="text-white">Início</a> >> <a href="{{route('web.blog.artigos')}}" class="text-white">Blog</a> >> {{$categoria->titulo}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div> 

 <section class="blog_area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-5 mb-lg-0">
                <div class="blog_left_sidebar">
                    @if($posts->count() && $posts->count() > 0)
                        @foreach($posts as $artigo)
                            <article class="blog_item">
                                <div class="blog_item_img">
                                    <a class="d-inline-block" href="{{route('web.blog.artigo', ['slug' => $artigo->slug] )}}">
                                        <img class="card-img rounded-0" src="{{$artigo->cover()}}" alt="{{$artigo->nocover()}}">
                                    </a>
                                    <a href="{{route('web.blog.artigo', ['slug' => $artigo->slug] )}}" class="blog_item_date">
                                        <h3>{{date('d', strtotime($artigo->created_at))}}</h3>
                                        @php
                                            setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                                            date_default_timezone_set('America/Sao_Paulo');
                                        @endphp         
                                        <p>{{strftime('%b', strtotime($artigo->created_at))}}</p>
                                    </a>
                                </div>

                                <div class="blog_details">
                                    <a class="d-inline-block" href="{{route('web.blog.artigo', ['slug' => $artigo->slug] )}}">
                                        <h2>{{$artigo->titulo}}</h2>
                                    </a>
                                    {!! $artigo->getContentWebAttribute() !!}
                                   
                                </div>
                            </article>
                        @endforeach
                    @endif
                    <nav class="blog-pagination justify-content-center d-flex">
                        @if (isset($filters))
                            {{ $posts->appends($filters)->links() }}
                        @else
                            {{ $posts->links() }}
                        @endif 
                    </nav>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="blog_right_sidebar">
                    <aside class="single_sidebar_widget search_widget">
                        <form action="{{route('web.blog.searchBlog')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="filter" value="{{ $filters['filter'] ?? '' }}"/>
                                    <div class="input-group-append">
                                        <button class="btns" type="submit"><i class="ti-search"></i></button>
                                    </div>
                                </div>
                            </div>                            
                        </form>
                    </aside>

                    @if(!empty($categorias) && $categorias->count() > 0)
                        <aside class="single_sidebar_widget post_category_widget">
                            <h4 class="widget_title">Categorias</h4>
                            @foreach($categorias as $categoria)                                    
                                @if($categoria->children)
                                    @foreach($categoria->children as $subcategoria)
                                        @if($subcategoria->countposts() >= 1)
                                            <li>
                                                <a class="d-flex" href="{{route('web.blog.categoria', ['slug' => $subcategoria->slug] )}}" title="{{ $subcategoria->titulo }}">
                                                    <p>{{ $subcategoria->titulo }} ({{$subcategoria->countposts()}})</p>
                                                </a> 
                                            </li>
                                        @endif                                            
                                    @endforeach
                                @endif                                                                                                                             
                            @endforeach
                        </aside>
                    @endif
                    
                    <aside class="single_sidebar_widget newsletter_widget">
                        <h4 class="widget_title">Newsletter</h4>

                        <form method="post" action="" class="j_submitnewsletter">
                            @csrf
                            <div id="js-newsletter-result"></div>
                            <!-- HONEYPOT -->
                            <input type="hidden" class="noclear" name="bairro" value="" />
                            <input type="text" class="noclear" style="display: none;" name="cidade" value="" />
                            <input type="hidden" class="noclear" name="categoria" value="1" />
                            <input type="hidden" class="noclear" name="status" value="1" />
                            <input type="hidden" class="noclear" name="nome" value="#Cadastrado pelo Site" />
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder='Seu email...'/>
                            </div>
                            <button id="js-subscribe-btn" class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn"
                                type="submit">Cadastrar</button>
                        </form>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</section> 

@endsection

@section('js')
<script>
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Seletor, Evento/efeitos, CallBack, Ação
        $('.j_submitnewsletter').submit(function (){
            var form = $(this);
            var dataString = $(form).serialize();

            $.ajax({
                url: '{{ route('web.sendNewsletter') }}',
                data: dataString,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function(){
                    form.find("#js-subscribe-btn").attr("disabled", true);
                    form.find('#js-subscribe-btn').html("Carregando...");                
                    form.find('.alert').fadeOut(500, function(){
                        $(this).remove();
                    });
                },
                success: function(response){
                    $('html, body').animate({scrollTop:$('#js-newsletter-result').offset().top-160}, 'slow');
                    if(response.error){
                        form.find('#js-newsletter-result').html('<div class="alert alert-danger error-msg">'+ response.error +'</div>');
                        form.find('.error-msg').fadeIn();                    
                    }else{
                        form.find('#js-newsletter-result').html('<div class="alert alert-success error-msg">'+ response.sucess +'</div>');
                        form.find('.error-msg').fadeIn();                    
                        form.find('input[class!="noclear"]').val('');
                        form.find('.form_hide').fadeOut(500);
                    }
                },
                complete: function(response){
                    form.find("#js-subscribe-btn").attr("disabled", false);
                    form.find('#js-subscribe-btn').html("Cadastrar");                                
                }

            });

            return false;
        });

    });
</script>

@endsection
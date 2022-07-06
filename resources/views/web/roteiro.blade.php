@extends('web.master.master')


@section('content')

<div class="slider-area ">   
    <div class="single-slider slider-height2 d-flex align-items-center" data-background="{{$configuracoes->gettopodosite()}}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2>Roteiro - {{$roteiro->name}}</h2>
                        <p><a href="{{route('web.home')}}" class="text-white">Início</a> >> <a href="{{route('web.roteiros')}}" class="text-white">Roteiros</a> >> {{$roteiro->name}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>

 
 <section class="single-post-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-5 mb-lg-0 posts-list">
                <div class="single-post">
                    <div class="feature-img">
                       <img class="img-fluid" src="{{$roteiro->nocover()}}" alt="{{$roteiro->nocover()}}">
                    </div>
                    <div>                  
                       <ul class="blog-info-link mt-3 mb-4">
                           @if (!empty($roteiro->legendaimgcapa))
                                <li>Foto maior: {{$roteiro->legendaimgcapa}}</li>
                           @endif   
                           <div style="top:2px;" class="fb-share-button" data-href="{{url()->current()}}" data-layout="button_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Compartilhar</a></div>
                            <a class="btn-front" target="_blank" href="https://web.whatsapp.com/send?text={{url()->current()}}" data-action="share/whatsapp/share"><i class="fab fa-whatsapp"></i> Compartilhar</a>                      
                       </ul>
                       {!!$roteiro->content!!}    
                       <p style="font-size: 0.875em;color:#999;">*{!!$roteiro->notasadicionais!!}</p>              
                    </div>
                    @if($roteiro->images()->get()->count())
                        <div class="section-top-border">
                            <div class="row gallery-item">
                                @foreach($roteiro->images()->get() as $image)
                                    <div class="col-md-3">                                
                                        <a class="img-pop-up" href="{{ $image->getUrlCroppedAttribute() }}">                                    
                                            <div class="single-gallery-image" style="background: url({{ $image->getUrlCroppedAttribute() }});"></div>                                    
                                        </a>                                
                                    </div>
                                @endforeach
                            </div>
                        </div>           
                    @endif                
                 </div>
            </div>

            <div class="col-lg-4">
                <div class="blog_right_sidebar">
                    <aside class="single_sidebar_widget search_widget" style="padding: 0px;">
                        {!!$roteiro->mapadogoogle!!}
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
                   
                </div>
            </div>

            @if ($passeios->count() && $passeios->count() > 0)
            <div class="col-12">
                <div class="section-top-border">
                    <h3 class="mb-30">Passeios disponíveis para este roteiro</h3>
                    <div class="progress-table-wrap">
                        <div class="progress-table">
                            <div class="table-head">
                                <div class="serial">Embarque</div>
                                <div class="country">Saída</div>
                                <div class="visit">Duração</div>
                                <div class="percentage">Vagas</div>
                                <div class="Tipo">Tipo</div>
                                <div class="Valor">Valor</div>
                                <div class="status"></div>
                            </div>
                            @foreach ($passeios as $passeio)
                                <div class="table-row">
                                    <div class="serial"><b>{{$passeio->rua}}
                                        {{($passeio->num ? ', '.$passeio->num : '')}}
                                        {{($passeio->rua && $passeio->num ? ' - '.$passeio->bairro : $passeio->bairro)}}</b>
                                    </div>
                                    <div class="country">{{$passeio->saida}}</div>
                                    <div class="visit">{{$passeio->duracao}}hs</div>
                                    <div class="percentage">{{$passeio->vagas}}</div>
                                    @if ($passeio->venda == true && $passeio->locacao == false)
                                        <div class="Tipo">Individual</div>
                                        <div class="Valor">
                                            @if ($passeio->valor_venda_promocional != '')
                                                R$ {{$passeio->valor_venda_promocional}}<br>
                                                <span style="text-decoration: line-through">R$ {{$passeio->valor_venda}}</span>
                                            @else
                                                R$ {{$passeio->valor_venda}}
                                            @endif
                                        </div>                        
                                    @elseif($passeio->venda == false && $passeio->locacao == true)
                                        <div class="Tipo">Pacote</div>
                                        <div class="Valor">
                                            @if ($passeio->valor_locacao_promocional != '')
                                                R$ {{$passeio->valor_locacao_promocional}}<br>
                                                <span style="text-decoration: line-through">R$ {{$passeio->valor_locacao}}</span>
                                            @else
                                                R$ {{$passeio->valor_locacao}}
                                            @endif
                                        </div>                        
                                    @else
                                        <div class="Tipo">
                                            Individual<br>
                                            Pacote
                                        </div>
                                        <div class="Valor">
                                            @if ($passeio->valor_venda_promocional != '' && $passeio->valor_locacao_promocional != '')
                                                R$ {{$passeio->valor_venda_promocional}}<br>
                                                <span style="text-decoration: line-through">R$ {{$passeio->valor_venda}}</span><br>
                                                R$ {{$passeio->valor_locacao_promocional}}<br>
                                                <span style="text-decoration: line-through">R$ {{$passeio->valor_locacao}}</span>
                                            @elseif($passeio->valor_venda_promocional == '' && $passeio->valor_locacao_promocional != '')
                                                R$ {{$passeio->valor_venda_promocional}}<br>
                                                <span style="text-decoration: line-through">R$ {{$passeio->valor_venda}}</span>
                                            @elseif($passeio->valor_venda_promocional != '' && $passeio->valor_locacao_promocional == '')
                                                R$ {{$passeio->valor_locacao_promocional}}<br>
                                                <span style="text-decoration: line-through">R$ {{$passeio->valor_locacao}}</span>
                                            @else
                                                R$ {{$passeio->valor_venda_promocional}}<br>
                                                R$ {{$passeio->valor_locacao_promocional}}
                                            @endif
                                        </div>                         
                                    @endif 
                                    <div class="status">
                                        @if ($passeio->status == '1')
                                            <a href="{{route('web.passeios.comprar', ['passeio' => $passeio->id])}}">
                                                <button class="genric-btn success large">Comprar</button>
                                            </a>
                                        @else
                                            Não Disponível
                                        @endif
                                    </div>    
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</section>

@endsection

@section('css')
<style>
    iframe{
      height: 400px;
      width: 100%;
      display: inline-block;
      overflow: hidden"
    }
    .btn-front{
        background-color: #6ebf58;
        color:#fff;
        border-radius: .25rem;
        padding: 3px 8px !important;
        border:none;
    }
    .btn-front:hover, mdi:hover{
        color:#fff;
    }
  </style>
@endsection

@section('js')
<script>
    $(function () {       

        

    });
</script>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v11.0&appId=1787040554899561&autoLogAppEvents=1" nonce="1eBNUT9J"></script>
@endsection
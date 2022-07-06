@extends('web.master.master')


@section('content')

<div class="slider-area ">        
    <div class="single-slider slider-height2 d-flex align-items-center" data-background="{{$configuracoes->gettopodosite()}}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2>{{$embarcacao->name}}</h2>
                        <p><a href="{{route('web.home')}}" class="text-white">Início</a> >> <a href="{{route('web.embarcacoes')}}">Embarcações</a> >> {{$embarcacao->name}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="blog_area single-post-area section-padding">
    <div class="container">
       <div class="row">
        <div class="col-lg-4">
            <div class="blog_right_sidebar">
               <aside class="single_sidebar_widget search_widget text-center">
                  <img class="img-fluid" src="{{$embarcacao->cover()}}" alt="{{$embarcacao->name}}">
               </aside>
               <aside class="single_sidebar_widget post_category_widget">
                  <h4 class="widget_title">Informações</h4>
                  <ul class="list cat-list">
                    <li> <b>Capacidade de Passageiros:</b> {{$embarcacao->passageiros}}</li>
                    <li> <b>Tripulantes:</b> {{$embarcacao->tripulantes}}</li>
                    <li> <b>Comprimento:</b> {{$embarcacao->comprimento}}</li>
                    <li> <b>Ano de Construcao:</b> {{$embarcacao->ano_de_construcao}}</li>
                  </ul>
               </aside>                              
            </div>
         </div>
          <div class="col-lg-8 posts-list">
             <div class="single-post">                
                <div>
                   <h2>{{$embarcacao->name}}</h2>
                   <ul class="blog-info-link mt-3 mb-4">
                        <div style="top:2px;" class="fb-share-button" data-href="{{url()->current()}}" data-layout="button_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Compartilhar</a></div>
                        <a class="btn-front" target="_blank" href="https://web.whatsapp.com/send?text={{url()->current()}}" data-action="share/whatsapp/share"><i class="fab fa-whatsapp"></i> Compartilhar</a>
                   </ul>
                   {!!$embarcacao->content!!}
                </div>
             </div>
             <div class="navigation-top">
                <div class="d-sm-flex justify-content-between text-center">
                   <p class="like-info">
                       <span class="align-middle"><i class="fa fa-eye"></i></span> {{$embarcacao->views}}
                    </p> 
                </div>     
             </div>
                            
            @if($embarcacao->images()->get()->count())                        
                <div class="row gallery-item">
                    @foreach($embarcacao->images()->get() as $image)
                        <div class="col-md-3">                                
                            <a class="img-pop-up" href="{{ $image->url_cropped }}">                                    
                                <div class="single-gallery-image" style="background: url({{ $image->url_cropped }});"></div>                                    
                            </a>                                
                        </div>
                    @endforeach
                </div>                                  
            @endif              
             
          </div>
       </div>
    </div>
 </section>
@endsection

@section('css')
<style>    
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
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v11.0&appId=1787040554899561&autoLogAppEvents=1" nonce="1eBNUT9J"></script>
@endsection
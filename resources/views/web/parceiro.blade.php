@extends('web.master.master')

@section('content')

<div class="slider-area ">        
    <div class="single-slider slider-height2 d-flex align-items-center" data-background="{{$configuracoes->gettopodosite()}}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2>{{$parceiro->name}}</h2>
                        <p><a href="{{route('web.home')}}" class="text-white">Início</a> >> <a href="{{route('web.parceiros')}}">Parceiros</a> >> {{$parceiro->name}}</p>
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
                  <img class="img-fluid" src="{{$parceiro->nocover()}}" alt="{{$parceiro->name}}">
               </aside>
               <aside class="single_sidebar_widget post_category_widget">
                  <h4 class="widget_title">Atendimento</h4>
                  <ul class="list cat-list">
                      @if ($parceiro->link)
                           <li>                                
                               <p class="mb-0">
                                   Site: <a target="_blank" href="{{$parceiro->link}}" class="d-flex">{{$parceiro->link}}</a>
                               </p>
                           </li>
                      @endif
                      @if ($parceiro->email)
                           <li>                                
                               <p class="mb-0">
                                   Email: <a target="_blank" href="mailto:{{$parceiro->email}}" class="d-flex">{{$parceiro->email}}</a>
                               </p>
                           </li>
                      @endif
                      @if ($parceiro->telefone)
                           <li>                                
                               <p class="mb-0">
                                   Telefone: <a target="_blank" href="tel:{{$parceiro->telefone}}" class="d-flex">{{$parceiro->telefone}}</a>
                               </p>
                           </li>
                      @endif
                      @if ($parceiro->celular)
                           <li>                                
                               <p class="mb-0">
                                   Celular: <a target="_blank" href="tel:{{$parceiro->celular}}" class="d-flex">{{$parceiro->celular}}</a>
                               </p>
                           </li>
                      @endif
                      @if ($parceiro->whatsapp)
                           <li>                                
                               <p class="mb-0">
                                   WhatsApp: <a target="_blank" href="tel:{{$parceiro->whatsapp}}" class="d-flex">{{$parceiro->whatsapp}}</a>
                               </p>
                           </li>
                      @endif
                  </ul>
               </aside>
               <aside class="single_sidebar_widget">
                   {!!$parceiro->mapa_google!!}
               </aside>                
            </div>
         </div>
          <div class="col-lg-8 posts-list">
             <div class="single-post">                
                <div>
                   <h2>{{$parceiro->name}}</h2>
                   <ul class="blog-info-link mt-3 mb-4">
                        <div style="top:2px;" class="fb-share-button" data-href="{{url()->current()}}" data-layout="button_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Compartilhar</a></div>
                        <a class="btn-front" target="_blank" href="https://web.whatsapp.com/send?text={{url()->current()}}" data-action="share/whatsapp/share"><i class="fab fa-whatsapp"></i> Compartilhar</a>
                   </ul>
                   {!!$parceiro->content!!}
                </div>
             </div>
             <div class="navigation-top">
                <div class="d-sm-flex justify-content-between text-center">
                   <p class="like-info">
                       <span class="align-middle"><i class="fa fa-eye"></i></span> {{$parceiro->views}}
                    </p>                  
                   <ul class="social-icons">
                        @if (!empty($parceiro->facebook))
                            <li style="float: right;" class="mr-2"><a target="_blank" href="{{$parceiro->facebook}}"><i class="fab fa-facebook"></i></a></li>
                        @endif                                
                        @if (!empty($parceiro->twitter))
                            <li style="float: right;" class="mr-2"><a target="_blank" href="{{$parceiro->twitter}}"><i class="fab fa-twitter"></i></a></li>
                        @endif                                
                        @if (!empty($parceiro->instagram))
                            <li style="float: right;" class="mr-2"><a target="_blank" href="{{$parceiro->instagram}}"><i class="fab fa-instagram"></i></a></li>
                        @endif                                
                        @if (!empty($parceiro->youtube))
                            <li style="float: right;" class="mr-2"><a target="_blank" href="{{$parceiro->youtube}}"><i class="fab fa-youtube"></i></a></li>
                        @endif                                
                        @if (!empty($parceiro->linkedin))
                            <li style="float: right;" class="mr-2"><a target="_blank" href="{{$parceiro->linkedin}}"><i class="fab fa-linkedin"></i></a></li>
                        @endif                                
                        @if (!empty($parceiro->vimeo))
                            <li style="float: right;" class="mr-2"><a target="_blank" href="{{$parceiro->vimeo}}"><i class="fab fa-vimeo"></i></a></li>
                        @endif                                
                        @if (!empty($parceiro->fliccr))
                            <li style="float: right;" class="mr-2"><a target="_blank" href="{{$parceiro->fliccr}}"><i class="fab fa-flickr"></i></a></li>
                        @endif                                
                        @if (!empty($parceiro->soundclound))
                            <li style="float: right;" class="mr-2"><a target="_blank" href="{{$parceiro->soundclound}}"><i class="fab fa-soundcloud"></i></a></li>
                        @endif                                
                        @if (!empty($parceiro->snapchat))
                            <li style="float: right;" class="mr-2"><a target="_blank" href="{{$parceiro->snapchat}}"><i class="fab fa-snapchat"></i></a></li>
                        @endif 
                   </ul>
                </div> 

                <p class="my-3"><b>Endereço: </b>
                    @if ($parceiro->rua)
                        {{$parceiro->rua}}
                    @endif
                    @if ($parceiro->rua && $parceiro->num)
                        , {{$parceiro->num}}
                    @endif
                    @if ($parceiro->rua && $parceiro->bairro)
                        , {{$parceiro->bairro}}
                    @endif
                    @if (!$parceiro->rua && $parceiro->bairro)
                        {{$parceiro->bairro}}
                    @endif
                    @if ($parceiro->bairro && $parceiro->uf)
                        - {{\App\Helpers\Cidade::getCidadeNome($parceiro->cidade, 'cidades')}}
                    @endif
                    @if(!$parceiro->bairro && $parceiro->uf)
                        {{\App\Helpers\CidadegetCidadeNome($parceiro->cidade, 'cidades')}}
                    @endif
                    @if ($parceiro->cep)
                        - {{$parceiro->cep}}
                    @endif
                </p>               
             </div>
                            
                @if($parceiro->images()->get()->count())                        
                    <div class="row gallery-item">
                        @foreach($parceiro->images()->get() as $image)
                            <div class="col-md-3">                                
                                <a class="img-pop-up" href="{{ $image->url_cropped }}">                                    
                                    <div class="single-gallery-image" style="background: url({{ $image->url_cropped }});"></div>                                    
                                </a>                                
                            </div>
                        @endforeach
                    </div>                                  
                @endif               
             
             @if (!empty($parceiro->email))
                <div class="comment-form">
                    <h4>Enviar Mensagem</h4>
                    <form class="form-contact comment_form j_formsubmit" action="" method="post" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div id="js-contact-result"></div>
                        </div>
                        <input type="hidden" class="noclear" name="parceiro_id" value="{{$parceiro->id}}" />
                        <div class="form-group form_hide">
                            <!-- HONEYPOT -->
                            <input type="hidden" class="noclear" name="bairro" value="" />
                            <input type="text" class="noclear" style="display: none;" name="cidade" value="" />
                        </div> 
                        <div class="col-sm-6 form_hide">
                            <div class="form-group">
                            <input class="form-control" name="nome" type="text" placeholder="Nome">
                            </div>
                        </div>
                        <div class="col-sm-6 form_hide">
                            <div class="form-group">
                            <input class="form-control" name="email" type="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-12 form_hide">
                            <div class="form-group">
                                <textarea class="form-control w-100" name="mensagem" cols="30" rows="9"
                                placeholder="Mensagem"></textarea>
                            </div>
                        </div> 
                    </div>
                    <div class="form-group form_hide">
                        <button type="submit" class="button button-contactForm btn_1 boxed-btn" id="js-contact-btn">Enviar Agora</button>
                    </div>
                    </form>
                </div>
             @endif
             
          </div>
       </div>
    </div>
 </section>
@endsection

@section('css')
<style>
    iframe{
      height: 300px;
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });     

        // Seletor, Evento/efeitos, CallBack, Ação
        $('.j_formsubmit').submit(function (){
            var form = $(this);
            var dataString = $(form).serialize();

            $.ajax({
                url: "{{ route('web.sendEmailParceiro') }}",
                data: dataString,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function(){
                    form.find("#js-contact-btn").attr("disabled", true);
                    form.find('#js-contact-btn').html("Carregando...");                
                    form.find('.alert').fadeOut(500, function(){
                        $(this).remove();
                    });
                },
                success: function(resposta){
                    $('html, body').animate({scrollTop:$('#js-contact-result').offset().top-190}, 'slow');
                    if(resposta.error){
                        form.find('#js-contact-result').html('<div class="alert alert-danger error-msg">'+ resposta.error +'</div>');
                        form.find('.error-msg').fadeIn();                    
                    }else{
                        form.find('#js-contact-result').html('<div class="alert alert-success error-msg">'+ resposta.sucess +'</div>');
                        form.find('.error-msg').fadeIn();                    
                        form.find('input[class!="noclear"]').val('');
                        form.find('textarea[class!="noclear"]').val('');
                        form.find('.form_hide').fadeOut(500);
                    }
                },
                complete: function(resposta){
                    form.find("#js-contact-btn").attr("disabled", false);
                    form.find('#js-contact-btn').html("Enviar Agora");                                
                }

            });

            return false;
        });

    });
</script>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v11.0&appId=1787040554899561&autoLogAppEvents=1" nonce="1eBNUT9J"></script>
@endsection
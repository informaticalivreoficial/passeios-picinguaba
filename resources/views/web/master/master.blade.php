<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">  
        <meta name="language" content="pt-br" />  
        <meta name="robots" content="index, follow"/>      
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="{{$configuracoes->getfaveicon()}}">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="author" content="Informática Livre"/>
        <meta name="url" content="https://passeiospicinguaba.com.br" />
        <meta name="keywords" content="{{$configuracoes->metatags}}">    
        <meta name="date" content="Dec 26">
        <!-- Bing -->
        <meta name="msvalidate.01" content="AB238289F13C246C5E386B6770D9F10E" />

        {!! $head ?? '' !!}

		<!-- CSS -->
        <link rel="stylesheet" href="{{url(mix('frontend/assets/css/bootstrap.min.css'))}}">
        <link rel="stylesheet" href="{{url(mix('frontend/assets/css/owl.carousel.min.css'))}}">
        <link rel="stylesheet" href="{{url(mix('frontend/assets/css/flaticon.css'))}}">
        <link rel="stylesheet" href="{{url(mix('frontend/assets/css/slicknav.css'))}}">
        <link rel="stylesheet" href="{{url(mix('frontend/assets/css/animate.min.css'))}}">
        <link rel="stylesheet" href="{{url(mix('frontend/assets/css/magnific-popup.css'))}}">
        <link rel="stylesheet" href="{{url(mix('frontend/assets/css/fontawesome-all.min.css'))}}">
        <link rel="stylesheet" href="{{url(mix('frontend/assets/css/themify-icons.css'))}}">
        <link rel="stylesheet" href="{{url(mix('frontend/assets/css/slick.css'))}}">
        <link rel="stylesheet" href="{{url(mix('frontend/assets/css/nice-select.css'))}}">
        <link rel="stylesheet" href="{{url(mix('frontend/assets/css/style.css'))}}">
        <link rel="stylesheet" href="{{url(asset('frontend/assets/css/renato.css'))}}">

        @hasSection('css')
            @yield('css')
        @endif 
   </head>

   <body>
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="{{$configuracoes->getlogomarca()}}">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->
    <header>
        <!-- Header Start -->
       <div class="header-area">
            <div class="main-header">
                @if(Session::has('cart'))
                    <div class="header-top top-bg d-lg-none">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <ul>
                                        <li>
                                            <a style="font-size:1.7em;position:relative;" href="{{route('web.passeios.meucarrinho')}}" class="icon icon-xxs fa fa-shopping-cart"></a>
                                            <span style="padding: 3px;font-size: 12px;                        
                                            min-width: 17px;background-color: #21a9e1;
                                            color: #ffffff;border-radius: 20px;
                                            line-height: 12px;position:relative;top:-11px;left:-11px;">1</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="header-top top-bg d-none d-lg-block">
                   <div class="container">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-8">
                            <div class="header-info-left">
                                <ul>                          
                                    @if ($configuracoes->email)
                                        <li><i class="fas fa-envelope"></i>{{$configuracoes->email}}</li>
                                    @endif
                                    @if ($configuracoes->whatsapp)
                                        <li><i class="fab fa-whatsapp"></i><a href="{{\App\Helpers\WhatsApp::getNumZap($configuracoes->whatsapp ,'Atendimento '. $configuracoes->nomedosite)}}">{{$configuracoes->whatsapp}}</a></li>
                                    @endif
                                    @if ($configuracoes->bairro)
                                        <li><i class="fas fa-map-marker-alt"></i>{{$configuracoes->bairro}}</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="header-info-right f-right">
                                <ul class="header-social">    
                                    @if ($configuracoes->facebook)
                                        <li><a target="_blank" href="{{$configuracoes->facebook}}"><i class="fab fa-facebook-f"></i></a></li>
                                    @endif
                                    @if ($configuracoes->twitter)
                                        <li><a target="_blank" href="{{$configuracoes->twitter}}"><i class="fab fa-twitter"></i></a></li>
                                    @endif
                                    @if ($configuracoes->instagram)
                                        <li><a target="_blank" href="{{$configuracoes->instagram}}"><i class="fab fa-instagram"></i></a></li>
                                    @endif  
                                    @if ($configuracoes->youtube)
                                        <li><a target="_blank" href="{{$configuracoes->youtube}}"><i class="fab fa-youtube"></i></a></li>
                                    @endif 
                                    @if(Session::has('cart'))
                                        <li>
                                            <a style="font-size:1.7em;position:relative;" href="{{route('web.passeios.meucarrinho')}}" class="icon icon-xxs fa fa-shopping-cart"></a>
                                            <span style="padding: 3px;font-size: 12px;                        
                                            min-width: 17px;background-color: #21a9e1;
                                            color: #ffffff;border-radius: 20px;
                                            line-height: 12px;position:relative;top:-11px;left:-25px;">1</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                       </div>
                   </div>
                </div>
               <div class="header-bottom  header-sticky">
                    <div class="container">
                        <div class="row align-items-center">
                            <!-- Logo -->
                            <div class="col-xl-2 col-lg-2 col-md-1">
                                <div class="logo py-2">
                                  <a href="{{route('web.home')}}">
                                    <img style="max-width:184px;" src="{{$configuracoes->getlogomarca()}}" alt="{{$configuracoes->getlogomarca()}}">
                                  </a>
                                </div>
                            </div>
                            <div class="col-xl-10 col-lg-10 col-md-10">
                                <!-- Main-menu -->
                                <div class="main-menu f-right d-none d-lg-block">
                                    <nav>               
                                        <ul id="navigation">                                                                                                                                     
                                            <li><a href="{{route('web.home')}}">Início</a></li>
                                            @if (!empty($paginas) && $paginas->count() > 0)
                                                <li><a href="#">{{$configuracoes->nomedosite}}</a>
                                                    <ul class="submenu">
                                                        @foreach($paginas as $pagina)
                                                            <li><a href="{{route('web.pagina',['slug' => $pagina->slug])}}">{{$pagina->titulo}}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endif
                                            @if (!empty($parceiros) && $parceiros->count() > 0)
                                                <li><a href="{{route('web.parceiros')}}">Parceiros</a></li>
                                            @endif                                                                                        
                                            @if (!empty($embarcacoes) && $embarcacoes->count() > 0)
                                                <li class=""><a href="{{route('web.embarcacoes')}}">Embarcações</a></li>
                                            @endif 
                                            <li class=""><a href="{{route('web.roteiros')}}">Roteiros</a></li>
                                            <li class=""><a href="{{route('web.blog.artigos')}}">Dicas</a></li>
                                            <li><a href="{{route('web.atendimento')}}">Atendimento</a></li>
                                            @if(Session::has('cliente'))
                                                <li>
                                                    <a href="{{route('web.passeios')}}">Meus Passeios</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <!-- Mobile Menu -->
                            <div class="col-12">
                                <div class="mobile_menu d-block d-lg-none"></div>
                            </div>
                        </div>
                    </div>
               </div>
            </div>
       </div>
        <!-- Header End -->
    </header>

    <main>@yield('content')</main>

    <footer>
        <!-- Footer Start-->
        <div class="footer-area footer-padding footer-bg" data-background="{{url(asset('frontend/assets/images/service/footer_bg.jpg'))}}">
            <div class="container">
                <div class="row d-flex justify-content-between">
                    <div class="col-xl-5 col-lg-4 col-md-12 col-sm-12">
                       <div class="single-footer-caption mb-50">
                         <div class="single-footer-caption mb-30">
                              <!-- logo -->
                             <div class="footer-logo">
                                 <img src="{{$configuracoes->getlogomarca()}}" alt="{{$configuracoes->getlogomarca()}}">
                             </div>
                             <div class="footer-tittle">
                                 <div class="footer-pera" style="color:#fff;">
                                    {!!$configuracoes->descricao!!}
                                    @if($configuracoes->cnpj)
                                        <p class="mt-2">CNPJ: {{$configuracoes->cnpj}}</p>
                                    @endif                                        
                                    @if($configuracoes->ie)
                                        <p class="mt-2">IE: {{$configuracoes->ie}}</p>
                                    @endif 
                                </div>
                             </div>
                         </div>
                       </div>
                    </div>                    
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <h4>Atendimento</h4>
                                <ul>
                                    @if ($configuracoes->whatsapp)
                                        <li><i class="fab fa-whatsapp"></i> 
                                            <a href="{{\App\Helpers\WhatsApp::getNumZap($configuracoes->whatsapp ,'Atendimento '. $configuracoes->nomedosite)}}">{{$configuracoes->whatsapp}}</a>
                                        </li>                                        
                                    @endif
                                    @if ($configuracoes->telefone1)
                                        <li><i class="fas fa-phone"></i> 
                                            <a href="callto:{{$configuracoes->telefone1}}">{{$configuracoes->telefone1}}</a>
                                        </li>                                        
                                    @endif
                                    @if ($configuracoes->telefone2)
                                        <li><i class="fas fa-phone"></i> 
                                            <a href="callto:{{$configuracoes->telefone2}}">{{$configuracoes->telefone2}}</a>
                                        </li>                                        
                                    @endif
                                    @if ($configuracoes->email)
                                        <li><i class="fas fa-envelope"></i> 
                                            <a href="mailto:{{$configuracoes->email}}">{{$configuracoes->email}}</a>
                                        </li>                                        
                                    @endif
                                    @if ($configuracoes->email1)
                                        <li><i class="fas fa-envelope"></i> 
                                            <a href="mailto:{{$configuracoes->email1}}">{{$configuracoes->email1}}</a>
                                        </li>                                        
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="single-footer-caption mb-50">
                            <div class="footer-tittle">
                                <h4>Cliente</h4>
                                <ul>
                                 <li><a href="{{route('web.login')}}">Meus Passeios</a></li>
                                 <li><a href="{{route('web.politica')}}">Política de Privacidade</a></li>
                                 <li><a href="#">Perguntas Frequentes</a></li>
                             </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer bottom -->
                <div class="row pt-padding">
                 <div class="col-xl-7 col-lg-7 col-md-7">
                    <div class="footer-copy-right">
                         <p>
                         Copyright &copy;{{$configuracoes->ano_de_inicio}} {{$configuracoes->nomedosite}} - todos os direitos reservados.<br>
                         Feito com <i class="ti-heart" aria-hidden="true"></i> por <a href="{{env('DESENVOLVEDOR_URL')}}" target="_blank">{{env('DESENVOLVEDOR')}}</a>
                        </p>
                    </div>
                 </div>
                  <div class="col-xl-5 col-lg-5 col-md-5">
                        <!-- social -->
                        <div class="footer-social f-right">
                            @if ($configuracoes->facebook)
                                <a target="_blank" href="{{$configuracoes->facebook}}"><i class="fab fa-facebook-f"></i></a>
                            @endif
                            @if ($configuracoes->twitter)
                                <a target="_blank" href="{{$configuracoes->twitter}}"><i class="fab fa-twitter"></i></a>
                            @endif
                            @if ($configuracoes->instagram)
                                <a target="_blank" href="{{$configuracoes->instagram}}"><i class="fab fa-instagram"></i></a>
                            @endif
                            @if ($configuracoes->youtube)
                                <a target="_blank" href="{{$configuracoes->instagram}}"><i class="fab fa-youtube"></i></a>
                            @endif
                        </div>
                        
                 </div>
             </div>
            </div>
        </div>
        <!-- Footer End-->
    </footer>

    <div class="whatsapp-footer">
        <a target="_blank" href="{{\App\Helpers\WhatsApp::getNumZap($configuracoes->whatsapp ,$configuracoes->nomedosite)}}" title="WhatsApp">
            <img src="{{url(asset('frontend/assets/images/zap-topo.png'))}}" alt="{{url(asset('frontend/assets/images/zap-topo.png'))}}" title="WhatsApp" />
        </a>
    </div>

	<!-- JS here -->
	
		<!-- All JS Custom Plugins Link Here here -->
        <script src="{{url(mix('frontend/assets/js/vendor/modernizr-3.5.0.min.js'))}}"></script>
		
		<!-- Jquery, Popper, Bootstrap -->
		<script src="{{url(mix('frontend/assets/js/vendor/jquery-1.12.4.min.js'))}}"></script>
        <script src="{{url(mix('frontend/assets/js/popper.min.js'))}}"></script>
        <script src="{{url(mix('frontend/assets/js/bootstrap.min.js'))}}"></script>
	    <!-- Jquery Mobile Menu -->
        <script src="{{url(asset('frontend/assets/js/jquery.slicknav.min.js'))}}"></script>

		<!-- Jquery Slick , Owl-Carousel Plugins -->
        <script src="{{url(mix('frontend/assets/js/owl.carousel.min.js'))}}"></script>
        <script src="{{url(mix('frontend/assets/js/slick.min.js'))}}"></script>
		<!-- One Page, Animated-HeadLin -->
        <script src="{{url(mix('frontend/assets/js/wow.min.js'))}}"></script>
		<script src="{{url(mix('frontend/assets/js/animated.headline.js'))}}"></script>
        <script src="{{url(mix('frontend/assets/js/jquery.magnific-popup.js'))}}"></script>

		<!-- Scrollup, nice-select, sticky -->
        <script src="{{url(mix('frontend/assets/js/jquery.scrollUp.min.js'))}}"></script>
        <script src="{{url(mix('frontend/assets/js/jquery.nice-select.min.js'))}}"></script>
		<script src="{{url(mix('frontend/assets/js/jquery.sticky.js'))}}"></script>        
        
		<!-- Jquery Plugins, main Jquery -->	
        <script src="{{url(mix('frontend/assets/js/plugins.js'))}}"></script>
        <script src="{{url(mix('frontend/assets/js/main.js'))}}"></script>
        
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-5N0258YEHN"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'G-5N0258YEHN');
        </script>

        @hasSection('js')
            @yield('js')
        @endif
        
    </body>
</html>
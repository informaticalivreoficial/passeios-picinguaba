@extends('web.master.master')

@section('content')
<header class="page-head slider-menu-position">
    @include('web.include.header')  

<section class="section-height-800 breadcrumb-modern rd-parallax context-dark bg-gray-darkest text-lg-left">
    <div data-speed="0.2" data-type="media" data-url="{{url(asset('frontend/assets/images/backgrounds/background-01-1920x900.jpg'))}}" class="rd-parallax-layer"></div>
        <div data-speed="0" data-type="html" class="rd-parallax-layer">
        <div class="bg-primary-chathams-blue-reverse">
            <div class="shell section-top-57 section-bottom-30 section-md-top-185">
            <div class="veil reveal-md-block">
                <h1 class="text-bold">{{$pagina->titulo}}</h1>
            </div>
            <ul class="list-inline list-inline-icon list-inline-icon-type-1 list-inline-icon-extra-small list-inline-icon-white p offset-top-30 offset-md-top-40">
                <li><a href="{{route('web.home')}}" class="text-white">Início</a></li>
                <li>{{$pagina->titulo}}</li>
            </ul>
            </div>
        </div>
    </div>
</section>
</header>
<!-- Page Contents-->
<main class="page-content">
<!-- Blog Classic-->
<div id="fb-root"></div>
<section class="section-90 section-md-111 text-left">
    <div class="shell">
    <div class="range range-xs-center range-lg-right">
        <div class="cell-sm-12 cell-md-12">
        <div class="offset-top-25">
            <img src="{{$pagina->cover()}}" width="770" height="420" alt="" class="img-responsive center-block">
        </div>        
        <div class="offset-top-30">
            {!! $pagina->content !!}
        </div> 

        @if($pagina->images()->get()->count())
            <div class="offset-top-15 offset-md-top-20">
                <div class="range range-xs-center section-gallery-lg-column-offset">
                @foreach($pagina->images()->get() as $image)
                    <div class="cell-xs-4 cell-md-6 inset-lg-left-13 inset-lg-right-13 offset-top-20">
                        <div class="inset-left-30 inset-right-30 inset-xs-left-0 inset-xs-right-0">
                            <a class="thumbnail-rayen" href="{{ $image->getUrlCroppedAttribute() }}" data-toggle="lightbox"
                                data-gallery="property-gallery" data-type="image">
                                <span class="figure">
                                    <img width="160" height="160" src="{{ $image->getUrlCroppedAttribute() }}" alt="{{ $pagina->titulo }}">
                                    <span class="figcaption">
                                        <span class="icon icon-xs fa-search-plus"></span>
                                    </span>
                                </span>
                            </a>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>           
        @endif 
        <div class="offset-top-30">
           
            <div class="pull-sm-right inset-sm-right-6">
            <div class="reveal-inline-block">
                <p class="text-dark">Compartilhe:</p>
            </div>
            <div class="main_property_content_descripition">
                <div style="top:2px;" class="fb-share-button" data-href="{{url()->current()}}" data-layout="button_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Compartilhar</a></div>
                <a class="btn-front mdi mdi-whatsapp" target="_blank" href="https://web.whatsapp.com/send?text={{url()->current()}}" data-action="share/whatsapp/share"> Compartilhar</a>                        
            </div>
            </div>
            <div class="clearfix"></div>
        </div>
        
       
        </div>       
    </div>
    </div>
</section>
</main>      
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
<script>
    $(function () {       

        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
            alwaysShowClose: true
            });
        });

    });
</script>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v11.0&appId=1787040554899561&autoLogAppEvents=1" nonce="1eBNUT9J"></script>
@endsection
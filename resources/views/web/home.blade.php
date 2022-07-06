@extends('web.master.master')

@section('content')

@if(!empty($slides) && $slides->count() > 0)
<div class="slider-area ">
    <!-- Mobile Menu -->
    <div class="slider-active">
        @foreach ($slides as $slide)
        <div class="single-slider hero-overly  slider-height d-flex align-items-center" data-background="{{$slide->getimagem()}}">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="hero__caption">
                            <h1>{{$slide->titulo}}</h1>
                            <p>{!!$slide->content!!}</p>
                        </div>
                    </div>
                </div>
                <!-- Search Box -->
                <div class="row">
                    <div class="col-xl-12">
                        <!-- form -->
                        <form method="post" action="{{ route('web.roteiro.do') }}" class="search-box" name="roteiro">
                            <div class="select-form mb-30">
                                <div class="select-itms">
                                    <select name="slug" id="select1">
                                        @foreach ($roteiros as $roteiro)
                                            <option value="{{$roteiro->slug}}">{{$roteiro->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                                <button type="submit" class="genric-btn roteiro search-form mb-30">Quero Reservar</button>
                            	
                        </form>	
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif


@if($roteiros->count() && $roteiros->count() > 0)
<div class="favourite-place place-padding">
    <div class="container">           
        <div class="row">
            <div class="col-lg-12">
                <div class="section-tittle text-center">
                    <h2>Roteiros</h2>
                </div>
            </div>
            @foreach ($roteiros as $roteiro)
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-place mb-30">
                        <div class="place-img">
                            <a style="color: #007bff;"  href="{{route('web.roteiro', ['slug' => $roteiro->slug])}}">
                                <img src="{{$roteiro->cover()}}" alt="{{$roteiro->nocover()}}">
                            </a>
                        </div>
                        <div class="place-cap">
                            <div class="place-cap-top">
                                <h3><a href="{{route('web.roteiro', ['slug' => $roteiro->slug])}}">{{$roteiro->name}}</a></h3>
                                <p class="dolor"><a style="color: #007bff;"  href="{{route('web.roteiro', ['slug' => $roteiro->slug])}}">Leia mais</a></p>
                            </div>                                   
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
 

@if($artigos->count() && $artigos->count() > 0)
<div class="home-blog-area section-padding2">
    <div class="container">
        <!-- Section Tittle -->
        <div class="row">
            <div class="col-lg-12">
                <div class="section-tittle text-center">
                    <span>Acompanhe nossas Dicas</span>
                    <h2>Blog</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($artigos as $artigo)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="home-blog-single mb-30">
                    <div class="blog-img-cap">
                        <div class="blog-img">
                            <a href="{{route('web.blog.artigo',['slug' => $artigo->slug])}}">
                                <img src="{{$artigo->cover()}}" alt="{{$artigo->cover()}}">
                            </a>
                        </div>
                        <div class="blog-cap">
                            <p>{{$artigo->categoriaObject->titulo}}</p>
                            <h3><a href="{{route('web.blog.artigo',['slug' => $artigo->slug])}}">{{$artigo->titulo}}</a></h3>
                            <a href="{{route('web.blog.artigo',['slug' => $artigo->slug])}}" class="more-btn">Ler mais »</a>
                        </div>
                    </div>
                    <div class="blog-date text-center">
                        <span>{{date('d', strtotime($artigo->created_at))}}</span>
                        @php
                            setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                            date_default_timezone_set('America/Sao_Paulo');
                        @endphp         
                        <p>{{strftime('%b', strtotime($artigo->created_at))}}</p>
                    </div>
                </div>
            </div>
            @endforeach             
        </div>
    </div>
</div>
@endif

@if (!empty($parceiros) && $parceiros->count() > 0)
<div class="our-services">
    <div class="container">
        <div class="row d-flex justify-contnet-center">
            <div class="col-lg-12">
                <div class="section-tittle text-center">
                    <h2>Nossos Parceiros</h2>
                </div>
            </div>
            @foreach ($parceiros as $parceiro)
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                <div class="single-services text-center mb-30">
                    <div class="">
                        <a href="{{route('web.parceiro',['slug' => $parceiro->slug])}}">
                            <img class="img-fluid" src="{{$parceiro->cover()}}" alt="{{$parceiro->name}}">
                        </a>
                    </div>
                    <div class="services-cap">
                        <h5>{{$parceiro->name}}</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>   
@endif

@endsection

@section('css')

@endsection

@section('js')
<script>
    $(function () { 

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* 6. Nice Selectorp  */
    var nice_Select = $('select');
    if(nice_Select.length){
      nice_Select.niceSelect();
    }
    
    $('form[name="roteiro"]').submit(function (event) {
        event.preventDefault();

        const form = $(this);
        const action = form.attr('action');
        const slug = form.find('select[name="slug"]').val();       

        $.post(action, {slug: slug}, function (response) {  
            if(response.redirect) {                
                setTimeout(function() {
                    window.location.href = response.redirect + '#reservar';
                }, 2000);                                
            }
        }, 'json');

    });

    });
</script>
@endsection
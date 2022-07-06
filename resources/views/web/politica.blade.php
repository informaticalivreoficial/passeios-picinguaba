@extends('web.master.master')

@section('content')

<div class="slider-area ">
    <!-- Mobile Menu -->
    <div class="single-slider slider-height2 d-flex align-items-center" data-background="{{$configuracoes->gettopodosite()}}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2>Políticas de Privacidade</h2>
                        <p><a href="{{route('web.home')}}" class="text-white">Início</a> >> Políticas de Privacidade</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>

 <section class="blog_area single-post-area section-padding">
    <div class="container">
       <div class="row">
          <div class="col-lg-12 posts-list">
             <div class="single-post">
                <div class="blog_details">
                    {!! $configuracoes->politicas_de_privacidade !!}
                </div>
            </div>
        </div>
    </div>
@endsection
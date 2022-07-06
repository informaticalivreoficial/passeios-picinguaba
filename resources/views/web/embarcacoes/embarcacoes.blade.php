@extends('web.master.master')


@section('content')

<div class="slider-area ">        
    <div class="single-slider slider-height2 d-flex align-items-center" data-background="{{$configuracoes->gettopodosite()}}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2>Embarcações</h2>
                        <p><a href="{{route('web.home')}}" class="text-white">Início</a> >> Embarcações</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

<div class="favourite-place place-padding">
    <div class="container">       
        <div class="row">
            @if($embarcacoes->count() && $embarcacoes->count() > 0)
                @foreach ($embarcacoes as $embarcacao)
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-place mb-30">
                        <div class="place-img">
                            <a href="{{route('web.embarcacao', ['slug' => $embarcacao->slug])}}">
                                <img src="{{$embarcacao->cover()}}" alt="{{$embarcacao->name}}">
                            </a>
                        </div>
                        <div class="place-cap">
                            <div class="place-cap-top">
                                <h2><a href="{{route('web.embarcacao', ['slug' => $embarcacao->slug])}}">{{$embarcacao->name}}</a></h2>
                            </div>                            
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

@endsection
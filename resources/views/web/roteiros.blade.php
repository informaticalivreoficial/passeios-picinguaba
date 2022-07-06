@extends('web.master.master')


@section('content')

    <div class="slider-area ">        
        <div class="single-slider slider-height2 d-flex align-items-center" data-background="{{$configuracoes->gettopodosite()}}">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">
                            <h2>Roteiros</h2>
                            <p><a href="{{route('web.home')}}" class="text-white">Início</a> >> Roteiros</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    
    <div class="favourite-place place-padding">
        <div class="container">           
            <div class="row">
                @if($roteiros->count() && $roteiros->count() > 0)
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
                @endif
            </div>
        </div>
    </div>

    <!-- Pagination-area Start -->
    <div class="pagination-area pb-100 text-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="single-wrap d-flex justify-content-center">                       
                        {{ $roteiros->links() }}  
                    </div>
                </div>
            </div>
        </div>
    </div>
    


@endsection

@section('css')

@endsection

@section('js')

@endsection
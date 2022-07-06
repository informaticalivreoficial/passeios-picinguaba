@extends('web.master.master')


@section('content')

<div class="slider-area ">        
    <div class="single-slider slider-height2 d-flex align-items-center" data-background="{{$configuracoes->gettopodosite()}}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2>Parceiros</h2>
                        <p><a href="{{route('web.home')}}" class="text-white">Início</a> >> Parceiros</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

<div class="whole-wrap">
    <div class="container box_1170">
        @if (!empty($parceiros && $parceiros->count() > 0))
            @foreach ($parceiros as $parceiro)
                <div class="section-top-border">
                    <a href="{{route('web.parceiro', ['slug' => $parceiro->slug])}}">
                        <h3 class="mb-30">{{$parceiro->name}}</h3>
                    </a>
                    <div class="row">
                        <div class="col-md-3">
                           <a href="{{route('web.parceiro', ['slug' => $parceiro->slug])}}"><img src="{{$parceiro->cover()}}" alt="{{$parceiro->ame}}" class="img-fluid"></a> 
                        </div>
                        <div class="col-md-9 mt-sm-20">
                            {!!$parceiro->content_web!!}
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{route('web.parceiro', ['slug' => $parceiro->slug])}}" class="genric-btn info">+ informações</a>
                                </div>
                                <div class="col-6">
                                    <ul class="blog-info-link">
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
                            </div> 
                        </div>
                    </div>
                </div>
            @endforeach
        @endif  
        <nav class="blog-pagination justify-content-center d-flex">
            {{ $parceiros->links() }} 
        </nav>      
    </div>
</div>
@endsection
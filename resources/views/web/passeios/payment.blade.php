@extends('web.master.master')

@section('content')
<section class="contact-section" style="background-color: #eee;">
    <div class="container">
        <div class="row">
            <div class="col-12">        
                @if(session()->exists('message'))
                    <div class="alert alert-{{ session()->get('color') }} alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ session()->get('message') }}
                    </div>                
                @endif
            </div>
        </div>
    </div>
</section>

@endsection

@section('css')

@endsection

@section('js')

@endsection
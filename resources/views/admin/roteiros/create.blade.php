@extends('adminlte::page')

@section('title', 'Cadastrar Roteiro')

@php
$config = [
    "height" => "300",
    "fontSizes" => ['8', '9', '10', '11', '12', '14', '18'],
    "lang" => 'pt-BR',
    "toolbar" => [
        // [groupName, [list of button]]
        ['style', ['style']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['style', ['bold', 'italic', 'underline', 'clear']],
        //['font', ['strikethrough', 'superscript', 'subscript']],        
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video','hr']],
        ['view', ['fullscreen', 'codeview']],
    ],
]
@endphp

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-search mr-2"></i>Cadastrar novo Roteiro</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="{{route('roteiros.index')}}">Roteiros</a></li>
            <li class="breadcrumb-item active">Cadastrar novo Roteiro</li>
        </ol>
    </div>
</div> 
@stop

@section('content')
<div class="row">
    <div class="col-12">
       @if($errors->all())
            @foreach($errors->all() as $error)
                @message(['color' => 'danger'])
                {{ $error }}
                @endmessage
            @endforeach
        @endif         
    </div>            
</div>   
                    
            
<form action="{{ route('roteiros.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
@csrf          
<div class="row">            
<div class="col-12">
<div class="card card-teal card-outline card-outline-tabs">                            
<div class="card-header p-0 border-bottom-0">
<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Informações</a>
    </li>  
    <li class="nav-item">
        <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Fotos</a>
    </li>      
</ul>
</div>
<div class="card-body">
<div class="tab-content" id="custom-tabs-four-tabContent">
    <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
       
        <div class="row mb-2"> 
            <div class="col-12 col-md-4 col-lg-5"> 
                <div class="form-group">
                    <label class="labelforms text-muted"><b>*Nome do Roteiro</b> </label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                </div>
            </div> 
            <div class="col-12 col-md-6 col-lg-5">   
                <div class="form-group">
                    <label class="labelforms text-muted"><b>Headline</b> <small class="text-info">(Chamada que vai em destaque nas redes sociais)</small></label>
                    <input type="text" class="form-control" name="headline" value="{{old('headline')}}">
                </div>                                                    
            </div>          
              
            <div class="col-3 col-md-4 col-lg-2">
                <div class="form-group">
                    <label class="labelforms text-muted"><b>Status:</b></label>
                    <select name="status" class="form-control">
                        <option value="1" {{ (old('status') == '1' ? 'selected' : '') }}>Publicado</option>
                        <option value="0" {{ (old('status') == '0' ? 'selected' : '') }}>Rascunho</option>
                    </select>
                </div>
            </div>                           
        </div>
        <div class="col-12 mb-1"> 
            <div class="form-group">
                <label class="labelforms text-muted"><b>MetaTags</b></label>
                <input id="tags_1" class="tags" rows="5" name="metatags" value="{{ old('metatags') }}">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">   
                <label class="labelforms text-muted"><b>Descrição do Roteiro</b></label>
                <x-adminlte-text-editor name="content" v placeholder="Descrição do roteiro..." :config="$config">{{ old('content') }}</x-adminlte-text-editor>                                                                                     
            </div>
            <div class="col-12">   
                <label class="labelforms text-muted"><b>Informações Adicionais</b></label>
                <textarea id="inputDescription" class="form-control" rows="5" name="notasadicionais">{{ old('notasadicionais') }}</textarea>                                                      
            </div>
            <div class="col-12 mt-3">   
                <label class="labelforms text-muted"><b>Mapa do Google</b> <small class="text-info">(Copie o código de incorporação do Google Maps e cole abaixo)</small></label>
                <textarea id="inputDescription" class="form-control" rows="5" name="mapadogoogle">{{ old('mapadogoogle') }}</textarea>                                                      
            </div>
        </div>
                
    </div>                                   
    
    
    <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
        <div class="row mb-4">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6"> 
                <div class="form-group">
                    <label class="labelforms text-muted"><b>Deseja exibir uma Marca D'agua? </b><small class="text-info">(esta opção permite inserir uma marca em todas as imagens)</small></label>
                    <div class="form-check">
                        <input id="exibirmarcadaguasim" class="form-check-input" type="radio" value="1" name="exibirmarcadagua" {{(old('exibirmarcadagua') == '1' ? 'checked' : '')}}>
                        <label for="exibirmarcadaguasim" class="form-check-label mr-5">Sim</label>
                        <input id="exibirmarcadaguanao" class="form-check-input" type="radio" value="0" name="exibirmarcadagua" {{(old('exibirmarcadagua') == '0' ? 'checked' : '')}}>
                        <label for="exibirmarcadaguanao" class="form-check-label">Não</label>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">   
                <div class="form-group">
                    <label class="labelforms text-muted"><b>Legenda da Imagem de Capa</b></label>
                    <input type="text" class="form-control"  name="legendaimgcapa" value="{{ old('legendaimgcapa') }}">
                </div>                                                    
            </div>
            <div class="col-sm-12">                                        
                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="files[]" multiple>
                        <label class="custom-file-label" for="exampleInputFile">Escolher Fotos</label>
                    </div>
                </div>                                        
                <div class="content_image"></div>
            </div>
        </div> 
    </div>   
    

</div>
<div class="row text-right">
    <div class="col-12 my-3">
        <button type="submit" class="btn btn-lg btn-success"><i class="nav-icon fas fa-check mr-2"></i> Cadastrar Agora</button>
    </div>
</div> 
                        
</form>                 
            
@stop

@section('css')
    <!--tags input-->
    <link rel="stylesheet" href="{{url(asset('backend/plugins/jquery-tags-input/jquery.tagsinput.css'))}}" />
    <style type="text/css">
        div.tagsinput span.tag {
            background: #65CEA7 !important;
            border-color: #65CEA7;
            color: #fff;
            border-radius: 15px;
            -webkit-border-radius: 15px;
            padding: 3px 10px;
        }
        div.tagsinput span.tag a {
            color: #43886e;    
        }
        .property_image, .content_image {
            width: 100%;
            flex-basis: 100%;
            display: flex;
            justify-content: flex-start;
            flex-wrap: wrap;
        }
        .property_image .property_image_item, .content_image .property_image_item {
            flex-basis: calc(25% - 20px) !important;
            margin-bottom: 20px;
            margin-right: 20px;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            position: relative;
        }

        .property_image .property_image_item img, .content_image .property_image_item img {
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
        }
        .property_image .property_image_item .property_image_actions, .content_image .property_image_item .property_image_actions {
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .embed {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            max-width: 100%;
        }
    </style>
    @stop

@section('js')

<script src="{{url(asset('backend/assets/js/jquery.mask.js'))}}"></script>
<script>
    $(document).ready(function () { 
        var $zipcode = $(".mask-zipcode");
        $zipcode.mask('00.000-000', {reverse: true});       
        var $money = $(".mask-money");
        $money.mask('R$ 000.000.000.000.000,00', {reverse: true, placeholder: "R$ 0,00"});
    });
</script>

<!--tags input-->
<script src="{{url(asset('backend/plugins/jquery-tags-input/jquery.tagsinput.js'))}}"></script>
<script>
    $(function () { 
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });  
        
        $('input[name="files[]"]').change(function (files) {

            $('.content_image').text('');

            $.each(files.target.files, function (key, value) {
                var reader = new FileReader();
                reader.onload = function (value) {
                    $('.content_image').append(
                        '<div id="list" class="property_image_item">' +
                        '<div class="embed radius" style="background-image: url(' + value.target.result + '); background-size: cover; background-position: center center;"></div>' +
                        '<div class="property_image_actions">' +
                            '<a href="javascript:void(0)" class="btn btn-danger btn-xs image-remove px-2"><i class="nav-icon fas fa-times"></i> </a>' +
                        '</div>' +
                        '</div>');

                    $('.image-remove').click(function(){
                        $(this).closest('#list').remove()
                    });
                };
                reader.readAsDataURL(value);
            });
        });
        
        //tag input
        function onAddTag(tag) {
            alert("Adicionar uma Tag: " + tag);
        }
        function onRemoveTag(tag) {
            alert("Remover Tag: " + tag);
        }
        function onChangeTag(input,tag) {
            alert("Changed a tag: " + tag);
        }
        $(function() {
            $('#tags_1').tagsInput({
                width:'auto',
                height:200
            });
        });
    });
</script>
@stop
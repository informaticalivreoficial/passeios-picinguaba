@extends('adminlte::page')

@section('title', 'Cadastrar Passeio')

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
        <h1><i class="fas fa-search mr-2"></i>Cadastrar novo Passeio</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="{{route('passeios.index')}}">Passeios</a></li>
            <li class="breadcrumb-item active">Cadastrar novo Passeio</li>
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
                    
            
<form action="{{ route('passeios.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
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
        <a class="nav-link" id="custom-tabs-four-integracao-tab" data-toggle="pill" href="#custom-tabs-four-integracao" role="tab" aria-controls="custom-tabs-four-integracao" aria-selected="false">Valores</a>
    </li>                                                              
       
</ul>
</div>
<div class="card-body">
<div class="tab-content" id="custom-tabs-four-tabContent">
    <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
        <div class="row mb-4">
            <div class="col-sm-12 bg-gray-light">                                        
                <!-- checkbox -->
                <div class="form-group p-3 mb-0">
                    <span class="mr-3 text-muted"><b>Finalidade:</b></span>  
                    <div class="form-check d-inline mx-2">
                        <input id="venda" class="form-check-input" type="checkbox" name="venda" {{ (old('venda') == 'on' || old('venda') == true ? 'checked' : '') }}>
                        <label for="venda" class="form-check-label">Venda individual</label>
                    </div>
                    <div class="form-check d-inline mx-2">
                        <input id="locacao" class="form-check-input" type="checkbox"  name="locacao" {{ (old('locacao') == 'on' || old('locacao') == true ? 'checked' : '') }}>
                        <label for="locacao" class="form-check-label">Venda de Pacote</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4"> 
            <div class="col-12 col-md-4 col-lg-5"> 
                <div class="form-group">
                    <label class="labelforms text-muted"><b>*Roteiro</b></label>
                    <select class="form-control" name="roteiro_id">                        
                        @if (!empty($roteiros) && $roteiros->count() > 0)
                            <option value=""> Selecione o Roteiro </option>
                            @foreach ($roteiros as $roteiro)
                                <option value="{{$roteiro->id}}" {{ (old('roteiro_id') == $roteiro->id ? 'selected' : '') }}> {{$roteiro->name}} </option>
                            @endforeach
                        @else
                            <option value=""> Cadastre um Roteiro </option>
                        @endif
                    </select>
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
            <div class="col-12 col-sm-6 col-md-4 col-lg-1"> 
                <div class="form-group">
                    <label class="labelforms text-muted"><b>Vagas</b></label>
                    <input type="text" class="form-control" name="vagas" value="{{ old('vagas') }}">
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-2"> 
                <div class="form-group">
                    <label class="labelforms text-muted"><b>Horário de saída</b></label>
                    <div class="input-group">
                        <input type="text" class="form-control only-time" data-language='pt-BR' name="saida" value="{{ old('saida') }}"/>
                        <div class="input-group-append">
                            <div class="input-group-text"><i class="fa fa-clock"></i></div>
                        </div>
                    </div>
                </div> 
            </div>                    
            <div class="col-12 col-sm-6 col-md-4 col-lg-2"> 
                <div class="form-group">
                    <label class="labelforms text-muted"><b>Duração do Passeio</b></label>
                    <div class="input-group">
                        <input type="text" class="form-control only-time" data-language='pt-BR' name="duracao" value="{{ old('duracao') }}"/>
                        <div class="input-group-append">
                            <div class="input-group-text"><i class="fa fa-clock"></i></div>
                        </div>
                    </div>
                </div> 
            </div>                          
        </div>
        
        <div id="accordion">
            <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
            <div class="card">
                <div class="card-header">
                    <h4>                          
                        <a style="border:none;color: #555;" data-toggle="collapse" data-parent="#accordion" href="#collapseValores">
                            <i class="nav-icon fas fa-plus mr-2"></i> Ative as Datas para o Passeio
                        </a>
                    </h4>
                </div>
                <div id="collapseValores" class="panel-collapse collapse show">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="form-group p-3 mb-1">
                                    <div class="form-check mb-3">
                                        <input id="segunda" class="form-check-input" type="checkbox" name="segunda" {{ (old('segunda') == 'on' || old('segunda') == true ? 'checked' : '') }}>
                                        <label for="segunda" class="form-check-label">Segunda</label>
                                    </div> 
                                    <div class="form-check mb-3">
                                        <input id="sexta" class="form-check-input" type="checkbox" name="sexta" {{ (old('sexta') == 'on' || old('sexta') == true ? 'checked' : '' ) }}>
                                        <label for="sexta" class="form-check-label">Sexta</label>
                                    </div>                                                    
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="form-group p-3 mb-1">
                                    <div class="form-check mb-3">
                                        <input id="terca" class="form-check-input" type="checkbox" name="terca" {{ (old('terca') == 'on' || old('terca') == true ? 'checked' : '' ) }}>
                                        <label for="terca" class="form-check-label">Terça</label>
                                    </div>   
                                    <div class="form-check mb-3">
                                        <input id="sabado" class="form-check-input" type="checkbox" name="sabado" {{ (old('sabado') == 'on' || old('sabado') == true ? 'checked' : '') }}>
                                        <label for="sabado" class="form-check-label">Sábado</label>
                                    </div>            
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="form-group p-3 mb-1">
                                    <div class="form-check mb-3">
                                        <input id="quarta" class="form-check-input" type="checkbox" name="quarta" {{ (old('quarta') == 'on' || old('quarta') == true ? 'checked' : '') }}>
                                        <label for="quarta" class="form-check-label">Quarta</label>
                                    </div>  
                                    <div class="form-check mb-3">
                                        <input id="domingo" class="form-check-input" type="checkbox" name="domingo" {{ (old('domingo') == 'on' || old('domingo') == true ? 'checked' : '') }}>
                                        <label for="domingo" class="form-check-label">Domingo</label>
                                    </div>               
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="form-group p-3 mb-1">
                                    <div class="form-check mb-2">
                                        <input id="quinta" class="form-check-input" type="checkbox" name="quinta" {{ (old('quinta') == 'on' || old('quinta') == true ? 'checked' : '') }}>
                                        <label for="quinta" class="form-check-label">Quinta</label>
                                    </div>          
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h4>
                        <a style="border:none;color: #555;" data-toggle="collapse" data-parent="#accordion" href="#collapseEndereco">
                            <i class="nav-icon fas fa-plus mr-2"></i> Local de saída
                        </a>
                    </h4>
                </div>
                <div id="collapseEndereco" class="panel-collapse collapse show">
                    <div class="card-body">
                        <div class="row mb-2">                           
                            <div class="col-12 col-md-4 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Estado:</b></label>
                                    <select id="state-dd" class="form-control" name="uf">
                                        @if(!empty($estados))
                                            <option value="">Selecione o Estado</option>
                                            @foreach($estados as $estado)
                                            <option value="{{$estado->estado_id}}" {{ (old('uf') == $estado->estado_id ? 'selected' : '') }}>{{$estado->estado_nome}}</option>
                                            @endforeach                                                                        
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Cidade:</b></label>
                                    <select id="city-dd" class="form-control" name="cidade">
                                        @if(!empty($cidades)))
                                            <option value="">Selecione o Estado</option>
                                            @foreach($cidades as $cidade)
                                                <option value="{{$cidade->cidade_id}}" 
                                                        {{ (old('cidade') == $cidade->cidade_id ? 'selected' : '') }}>{{$cidade->cidade_nome}}</option>                                                                   
                                            @endforeach                                                                        
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Bairro:</b></label>
                                    <input type="text" class="form-control" title="Bairro" name="bairro" value="{{old('bairro')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12 col-md-6 col-lg-5"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Endereço:</b></label>
                                    <input type="text" class="form-control" title="Endereço Completo" name="rua" value="{{old('rua')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-2"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Número:</b></label>
                                    <input type="text" class="form-control" title="Número do Endereço" name="num" value="{{old('num')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Complemento:</b></label>
                                    <input type="text" class="form-control" title="Completo (Opcional)" name="complemento" value="{{old('complemento')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-2"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>CEP:</b></label>
                                    <input type="text" class="form-control mask-zipcode" title="Digite o CEP" name="cep" value="{{old('cep')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                
                <div id="collapseCaracteristicas" class="panel-collapse collapse show">
                    <div class="card-body">                        
                        <div class="row mb-2">
                            <div class="col-12">   
                                <label class="labelforms text-muted"><b>Informações Adicionais</b></label>
                                <textarea id="inputDescription" class="form-control" rows="5" name="notasadicionais">{{ old('notasadicionais') }}</textarea>                                                      
                            </div>
                        </div>                                                
                    </div>
                </div>
            </div>
        </div> 
    </div> 
    

    <div class="tab-pane fade" id="custom-tabs-four-integracao" role="tabpanel" aria-labelledby="custom-tabs-four-integracao-tab">
        <div class="row">
            <div class="col-sm-12 text-muted">
                <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
            <div class="card">
                <div class="card-header">
                    <h4>                          
                        <a style="border:none;color: #555;" data-toggle="collapse" data-parent="#accordion" href="#collapseValores">
                            <i class="nav-icon fas fa-plus mr-2"></i> Valores para venda Individual
                        </a>
                    </h4>
                </div>
                <div id="collapseValores" class="panel-collapse collapse show">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-12"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Deseja exibir os valores?</b> <small class="text-info">(valores exibidos no layout do cliente)</small></label>
                                    <div class="form-check">
                                        <input id="exibivalores_vendasim" class="form-check-input" type="radio" value="1" name="exibivalores_venda" {{(old('exibivalores_venda') == '1' ? 'checked' : '')}}>
                                        <label for="exibivalores_vendasim" class="form-check-label mr-5">Sim</label>
                                        <input id="exibivalores_vendanao" class="form-check-input" type="radio" value="0" name="exibivalores_venda" {{(old('exibivalores_venda') == '0' ? 'checked' : '')}}>
                                        <label for="exibivalores_vendanao" class="form-check-label">Não</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Valor de Venda</b></label>
                                    <input type="text" class="form-control mask-money" name="valor_venda" value="{{old('valor_venda')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Valor Promocional</b></label>
                                    <input type="text" class="form-control mask-money" name="valor_venda_promocional" value="{{old('valor_venda_promocional')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Criança de 0 a 5 anos</b></label>
                                    <input type="text" class="form-control mask-money" name="valor_v_zerocinco" value="{{old('valor_v_zerocinco')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Criança de 6 a 12 anos</b></label>
                                    <input type="text" class="form-control mask-money" name="valor_v_seisdoze" value="{{old('valor_v_seisdoze')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
            <div class="card">
                <div class="card-header">
                    <h4>                          
                        <a style="border:none;color: #555;" data-toggle="collapse" data-parent="#accordion" href="#collapseValores">
                            <i class="nav-icon fas fa-plus mr-2"></i> Valores para Pacote
                        </a>
                    </h4>
                </div>
                <div id="collapseValores" class="panel-collapse collapse show">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-12"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Deseja exibir os valores?</b> <small class="text-info">(valores exibidos no layout do cliente)</small></label>
                                    <div class="form-check">
                                        <input id="exibivalores_locacaosim" class="form-check-input" type="radio" value="1" name="exibivalores_locacao" {{(old('exibivalores_locacao') == '1' ? 'checked' : '')}}>
                                        <label for="exibivalores_locacaosim" class="form-check-label mr-5">Sim</label>
                                        <input id="exibivalores_locacaonao" class="form-check-input" type="radio" value="0" name="exibivalores_locacao" {{(old('exibivalores_locacao') == '0' ? 'checked' : '')}}>
                                        <label for="exibivalores_locacaonao" class="form-check-label">Não</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Valor do Pacote</b></label>
                                    <input type="text" class="form-control mask-money" name="valor_locacao" value="{{old('valor_locacao')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Valor Promocional</b></label>
                                    <input type="text" class="form-control mask-money" name="valor_locacao_promocional" value="{{old('valor_locacao_promocional')}}">
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>         
    </div>
</div>
<div class="row text-right">
    <div class="col-12 mb-4">
        <button type="submit" class="btn btn-lg btn-success"><i class="nav-icon fas fa-check mr-2"></i> Cadastrar Agora</button>
    </div>
</div> 
                        
</form>                 
            
@stop

@section('css')
<link href="{{url(asset('backend/plugins/airdatepicker/css/datepicker.min.css'))}}" rel="stylesheet" type="text/css">
<style>
    .only-timepicker .datepicker--nav,
    .only-timepicker .datepicker--content {
        display: none;
    }
    .only-timepicker .datepicker--time {
        border-top: none;
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
<script src="{{url(asset('backend/plugins/airdatepicker/js/datepicker.min.js'))}}"></script>
<script src="{{url(asset('backend/plugins/airdatepicker/js/i18n/datepicker.pt-BR.js'))}}"></script>
<script>
    $(function () { 
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.only-time').datepicker({
            confirmButton:true,
            clearButton:true,
            autoClose:true,
            // dateFormat: ' ',
            // timeFormat: 'hh:ii',
            // classes: 'only-timepicker'
            dateFormat: ' ',
            timepicker: true,
            classes: 'only-timepicker'
        });
        var okButton = '<span class="datepicker--button" data-action="hide">Ok</span>'; 
        $('.datepicker--button[data-action="clear"]').each(function( index ) { 
            $(okButton).insertBefore($(this)); 
        });
        
        $('#state-dd').on('change', function () {
            var idState = this.value;
            $("#city-dd").html('Carregando...');
            $.ajax({
                url: "{{route('passeios.fetchCity')}}",
                type: "POST",
                data: {
                    estado_id: idState,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res) {
                    $('#city-dd').html('<option value="">Selecione a cidade</option>');
                    $.each(res.cidades, function (key, value) {
                        $("#city-dd").append('<option value="' + value
                            .cidade_id + '">' + value.cidade_nome + '</option>');
                    });
                }
            });
        });
             
        
    });
</script>
@stop
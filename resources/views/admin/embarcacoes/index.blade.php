@extends('adminlte::page')

@section('title', 'Gerenciar Embarcações')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-search mr-2"></i> Embarcações</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">                    
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item active">Embarcações</li>
        </ol>
    </div>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header text-right">
        <a href="{{route('embarcacoes.create')}}" class="btn btn-sm btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Novo</a>
    </div>        
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-12">                
                @if(session()->exists('message'))
                    @message(['color' => session()->get('color')])
                        {{ session()->get('message') }}
                    @endmessage
                @endif
            </div>           
        </div>
        @if(!empty($embarcacoes) && $embarcacoes->count() > 0)
            <table class="table table-bordered table-striped projects">
                <thead>
                    <tr>
                        <th class="text-center">Capa</th>
                        <th>Nome</th>
                        <th class="text-center">Imagens</th>
                        <th class="text-center">Views</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($embarcacoes as $embarcacao)                    
                    <tr style="{{ ($embarcacao->status == '1' ? '' : 'background: #fffed8 !important;')  }}">
                        <td class="text-center">
                            <a href="{{url($embarcacao->nocover())}}" data-title="{{$embarcacao->name}}" data-toggle="lightbox">
                                <img alt="{{$embarcacao->name}}" src="{{url($embarcacao->cover())}}" width="60">
                            </a>
                        </td>
                        <td>{{$embarcacao->name}}</td>
                        <td class="text-center">{{$embarcacao->countimages()}}</td>
                        <td class="text-center">{{$embarcacao->views}}</td>
                        <td>
                            <input type="checkbox" data-onstyle="success" data-offstyle="warning" data-size="mini" class="toggle-class" data-id="{{ $embarcacao->id }}" data-toggle="toggle" data-style="slow" data-on="<i class='fas fa-check'></i>" data-off="<i style='color:#fff !important;' class='fas fa-exclamation-triangle'></i>" {{ $embarcacao->status == true ? 'checked' : ''}}>
                            <a target="_blank" href="{{route('web.embarcacao',['slug' => $embarcacao->slug])}}" title="Visualizar" class="btn btn-xs btn-info text-white"><i class="fas fa-search"></i></a>
                            <a href="{{route('embarcacoes.edit',['id' => $embarcacao->id])}}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                            <button type="button" class="btn btn-xs btn-secondary text-white j_modal_qrcode" title="QrCode" data-slug="{{$embarcacao->slug}}" data-toggle="modal" data-target="#modal-qrcode">
                                <i class="fas fa-qrcode"></i>
                            </button>
                            <button type="button" class="btn btn-xs btn-danger text-white j_modal_btn" data-id="{{$embarcacao->id}}" data-toggle="modal" data-target="#modal-default">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>                
            </table>
        @else
            <div class="row mb-4">
                <div class="col-12">                                                        
                    <div class="alert alert-info p-3">
                        Não foram encontrados registros!
                    </div>                                                        
                </div>
            </div>
        @endif
    </div>
    <div class="card-footer paginacao">
        {{ $embarcacoes->links() }}          
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->   


<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="frm" action="" method="post">            
            @csrf
            @method('DELETE')
            <input id="id_embarcacao" name="embarcacao_id" type="hidden" value=""/>
                <div class="modal-header">
                    <h4 class="modal-title">Remover Embarcação!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span class="j_param_data"></span>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                    <button type="submit" class="btn btn-primary">Excluir Agora</button>
                </div>
            </form>
        </div>        
    </div>
</div>

<div class="modal fade" id="modal-qrcode">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Copiar QrCode</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">                
                <img id="qrcode" src="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>            
        </div>        
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{url(asset('backend/plugins/ekko-lightbox/ekko-lightbox.css'))}}">
<link href="{{url(asset('backend/plugins/bootstrap-toggle/bootstrap-toggle.min.css'))}}" rel="stylesheet">
@stop

@section('js')
    <script src="{{url(asset('backend/plugins/ekko-lightbox/ekko-lightbox.min.js'))}}"></script>
    <script src="{{url(asset('backend/plugins/bootstrap-toggle/bootstrap-toggle.min.js'))}}"></script>
    <script>
       $(function () {           
           
           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
           
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
              event.preventDefault();
              $(this).ekkoLightbox({
                alwaysShowClose: true
              });
            }); 
            
            //FUNÇÃO PARA EXCLUIR
            $('.j_modal_btn').click(function() {
                var embarcacao_id = $(this).data('id');                
                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('embarcacoes.delete') }}",
                    data: {
                       'id': embarcacao_id
                    },
                    success:function(data) {
                        if(data.error){
                            $('.j_param_data').html(data.error);
                            $('#id_embarcacao').val(data.id);
                            $('#frm').prop('action','{{ route('embarcacoes.deleteon') }}');
                        }else{
                            $('#frm').prop('action','{{ route('embarcacoes.deleteon') }}');
                        }
                    }
                });
            });

            //GERAR QRCODE
            $('.j_modal_qrcode').click(function() {
                var slug = $(this).data('slug');                
                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('embarcacoes.qrCode') }}",
                    data: {
                       'slug': slug
                    },
                    success:function(data) {
                        if(data.error){
                            $('.j_param_data').html(data.error);                           
                        }else{
                            $('#qrcode').prop('src',data.qrcode);
                        }
                    }
                });
            });
            
            $('#toggle-two').bootstrapToggle({
                on: 'Enabled',
                off: 'Disabled'
            });
            
            $('.toggle-class').on('change', function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var embarcacao_id = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: '{{ route('embarcacoes.embarcacaoSetStatus') }}',
                    data: {
                        'status': status,
                        'id': embarcacao_id
                    },
                    success:function(data) {
                        
                    }
                });
            });
        });
    </script>
@endsection
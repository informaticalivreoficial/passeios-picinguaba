@extends('adminlte::page')

@section('title', 'Gerenciar Roteiros')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-search mr-2"></i> Roteiros</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">                    
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item active">Roteiros</li>
        </ol>
    </div>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-12 col-sm-6 my-2">
                <div class="card-tools">
                    <div style="width: 250px;">
                        <form class="input-group input-group-sm" action="{{route('roteiros.search')}}" method="post">
                            @csrf   
                            <input type="text" name="filter" value="{{ $filters['search'] ?? '' }}" class="form-control float-right" placeholder="Pesquisar">
            
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                  </div>
            </div>
            <div class="col-12 col-sm-6 my-2 text-right">
                <a href="{{route('roteiros.create')}}" class="btn btn-sm btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Novo</a>
            </div>
        </div>
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
        @if(!empty($roteiros) && $roteiros->count() > 0)
            <table class="table table-bordered table-striped projects">
                <thead>
                    <tr>
                        <th class="text-center">Capa</th>
                        <th>Roteiro</th>
                        <th class="text-center">Imagens</th>
                        <th class="text-center">Views</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roteiros as $roteiro)                    
                    <tr style="{{ ($roteiro->status == '1' ? '' : 'background: #fffed8 !important;')  }}">
                        <td class="text-center">
                            <a href="{{url($roteiro->nocover())}}" data-title="{{$roteiro->name}}" data-toggle="lightbox">
                                <img alt="{{$roteiro->name}}" src="{{url($roteiro->cover())}}" width="60">
                            </a>
                        </td>
                        <td>{{$roteiro->name}}</td>
                        <td class="text-center">{{$roteiro->countimages()}}</td>
                        <td class="text-center">{{$roteiro->views}}</td>
                        <td>
                            <input type="checkbox" data-onstyle="success" data-offstyle="warning" data-size="mini" class="toggle-class" data-id="{{ $roteiro->id }}" data-toggle="toggle" data-style="slow" data-on="<i class='fas fa-check'></i>" data-off="<i style='color:#fff !important;' class='fas fa-exclamation-triangle'></i>" {{ $roteiro->status == true ? 'checked' : ''}}>
                            <button data-toggle="tooltip" data-placement="top" title="Inserir Marca D'agua" type="button" class="btn btn-xs btn-secondary text-white j_marcadagua {{$roteiro->id}} @php if($roteiro->imagesmarcadagua() >= 1){echo '';}else{echo 'disabled';}  @endphp" id="{{$roteiro->id}}" data-id="{{$roteiro->id}}"><i class="fas fa-copyright icon{{$roteiro->id}}"></i></button>                            
                            <a target="_blank" href="{{route('web.roteiro',['slug' => $roteiro->slug])}}" title="Visualizar" class="btn btn-xs btn-info text-white"><i class="fas fa-search"></i></a>
                            <a href="{{route('roteiros.edit',['id' => $roteiro->id])}}" title="Editar" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                            <button type="button" class="btn btn-xs btn-secondary text-white j_modal_qrcode" title="QrCode" data-slug="{{$roteiro->slug}}" data-toggle="modal" data-target="#modal-qrcode">
                                <i class="fas fa-qrcode"></i>
                            </button>
                            <button type="button" class="btn btn-xs btn-danger text-white j_modal_btn" title="Excluir" data-id="{{$roteiro->id}}" data-toggle="modal" data-target="#modal-default">
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
        @if (isset($filters))
            {{ $roteiros->appends($filters)->links() }}
        @else
            {{ $roteiros->links() }}
        @endif          
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
            <input id="id_roteiro" name="roteiro_id" type="hidden" value=""/>
                <div class="modal-header">
                    <h4 class="modal-title">Remover Roteiro!</h4>
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

@section('plugins.Toastr', true)

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

            // FUNÇÃO MARCA DAGUA
            $('.j_marcadagua').click(function(){
                var imovel_id = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('roteiros.marcadagua') }}",
                    data: {
                       'id': imovel_id
                    },
                    beforeSend:function(){
                        $('[data-toggle="tooltip"]').tooltip("hide");
                        $('.icon'+imovel_id).hide();
                        $('.'+imovel_id).html("<img style='width:16px;' src='{{url(asset('backend/assets/images/loading.gif'))}}' />");
                    },
                    complete: function(){
                        $('[data-toggle="tooltip"]').tooltip("hide"); 
                        $('.'+imovel_id).html("<i class='fas fa-copyright icon'></i>");                                  
                    },
                    success:function(data){
                        if(data.success){
                            toastr.success(data.success);
                            $('#'+imovel_id).prop('disabled', true);
                            $('[data-toggle="tooltip"]').tooltip("hide");
                        }else{
                            toastr.error(data.error);
                        }                        
                    }
                });
            });
            
            //FUNÇÃO PARA EXCLUIR
            $('.j_modal_btn').click(function() {
                var roteiro_id = $(this).data('id');                
                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('roteiros.delete') }}",
                    data: {
                       'id': roteiro_id
                    },
                    success:function(data) {
                        if(data.error){
                            $('.j_param_data').html(data.error);
                            $('#id_roteiro').val(data.id);
                            $('#frm').prop('action','{{ route('roteiros.deleteon') }}');
                        }else{
                            $('#frm').prop('action','{{ route('roteiros.deleteon') }}');
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
                    url: "{{ route('roteiros.qrCode') }}",
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
                var roteiro_id = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: '{{ route('roteiros.roteiroSetStatus') }}',
                    data: {
                        'status': status,
                        'id': roteiro_id
                    },
                    success:function(data) {
                        
                    }
                });
            });
        });
    </script>
@endsection
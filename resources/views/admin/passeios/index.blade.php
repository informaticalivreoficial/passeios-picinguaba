@extends('adminlte::page')

@section('title', 'Gerenciar Passeios')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-search mr-2"></i> Gerenciar Passeios</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">                    
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item active">Gerenciar Passeios</li>
        </ol>
    </div>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">            
            <div class="col-12 my-2 text-right">
                <a href="{{route('passeios.create')}}" class="btn btn-sm btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Novo</a>
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
        @if(!empty($passeios) && $passeios->count() > 0)
            <table class="table table-bordered table-striped projects">
                <thead>
                    <tr>
                        <th>Roteiro</th>
                        <th class="text-center">Venda</th>
                        <th class="text-center">Valor</th>
                        <th class="text-center">Vagas</th>                        
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($passeios as $passeio)                    
                    <tr style="{{ ($passeio->status == '1' ? '' : 'background: #fffed8 !important;')  }}">                        
                        <td>{{$passeio->roteiro->name}}</td>
                        <td class="text-center">{!!$passeio->getTipoVenda()!!}</td>                       

                        @if ($passeio->venda == '1' && $passeio->locacao == '1')
                            <td class="text-center">R$ {{$passeio->valor_venda}}<br>R$ {{$passeio->valor_locacao}}</td>
                        @elseif($passeio->venda == '1' && $passeio->locacao == null)
                            <td class="text-center">R$ {{$passeio->valor_venda}}</td>
                        @else
                            <td class="text-center">R$ {{$passeio->valor_locacao}}</td>
                        @endif

                        <td class="text-center">{{$passeio->vagas}}</td>
                        
                        <td>
                            <input type="checkbox" data-onstyle="success" data-offstyle="warning" data-size="mini" class="toggle-class" data-id="{{ $passeio->id }}" data-toggle="toggle" data-style="slow" data-on="<i class='fas fa-check'></i>" data-off="<i style='color:#fff !important;' class='fas fa-exclamation-triangle'></i>" {{ $passeio->status == true ? 'checked' : ''}}>
                            <a href="{{route('passeios.edit',['id' => $passeio->id])}}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                            <button type="button" class="btn btn-xs btn-danger text-white j_modal_btn" data-id="{{$passeio->id}}" data-toggle="modal" data-target="#modal-default">
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
        {{ $passeios->links() }}         
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
        <input id="id_passeio" name="passeio_id" type="hidden" value=""/>
            <div class="modal-header">
                <h4 class="modal-title">Remover Passeio!</h4>
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
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
@stop

@section('css')
<link href="{{url(asset('backend/plugins/bootstrap-toggle/bootstrap-toggle.min.css'))}}" rel="stylesheet">
@stop

@section('js')    
    <script src="{{url(asset('backend/plugins/bootstrap-toggle/bootstrap-toggle.min.js'))}}"></script>
    <script>
       $(function () {           
           
           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });          
            
            
            //FUNÇÃO PARA EXCLUIR
            $('.j_modal_btn').click(function() {
                var passeio_id = $(this).data('id');                
                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('passeios.delete') }}",
                    data: {
                       'id': passeio_id
                    },
                    success:function(data) {
                        if(data.error){
                            $('.j_param_data').html(data.error);
                            $('#id_passeio').val(data.id);
                            $('#frm').prop('action','{{ route('passeios.deleteon') }}');
                        }else{
                            $('#frm').prop('action','{{ route('passeios.deleteon') }}');
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
                var passeio_id = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('passeios.passeioSetStatus') }}",
                    data: {
                        'status': status,
                        'id': passeio_id
                    },
                    success:function(data) {
                        
                    }
                });
            });
        });
    </script>
@endsection
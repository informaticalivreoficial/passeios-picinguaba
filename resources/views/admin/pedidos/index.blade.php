@extends('adminlte::page')

@section('title', 'Gerenciar Pedidos')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-search mr-2"></i> Gerenciar Pedidos</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">                    
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item active">Gerenciar Pedidos</li>
        </ol>
    </div>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">            
            
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
        @if(!empty($pedidos) && $pedidos->count() > 0)
            <table class="table table-bordered table-striped projects">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Passeio</th>
                        <th class="text-center">Valor Total</th>
                        <th class="text-center">Status</th>                        
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedidos as $pedido)                    
                    <tr style="{{ ($pedido->status == '1' ? '' : 'background: #fffed8 !important;')  }}">                        
                        <td>{{$pedido->cliente->name}}</td>
                        <td>{{$pedido->passeio->roteiro->name}}</td>                       
                        <td class="text-center">R$ {{$pedido->valor}}</td> 
                        <td class="text-center">{!!$pedido->getStatusPayment()!!}</td>
                        <td class="text-center">
                            <a href="{{route('pedidos.show',['id' => $pedido->id])}}" class="btn btn-xs btn-info text-white"><i class="fas fa-search"></i></a>
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
        {{ $pedidos->links() }}         
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card --> 
@stop

@section('css')

@stop

@section('js')    
    
@endsection
@extends('adminlte::page')

@section('title', 'Visualizar Pedido')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-search mr-2"></i> Visualizar Pedido</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">                    
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item active">Visualizar Pedido</li>
        </ol>
    </div>
</div>
@stop

@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <h4>
                  <img src="{{$configuracoes->getfaveicon()}}" alt="{{$configuracoes->nomedosite}}"> {{$configuracoes->nomedosite}}.
                  <small class="float-right">Data: {{$pedido->created_at}}</small>
                </h4>
              </div>
              <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                Prestador
                <address>
                  <strong>{{$configuracoes->nomedosite}}.</strong><br>
                  {{$configuracoes->rua}}, {{$configuracoes->num}}<br>
                  {{$configuracoes->bairro}}, {{getCidadeNome($configuracoes->cidade, 'cidades')}}<br>
                  Tel: {{$configuracoes->whatsapp}}<br>
                  Email: {{$configuracoes->email}}
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                Cliente
                <address>
                  <strong>{{$pedido->cliente->name}}</strong><br>
                  Tel: {{$pedido->cliente->celular}}<br>
                  Email: {{$pedido->cliente->email}}
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <b>Fatura #{{$pedido->id}}</b><br>
                <br>
                <b>Status da Compra:</b> {!!$pedido->getStatusPayment()!!}              
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                  <tr>                    
                    <th>Passeio</th>
                    <th>Data</th>
                    <th>Passageiros</th>
                    <th>Subtotal</th>
                  </tr>
                  </thead>
                  <tbody>                 
                  <tr>                    
                    <td>{{$pedido->passeio->roteiro->name}} - <b>Saída {{$pedido->passeio->bairro}}</b></td>
                    <td>{{$pedido->data_compra}}</td>
                    <td>{{$pedido->total_passageiros}}</td>
                    <td>R$ {{$pedido->valor}}</td>
                  </tr>                  
                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <!-- accepted payments column -->
              <div class="col-6">
                <p class="lead">Descrição:</p> 
                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                  {!!$pedido->description!!}
                  <br>
                  Local de Saída: {{$pedido->passeio->bairro}}
                  <br>
                  Horário de Saída: {{$pedido->passeio->saida}}
                </p>
              </div>
              <!-- /.col -->
              <div class="col-6"> 
                <div class="table-responsive">
                  <table class="table">                    
                    <tr>
                      <th>Total:</th>
                      <td>R$ {{$pedido->valor}}</td>
                    </tr>
                  </table>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-12">
                <a href="{{route('web.passeios.voucher',['token' => $pedido->token])}}" rel="noopener" target="_blank" class="btn btn-primary float-right"><i class="fas fa-print"></i> Print</a> 
              </div>
            </div>
          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@stop

@section('css')

@stop

@section('js')    
    
@endsection
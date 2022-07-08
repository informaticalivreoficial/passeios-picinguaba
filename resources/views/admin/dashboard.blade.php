@extends('adminlte::page')

@section('title', 'Painel de Controle')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Painel de Controle</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Início</a></li>
            <li class="breadcrumb-item active">Painel de Controle</li>
        </ol>
    </div><!-- /.col -->
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="info-box">
            <span class="info-box-icon bg-teal"><a href="{{route('roteiros.index')}}" title="Roteiros"><i class="fa far fa-compass"></i></a></span>

            <div class="info-box-content">
                <span class="info-box-text"><b>Roteiros</b></span>
                <span class="info-box-text">Disponíveis: {{ $roteirosAvailable }}</span>
                <span class="info-box-text">Inativos: {{ $roteirosUnavailable }}</span>
                <span class="info-box-text">Total: {{ $roteirosTotal }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="info-box">
            <span class="info-box-icon bg-teal"><a href="{{route('passeios.index')}}" title="Passeios"><i class="fa far fa-route"></i></a></span>

            <div class="info-box-content">
                <span class="info-box-text"><b>Passeios</b></span>
                <span class="info-box-text">Disponíveis: {{ $passeiosAvailable }}</span>
                <span class="info-box-text">Inativos: {{ $passeiosUnavailable }}</span>
                <span class="info-box-text">Total: {{ $passeiosTotal }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
    <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="info-box">
            <span class="info-box-icon bg-teal"><a href="{{route('embarcacoes.index')}}" title="Embarcações"><i class="fa far fa-ship"></i></a></span>

            <div class="info-box-content">
                <span class="info-box-text"><b>Embarcações</b></span>
                <span class="info-box-text">Disponíveis: {{ $embarcacoesAvailable }}</span>
                <span class="info-box-text">Inativas: {{ $embarcacoesUnavailable }}</span>
                <span class="info-box-text">Total: {{ $embarcacoesTotal }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
    <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="info-box">
            <span class="info-box-icon bg-teal"><a href="{{route('embarcacoes.index')}}" title="Pedidos"><i class="fa far fa-money-check"></i></a></span>

            <div class="info-box-content">
                <span class="info-box-text"><b>Pedidos</b></span>
                <span class="info-box-text">Aprovados: {{ $pedidosApproved }}</span>
                <span class="info-box-text">Processando: {{ $pedidosInprocess }}</span>
                <span class="info-box-text">Cancelado: {{ $pedidosRejected }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
    <!-- /.info-box -->
    </div>
</div>

<div class="row">
    <section class="col-lg-6 connectedSortable">
            <!-- BAR CHART -->
            <div class="card card-teal">
                <div class="card-header">
                    <h3 class="card-title">Visitas/Últimos 6 meses</h3>

                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
        <section class="col-lg-6 connectedSortable">
        <!-- DONUT CHART -->
        <div class="card card-teal">
            <div class="card-header">
            <h3 class="card-title">Dispositivos/Últimos 6 meses</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
            </div>
            <div class="card-body">
            <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        </section>
    </div><!-- /.row -->


<div class="row">
    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-3">
        <div class="card card-danger">                
            <div class="card-body">
              <canvas id="donutChartusers" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-3">
        <div class="card card-danger">                
            <div class="card-body">
              <canvas id="donutChartposts" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-3">
        <div class="card card-danger">                
            <div class="card-body">
              <canvas id="donutChartpedidos" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>

<section class="col-12 connectedSortable">
    @if(!empty($roteirosTop) && $roteirosTop->count() > 0 )
    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Roteiros mais visitados</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
          <table class="table table-sm">
            <thead>
              <tr>
                <th class="text-center">Foto</th>
                <th>Título</th>
                <th></th>
                <th class="text-center">Visitas</th>
              </tr>
            </thead>
            <tbody>                            
                @foreach($roteirosTop as $roteirotop)
                @php
                    //REALIZA PORCENTAGEM DE VISITAS!
                    if($roteirotop->views == '0'){
                        $percentr = 1;
                    }else{
                        $percentr = substr(( $roteirotop['views'] / $totalviewsroteiros ) * 100, 0, 5);
                    }
                    $percenttagr = str_replace(",", ".", $percentr);
                @endphp
                <tr>
                    <td class="text-center">
                        <a href="{{url($roteirotop->nocover())}}" data-title="{{$roteirotop->name}}" data-toggle="lightbox"> 
                            <img src="{{url($roteirotop->cover())}}" alt="{{$roteirotop->name}}" class="img-size-50">
                        </a>
                    </td>
                    <td>{{$roteirotop->name}}</td>
                    <td style="width:10%;">
                      <div class="progress progress-md progress-striped active">
                        <div class="progress-bar bg-primary" style="width: {{$percenttagr}}%" title="{{$percenttagr}}%"></div>
                      </div>
                    </td>
                    <td class="text-center">
                      <span class="badge bg-primary">{{$roteirotop->views}}</span>
                      <a data-toggle="tooltip" data-placement="top" title="Editar Roteiro" href="{{route('roteiros.edit', ['id' => $roteirotop->id])}}" class="btn btn-xs btn-default ml-2"><i class="fas fa-pen"></i></a>
                    </td>
                </tr>
                @endforeach                            
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
    </div>
    @endif
    @if(!empty($artigosTop) && $artigosTop->count() > 0)
    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Artigos mais visitados</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
          <table class="table table-sm">
            <thead>
              <tr>
                <th class="text-center">Foto</th>
                <th>Título</th>
                <th></th>
                <th class="text-center">Visitas</th>
              </tr>
            </thead>
            <tbody>                            
                @foreach($artigosTop as $artigotop)
                @php
                    //REALIZA PORCENTAGEM DE VISITAS!
                    if($artigotop->views == '0'){
                        $percent = 1;
                    }else{
                        $percent = substr(( $artigotop['views'] / $artigostotalviews ) * 100, 0, 5);
                    }
                    $percenttag = str_replace(",", ".", $percent);
                @endphp
                <tr>
                    <td class="text-center">
                        <a href="{{url($artigotop->nocover())}}" data-title="{{$artigotop->titulo}}" data-toggle="lightbox"> 
                            <img src="{{url($artigotop->cover())}}" alt="{{$artigotop->titulo}}" class="img-size-50">
                        </a>
                    </td>
                    <td>{{$artigotop->titulo}}</td>
                    <td style="width:10%;">
                      <div class="progress progress-md progress-striped active">
                        <div class="progress-bar bg-primary" style="width: {{$percenttag}}%" title="{{$percenttag}}%"></div>
                      </div>
                    </td>
                    <td class="text-center">
                      <span class="badge bg-primary">{{$artigotop->views}}</span>
                      <a data-toggle="tooltip" data-placement="top" title="Editar Artigo" href="{{route('posts.edit', ['id' => $artigotop->id])}}" class="btn btn-xs btn-default ml-2"><i class="fas fa-pen"></i></a>
                    </td>
                </tr>
                @endforeach                            
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
    </div>
    @endif

    @if(!empty($parceirosTop) && $parceirosTop->count() > 0)
    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Parceiros mais visitados</h3>
        </div>
        <div class="card-body p-0">
          <table class="table table-sm">
            <thead>
              <tr>
                <th class="text-center">Foto</th>
                <th>Parceiro</th>
                <th></th>
                <th></th>
                <th class="text-center">Visitas</th>
              </tr>
            </thead>
            <tbody>                            
                @foreach($parceirosTop as $parceirotop)
                @php
                    //REALIZA PORCENTAGEM DE VISITAS!
                    if($parceirotop->views == '0'){
                        $percent = 1;
                    }else{
                        $percent = substr(( $parceirotop['views'] / $totalviewsparceiros ) * 100, 0, 5);
                    }
                    $percenttag = str_replace(",", ".", $percent);
                @endphp
                <tr>
                    <td class="text-center">
                        <a href="{{url($parceirotop->nocover())}}" data-title="{{$parceirotop->name}}" data-toggle="lightbox"> 
                            <img src="{{url($parceirotop->cover())}}" alt="{{$parceirotop->name}}" class="img-size-50">
                        </a>
                    </td>
                    <td><a target="_blank" href="{{route('web.parceiro', ['slug' =>$parceirotop->slug])}}">{{$parceirotop->name}}</a></td>
                    <td style="width:10%;">
                        <i class="fas fa-envelope"></i> ({{$parceirotop->email_send_count}})
                    </td>
                    <td style="width:10%;">
                      <div class="progress progress-md progress-striped active">
                        <div class="progress-bar bg-primary" style="width: {{$percenttag}}%" title="{{$percenttag}}%"></div>
                      </div>
                    </td>
                    <td class="text-center">
                      <span class="badge bg-primary">{{$parceirotop->views}}</span>
                      <a data-toggle="tooltip" data-placement="top" title="Editar Artigo" href="{{route('parceiros.edit', ['id' => $parceirotop->id])}}" class="btn btn-xs btn-default ml-2"><i class="fas fa-pen"></i></a>
                    </td>
                </tr>
                @endforeach                            
            </tbody>
          </table>
        </div>
    </div>
    @endif
</section>
@stop

@section('css')
<link rel="stylesheet" href="{{url(asset('backend/plugins/ekko-lightbox/ekko-lightbox.css'))}}">
<style>
    .info-box .info-box-content {   
        line-height: 120%;
    }
</style>
@endsection

@section('js')
<script src="{{url(asset('backend/plugins/ekko-lightbox/ekko-lightbox.min.js'))}}"></script>
    <script>  
    $(function (){

        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
            alwaysShowClose: true
            });
        }); 

        var areaChartData = {
            labels  : [
            @foreach($analyticsData->rows as $dataMonth)                
                'Mês/{{substr($dataMonth[0], -2)}}',                                 
            @endforeach
            ],
            datasets: [
                {
                label               : 'Visitas Únicas',
                backgroundColor     : 'rgba(60,141,188,0.9)',
                borderColor         : 'rgba(60,141,188,0.8)',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : [
                                    @foreach($analyticsData->rows as $dataMonth)                
                                        '{{$dataMonth[2]}}',                                 
                                    @endforeach
                                    ]
                },
                {
                label               : 'Visitas',
                backgroundColor     : 'rgba(210, 214, 222, 1)',
                borderColor         : 'rgba(210, 214, 222, 1)',
                pointRadius         : false,
                pointColor          : 'rgba(210, 214, 222, 1)',
                pointStrokeColor    : '#c1c7d1',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data                : [
                                    @foreach($analyticsData->rows as $dataMonth)                
                                        '{{$dataMonth[1]}}',                                 
                                    @endforeach
                                    ]
                },
            ]
        }

        //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = jQuery.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        var temp1 = areaChartData.datasets[1]
        barChartData.datasets[0] = temp1
        barChartData.datasets[1] = temp0

        var barChartOptions = {
        responsive              : true,
        maintainAspectRatio     : false,
        datasetFill             : false
        }

        var barChart = new Chart(barChartCanvas, {
        type: 'bar', 
        data: barChartData,
        options: barChartOptions
        });

        function dynamicColors() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgba(" + r + "," + g + "," + b + ", 0.5)";
        }

        //-------------
        //- DONUT CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
        var donutData        = {
          labels: [
              @if(!empty($top_browser))
                @foreach($top_browser as $browser)
                  '{{$browser['browser']}}',
                @endforeach
              @else
                'Chrome', 
                'IE',
                'FireFox', 
                'Safari', 
                'Opera', 
                'Navigator',
              @endif               
          ],
          datasets: [
            {
              data: [
                @if(!empty($top_browser))
                  @foreach($top_browser as $key => $browser)
                    {{$browser['sessions']}},
                  @endforeach
                @else
                  700,500,400,600,300,100
                @endif                
                ],
              backgroundColor : [
                @foreach($top_browser as $key => $browser)
                  dynamicColors(),
                @endforeach
                ],
            }
          ]
        }
        var donutOptions     = {
          maintainAspectRatio : false,
          responsive : true,
        }

        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        var donutChart = new Chart(donutChartCanvas, {
          type: 'doughnut',
          data: donutData,
          options: donutOptions      
        });




        var donutChartCanvasUsers = $('#donutChartusers').get(0).getContext('2d');
        var donutDatausers        = {
            labels: [ 
                'Clientes Inativos', 
                'Clientes Ativos',
                'Time'             
            ],
            datasets: [
                {
                data: [{{ $usersUnavailable }},{{ $usersAvailable }}, {{ $time }}],
                    backgroundColor : ['#4BC0C0', '#36A2EB', '#FF6384'],
                }
            ]
            }
            var donutOptions     = {
            maintainAspectRatio : false,
            responsive : true,
            }

            var donutChart = new Chart(donutChartCanvasUsers, {
            type: 'doughnut',
            data: donutDatausers,
            options: donutOptions      
            });
    }); 

    $(function (){
        var donutChartCanvasPosts = $('#donutChartposts').get(0).getContext('2d');
        var donutDataposts        = {
            labels: [ 
                'Artigos', 
                'Notícias',
                'Páginas'             
            ],
            datasets: [
                {
                data: [{{ $postsArtigos }},{{ $postsNoticias }}, {{ $postsPaginas }}],
                    backgroundColor : ['#018577', '#419B45', '#BAC431'],
                }
            ]
            }
            var donutOptions     = {
            maintainAspectRatio : false,
            responsive : true,
            }

            var donutChart = new Chart(donutChartCanvasPosts, {
            type: 'doughnut',
            data: donutDataposts,
            options: donutOptions      
            });
    });    
    $(function (){
        var donutChartCanvasPedidos = $('#donutChartpedidos').get(0).getContext('2d');
        var donutDatapedidos        = {
            labels: [ 
                'Aprovados', 
                'Processando',
                'Cancelado'             
            ],
            datasets: [
                {
                data: [{{ $pedidosApproved }},{{ $pedidosInprocess }}, {{ $pedidosRejected }}],
                    backgroundColor : ['#97C490', '#EBCF7F', '#E98BA5'],
                }
            ]
            }
            var donutOptions     = {
            maintainAspectRatio : false,
            responsive : true,
            }

            var donutChart = new Chart(donutChartCanvasPedidos, {
            type: 'doughnut',
            data: donutDatapedidos,
            options: donutOptions      
            });
    });    
    </script>
@stop

@extends('web.master.master')

@section('content')


<section class="contact-section" style="background-color: #eee;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="contact-title">Meus Passeios</h2>
            </div>
            @if (!empty($pedidos) && $pedidos->count() > 0)
                <div class="col-12">
                    <div class="table-schedule-wrap">
                        <div class="table-schedule">                
                        <div class="table-schedule-body bg-white">
                        <table class="table table-custom table-fixed table-hover-rows">
                            <tr>
                                <th>Passeio</th>
                                <th class="text-center">Data</th>
                                <th class="text-center">Saída</th>
                                <th class="text-center">Passageiros</th>
                                <th class="text-center">Valor</th>
                            </tr>
                            @foreach ($pedidos as $pedido)
                                <tr>
                                    <td>{{$pedido->passeio->roteiro->name}}</td>
                                    <td class="text-center">{{$pedido->data_compra}}</td>
                                    <td class="text-center">{{$pedido->passeio->saida}}</td>
                                    <td class="text-center">{{$pedido->total_passageiros}}</td>
                                    <td class="text-center">R${{$pedido->valor}}</td>
                                    <td class="text-center">
                                        {!!$pedido->getStatusPayment()!!}
                                        <span style="margin-left: 10px;">
                                            <a target="_blank" href="{{route('web.passeios.voucher',['token' => $pedido->token])}}">
                                                <button type="button" class="btn btn-info btn-sm"><i class="fas fa-search"></i></button>
                                            </a>                                            
                                        </span>
                                    </td>
                                </tr>
                            @endforeach                            
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            @else
            <div class="col-12">
                <div class="alert alert-info">Olá <b>{{getPrimeiroNome(Session()->get('cliente')[0]->name)}}</b>, 
                    desculpe não encontramos seus passeios, caso precise de suporte acesse nossa página de atendimento</div>
            </div>            
            @endif            
        </div>
    </div>
</section>

@endsection

@section('css')

@endsection

@section('js')
<script>   

    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });       

        $('.j_formsubmit').submit(function (){
            var form = $(this);
            var dataString = $(form).serialize();

            $.ajax({
                url: "{{ route('web.passeios.carrinhocreate') }}",
                data: dataString,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function(){
                    form.find("#js-contact-btn").attr("disabled", true);
                    form.find('#js-contact-btn').html("Carregando...");                
                    form.find('.alert').fadeOut(500, function(){
                        $(this).remove();
                    });
                },
                success: function(resposta){
                    $('html, body').animate({scrollTop:$('#js-contact-result').offset().top-130}, 'slow');
                    if(resposta.error){
                        form.find('#js-contact-result').html('<div class="alert alert-danger error-msg">'+ resposta.error +'</div>');
                        form.find('.error-msg').fadeIn();                    
                    }else{
                        form.find('.error-msg').fadeIn(); 
                        setTimeout(function() {
                            window.location.href = resposta.redirect;
                        }, 2000); 
                    }
                },
                complete: function(resposta){
                    form.find("#js-contact-btn").attr("disabled", false);
                    form.find('#js-contact-btn').html("Finalizar >>");                                
                }

            });

            return false;
        });
    });
</script>
@endsection
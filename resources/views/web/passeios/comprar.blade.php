@extends('web.master.master')

@section('content')
<section class="contact-section" style="background-color: #eee;">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-sm-8 col-md-6 col-lg-7"> 
                <form class="text-left j_formsubmit" method="post" action="" autocomplete="off">
                    @csrf
                    <div id="js-contact-result"></div>
                    <input type="hidden" name="id_passeio" value="{{$passeio->id}}">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label form-label-outside text-dark">*Responsável</label>
                                <input type="text" name="nome" class="form-control">
                            </div>                            
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label form-label-outside text-dark">*Email</label>
                                <input type="text" name="email" class="form-control">
                            </div>                            
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label form-label-outside text-dark">*CPF</label>
                                <input type="text" name="cpf" class="form-control cpfmask">
                            </div>                            
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label form-label-outside text-dark">*Celular</label>
                                <input type="text" name="celular" class="form-control celularmask">
                            </div>                            
                        </div>
                        @php
                            if ($passeio->valor_venda_promocional != ''){
                                $valorAdulto = substr(str_replace('.', '', str_replace(',', '.', $passeio->valor_venda_promocional)), 0, -2);
                            }else{
                                $valorAdulto = substr(str_replace('.', '', str_replace(',', '.', $passeio->valor_venda)), 0, -2); 
                            }
                        @endphp
                        <div class="col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label style="display: block;" class="form-label-outside text-dark">Adultos</label>
                                <select name="adultos" class="form-control select_adultos">
                                    @for($i = 1; $i <= 15; $i++)
                                        <option value="{{$i}}">{{$i}} -
                                        @if ($passeio->valor_venda_promocional != '')
                                            (R$ {{$i * $valorAdulto}})
                                        @else
                                            (R$ {{$i * $valorAdulto}}) 
                                        @endif
                                        </option>
                                    @endfor                                    
                                </select>
                            </div>                            
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label style="display: block;" class="form-label-outside text-dark">Crianças de 0 a 5</label>
                                <select name="valor_v_zerocinco" class="form-control select_zerocinco">
                                    @for($i = 0; $i <= 15; $i++)
                                        <option value="{{$i}}">{{$i}} -
                                            (R$ {{$i * substr(str_replace('.', '', str_replace(',', '.', $passeio->valor_v_zerocinco)), 0, -2)}})
                                        </option>
                                    @endfor
                                </select>
                            </div>                            
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label style="display: block;" class="form-label-outside text-dark">Crianças de 6 a 12</label>
                                <select name="valor_v_seisdoze" class="form-control select_seisdoze">
                                    @for($i = 0; $i <= 15; $i++)
                                        <option value="{{$i}}">{{$i}} -
                                            (R$ {{$i * substr(str_replace('.', '', str_replace(',', '.', $passeio->valor_v_seisdoze)), 0, -2)}})
                                        </option>
                                    @endfor
                                </select>
                            </div>                            
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label form-label-outside text-dark">*Data do Passeio</label>
                                <input type="text" name="datapasseio" class="form-control datepicker-here" data-language='pt-BR'>
                            </div>                            
                        </div>
                        <div class="col-lg-6">
                            <label style="color: #eee;">finalizar</label>
                            <button type="submit" style="width: 100%;" class="btn btn-md btn-info" id="js-contact-btn">Finalizar >></button>                                          
                        </div>
                    </div> 
                </form>                
            </div>
            <div class="col-xl-5 col-sm-8 col-md-6 col-lg-5">
                <h4>Meu Pedido</h4>
                <p>
                    <b>Roteiro:</b> {{$passeio->roteiro->name}}<br>
                    <b>Local de saída:</b> {{$passeio->rua}}
                    {{($passeio->rua && $passeio->num ? ', '.$passeio->num : '')}}
                    {{($passeio->rua && $passeio->num ? ' - '.$passeio->bairro : $passeio->bairro)}}<br>
                    <b>Horário de Saída:</b> {{$passeio->saida}}<br>
                    <b>Duração do Passeio:</b> {{$passeio->duracao}}hs<br>
                    <b>Data Selecionada:</b> <br>
                </p>
                <hr>
                <p>
                    <b>Adultos:</b> <span class="qtdAdulto">R$ 0,00</span><br>
                    <b>Crianças de 0 a 5 anos:</b> <span class="qtd05">R$ 0,00</span><br>
                    <b>Crianças de 6 a 12 anos:</b> <span class="qtd612">R$ 0,00</span><br>
                    <b>Total:</b> <span class="valorTotal">R$ 0,00</span><br>
                </p>
            </div>
        </div>
    </div>
</section>


@endsection

@section('css')
<style>
    html.lt-ie-10 * + [class*='cell-'], * + [class*='cell-'], html.lt-ie-10 * + .range-sm, * + .range-sm {
    margin-top: 0px;
}
</style>
<link href="{{url(asset('backend/plugins/airdatepicker/css/datepicker.min.css'))}}" rel="stylesheet" type="text/css">
@endsection

@section('js')
<script src="{{url(asset('backend/plugins/airdatepicker/js/datepicker.min.js'))}}"></script>
<script src="{{url(asset('backend/plugins/airdatepicker/js/i18n/datepicker.pt-BR.js'))}}"></script>
<script src="{{url(asset('backend/assets/js/jquery.mask.js'))}}"></script>
<script>
    $(document).ready(function () { 
        var $Cpf = $(".cpfmask");
        $Cpf.mask('000.000.000-00', {reverse: true});
        var $celularmask = $(".celularmask");
        $celularmask.mask('(99) 99999-9999', {reverse: false});
    });

    $(function(){
       //Desabilita dias da semana
        var disabledDays = [
            {{$passeio->domingo == 1 ? '' : '0'}},
            {{$passeio->segunda == 1 ? '' : '1'}},
            {{$passeio->terca == 1 ? '' : '2'}},
            {{$passeio->quarta == 1 ? '' : '3'}},
            {{$passeio->quinta == 1 ? '' : '4'}},
            {{$passeio->sexta == 1 ? '' : '5'}},
            {{$passeio->sabado == 1 ? '' : '6'}},
        ];
         
        $('.datepicker-here').datepicker({
            autoClose: true,            
            minDate: new Date(),
            position: "top right", //'right center', 'right bottom', 'right top', 'top center', 'bottom center'
            onRenderCell: function (date, cellType) {
                if (cellType == 'day') {
                    var day = date.getDay(),
                        isDisabled = disabledDays.indexOf(day) != -1;

                    return {
                        disabled: isDisabled
                    }
                }
            }
        });  
             
    });

    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.select_adultos').change(function(){
            var valueadulto = $(this).val();
            var valor = (valueadulto * {{$valorAdulto}});
            $('.qtdAdulto').html(parseFloat(valor).toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));            
        });

        $('.select_zerocinco').change(function(){
            var valuezerocinco = $(this).val();
            var valorzerocinco = (valuezerocinco * {{substr(str_replace('.', '', str_replace(',', '.', $passeio->valor_v_zerocinco)), 0, -2)}});
            $('.qtd05').html(parseFloat(valorzerocinco).toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));            
        });

        $('.select_seisdoze').change(function(){
            var valueseisdoze = $(this).val();
            var valorseisdoze = (valueseisdoze * {{substr(str_replace('.', '', str_replace(',', '.', $passeio->valor_v_seisdoze)), 0, -2)}});
            $('.qtd612').html(parseFloat(valorseisdoze).toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
        });

        $('.select_adultos,.select_zerocinco,.select_seisdoze').on('change', function() {
            var valor = parseFloat($('.select_adultos').val() * {{$valorAdulto}}) || 0;
            var valorzerocinco = parseFloat($('.select_zerocinco').val() * {{substr(str_replace('.', '', str_replace(',', '.', $passeio->valor_v_zerocinco)), 0, -2)}}) || 0;
            var valorseisdoze = parseFloat($('.select_seisdoze').val() * {{substr(str_replace('.', '', str_replace(',', '.', $passeio->valor_v_seisdoze)), 0, -2)}}) || 0;

            var totalValorAdicionalDX = valor + valorzerocinco + valorseisdoze;

            $('.valorTotal').html(parseFloat(totalValorAdicionalDX).toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
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
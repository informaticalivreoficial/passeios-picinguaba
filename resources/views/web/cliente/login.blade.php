@extends('web.master.master')

@section('content')

<section class="contact-section" style="background-color: #eee;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="contact-title">Meus Passeios</h2>
            </div>
            <div class="col-12 mb-4">
                <form class="form-contact j_formsubmit" action="{{route('web.login.do')}}" method="post" autocomplete="off">
                    @csrf
                    <div class="row">        
                    <div class="col-sm-12 text-center">
                        <div id="js-contact-result"></div>
                        <div class="form-group text-center" style="width: 40%;display:inline;">
                            <label class="text-muted"><b>Digite seu CPF</b></label><br>
                            <input class="form-control cpfmask" name="cpf" type="text" style="background: #fff;padding-top:1px;height:47px;font-size: 18px;width: 40%;display:inline;">
                        </div>
                        <div class="form-group text-center" style="width: 30%;display:inline;">                        
                            <button style="height: 45px;padding:5px 30px;" type="submit" class="button button-contactForm boxed-btn" id="js-contact-btn">Enviar</button>
                        </div>
                    </div>                  
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection

@section('css')

@endsection

@section('js')
<script src="{{url(asset('backend/assets/js/jquery.mask.js'))}}"></script>
<script>
    $(document).ready(function () { 
        var $Cpf = $(".cpfmask");
        $Cpf.mask('000.000.000-00', {reverse: true});        
    });

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
                url: "{{ route('web.login.do') }}",
                data: dataString,
                type: 'POST',
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
                            form.find("#js-contact-btn").attr("disabled", true);
                            form.find('#js-contact-btn').html("Redirecionando");
                            window.location.href = resposta.redirect;
                        }, 2000); 

                    }
                },
                complete: function(resposta){
                    form.find("#js-contact-btn").attr("disabled", false);
                    form.find('#js-contact-btn').html("Enviar");                                
                }

            });

            return false;
        });
    });
</script>
@endsection
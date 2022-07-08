@extends('web.master.master')


@section('content')

    <div class="slider-area ">        
      <div class="single-slider slider-height2 d-flex align-items-center" data-background="{{$configuracoes->gettopodosite()}}">
          <div class="container">
              <div class="row">
                  <div class="col-xl-12">
                      <div class="hero-cap text-center">
                          <h2>Atendimento</h2>
                          <p><a href="{{route('web.home')}}" class="text-white">Início</a> >> Atendimento</p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div> 

  <section class="contact-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="contact-title">Preencha o Formulário</h2>
            </div>
            <div class="col-lg-8">
                <form class="form-contact contact_form j_formsubmit" action="" method="post" autocomplete="off">
                  @csrf
                    <div class="row">
                        <div class="col-12">
                          <div id="js-contact-result"></div>
                        </div>  
                        <div class="form-group form_hide">
                            <!-- HONEYPOT -->
                            <input type="hidden" class="noclear" name="bairro" value="" />
                            <input type="text" class="noclear" style="display: none;" name="cidade" value="" />
                        </div>                      
                        <div class="col-sm-6 form_hide">
                            <div class="form-group">
                                <input class="form-control valid" name="nome" type="text" placeholder="Seu nome">
                            </div>
                        </div>
                        <div class="col-sm-6 form_hide">
                            <div class="form-group">
                                <input class="form-control valid" name="email" type="email" placeholder="Seu email">
                            </div>
                        </div>
                        <div class="col-12 form_hide">
                          <div class="form-group">
                              <textarea class="form-control w-100" name="mensagem" cols="30" rows="9" placeholder="Mensagem"></textarea>
                          </div>
                        </div>                        
                    </div>
                    <div class="form-group mt-3 form_hide">
                        <button type="submit" class="button button-contactForm boxed-btn" id="js-contact-btn">Enviar Agora</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-4">
                <h3>Atendimento</h3>
                @if ($configuracoes->whatsapp)
                  <div class="media contact-info">
                      <span class="contact-info__icon"><i class="fab fa-whatsapp"></i></span>
                      <div class="media-body">
                          <h3><a href="{{\App\Helpers\WhatsApp::getNumZap($configuracoes->whatsapp ,'Atendimento '. $configuracoes->nomedosite)}}">{{$configuracoes->whatsapp}}</a></h3>                          
                      </div>
                  </div>                                        
                @endif
                @if ($configuracoes->telefone1)
                  <div class="media contact-info">
                      <span class="contact-info__icon"><i class="fas fa-phone"></i></span>
                      <div class="media-body">
                          <h3><a href="callto:{{$configuracoes->telefone1}}">{{$configuracoes->telefone1}}</a></h3>                          
                      </div>
                  </div>                                        
                @endif
                @if ($configuracoes->telefone2)
                  <div class="media contact-info">
                      <span class="contact-info__icon"><i class="fas fa-phone"></i></span>
                      <div class="media-body">
                          <h3><a href="callto:{{$configuracoes->telefone2}}">{{$configuracoes->telefone2}}</a></h3>                          
                      </div>
                  </div>                                        
                @endif
                @if ($configuracoes->email)
                  <div class="media contact-info">
                      <span class="contact-info__icon"><i class="fas fa-envelope"></i></span>
                      <div class="media-body">
                          <h3><a href="mailto:{{$configuracoes->email}}">{{$configuracoes->email}}</a></h3>
                      </div>
                  </div>                                       
                @endif
                @if ($configuracoes->email1)
                  <div class="media contact-info">
                      <span class="contact-info__icon"><i class="fas fa-envelope"></i></span>
                      <div class="media-body">
                          <h3><a href="mailto:{{$configuracoes->email1}}">{{$configuracoes->email1}}</a></h3>
                      </div>
                  </div>                                       
                @endif
            </div>
        </div>

        <div class="d-none d-sm-block mb-5 pb-4">
          {!!$configuracoes->mapa_google!!}
        </div>
    </div>
</section>
  
  @endsection

@section('css')
<style>
  iframe{
    height: 450px;
    width: 100%;
    display: inline-block;
    overflow: hidden"
  }
</style>
@endsection

@section('js')
  <script>
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Seletor, Evento/efeitos, CallBack, Ação
        $('.j_formsubmit').submit(function (){
            var form = $(this);
            var dataString = $(form).serialize();

            $.ajax({
                url: "{{ route('web.sendEmail') }}",
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
                    $('html, body').animate({scrollTop:$('#js-contact-result').offset().top-190}, 'slow');
                    if(resposta.error){
                        form.find('#js-contact-result').html('<div class="alert alert-danger error-msg">'+ resposta.error +'</div>');
                        form.find('.error-msg').fadeIn();                    
                    }else{
                        form.find('#js-contact-result').html('<div class="alert alert-success error-msg">'+ resposta.sucess +'</div>');
                        form.find('.error-msg').fadeIn();                    
                        form.find('input[class!="noclear"]').val('');
                        form.find('textarea[class!="noclear"]').val('');
                        form.find('.form_hide').fadeOut(500);
                    }
                },
                complete: function(resposta){
                    form.find("#js-contact-btn").attr("disabled", false);
                    form.find('#js-contact-btn').html("Enviar Agora");                                
                }

            });

            return false;
        });

    });
</script>   
  @endsection
  
  
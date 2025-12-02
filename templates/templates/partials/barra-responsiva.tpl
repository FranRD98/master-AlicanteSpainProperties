<div class="bottom-bar-new">
    <a href="#" data-bs-toggle="modal" data-bs-target="#contactFootFormWhatsappModal"  class="btn-whatsapp d-none d-xl-inline-flex-">
        <span>
            <img height="62" src="/media/images/website/icon-whatsp-property.svg" alt="WhatsApp">
        </span>
        <strong>
            {$lng_chat_with_us_now}
        </strong>
    </a>
</div>

<div class="modal fade bg-gray modal-whatsapp" tabindex="-1" role="dialog" id="contactFootFormWhatsappModal">


    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header bg-primary py-2">
                <h3 class="text-white text-center my-2">{$lng_contactar_por_whatsapp}</h3>
                <a class="close mr-2" data-bs-dismiss="modal" aria-label="Close">
                    <img src="/media/images/website/icon-close-modal.svg" alt="cerrar">
                </a>
            </div>


           <div class="p-4">

                <p class="text-center text-dark px-4 mb-0">
                    {$lng_deja_tu_nombre_y_telefono_para_iniciar_la_conversacion_en_whatsapp}.
                </p>

                <div class="pe-xl-2">
                      <form action="#" id="contactFootFormWhatsapp" method="post" role="form" class="validate custom-form">

                         <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="hide-label">
                                        {$lng_nombre} *
                                    </label>
                                    <input type="text" class="form-control required" name="name" id="name" placeholder="{$lng_nombre} *">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="hide-label">
                                        {$lng_telefono} *
                                    </label>
                                    <input type="text" class="form-control  telefono required" name="telefono" id="telefono" placeholder="{$lng_telefono} *">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="checkcontainer mb-4">
                                <span class="tag-name">{assign var="urlPPRV" value=sprintf('<a href="%s%s/" target="_blank">', {$urlStart},
                                    {$url_privacy})}
                                    {$lng_marque_la_casilla_para_confirmar_que_ha_leido_y_entendido_nuestra_politica_de_privacidad|sprintf:{$urlPPRV}:'</a>'}*
                                </span>
                                <input type="checkbox" name="lpd" id="lpd" class="required" />
                                <span class="checkmark"></span>
                            </label>
                        </div>

                        <input type="hidden" name="lang" value="{$lang}">
                        <input type="hidden" name="f{$smarty.now|date_format:"%d%m%y"|replace:" ":"0"}">

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary text-light mb-2">
                               {$lng_solicitar_informacion}
                           </button>
                        </div>

                        {* <div class="gdpr mb-4">{$texto_formularios_GDPR}</div> *}
                    </form>
                </div>

           </div>
        </div>
    </div>

</div>


<div class="modal fade bg-gray modal-whatsapp" tabindex="-1" role="dialog" id="respuesta">


    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header bg-primary py-2">
                <h3 class="text-white text-center my-2">{$lng_contactar_por_whatsapp}</h3>
                <a class="close mr-2" data-bs-dismiss="modal" aria-label="Close">
                    <img src="/media/images/website/icon-close-modal.svg" alt="cerrar">
                </a>
            </div>
           <div class="p-4">

                <div class="pe-xl-2">
                    {if $seccion == $url_property }
                        <a onclick="gtag('event', 'evento', { 'event_category': 'Contact Form', 'event_action': 'Contact', 'event_label': 'whats' });"  href="https://wa.me/{$phoneRespBar}/?text={"{$lng_estoy_interesado_en_esta_propiedad}: {$property[0].ref}"|escape:'url'}" target="_blank" class="btn btn-primary w-100 my-4">{$lng_hablar_por_whatsapp_ahora}</a>
                    {else}
                        <a onclick="gtag('event', 'evento', { 'event_category': 'Contact Form', 'event_action': 'Contact', 'event_label': 'whats' });"  href="https://wa.me/{$phoneRespBar}/?text={""|escape:'url'}" target="_blank" class="btn btn-primary w-100 my-4">{$lng_hablar_por_whatsapp_ahora}</a>
                    {/if}
                </div>

           </div>
        </div>
    </div>

</div>


<style type="text/css">
    .modal.bg-gray.modal-whatsapp
    {
        -webkit-backdrop-filter: blur(50px);
        backdrop-filter: blur(50px);
        background-color: rgba(0,0,0,0.1);
    }
    .modal.modal-whatsapp .modal-content, .modal.modal-whatsapp .modal-header
    {
        border-radius: 0;
        border: 0;
    }

    .modal.modal-whatsapp .modal-header span
    {
        display: inline-flex;
        background-color: #000000;
        border-radius: 50%;
        height: 50px;
        width: 50px;
        justify-content: center;
        align-items: center;
    }
    .modal.modal-whatsapp p
    {
        font-size: 17px;
      font-weight: 300;
      font-stretch: normal;
      font-style: normal;
      line-height: 1.5;
    }
    .modal.modal-whatsapp .close
    {
        width: auto;
    }
    .modal.modal-whatsapp .close img
    {
        height: 21px;
        width: auto;
    }
    .modal.modal-whatsapp .custom-form .customSelectInner
    {
        color: #212529;
    }
    .modal.modal-whatsapp h3
    {
          font-size: 20px;
          font-weight: 500;
          font-stretch: normal;
          font-style: normal;
          line-height: 1.45;
          letter-spacing: 0.2px;
    }
    .modal.modal-whatsapp .modal-dialog
    {
        margin: 0;
        position: absolute;
        bottom: 30px;
        right: 50px;
        min-width: 460px;
    }
    .bottom-bar-new .btn.btn-primary
    {
        line-height: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 260px;
        padding: 4px 14px;
        border-radius: 0 !important;
        height: 60px !important;
        color: #000 !important;
        text-transform: none;
        font-size: 18px !important;
        letter-spacing: normal !important;
        box-shadow: 0 0px 18px rgba(0, 0, 0, 0.1) !important;
    }

    .bottom-bar-new.left
    {
        left: 20px;
        right: auto;
        bottom: 20px;
    }

    @media (max-width: 960px)
    {
        .bottom-bar-new .btn.btn-primary
        {
            min-width: 240px;
            font-size: 17px !important;
        }
        .bottom-bar-new.left
        {
            bottom: -100px;
        }
        .bottom-bar-new.left.show
        {
            bottom: 20px;
        }
    }

    .bottom-bar-new .btn.btn-primary img
    {
        margin-top: 0 !important;
    }



    .bottom-bar-whatsapp .btn-whatsapp {
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }
    .bottom-bar-whatsapp .btn-whatsapp span {
      background-color: #2ed9c3;
      display: inline-flex;
      height: 64px;
      width: 64px;
      border-radius: 50%;
      align-items: center;
      justify-content: center;
      position: relative;
      z-index: 1;
/*      border: solid 1px #fff;*/
    }
    @media (max-width: 1022.98px) {
      .bottom-bar-whatsapp .btn-whatsapp span {
        transform: translateX(10px);
      }
    }
    .bottom-bar-whatsapp .btn-whatsapp img {
      height: 62px;
    }
    .bottom-bar-whatsapp .btn-whatsapp strong {
      display: none;
      font-size: 15px;
      height: 42px;
      color: #fff;
      padding: 8px 18px 8px 32px;
      border-radius: 50px;
      background-color: #2ed9c3;
      transform: translateX(-16px);
      transition: all ease-in-out 0.3s;
    }
    @media (min-width: 768px) {
      .bottom-bar-whatsapp .btn-whatsapp strong {
        padding: 8px 18px 8px 43px;
        display: inline-block;
        font-size: 16px;
        transform: translateX(-36px);
      }
      .bottom-bar-whatsapp .btn-whatsapp span {
        border: solid 1px #fff;
      }
    }
    .bottom-bar-whatsapp .btn-whatsapp:hover strong {
      transform: translateX(-10px);
    }
    @media (min-width: 768px) {
      .bottom-bar-whatsapp .btn-whatsapp:hover strong {
        transform: translateX(-30px);
      }
    }

</style>
<div class="modal" tabindex="-1" role="dialog" id="similarModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">{$lng_gracias_por_contactarnos}</h5>
                <a class="close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fal fa-times"></i>
                </a>
            </div>
            <div class="modal-body">
                {if isset($similares[0]) && $similares[0].id_prop != ""}
                    <p>{$lng_first_of_all_thanks_for_contacting_us_}</p>
                    <p>{$lng_we_have_received_your_request_regarding_the_property_reference_s__one_of_our_agents_will_contact_you_as_soon_as_possible_|sprintf:$property[0].ref}</p>
                {else}
                    <p class="lead">{$lng_el_mensaje_se_ha_enviado_correctamente_}</p>
                {/if}
                {if isset($similares[0]) && $similares[0].area != ''}
                    <h3>{$lng_propiedades_similares}</h3>
                    <div id="similares-properties-modal">
                        <div class="slides">
                            {section name=ft loop=$similares}
                                {include file="partials/slider-properties.tpl" resource=$similares[ft]}
                            {/section}
                        </div>
                    </div>
                {/if}
            </div>
        </div>
    </div>
</div>

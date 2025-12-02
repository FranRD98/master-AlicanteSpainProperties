<div class="modal" tabindex="-1" role="dialog" id="similarModalBajada">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">{$lng_gracias_por_contactarnos}</h5>
                <a class="close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fal fa-times"></i>
                </a>
            </div>
            <div class="modal-body">
                <p>{$lng_first_of_all_thanks_for_contacting_us_}</p>
                <p>{$lng_we_have_received_a_request_for_a_report_if_you_lower_the_price_of_the_property_with_the_reference}: {$property[0].ref}</p>
                {if $similares[0].id_prop != ""}
                    <p>{$lng_in_the_meantime_please_have_a_look_at_this_selection_of_similar_properties_that_might_be_of_interest_to_you}</p>
                {/if}
                {if $similares[0].area != ''}
                    <h3>{$lng_propiedades_similares}</h3>
                    <div id="similares-properties-bajada-modal">
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

<div class="row">

    <div class="col-12">
        <h3 class="main-title subtitle">{$lng_caracteristicas}</h3>
    </div>



    {if isset($property[0]) && $property[0].construccion_prop != ''}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_ano_de_construccion}:</strong> {$property[0].construccion_prop}</div>
    {/if}

    {if isset($property[0]) && $property[0].entraga_date_prop != ''}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_fecha_de_entrega}:</strong> {$property[0].entraga_date_prop}</div>
    {/if}

    {if {$property[0].habitaciones_prop|number_format:0:",":"."} > 0}
    <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_habitaciones}:</strong> {$property[0].habitaciones_prop|number_format:0:",":"."}</div>
    {/if}

    {if {$property[0].aseos_prop|number_format:0:",":"."} > 0}
    <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_banos}:</strong> {$property[0].aseos_prop|number_format:0:",":"."}</div>
    {/if}

    {if {$property[0].aseos2_prop|number_format:0:",":"."} > 0}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_aseos}: </strong>{$property[0].aseos2_prop|number_format:0:",":"."}</div>
    {/if}

    {if {$property[0].m2_prop|number_format:0:",":"."} > 0}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_construidos}:</strong> {$property[0].m2_prop|number_format:0:",":"."}m<sup>2</sup></div>
    {/if}

    {if {$property[0].m2_utiles_prop|number_format:0:",":"."} > 0}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_utiles}:</strong> {$property[0].m2_utiles_prop|number_format:0:",":"."}m<sup>2</sup></div>
    {/if}

    {if {$property[0].m2p_prop|number_format:0:",":"."} > 0}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_parcela}:</strong> {$property[0].m2p_prop|number_format:0:",":"."}m<sup>2</sup></div>
    {/if}

    {if {$property[0].m2_solarium_prop|number_format:0:",":"."} > 0}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_solarium}:</strong> {$property[0].m2_solarium_prop|number_format:0:",":"."}m<sup>2</sup></div>
    {/if}

    {if isset($property[0].terrazas_prop) && {$property[0].terrazas_prop|number_format:0:",":"."} > 0}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_terrazas}: </strong>{$property[0].terrazas_prop|number_format:0:",":"."}m<sup>2</sup></div>
    {/if}

    {if isset($property[0].m2_terraza_prop) && {$property[0].m2_terraza_prop|number_format:0:",":"."} > 0}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_terraza}:</strong> {$property[0].m2_terraza_prop|number_format:0:",":"."}m<sup>2</sup></div>
    {/if}

    {if isset($property[0].m2b_prop) && {$property[0].m2b_prop|number_format:0:",":"."} > 0}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_balcon}: </strong> {$property[0].m2b_prop|number_format:0:",":"."} m<sup>2</sup></div>
    {/if}

    {if isset($property[0].piscina_prop) && $property[0].piscina_prop != ''}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_piscina}:</strong> <span>{$property[0].piscina_prop}</span></div>
    {/if}

    {if isset($property[0].parking_prop) && $property[0].parking_prop != ''}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_garaje}:</strong> <span>{$property[0].parking_prop}</span></div>
    {/if}

    {if isset($property[0].plazas_garaje_prop) && {$property[0].plazas_garaje_prop|number_format:0:",":"."} > 0}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_plazas_de_garaje}:</strong> {$property[0].plazas_garaje_prop|number_format:0:",":"."} </div>
    {/if}

    {if isset($property[0].cocinas_prop) && $property[0].cocinas_prop != ''}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_cocinas}:</strong> {$property[0].cocinas_prop}</div>
    {/if}

    {if isset($property[0].estado_prop) && $property[0].estado_prop != ''}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_condition}:</strong> {$property[0].estado_prop}</div>
    {/if}

    {if isset($property[0].planta_prop) && $property[0].planta_prop != ''}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_planta}:</strong> {$property[0].planta_prop}</div>
    {/if}

    {if isset($property[0].salones_prop) && {$property[0].salones_prop|number_format:0:",":"."} > 0}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_salones}:</strong> {$property[0].salones_prop|number_format:0:",":"."}m<sup>2</sup></div>
    {/if}

    {if isset($property[0].salas_prop) &&  {$property[0].salas_prop|number_format:0:",":"."} > 0}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_salas}:</strong> {$property[0].salas_prop|number_format:0:",":"."}m<sup>2</sup></div>
    {/if}

    {if isset($property[0].armarios_empotrados_prop) && {$property[0].armarios_empotrados_prop|number_format:0:",":"."} > 0}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_armarios_empotrados}:</strong> {$property[0].armarios_empotrados_prop|number_format:0:",":"."} </div>
    {/if}

    {if isset($property[0].m2_garaje_prop) && {$property[0].m2_garaje_prop|number_format:0:",":"."} > 0}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_garaje}:</strong> {$property[0].m2_garaje_prop|number_format:0:",":"."}m<sup>2</sup></div>
    {/if}


    {if isset($property[0].m2_sotano_prop) && {$property[0].m2_sotano_prop|number_format:0:",":"."} > 0}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_sotano}:</strong> {$property[0].m2_sotano_prop|number_format:0:",":"."}m<sup>2</sup></div>
    {/if}

    {if isset($property[0].m2_fachada_prop) && {$property[0].m2_fachada_prop|number_format:0:",":"."} > 0}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_fachada}:</strong> {$property[0].m2_fachada_prop|number_format:0:",":"."}m<sup>2</sup></div>
    {/if}

    {if isset($property[0].orientacion_prop) && $property[0].orientacion_prop != ''}

        {if $property[0].orientacion_prop == 'o-n'}
            <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_orientacion}:</strong> {$lng_o_n}</div>
        {/if}

        {if $property[0].orientacion_prop == 'o-ne'}
            <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_orientacion}:</strong> {$lng_o_ne}</div>
        {/if}

        {if $property[0].orientacion_prop == 'o-e'}
            <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_orientacion}:</strong> {$lng_o_e}</div>
        {/if}

        {if $property[0].orientacion_prop == 'o-se'}
            <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_orientacion}:</strong> {$lng_o_se}</div>
        {/if}

        {if $property[0].orientacion_prop == 'o-s'}
            <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_orientacion}:</strong> {$lng_o_s}</div>
        {/if}

        {if $property[0].orientacion_prop == 'o-so'}
            <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_orientacion}:</strong> {$lng_o_so}</div>
        {/if}

        {if $property[0].orientacion_prop == 'o-o'}
            <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_orientacion}:</strong> {$lng_o_o}</div>
        {/if}

        {if $property[0].orientacion_prop == 'o-no'}
            <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_orientacion}:</strong> {$lng_o_no}</div>
        {/if}

    {/if}

    {if isset($property[0].distance_beach_prop) && $property[0].distance_beach_prop != ''}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_distancia_a_la_playa}:</strong> {$property[0].distance_beach_prop} {if $property[0].distance_beach_med_prop == 'Km'}{$lng_km_}{else}{if $property[0].distance_beach_med_prop == 'Mts'}{$lng_mts_}{else}{$lng_mins_}{/if}{/if}</div>
    {/if}

    {if isset($property[0].distance_airport_prop) && $property[0].distance_airport_prop != ''}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_distancia_al_aereopuerto}:</strong> {$property[0].distance_airport_prop} {if $property[0].distance_airport_med_prop == 'Km'}{$lng_km_}{else}{if $property[0].distance_airport_med_prop == 'Mts'}{$lng_mts_}{else}{$lng_mins_}{/if}{/if}</div>
    {/if}

    {if isset($property[0].distance_amenities_prop) && $property[0].distance_amenities_prop != ''}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_distancia_a_entretenimientos}:</strong> {$property[0].distance_amenities_prop} {if $property[0].distance_amenities_med_prop == 'Km'}{$lng_km_}{else}{if $property[0].distance_amenities_med_prop == 'Mts'}{$lng_mts_}{else}{$lng_mins_}{/if}{/if}</div>
    {/if}

    {if isset($property[0].distance_golf_prop) && $property[0].distance_golf_prop != ''}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_distancia_al_campo_de_golf}:</strong> {$property[0].distance_golf_prop} {if $property[0].distance_golf_med_prop == 'Km'}{$lng_km_}{else}{if $property[0].distance_golf_med_prop == 'Mts'}{$lng_mts_}{else}{$lng_mins_}{/if}{/if}</div>
    {/if}


{*     {if $property[0].energia_prop != ''}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_calificacion_energetica}:</strong> {$property[0].energia_prop}</div>
    {else}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_calificacion_energetica}: </strong>{$lng_en_proceso}</div>
    {/if} *}

{*     {if isset($property[0].piscina_prop) && $property[0].piscina_prop == 1}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_piscina}</strong></div>
    {/if}

    {if $property[0].ascensor_prop == 1}
        <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> <strong>{$lng_ascensor}</strong></div>
    {/if}
 *}
    {section name=ft loop=$features}
        {if {$features[ft].feat} != ''}
            <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> {$features[ft].feat}</div>
        {/if}
    {/section}

    {section name=ft loop=$featuresXML}
        {if {$featuresXML[ft].feat} != ''}
            <div class="col-12 col-lg-4 col-sm-6 mb-2"><i class="fas fa-check"></i> {$featuresXML[ft].feat}</div>
        {/if}
    {/section}

</div>
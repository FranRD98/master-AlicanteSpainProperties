{include file="header.tpl"}

<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-content">
                    <h1 class="main-title">{$lng_informe_de_propiedad}</h1>
                    {$pagetext}


                    <p><strong>{$lng_hola} {$datosprop[0].nombre_pro}</strong></p>

                    <p>{$lng_queremos_que_tengas_toda_la_informacion_sobre_como_avanza_la_venta_de_tu_vivienda_en_este_informe_podras_ver_cuantas_personas_han_visitado_tu_anuncio_cuantas_se_han_interesado_y_como_esta_funcionando_la_promocion_}</p>

                    <div class="row my-5">
                        <div class="col-lg-4 border-end">
                            <a href="{$urlStart}{$url_property}/{$datosprop[0].id_prop}/-/-/-/-/-/" class="btn btn-link text-start" target="_blank">🔗 {$lng_ademas_aqui_puedes_ver_como_hemos_presentado_tu_casa_online}</a>
                        </div>
                        <div class="col-lg-4">
                            <a href="javascript:;" class="btn btn-link text-start" data-bs-toggle="modal" data-bs-target="#solicitarCambio">✏️ {$lng_quieres_cambiar_algo_del_contenido_o_las_fotos_pincha_aqui}</a>
                        </div>
                        <div class="col-lg-4 border-start">
                            <a href="{$urlStart}{$url_contact}/" class="btn btn-link text-start" target="_blank">❓ {$lng_si_tienes_alguna_duda_o_comentario_haz_clic_aqui_para_ponerte_en_contacto_con_nosotros}</a>
                        </div>
                    </div>

                    <p>{$lng_seguimos_trabajando_cada_dia_para_encontrar_al_comprador_ideal_para_tu_vivienda__actualmente_la_estamos_promocionando_activamente_en_nuestra_pagina_web_a_traves_de_nuestra_red_de_contactos_en_redes_sociales_en_campanas_de_anuncios_online_soportes_offline_y_en_los_principales_portales_inmobiliarios_}</p>

                    <p><strong>{$lng_dedicamos_todos_nuestros_recursos_para_que_tu_casa_encuentre_comprador_}</strong></p>

                    <hr class="my-5">

                    <h2 class="text-uppercase font-weight-bold">{$lng_estos_son_los_datos_que_tenemos_para_ponernos_en_contacto_contigo}</h2>

                    <div class="row my-5">
                        <div class="col-lg-4">
                            <strong>{$lng_nombre}</strong><br>
                            {$datosprop[0].nombre_pro} {$datosprop[0].apellidos_pro}
                        </div>
                        <div class="col-lg-4">
                            <strong>{$lng_telefono}</strong><br>
                            {$datosprop[0].telefono_fijo_pro} {$datosprop[0].telefono_movil_pro}
                        </div>
                        <div class="col-lg-4">
                            <strong>{$lng_email}</strong><br>
                            {$datosprop[0].email_pro}
                        </div>
                    </div>

                    <hr>

                    <h2 class="text-uppercase font-weight-bold mt-5">{$lng_informe_de_la_propiedad}: {$datosprop[0].referencia_prop}</h2>

                    <p class="text-uppercase">{$lng_dias_desde_la_publicacion_del_anuncio_en_nuestra_web}: {$totaldias|number_format:0:",":"."}</p>

                    <h2 class="text-uppercase font-weight-bold mt-5">{$lng_visiualizaciones}</h2>
                    <div class="report-content">
                        <div class="row">
                            <div class="col-3">
                                <div class="views-rep">
                                    {$vistot|number_format:0:",":"."}
                                    <span>{$lng_total}</span>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="views-rep">
                                    {$vishoy|number_format:0:",":"."}
                                    <span>{$lng_hoy}</span>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="views-rep">
                                    {$vissem|number_format:0:",":"."}
                                    <span>{$lng_ultima_semana}</span>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="views-rep">
                                    {$vismes|number_format:0:",":"."}
                                    <span>{$lng_ultimo_mes}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h2 class="text-uppercase font-weight-bold mt-5">{$lng_seguimiento_de_la_propiedad}</h2>

                    <table class="display table table-bordered align-middle mt-5" width="100%">
                        <thead class="table-light">
                            <tr>
                                <th>{$lng_referencia}</th>
                                <th>{$lng_anadido}</th>
                                <th>{$lng_modificado}</th>
                                <th>{$lng_listado}</th>
                                <th>{$lng_property}</th>
                                <th>{$lng_consultas}</th>
                                <th>{$lng_enviar_a_un_amigo}</th>
                                <th>{$lng_favoritos}</th>
                                <th>{$lng_impreso}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{$datosprop[0].referencia_prop}</td>
                                <td>{$seg.inserted_xml_prop|date_format:"%d-%m-%Y %H:%M"}</td>
                                <td>{$seg.updated_prop|date_format:"%d-%m-%Y %H:%M"}</td>
                                <td>{$seg.listado|number_format:0:",":"."}</td>
                                <td>{$seg.propiedad|number_format:0:",":"."}</td>
                                <td>{$seg.consulta|number_format:0:",":"."}</td>
                                <td>{$seg.amigo|number_format:0:",":"."}</td>
                                <td>{$seg.impreso|number_format:0:",":"."}</td>
                                <td>{$seg.favoritos|number_format:0:",":"."}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div id="chart-container" class="mt-5"></div>

                    <h2 class="text-uppercase font-weight-bold mt-5">{$lng_emails} {$lng_desde_la_web}</h2>

                    <div class="report-content">
                        <div class="row">
                            <div class="col-3">
                                <div class="views-rep">
                                    {$mailstot|number_format:0:",":"."}
                                    <span>{$lng_total}</span>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="views-rep">
                                    {$mailshoy|number_format:0:",":"."}
                                    <span>{$lng_hoy}</span>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="views-rep">
                                    {$mailssem|number_format:0:",":"."}
                                    <span>{$lng_ultima_semana}</span>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="views-rep">
                                    {$mailsmes|number_format:0:",":"."}
                                    <span>{$lng_ultimo_mes}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="views-rep">
                                    <p>{$datosprop[0].properties_properties|number_format:0:",":"."} <span>{$lng_n_de_comunicaciones_por_email}</span> </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {if $actCalendar == 1 && $otros[0].inicio_ct != ''}
                    <h2 class="text-uppercase font-weight-bold mt-5">{$lng_agenda_de_seguimiento}</h2>

                    <table class="table table-striped">
                        <tr>
                            <th class="col-3">{$lng_fecha}</th>
                            <th class="col-3">{$lng_comercial}</th>
                            <th class="col-3">{$lng_accion}</th>
                        </tr>
                        {section name=h loop=$otros}
                        <tr>
                            <td>{$otros[h].inicio_ct|date_format:"%d-%m-%Y %H:%M"}</td>
                            <td>{$otros[h].nombre_usr}</td>
                            <td><span class="label label-default">{$otros[h].cat}</span></td>
                        </tr>
                        {/section}
                    </table>
                    {/if}

                    <hr class="my-5">

                    <p>{$lng_text_report_1}</p>

                    <p>{$lng_text_report_2}</p>

                    <p><strong>{$lng_text_report_3}</strong></p>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="solicitarCambio">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-light">
                <h5 class="modal-title">{$lng_save_and_edit_all_your_searches}</h5>
                <a class="close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fal fa-times"></i>
                </a>
            </div>
            <form action="#" id="solicitarCambioForm" method="post" class="validate">
                <div class="modal-body">
                    <p>{$lng_indicanos_que_datos_deseas_que_rectifiquemos_o_estan_incompletos}</p>

                    <div class="mb-3">
                        <label for="acomment">{$lng_mensaje}</label>
                        <textarea name="acomment" id="acomment" class="form-control" rows="5" placeholder="{$lng_mensaje}"></textarea>
                    </div>
                    <div class="legal">
                        {$lng_by_proceeding_i_agree_the_legal_note_eu_law_i_also_agree_that_this_site_may_set_cookies_on_my_browser__learn_about_uses_of_cookies_here}
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <input type="hidden" name="lang" value="{$lang}">
                    <input type="hidden" name="id" value="{$datosprop[0].id_prop}">
                    <input type="hidden" name="user" value="{$datosprop[0].id_pro}">
                    <input type="hidden" name="ref" value="{$datosprop[0].referencia_prop}">
                    <input type="hidden" name="name" value="{$datosprop[0].nombre_pro}">
                    <input type="hidden" name="f{$smarty.now|date_format:"%e%m%y"|replace:" ":"0"}" value="" class="hide">
                    <input type="submit" value="{$lng_solicitar_cambio}" class="btn btn-primary" />
                </div>
            </form>
        </div>
    </div>
</div>

{include file="footer.tpl"}

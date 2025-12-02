<h3 class="main-title">{$lng_property_listings}</h3>

<table class="table table-hover table-properties mt-xl-2">

      <thead>
            <tr>
                  <th scope="col"></th>
                  <th scope="col"><span>REF</span></th>
                  <th scope="col">{$lng_nombre}</th>
                  <th scope="col">{$lng_habitaciones}</th>
                  <th scope="col">{$lng_banos}</th>
                  <th scope="col">{$lng_meters}</th>
                  <th scope="col">{$lng_parcela}</th>
                  <th scope="col">{$lng_precio}</th>
                  <th scope="col">{$lng_floor_plans}</th>
            </tr>
      </thead>
      <tbody row>

            {section name=tg loop=$propiedades}

                  <tr>
                        <td class="image" style="min-width: 100px">
                              <div class="py-1">
                                  <a class="d-inline-block" href="{propURL($propiedades[tg].id_prop, $lang)}">
                                      {if file_exists("{$smarty.server.DOCUMENT_ROOT}/media/images/properties/thumbnails/{$propiedades[tg].id_img}_md.jpg")}
                                          <img src="/media/images/properties/thumbnails/{$propiedades[tg].id_img}_md.jpg" class="img-fluid">
                                      {else}
                                          {imagesize src='/media/images/website/no-image.png' width={$thumbnailsSizes['md'][0]} height={$thumbnailsSizes['md'][1]} class='img-fluid' }
                                      {/if}
                                  </a>
                              </div>
                        </td>
                        <th scope="row" class="col-2 col-xl-1 ps-lg-3 align-middle">
                              <a href="{propURL($propiedades[tg].id_prop, $lang)}" class="d-block py-3 referencia">
                                    {$propiedades[tg].ref}
                              </a>
                        </th>
                        <td class="col col-lg-3 align-middle">
                              <div class="py-3 table-name">
                                    {$propiedades[tg].titulo|html_entity_decode|strip_tags|truncate:60:"..."}
                              </div>
                        </td>
                        <td class="col align-middle">
                              <div class="py-3">{$propiedades[tg].habitaciones_prop} </div>
                        </td>
                        <td class="col align-middle">
                              <div class="py-3">{$propiedades[tg].aseos_prop} </div>
                        </td>
                        <td class="col col-lg-2 align-middle">
                              <div class="py-3">{$propiedades[tg].m2_prop}<small>m<sup>2</sup> </small></div>
                        </td>
                        <td class="col col-lg-2 align-middle">
                              <div class="py-3">{$propiedades[tg].m2p_prop}<small>m<sup>2</sup> </small></div>
                        </td>
                        <td class="col col-lg-3 align-middle">
                              <div class="py-3">
                                    {if $propiedades[tg].precio == 0}

                                          {$lng_consultar}
                                    {else}
                                          {$propiedades[tg].precio|number_format:0:",":"."}€
                                    {/if}

                              </div>
                        </td>
                        <td class="col align-middle">
                              <div class="py-1 text-center pe-lg-3">
                                    {if $propiedades[tg][1].planos[0].image_img != ''}
                                          {if file_exists("{$smarty.server.DOCUMENT_ROOT}/media/images/propertiesplanos/thumbnails/{$propiedades[tg][1].planos[0].id_img}_xl.jpg")}
                                                <a class="p-0 btn btn-file gallProp"
                                                      href="/media/images/propertiesplanos/thumbnails/{$propiedades[tg][1].planos[0].id_img}_xl.jpg"
                                                      target="_blank">
                                                      <img src="/media/images/website/icon-eye.svg" alt="{$lng_planos}">
                                                </a>
                                          {/if}
                                          {section name=img loop=$propiedades[tg][1].planos}
                                                <li class="d-none">
                                                      <a href="/media/images/propertiesplanos/thumbnails/{$propiedades[tg][1].planos[img].id_img}_xl.jpg"
                                                            class="gallProp">
                                                      </a>
                                                </li>
                                          {/section}
                                    {/if}
                              </div>
                        </td>
                  </tr>

            {/section}

      </tbody>
</table>
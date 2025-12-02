<div class="botonera">


    <div class="row g-2">
        
        <div class="col">
               <div class="d-grid"> 
                 <a href="#" data-href="/modules/property/add-fav.php?fav={$property[0].id_prop}" class="btn btn-outline-primary add-fav {if $isFav == '1'}fav-hide{/if}" title="{$lng_anadir_a_favoritos}" rel="nofollow"><i class="far fa-heart"></i><span>{$lng_anadir_a_favoritos}</span></a>

                <a href="#" data-href="/modules/property/rem-fav.php?fav={$property[0].id_prop}" class="btn btn-outline-primary rem-fav {if $isFav == '0'}fav-hide{/if}" title="{$lng_eliminar_de_favoritos}" rel="nofollow"><i class="fa fa-heart"></i><span>{$lng_eliminar_de_favoritos}</span></a>
               </div>
        </div>

        <div class="col"> 
            <div class="d-grid">
                
                <a href="#" class="btn btn-outline-primary" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" id="dropdownRedes" aria-haspopup="true" aria-expanded="false" >
                   {$lng_share} 
                </a>

                    <ul class="dropdown-menu animated fadeIn bg-light-blue" aria-labelledby="dropdownRedes" style="" >

                        <li class="dropdown-item social-links bg-white">
                              <a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" target="_blank">
                                  <i class="fab fa-facebook-f"></i>
                              </a>  
                              <a class="twitter" href="https://www.twitter.com/share?url=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" target="_blank">
                                  <i class="fab fa-x-twitter"></i>
                              </a>  

                               <a class="linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}&title=&summary=&source=" target="_blank">
                                  <i class="fab fa-linkedin"></i>
                              </a>
                              <a  class="btn-whatsapp-property" href="https://api.whatsapp.com/send?text=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" target="_blank">
                                  <i class="fab fa-whatsapp"></i>
                              </a>
                              <a  class="telegram" href="https://telegram.me/share/url?url={$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" target="_blank">
                                  <i class="fab fa-telegram-plane"></i>
                              </a>
                              <a href="#" class="friend" data-bs-toggle="modal" data-bs-target="#friendPureModal" title="{$lng_enviar_a_un_amigo}">
                                 <i class="fal fa-envelope"></i>
                             </a>
                              <a  class="link" href="javascript:getlink();"><i class="fal fa-link"></i></a>
                        </li>
                    
                    </ul>
            </div>
        </div>

        {if $property[0].vista360_prop != ''}
            <div class="col"> 
                <div class="d-grid">
                    <a href="{$property[0].vista360_prop}" class="btn btn-outline-primary" target="_blank">{$lng_vista_360}</a>
                </div>
            </div>
        {/if}
             
        <div class="col"> 
            <div class="d-grid">
                <a href="/modules/property/save_web.php?id={$property[0].id_prop}&lang={$lang}" target="_blank" class="btn btn-outline-primary descargar" rel="nofollow">{$lng_pdfimprimir}</a>
            </div>
        </div>

         {if $actBajadaPrecios == 1}
             <div class="col"> 
                <div class="d-grid">
                    <a href="#" class="btn btn-outline-primary btn-block" data-bs-toggle="modal" data-bs-target="#bajadaModal">{$lng_informarme_de_bajada_de_precio}</a>
                </div>
            </div>
        {/if}

        <div class="col"> 
            <div class="d-grid">
                <a href="{$http_referer}" class="btn btn-light">
                    {$lng_volver_a_resultados_de_busqueda}
                </a>
            </div>
        </div>   
        
    </div>

</div>


<li {if $submenu == 1}class="list-inline-item"{/if}>
    <a href="{$urlStart}">{$lng_inicio}</a>
</li>
{if $actMapaPropiedades == 1 }
<li  {if $submenu == 1}class="dropdown {if $seccmen != ''}dropup{/if} {if $seccion == $url_properties || $seccion == {$url_property} || $seccion == $url_property_map}active{/if} list-inline-item"{/if}>
{else}
<li  {if $submenu == 1}class="dropdown {if $seccmen != ''}dropup{/if} {if $seccion == $url_properties || $seccion == {$url_property}}active{/if} list-inline-item"{/if}>
{/if}
    <a href="{$urlStart}{$url_properties}/" {if $submenu == 1} role="button" data-bs-toggle="dropdown" id="dropdownMenuLink1{if $seccmen != ''}{$seccmen}{/if}" aria-haspopup="true" aria-expanded="false"{/if}>{$lng_propiedades}</a>
    <ul {if $submenu == 1}class="dropdown-menu animated fadeIn" aria-labelledby="dropdownMenuLink1{if $seccmen != ''}{$seccmen}{/if}"{/if}>
        <li class="dropdown-item">
            <a href="{$urlStart}{$url_properties}/">{$lng_ver_todas_las_propiedades}</a>
        </li>
        {section name=st loop=$status}
            {if $status[st].visible}
                <li {if $submenu == 1}class="dropdown-item"{/if}><a href="{$urlStart}{$url_properties}-{$status[st].sale|lower|slug}/">{$status[st].sale}</a></li>
            {/if}
        {/section}
        {if $actMapaPropiedades == 1 }
        <li {if $submenu == 1}class="dropdown-item"{/if}><a href="{$urlStart}{$url_property_map}/">{$lng_mapa_de_propiedades}</a></li>
        {/if}
    </ul>
</li>
{if $actPromociones == 1}
    <li {if $submenu == 1}class="list-inline-item{if $seccion == {$url_promociones}} active{/if}"
        {else}{if $seccion == ''}class="active" {/if}{/if}><a href="{$urlStart}{$url_promociones}/">{$lng_promotions}</a>
    </li>
{/if}
<li {if $submenu == 1}class="list-inline-item{if $seccion == {$url_about_us}} active{/if}"{else}{if $seccion == ''}class="active"{/if}{/if}><a href="{$urlStart}{$url_about_us}/">{$lng_quienes_somos}</a></li>

{if $actVenderPropiedad == 0}
<li {if $submenu == 1}class="list-inline-item{if $seccion == {$url_sell_your_property}} active{/if}"{else}{if $seccion == ''}class="active"{/if}{/if}><a href="{$urlStart}{$url_sell_your_property}/">{$lng_venda_su_propiedad}</a></li>
{/if}


{if $actNoticias == 0}
<li {if $submenu == 1}class="list-inline-item{if $seccion == {$url_news}} active{/if}"{else}{if $seccion == ''}class="active"{/if}{/if}><a href="{$urlStart}{$url_news}/">{$lng_blog}</a></li>
{/if}

{if $actTestimonials == 0}
<li {if $submenu == 1}class="list-inline-item{if $seccion == {$url_testimonials}} active{/if}"{else}{if $seccion == ''}class="active"{/if}{/if}><a href="{$urlStart}{$url_testimonials}/">{$lng_testimonials}</a></li>
{/if}
{if $Activarzonas == 0}
<li {if $submenu == 1}class="dropdown {if $seccmen != ''}dropup{/if} {if $seccion == {$url_areas}}active{/if} list-inline-item"{/if}>
      <a href="{$urlStart}{$url_areas}/" {if $submenu == 1}class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" id="dropdownMenuLink2{if $seccmen != ''}{$seccmen}{/if}" aria-expanded="false"{/if}>{$lng_areas}</a>
      <ul {if $submenu == 1}class="dropdown-menu animated fadeIn" aria-labelledby="dropdownMenuLink2{if $seccmen != ''}{$seccmen}{/if}"{/if}>
          {section name=ft loop=$zonasmen}
              {assign var="areaurl" value="{$smarty.server.REQUEST_URI}"}
              {assign var="areaurl2" value="{$urlStart}{$zonasmen[ft].titulo|slug}.html"}
              <li {if $submenu == 1}class="dropdown-item"{/if}><a href="{$urlStart}{$zonasmen[ft].titulo|slug}.html">{$zonasmen[ft].titulo}</a></li>
          {/section}
      </ul>
</li>
{/if}

{if $actEventos == 1}
<li {if $submenu == 1}class="list-inline-item{if $seccion == {$url_events}} active{/if}"{else}{if $seccion == ''}class="active"{/if}{/if}><a href="{$urlStart}{$url_events}/">{$lng_eventos}</a></li>
{/if}

<li {if $submenu == 1}class="list-inline-item{if $seccion == {$url_contact}} active{/if}"{else}{if $seccion == ''}class="active"{/if}{/if}><a href="{$urlStart}{$url_contact}/">{$lng_contactar}</a></li>

    {if $actRegister == 1}
    
        {if $isLevel1 == false}

         <li class="list-inline-item hidden-on-side-menu hidden-on-footer">
            <a class="pill-btn-login" href="{$urlStart}login/">
                <span>
                {$lng_login}
                <svg xmlns="http://www.w3.org/2000/svg" width="14.045" height="16.65" viewBox="0 0 14.045 16.65">
                    <g id="icono_usuario_negro" transform="translate(-15 -11)">
                        <path fill="#FFFFFF" id="Trazado_1" data-name="Trazado 1" d="M22.054,179l-.064.064h-.127l-.064.064h-.064l-.064.064v.064l-.064.064v.445l.254.254h3.813l.064.064h.318l.064.064h.191l.064.064H26.5l.064.064h.064l.064.064h.064l.127.127h.064l.635.636v.064l.127.127v.064l.064.064v.064l.064.064v.064l.064.064v.127l.064.064v.254l.064.064v1.716l-.064.064H16.08l-.064-.064v-1.716l.064-.064v-.254l.064-.064v-.127l.064-.064v-.064l.064-.064v-.064l.064-.064v-.064l.127-.127V181.1l.635-.636h.064l.064-.064h.064l.127-.127h.127l.064-.064h.064l.064-.064h.191l.064-.064h.191l.064-.064H18.3l.191-.191v-.064l.064-.064v-.318l-.127-.127v-.064l-.064-.064H18.3l-.064-.064H17.86l-.064.064h-.191l-.064.064h-.127l-.064.064h-.127l-.064.064H17.1l-.064.064h-.127l-.127.127h-.064l-.064.064h-.064l-.127.127H16.4l-.7.7v.064l-.127.127v.064l-.127.127v.064l-.064.064v.064l-.064.064v.064l-.064.064v.127l-.064.064v.127l-.064.064v.127l-.064.064v.254L15,182.05v2.606l.318.318H28.727l.254-.254v-.064l.064-.064v-2.478l-.064-.064v-.318l-.064-.064v-.127l-.064-.064v-.127l-.064-.064v-.127l-.064-.064v-.064l-.064-.064v-.064l-.064-.064v-.064l-.127-.127v-.064l-.127-.127V180.4l-.7-.7h-.064l-.127-.127h-.064l-.127-.127H27.2l-.064-.064h-.064l-.064-.064h-.127l-.064-.064h-.064l-.064-.064H26.5l-.064-.064h-.191l-.064-.064H25.74L25.676,179Z" transform="translate(0 -157.324)"></path>
                        <path fill="#FFFFFF" id="Trazado_2" data-name="Trazado 2" d="M56.749,11l-.064.064h-.254l-.064.064h-.191l-.064.064h-.127l-.064.064H55.86l-.064.064h-.127l-.064.064h-.064l-.064.064h-.064l-.064.064h-.064l-.064.064h-.064l-.127.127H54.97l-.127.127h-.064l-.254.254h-.064l-.381.381v.064l-.254.254v.064l-.127.127v.064l-.064.064v.064l-.127.127v.064l-.064.064v.064l-.064.064v.127l-.064.064V13.8l-.064.064v.127l-.064.064v.191l-.064.064V14.5l-.064.064v.381L53,15v.763l.064.064v.381l.064.064v.191l.064.064v.127l.064.064v.127l.064.064v.127l.064.064v.064l.064.064v.064l.064.064v.064l.064.064v.064l.127.127v.064l.127.127v.064l.191.191v.064l.445.445h.064l.254.254h.064l.127.127h.064l.064.064h.127l.127.127h.064l.064.064h.064l.064.064h.064l.064.064h.127l.064.064h.127l.064.064H56.3l.064.064h.254l.064.064H58.02l.064-.064h.254l.064-.064h.191l.064-.064h.127l.064-.064h.127l.064-.064H59.1l.064-.064h.064l.064-.064h.064l.064-.064h.064l.127-.127h.064l.064-.064H59.8l.127-.127h.064l.254-.254h.064l.318-.318v-.064l.254-.254v-.064l.191-.191v-.064l.064-.064v-.064l.127-.127v-.064l.064-.064V17.1l.064-.064v-.064l.064-.064v-.064l.064-.064v-.127l.064-.064V16.4l.064-.064v-.191l.064-.064v-.445l.064-.064V15l-.064-.064V14.5l-.064-.064v-.191l-.064-.064v-.191l-.064-.064V13.8l-.064-.064v-.064l-.064-.064v-.127l-.064-.064v-.064l-.064-.064v-.064l-.127-.127v-.064l-.127-.127h-.064l-.064-.064H60.5l-.254.254v.127l-.064.064v.127l.064.064v.127l.127.127V13.8l.064.064v.064l.064.064v.127l.064.064V14.3l.064.064v.191l.064.064v.318l.064.064v.572l-.064.064v.318l-.064.064v.191l-.064.064V16.4l-.064.064v.064l-.064.064v.127l-.127.127v.064l-.064.064v.064l-.127.127v.064l-.191.191v.064l-.381.381h-.064l-.191.191h-.064l-.127.127h-.064l-.064.064H58.91l-.064.064h-.064l-.064.064h-.064l-.064.064h-.127L58.4,18.5h-.127l-.064.064H58.02l-.064.064h-.508l-.064.064h-.064l-.064-.064h-.572l-.064-.064h-.191l-.064-.064h-.127l-.064-.064h-.064l-.064-.064h-.127l-.064-.064H55.8l-.127-.127h-.064l-.064-.064h-.064l-.191-.191h-.064l-.445-.445v-.064l-.191-.191v-.064l-.127-.127v-.064L54.4,16.91v-.064l-.064-.064V16.72l-.064-.064v-.064l-.064-.064V16.4l-.064-.064v-.191l-.064-.064V15.83l-.064-.064V15l.064-.064v-.318l.064-.064v-.127l.064-.064v-.127l.064-.064V14.05l.064-.064v-.064l.064-.064V13.8l.127-.127v-.064l.064-.064v-.064l.191-.191v-.064l.445-.445h.064l.191-.191h.064l.127-.127h.064L55.8,12.4h.064l.064-.064h.064l.064-.064h.064l.064-.064h.064l.064-.064H56.5l.064-.064h.191l.064-.064h.445l.064-.064h.191l.064-.064h.064l.064-.064v-.064l.064-.064v-.127l.064-.064v-.064l-.064-.064v-.127L57.512,11Z" transform="translate(-35.585 0)"></path>
                    </g>
                </svg>
            </a> 
         </li>
                 
         {else}
             <li class="list-inline-item hidden-on-side-menu hidden-on-footer">
                    <a class="dropdown-toggle login-btn" role="button" data-bs-toggle="dropdown" id="dropdownMenuPriv">
                      {$lng_hola},  {$usrLogin[0].nombre_usr}
                    </a> 
                    <ul class="dropdown-menu animated fadeIn" aria-labelledby="dropdownMenuPriv">

                            {if $actSaveSearch == 1}
                                <li class="dropdown-item">
                                    <a href="{$urlStart}saved-searches/">
                                        {$lng_tus_busquedas_guardadas}
                                    </a>
                                </li>
                            {/if}
                            
                            <li class="dropdown-item">
                                <a href="{$urlStart}update/">
                                    <span>{$lng_tu_cuenta}</span>
                                </a>
                            </li>
                            <li class="dropdown-item">
                                <a href="{$urlStart}{$url_favorites}/">
                                    <span>{$lng_tus_favoritos}</span> 
                                </a>
                            </li>
                            <li class="dropdown-item">
                                <a href="{$urlStart}logout/">
                                    <span>{$lng_desconectar}</span> 
                                </a>
                            </li>
                    </ul>
            </li>
        {/if}

{/if}

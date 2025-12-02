{if $actRegister == 1}
    
        {if $isLevel1 == false}

         <li class="list-inline-item hidden-on-side-menu hidden-on-footer">
            <a class="login-btn" href="{$urlStart}login/">
                {$lng_login}
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



<li {if $submenu == 1}class="list-inline-item{if $seccion == ''} active{/if}"{else}{if $seccion == ''}class="active"{/if}{/if}><a href="{$urlStart}">{$lng_inicio}</a></li>
<li {if $submenu == 1}class="list-inline-item{if $seccion == {$url_about_us}} active{/if}"{else}{if $seccion == ''}class="active"{/if}{/if}><a href="{$urlStart}{$url_about_us}/">{$lng_quienes_somos}</a></li>
{if $actMapaPropiedades == 1 }
<li  {if $submenu == 1}class="dropdown {if $seccmen != ''}dropup{/if} {if $seccion == $url_properties || $seccion == {$url_property} || $seccion == $url_property_map}active{/if} list-inline-item"{/if}>
{else}
<li  {if $submenu == 1}class="dropdown {if $seccmen != ''}dropup{/if} {if $seccion == $url_properties || $seccion == {$url_property}}active{/if} list-inline-item"{/if}>
{/if}
    <a href="{$urlStart}{$url_properties}/" {if $submenu == 1}class="dropdown-toggle" role="button" data-bs-toggle="dropdown" id="dropdownMenuLink1{if $seccmen != ''}{$seccmen}{/if}" aria-haspopup="true" aria-expanded="false"{/if}>{$lng_propiedades}</a>
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
{if $actVenderPropiedad == 1}
<li {if $submenu == 1}class="list-inline-item{if $seccion == {$url_sell_your_property}} active{/if}"{else}{if $seccion == ''}class="active"{/if}{/if}><a href="{$urlStart}{$url_sell_your_property}/">{$lng_venda_su_propiedad}</a></li>
{/if}
{if $actPromociones == 1}
    <li {if $submenu == 1}class="list-inline-item{if $seccion == {$url_promociones}} active{/if}"
        {else}{if $seccion == ''}class="active" {/if}{/if}><a href="{$urlStart}{$url_promociones}/">{$lng_promotions}</a>
    </li>
{/if}

{if $actNoticias == 1}
<li {if $submenu == 1}class="list-inline-item{if $seccion == {$url_news}} active{/if}"{else}{if $seccion == ''}class="active"{/if}{/if}><a href="{$urlStart}{$url_news}/">{$lng_blog}</a></li>
{/if}

{if $actTestimonials == 1}
<li {if $submenu == 1}class="list-inline-item{if $seccion == {$url_testimonials}} active{/if}"{else}{if $seccion == ''}class="active"{/if}{/if}><a href="{$urlStart}{$url_testimonials}/">{$lng_testimonials}</a></li>
{/if}
{if $Activarzonas == 1}
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

<li {if $submenu == 1}class="list-inline-item{if $seccion == {$url_favorites}} active{/if}"{else}{if $seccion == ''}class="active"{/if}{/if}><a href="{$urlStart}{$url_favorites}/"><span class="favor"></span> {$lng_favoritos} <span class="budget-fav">{if $totalFavs > 0}({$totalFavs}){/if}</span></a></li>

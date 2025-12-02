<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="{$lang}">
<!--<![endif]-->
<head>

<!-- Basic Page Needs
  ================================================== -->
<meta charset="utf-8">
<title>{$metaTitle}</title>

<!-- Mobile Specific Metas
  ================================================== -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!-- CSS
  ================================================== -->
<link rel="stylesheet" href="/modules/favorites/css/website_print_admin.css?{$csstime}">
<!-- <link rel="stylesheet" href="/css/no-responsive.css"> -->

<!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

<!-- SEO
    ================================================== -->
{foreach from=$languages item=idm}
    {if $idm == $language}
<link rel="alternate" hreflang="x-default" href="http://{$smarty.server.HTTP_HOST}/" />
{else}
<link rel="alternate" hreflang="{$idm}" href="http://{$smarty.server.HTTP_HOST}/{$idm}/" />
{/if}
    {/foreach}

<!-- Favicons
    ================================================== -->
<link rel="shortcut icon" href="/media/images/icons/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="./media/images/icons/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="./media/images/icons/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="./media/images/icons/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="./media/images/icons/apple-touch-icon-57-precomposed.png">
</head><body class="{$lang} print">

<!-- Header
    ================================================== -->

<!-- /#header -->

<div id="content">
<div class="container">
<!--<h1><span>{$lng_favoritos}</span></h1>-->
{if $properties[0].id_prop != ''}
<div class="row">
  <div class="row imprimir">
    <img src="/modules/favorites/view/intro_{$lang}.png" alt="">
  </div>
</div>
<div class="row"> {section name=ft loop=$properties}
  <div class="row imprimir">
  <div class="col-xs-5">
    <div class="mini-img">
      <div class="labels">

        {if {$properties[ft].nuevo_prop|strtotime} >= $smarty.now }
            <div class="label label-success">{$lng_nuevo}</div>
        {/if}
        {if $properties[ft].vendido_prop == 1}
            <div class="label label-danger">{$lng_vendido}</div>
        {/if}
        {if $properties[ft].alquilado_prop == 1}
            <div class="label label-danger">{$lng_alquilado}</div>
        {/if}
        {if $properties[ft].reservado_prop == 1}
            <div class="label label-danger">{$lng_reservado}</div>
        {/if}
        {assign var=tag value=getPropTags($properties[ft].id_prop, $lang)}
        {section name=tg loop=$tag}
            {if $tag[tg].tag != ''}
                <div class="label label-info label-{$tag[tg].id_tag}">{$tag[tg].tag}</div>
            {/if}
        {/section}
        </div>

        {assign var="altTitle" value="{$properties[ft].type} - {$properties[ft].sale} - {$properties[ft].area} - {$properties[ft].town}"}
        {if file_exists("{$smarty.server.DOCUMENT_ROOT}/media/images/properties/thumbnails/{$properties[ft].id_img}_md.jpg")}
            <img src="/media/images/properties/thumbnails/{$properties[ft].id_img}_md.jpg" class='img-responsive' alt="{$altTitle}" title="{$altTitle}">
        {else}
            {imagesize src='/media/images/website/no-image.png' width={$thumbnailsSizes['md'][0]} height={$thumbnailsSizes['md'][1]} class='img-responsive' alt="{$altTitle}" title="{$altTitle}" }
        {/if}
        </div>
      </div>
    <div class="col-xs-4">
    <h4><strong>{$properties[ft].province}</strong> / {if $properties[ft].area == $properties[ft].town}<strong>{$properties[ft].area}</strong>{else}<strong>{$properties[ft].area}</strong> / <strong>{$properties[ft].town}</strong>{/if}</h4>
    <h3><strong>{$properties[ft].type}</strong> / <strong>{$properties[ft].sale}</strong></h3>
    <p>{$properties[ft].descr|strip_tags|truncate:200:"..."}</p>
  </div>
  <div class="col-xs-3">
    <ul class="caracteristicas">
      <li><strong>Ref: {$properties[ft].ref}</strong></li>
      {if {$properties[ft].m2_prop|number_format:0:",":"."} > 0}
      <li>{$properties[ft].m2_prop|number_format:0:",":"."} m&sup2;</li>
      {/if}

      {if {$properties[ft].m2p_prop|number_format:0:",":"."} > 0}
      <li>{$properties[ft].m2p_prop|number_format:0:",":"."} m&sup2;</li>
      {/if}
      <li>{$lng_habitaciones}: {$properties[ft].habitaciones_prop|number_format:0:",":"."}</li>
      <li>{$lng_banos}: {$properties[ft].aseos_prop|number_format:0:",":"."}</li>
      {if isset($properties[ft].piscina_prop) && $properties[ft].piscina_prop != ''}
      <li class="pool"> {$roperties[ft].piscina_prop}</span> {/if}
      <li>
      <span class="prices">{if $properties[ft].old_precio > 0}<del>€ {$properties[ft].old_precio|number_format:0:",":"."}</del><br />
{/if} {if isset($properties[ft].display_from_prop) && $properties[ft].display_from_prop == 1}From{/if}
    {if {$properties[ft].precio|number_format:0:",":"."} != 0} € {$properties[ft].precio|number_format:0:",":"."} {else} {$lng_consultar} {/if}</span></li>
    </ul>
    <br style="clear: both;"><br><img src="/modules/favorites/view/bg-order.png?453" alt="">
  </div>

    <div class="clearfix"></div>
    {* <div class="row"> *}
    <div class="col-xs-5 propie">
          {if $lang == 'es'}
          <p><b>Hora:</b></p>
          {else}
          <p><b>Hour:</b></p>
          {/if}
          {if $properties[ft].nombre_pro != '' || $properties[ft].apellidos_pro != ''}
          <p>{$properties[ft].nombre_pro} {$properties[ft].apellidos_pro}</p>
          {/if}
          {if $properties[ft].telefono_fijo_pro != '' || $properties[ft].telefono_movil_pro != ''}
          <p>{$properties[ft].telefono_fijo_pro} - {$properties[ft].telefono_movil_pro}</p>
          {/if}
          {if isset($properties[ft].direccion_prop) && $properties[ft].direccion_prop != ''}
          <p>{$properties[ft].direccion_prop}</p>
          {/if}
      </div>
      <div class="col-xs-7 propie">
          {if $lang == 'es'}
              {if $properties[ft].llaves_prop == '1'}
                  <p><b>Llave:</b> {if $properties[ft].alcayata_prop != ''}Alcayata: {$properties[ft].alcayata_prop}{/if} {if $properties[ft].llave_txt_prop != ''} - {$properties[ft].llave_txt_prop}{/if}</p>
              {/if}
              {if $properties[ft].keyholder_prop == '1'}
                  <p><b>Responsable de llaves:</b> {if $properties[ft].keyholder_name_prop != ''}Nombre: {$properties[ft].keyholder_name_prop}{/if} {if $properties[ft].keyholder_tel_prop != ''} - Teléfono: {$properties[ft].keyholder_tel_prop}{/if}</p>
              {/if}
              {if $properties[ft].alarm_prop == '1'}
                  <p><b>Alarma:</b> {if $properties[ft].alarm_code_prop != ''}Código: {$properties[ft].alarm_code_prop}{/if}</p>
              {/if}
          {/if}
          {if $lang == 'en'}
              {if $properties[ft].llaves_prop == '1'}
                  <p><b>Keys:</b> {if $properties[ft].alcayata_prop != ''}Hooks: {$properties[ft].alcayata_prop}{/if} {if $properties[ft].llave_txt_prop != ''} - {$properties[ft].llave_txt_prop}{/if}</p>
              {/if}
              {if $properties[ft].keyholder_prop == '1'}
                  <p><b>Keyholder:</b> {if $properties[ft].keyholder_name_prop != ''}Name: {$properties[ft].keyholder_name_prop}{/if} {if $properties[ft].keyholder_tel_prop != ''} - Phone: {$properties[ft].keyholder_tel_prop}{/if}</p>
              {/if}
              {if $properties[ft].alarm_prop == '1'}
                  <p><b>Alarm:</b> {if $properties[ft].alarm_code_prop != ''}Code: {$properties[ft].alarm_code_prop}{/if}</p>
              {/if}
          {/if}

      </div>
    {* </div> *}
</div>

  {if ($smarty.section.ft.index + 1) % 3 == 0 && $smarty.section.ft.index != 7 }</div>
<div class="row">{/if}

  {/section} </div>
{else} <br>
<p class="lead text-center">{$lng_no_hay_favoritos_que_mostrar}.</p>
<br>
<br>
<br>
{/if}



<script>

	window.onload = function () {
	    // window.print();
	}

    </script>
</body>
</html>
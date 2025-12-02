

<h3 class="main-title subtitle">{$lng_zona}</h3>

<h2>{$zonas[0].titulo}</h2>
{if $zonas[0].img != ''}
    {if isset($zonas[0].alt) && $zonas[0].alt != ''}
        {assign var="altt" value="{$zonas[0].alt}"}
    {else}
        {assign var="altt" value="{$zonas[0].titulo}"}
    {/if}
    {assign var="imgZona" value="/media/images/news/{$zonas[0].img}"}
    {imagesize src="{$imgZona}" width=1200 height=500 class='img-responsive' alt="{$altt}" title="{$altt}" }
{/if}

{$zonas[0].contenido}
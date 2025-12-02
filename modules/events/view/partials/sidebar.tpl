{* @group SEC - BOTÓN VOLVER DE NOTICIA *}

{if $tokens[3] == '' && $tokens[2] != $url_category && $tokens[2] != ''}

    <div class="d-grid mb-4">
        <a href="{$smarty.server.HTTP_REFERER}" class="btn btn-light">{$lng_volver}</a>
    </div>

{/if}

{* @group SEC - CATEGORÍAS *}

<h2>{$lng_categorias}</h2>

{$menuCats} 

<h2 class="pt-4">Tags</h3>

<ul class="list-group">
{assign var="tags" value=explode(',', $resource.tags)}
{foreach from=','|explode:$menuTags item=curr_tag2}
<a href="{$urlStart}{$url_news}/{$curr_tag2}" class="list-group-item {if $category == $curr_tag2} text-primary {/if}">{$curr_tag2}</a>
{/foreach} 
</ul>
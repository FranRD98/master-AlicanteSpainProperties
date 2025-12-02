{* @group SEC - BOTÓN VOLVER DE NOTICIA *}

{if isset($tokens[2]) && $tokens[3] == '' && $tokens[2] != $url_category && $tokens[2] != ''}

    <div class="d-grid mb-4">
        <a href="{$http_referer}" class="btn btn-light">{$lng_volver}</a>
    </div>

{/if}

{* @group SEC - BUSCADOR *}
<h2>{$lng_search}</h2>
<form method="GET" >
    <div class="row">
        <div class="col-lg-10">
            <div class="form-group mb-10">
                <input type="text" name="ter" id="ter" class="form-control" value="{$smarty.get.ter|default:''}" placeholder="{$lng_buscar} {$lng_noticias}">
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group mb-2 d-grid">
                <button type="submit" class="btn btn-primary">{$lng_buscar}</button>
            </div>
        </div>
    </div>
</form>
{* @group SEC - CATEGORÍAS *}

<h2>{$lng_categorias}</h2>

{$menuCats}

{if $menuTags != ''}
<h2 class="pt-4">Tags</h3>

<ul class="list-group">
    {foreach from=','|explode:$menuTags item=curr_tag2}
        {if $curr_tag2 != ''}
            <a href="{$urlStart}{$url_news}/{$curr_tag2|replace:" ":"-"}"
        class="list-group-item {if $category == $curr_tag2} text-primary {/if}">{$curr_tag2}</a>
        {/if}
    {/foreach}
</ul>
{/if}

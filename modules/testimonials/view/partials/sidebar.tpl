{* @group SEC - BOTÓN VOLVER DE NOTICIA *}
{if $tokens[3] == '' && $tokens[2] != $url_category && $tokens[2] != ''}
     <a href="{$smarty.server.HTTP_REFERER}" class="btn btn-danger btn-block">{$lng_volver}</a> 
{/if}

{* @group SEC - CATEGORÍAS *}

{* <div class="wrapper-categories mt-5 mt-lg-0">
<h2 class="subtitle-news">{$lng_categorias}</h2>
{$menuCats}
</div> *}


{* @group SEC - NEWSLETTER *}
{* {include file="modules/mailchimp/views/newsletter.tpl"} *}
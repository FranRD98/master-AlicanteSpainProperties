<div class="views-properties" role="group">
    <strong class="porta-label d-inline-block pe-3">{$lng_show_as}: </strong>

    <a href="/modules/properties/set-view.php?v=box&url={urlencode($urlBox)}" class="btn {if isset($smarty.cookies.view) && $smarty.cookies.view != 'list' && $seccion != $url_property_map} btn-active {/if} ">

          {if isset($smarty.cookies.view) && $smarty.cookies.view == 'list' || $seccion == $url_property_map}
            <img src="/media/images/website/properties/grid-void.svg" class="m-0">
          {else}
            <img src="/media/images/website/properties/grid-active.svg" class="m-0">
          {/if}
    </a>

    <a href="/modules/properties/set-view.php?v=list&url={urlencode($urlList)}" class="btn {if isset($smarty.cookies.view) && $smarty.cookies.view == 'list' && $seccion != $url_property_map} btn-active {/if} btn-props-list d-none d-xl-inline-block">

      {if isset($smarty.cookies.view) && $smarty.cookies.view != 'list' || $seccion == $url_property_map}
        <img src="/media/images/website/properties/list-void.svg">
      {else}
        <img src="/media/images/website/properties/list-active.svg" class="m-0">
      {/if}

    </a>

    {if $actMapaPropiedades == 1}
    <a href="{$urlMap}" class="btn {if $seccion == $url_property_map} btn-active {/if} ">
      {if $seccion == $url_property_map}
         <img src="/media/images/website/properties/map-pin-white.svg">
      {else}
         <img src="/media/images/website/properties/map-pin-black.svg">
      {/if}
      
    </a>
    {/if}
</div>

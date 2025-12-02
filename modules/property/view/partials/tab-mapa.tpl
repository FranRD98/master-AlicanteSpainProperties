
<h3 class="main-title subtitle">{$lng_localizacion}</h3>

{if $property[0].lat != '' || $property[0].show_direccion_prop == '1'}
    {if $property[0].show_direccion_prop == '1'}
        <p>{$property[0].direccion_prop}</p>
    {/if}
    <div class="porta-gmap">
        <div class="gmap" id="gmap"></div>
    </div>
{/if}
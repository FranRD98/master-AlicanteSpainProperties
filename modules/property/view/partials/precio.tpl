<div class="precio">

    {if $property[0].precio_desde_prop == 1}
       <small>{$lng_from}</small> 
    {/if}

    {if {$property[0].precio|number_format:0:",":"."} != 0}
        {$property[0].precio|number_format:0:",":"."}€

        {if $property[0].old_precio > 0}
            <del>{$property[0].old_precio|number_format:0:",":"."}€</del>
        {/if}
    {else}
        {$lng_consultar}
    {/if}
</div>
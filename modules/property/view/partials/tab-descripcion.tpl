

<h3 class="main-title subtitle">{$lng_descripcion}</h3>

 <div class="bloque-texto">

    <div class="collapse collapsed-text" id="collapseText" aria-expanded="false">


{if {$property[0].description|strip_tags} != ''}

    <div class="property-description">
        {$description_has_p}
    </div>

{else}
    <p>{$lng_sin_contenido}</p>
{/if}

</div>


<a class="btn-collapse collapsed" data-bs-toggle="collapse" href="#collapseText" aria-expanded="false" aria-controls="collapseText">
    {$lng_mas_informacion}
</a>



</div>





<div class="row">
    <div class="col-lg-4">
        <a title="{$lng_obra_nueva}" href="{$urlStart}{$url_properties}-{slug(getFromArray($status, 2, 'id', 'sale'))}/" class="mini-banner">
            
            {imagesize src="/media/images/website/no-image.png" width=600 height=400 class='img-fluid' alt="{$lng_obra_nueva}" title="{$lng_obra_nueva}" }

            <div class="content-banner">
                <h3>{$lng_obra_nueva}</h3>
                <span class="total total-01"> <strong>20</strong> {$lng_propiedades} </span>
            </div>

            <div class="btn-show">{$lng_mostrar}</div>
        </a>
    </div>
    <div class="col-lg-4">
        <a title="{$lng_segunda_mano}" href="{$urlStart}{$url_properties}-{slug(getFromArray($status, 1, 'id', 'sale'))}/" class="mini-banner">

            {imagesize src="/media/images/website/no-image.png" width=600 height=400 class='img-fluid' alt="{$lng_segunda_mano}" title="{$lng_segunda_mano}" }


            <div class="content-banner">
                <h3>{$lng_segunda_mano}</h3>
                <span class="total total-02"> <strong>10</strong> {$lng_propiedades} </span>
            </div>

            <div class="btn-show">{$lng_mostrar}</div>
        </a>
    </div>
    <div class="col-lg-4">
        <a title="{$lng_alquiler}" href="{$urlStart}{$url_properties}-{slug(getFromArray($status, 4, 'id', 'sale'))}/" class="mini-banner">

            {imagesize src="/media/images/website/no-image.png" width=600 height=400 class='img-fluid' alt="{$lng_alquiler}" title="{$lng_alquiler}" }

            <div class="content-banner">
                <h3>{$lng_alquiler}</h3>
                <span class="total total-03"> <strong>20</strong> {$lng_propiedades} </span>
            </div>

            <div class="btn-show">{$lng_mostrar}</div>
        </a>
    </div>
</div>

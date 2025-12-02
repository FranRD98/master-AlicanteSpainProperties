{include file="header.tpl"}


<div class="page-content py-5">
        <div class="container">

            <h1 class="main-title smallest text-center big mb-5">
            <strong>
                {$lng_tus_busquedas_guardadas}
            </strong>
            </h1>
                        {$pagetext}

            <div class="row">
                <div class="col-md-12">
                    {if isset($searchs[0].id) && $searchs[0].id != ''}
                    {section name=ss loop=$searchs}
                    <div class="card card-success card-searchs mb-5">
                         <div class="p-3 bg-primary text-white">
                            <div class="badge badge-dark mt-1 text-uppercase py-2 px-3 resultc{$searchs[ss].id} float-end"><span></span>&nbsp; {$lng_propiedades}</div>
                            <span style="font-size: 20px; letter-spacing: 1px; text-transform: uppercase; font-weight: 500;"><i class=" ms-3 fal fa-search" aria-hidden="true"></i> {$lng_saved_search}: {$searchs[ss].created|date_format:"%e %B %Y"|upper}</span>
                        </div>
                        {* <div class="row row-searchs" id="search{$searchs[ss]['id']}"> *}
                        <ul class="list-group px-3" >
                        {foreach from=$searchs[ss].0 item=item key=key}

                        {* <pre>{$searchs[ss].0|print_r}</pre> *}

                            {if $item != ''}
                                {if $key == 'st'}
                                    <li class="list-group-item" style="border-left: 0; border-right: 0"><b>{$lng_estado}:</b>
                                        {foreach from=$item item=type key=k}{if $k > 0}, {/if}{getStatus($type)}{/foreach}
                                    </li>
                                {/if}
                            {/if}
                            {if isset($item[0]) && $item[0] != ''}
                                {if $key == 'tp'}
                                    <li class="list-group-item" style="border-left: 0; border-right: 0"><b>{$lng_tipo}:</b>
                                    {foreach from=$item item=type key=k}{if $k > 0}, {/if}{getTypeSRCH($type)}{/foreach}
                                    </li>
                                {/if}
                                {if $key == 'coast'}
                                    <li class="list-group-item" style="border-left: 0; border-right: 0"><b>{$lng_costa}:</b>
                                        {foreach from=$item item=type key=k}{if $k > 0}, {/if}{getCoast($type)}{/foreach}
                                    </li>
                                {/if}
                                {if $key == 'lopr'}
                                    <li class="list-group-item" style="border-left: 0; border-right: 0"><b>{$lng_provincia}:</b>
                                        {foreach from=$item item=type key=k}{if $k > 0}, {/if}{getTypeProv($type)}{/foreach}
                                    </li>
                                {/if}
                                {if $key == 'loct'}
                                    <li class="list-group-item" style="border-left: 0; border-right: 0"><b>{$lng_localizacion}:</b>
                                        {foreach from=$item item=type key=k}{if $k > 0}, {/if}{getTypeTown($type)}{/foreach}
                                    </li>
                                {/if}
                            {/if}
                            {if $item != ''}
                                {if $key == 'rf'}
                                    <li class="list-group-item" style="border-left: 0; border-right: 0"><b>{$lng_referencia}:</b> {$item}</li>
                                {/if}
                                {if $key == 'bd'}
                                    <li class="list-group-item" style="border-left: 0; border-right: 0"><b>{$lng_habitaciones}:</b> {$item}</li>
                                {/if}
                                {if $key == 'bt'}
                                    <li class="list-group-item" style="border-left: 0; border-right: 0"><b>{$lng_banos}:</b> {$item}</li>
                                {/if}
                                {if $key == 'prds'}
                                    <li class="list-group-item" style="border-left: 0; border-right: 0"><b>{$lng_precio_desde}:</b> {$item|number_format:0:',':'.'} €</li>
                                {/if}
                                {if $key == 'prhs'}
                                    <li class="list-group-item" style="border-left: 0; border-right: 0"><b>{$lng_precio_hasta}:</b> {if $item == '1000000' || $item == '3000'}+{/if} {$item|number_format:0:',':'.'} €</li>
                                {/if}
                                {if $key == 'pool'}
                                    <li class="list-group-item" style="border-left: 0; border-right: 0"><b>{$lng_piscina}:</b> {getTypePool($item)}</li>
                                {/if}
                                {if $key == 'tags'}
                                    {foreach from=$item item=type key=k}
                                        {if $type == 3}
                                            <li class="list-group-item" style="border-left: 0; border-right: 0"><b>{$lng_golf}</b></li>
                                        {/if}
                                        {if $type == 5}
                                            <li class="list-group-item" style="border-left: 0; border-right: 0"><b>{$lng_first_line}</b></li>
                                        {/if}
                                        {if $type == 1}
                                            <li class="list-group-item" style="border-left: 0; border-right: 0"><b>{$lng_sea_view}</b></li>
                                        {/if}
                                    {/foreach}
                                {/if}
                            {/if}
                        {/foreach}
                        </ul>
                         <div class="px-3 py-2 bg-light text-dark">
                            <a href="/" class="mt-1 mr-2 btn btn-danger btn-del-search" data-id="{$searchs[ss].id}"><i class="fal fa-trash text-white" aria-hidden="true"></i> {$lng_delete}</a>
                            <a href="{$urlStart}{$url_properties}/?{strip}{foreach from=$searchs[ss].0 item=item key=key}{if $key != 'q' && $key != 'lang' && $key != 'date' && $key != 'langx'}{if $key == 'tp' || $key == 'lopr' || $key == 'coast' || $key == 'loct' || $key == 'st' || $key == 'tags'}{foreach from=$item item=type key=k}{$key}[]={$type}&{/foreach}{else}{$key}={$item}&{/if}{/if}{/foreach}{/strip}" class="mt-1 btn btn-success pull-rightx" data-id="{$searchs[ss].id}" target="_blank"><i class="fal fa-search" aria-hidden="true"></i> {$lng_go_to_search}</a>
                            <div class="mt-2 float-end custom-form">

                                {* <div class="custom-control custom-checkbox">
                                  <input type="checkbox" id="customCheck1"value="1"  data-id="{$searchs[ss].id}" name="search{$searchs[ss].id}" class="custom-control-input sendMailSrch" {if $searchs[ss].send == '1'}checked{/if}>
                                  <label class="custom-control-label" for="customCheck1"><i class="fal fa-envelope mr-2"></i> {$lng_receive_emails}</label>
                                </div>
 *}

                                <div class="py-2">
                                    <label class="checkcontainer">
                                        <span class="tag-name">
                                          {$lng_receive_emails} 
                                        </span>
                                        <input {if $searchs[ss].send == '1'}checked{/if} class="custom-control-input sendMailSrch" type="checkbox" id="customCheck1"value="1"  data-id="{$searchs[ss].id}" name="search{$searchs[ss].id}"  />
                                        <span class="checkmark"></span>
                                    </label>
                                </div>


                            </div>
                            
                        </div>
                        {* </div> *}
                    </div>
                    {/section}
                    {/if}
                </div>
            </div>
        </div>
    </div>


{include file="footer.tpl"}

<script>
    $.get("/modules/properties/total.php?{strip}{foreach from=$searchs[ss].0 item=item key=key}{if $key != 'q' && $key != 'lang' && $key != 'date' && $key != 'langx'}{if $key == 'tp' || $key == 'lopr' || $key == 'loct' || $key == 'coast' || $key == 'st' || $key == 'tags'}{foreach from=$item item=type key=k}{$key}[]={$type}&{/foreach}{else}{$key}={$item}&{/if}{/if}{/foreach}{/strip}").done(function(data) {
        if (data != '') {
            $('.resultc{$searchs[ss].id} span').text(data);
        }
    });
</script>

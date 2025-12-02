<ol class="breadcrumb hidden-xs hidden-sm">
    <li><a href="{$urlStart}">{$lng_inicio}</a></li>
    <li><a href="{$urlStart}{$url_properties}/?locun[]={$property[0].countryid}">{$property[0].country}</a></li>
    <li><a href="{$urlStart}{$url_properties}/?lopr[]={$property[0].provinceid}">{$property[0].province}</a></li>
    <li><a href="{$urlStart}{$url_properties}/?loct[]={$property[0].areaid}">{$property[0].area}</a></li>
    <li><a href="{$urlStart}{$url_properties}/?lozn[]={$property[0].townid}">{$property[0].town}</a></li>
    <li><a href="{$urlStart}{$url_properties}/?tp[]={$property[0].typeid}">{$property[0].type}</a></li>
    <li><a href="{$urlStart}{$url_properties}/?st={$property[0].saleId}">{$property[0].sale}</a></li>
    <li class="active">{$lng_ref_}: {$property[0].ref}</li>
</ol>
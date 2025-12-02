{if $languages|@count > 1}

    <div class="dropdown idiomas-dropdown">
        {if $button == 1}
            <button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img height="24" width="24" src="/media/images/website/{$url_flags}/{$lang}.svg" alt="{$languages_names[{$lang}]}">
            </button>
        {else}
            <a href="{if $lang == $language}{$urlDefault}{else}{$url{$idm|upper}}{/if}" class="dropdown-toggle" id="dropdownMenu1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img height="24" width="24" src="/media/images/website/{$url_flags}/{$lang}.svg" alt="{$languages_names[{$lang}]}">
                {* <span>{$languages_names[{$lang}]}</span> *}
            </a>
        {/if}
        <ul class="dropdown-menu animated fadeIn" aria-labelledby="dropdownMenu1">
            {foreach from=$languages item=idm}
                {if $idm != $lang }
                <li class="dropdown-item">
                    <a href="{if $idm == $language}{$urlDefault}{else}{if $seccion != ''}{$url{$idm|upper}}{else}{$base_url}/{$idm}/{/if}{/if}">
                        <img height="24" width="24" src="/media/images/website/{$url_flags}/{$idm}.svg" alt="{$languages_names[{$idm}]}">
                        <span>{$languages_names[{$idm}]}</span>
                    </a>
                </li>
                {/if}
            {/foreach}
        </ul>
    </div>
{/if}

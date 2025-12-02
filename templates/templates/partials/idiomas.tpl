{if $languages|@count > 1}

    <div class="dropdown idiomas-dropdown">
        {if $button == 1}
            <button class="btn" type="button" id="dropdownMenu1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img height="24" width="24" src="/media/images/website/{$url_flags}/{$lang}.svg" alt="{$languages_names[{$lang}]}">
                <svg class="ms-2" xmlns="http://www.w3.org/2000/svg" width="6.561" height="3.78" viewBox="0 0 6.561 3.78">
    <g data-name="Icon feather-arrow-down">
        <path data-name="Trazado 310" d="m12.646 18-2.573 2.573L7.5 18" transform="translate(-6.793 -17.293)" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round"/>
    </g>
</svg>

            </button>
        {else}
            <a href="{if $lang == $lang}{$urlDefault}{else}{$url{$idm|upper}}{/if}" id="dropdownMenu1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img height="24" width="24" src="/media/images/website/{$url_flags}/{$lang}.svg" alt="{$languages_names[{$lang}]}">
                <svg class="ms-2" xmlns="http://www.w3.org/2000/svg" width="6.561" height="3.78" viewBox="0 0 6.561 3.78">
    <g data-name="Icon feather-arrow-down">
        <path data-name="Trazado 310" d="m12.646 18-2.573 2.573L7.5 18" transform="translate(-6.793 -17.293)" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round"/>
    </g>
</svg>

                {* <span>{$languages_names[{$lang}]}</span> *}
            </a>
        {/if}
        <ul class="dropdown-menu animated fadeIn" aria-labelledby="dropdownMenu1">

            {foreach from=$languages item=idm}

                {if $idm != $lang }
                <li class="dropdown-item">

                     <a href="{if $idm == $lang}{$urlDefault}{else}{if $seccion != ''}{$url{$idm|upper}}{else}{$base_url}/{$idm}/{/if}{/if}">
                        <img height="24" width="24" src="/media/images/website/{$url_flags}/{$idm}.svg" alt="{$languages_names[{$idm}]}">
                        <span>{$languages_names[{$idm}]}</span>
                    </a>
                </li>
                {/if}
            {/foreach}
        </ul>
    </div>
{/if}

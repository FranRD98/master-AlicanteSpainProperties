
<h3 class="main-title subtitle">{$lng_descargas}</h3>

{section name=vid loop=$files}
    {if $files[vid].file_fil != ''}
        {if preg_match pattern="https?" subject=$files[vid].file_fil}
            <a href="{$files[vid].file_fil}" target="_blank" class="btn btn-primary mb-3 px-5">
                {getDownloadName($files[vid].file_fil)}
            </a>
        {else}
            <a href="/media/files/properties/{$files[vid].file_fil}" target="_blank" class="btn btn-primary mb-3 px-5">
                {if $files[vid].name != ''}
                    {$files[vid].name}
                {else}
                    {$lng_descargar}
                {/if}
            </a>
        {/if}
    {/if}
{/section}
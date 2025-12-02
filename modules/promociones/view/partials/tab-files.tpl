
<h3 class="main-title subtitle">{$lng_descargas}</h3>

{section name=vid loop=$files}
    {if $files[vid].file_fil != ''}
        <a href="/media/files/news/{$files[vid].file_fil}" target="_blank" class="btn btn-primary mb-3">
            {if $files[vid].name != ''}
                {$files[vid].name}
            {else}
                {$lng_descargar}
            {/if}
        </a>
    {/if}
{/section}
<h3 class="main-title subtitle">{$lng_vista_360}</h3>

<div class="row">
    {section name=vid loop=$view360}
        {if $view360[vid].video_360 != ''}
            <div class="col-md-12{if !$smarty.section.vid.last} mb-3{/if}">
                <div class="embed-responsive embed-responsive-16by9">
                    {$view360[vid].video_360|replace:'\"':''}
                </div>
            </div>
        {/if}
        {if ($smarty.section.vid.index + 1) % 2 == 0 }</div><div class="row">{/if}
    {/section}
</div>
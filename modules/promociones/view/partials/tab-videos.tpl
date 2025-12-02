
<h3 class="main-title subtitle">{$lng_videos}</h3>

<div class="row">
    {section name=vid loop=$videos}
        {if $videos[vid].video_vid != ''}
            <div class="col-md-12{if !$smarty.section.vid.last} mb-3{/if}">
                <div class="embed-responsive embed-responsive-16by9">
                    {$videos[vid].video_vid|replace:'\"':''}
                </div>
            </div>
        {/if}
        {if ($smarty.section.vid.index + 1) % 2 == 0 }</div><div class="row">{/if}
    {/section}
</div>
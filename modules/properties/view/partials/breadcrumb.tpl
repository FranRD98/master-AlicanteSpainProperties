<ol class="breadcrumb p-2">
    <li class="breadcrumb-item"><a href="{$urlStart}"><i class="fa fa-home"></i></a></li>

    {if $breadcrumb['country'] != ""}
    	<li class="breadcrumb-item">
    		{foreach from=$breadcrumb["country"] item=country key=id_country name=bcnt}
				{if !$smarty.foreach.bcnt.first} / {/if}
				<a href="{$urlStart}{$url_properties}/?locun%5B%5D={$id_country}">{$country}</a>
			{/foreach}
		</li>
	{/if}

    {if $breadcrumb['province'] != ""}
    	<li class="breadcrumb-item">
    		{foreach from=$breadcrumb["province"] item=province key=id_province name=bprv}
				{if !$smarty.foreach.bprv.first} / {/if}
				<a href="{$urlStart}{$url_properties}/?lopr%5B%5D={$id_province}">{$province}</a>
			{/foreach}
		</li>
	{/if}

	{if $breadcrumb['area'] != ""}
		<li class="breadcrumb-item">
    		{foreach from=$breadcrumb["area"] item=area key=id_area name=bare}
				{if !$smarty.foreach.bare.first} / {/if}
				<a href="{$urlStart}{$url_properties}/?loct%5B%5D={$id_area}">{$area}</a>
			{/foreach}
		</li>
	{/if}

    {if $breadcrumb['town'] != ""}
		{foreach from=$breadcrumb["town"] item=town key=id_town name=btow}
			{if !$smarty.foreach.btow.first} / {/if}
    		<li class="breadcrumb-item"><a href="{$urlStart}{$url_properties}/?lozn%5B%5D={$id_town}">{$town}</a></li>
		{/foreach}
    {/if}

	{if $breadcrumb['type'] != ""}
    	<li class="breadcrumb-item">
			{section name=btyp loop=$breadcrumb['type']}
				{if !$smarty.section.btyp.first} / {/if}
	            <a href="{$urlStart}{$url_properties}/?tp%5B%5D={$breadcrumb['type'][btyp].id_typ}">{$breadcrumb['type'][btyp].type}</a>
	        {/section}
    	</li>
    {/if}

    {if $breadcrumb['sale'] != ""}
        <li class="breadcrumb-item">
            {section name=sts loop=$breadcrumb['sale']}
                {if !$smarty.section.sts.first} / {/if}
                <a href="{$urlStart}{$url_properties}/?st%5B%5D={$breadcrumb['sale'][sts].id_sta}">{$breadcrumb['sale'][sts].sale}</a>
            {/section}
        </li>
    {/if}

    {if $breadcrumb['country'] == "" && $breadcrumb['province'] == "" && $breadcrumb['area'] == "" && $breadcrumb['town'] == ""}
		<li class="breadcrumb-item active">{$lng_propiedades}</li>
    {/if}
</ol>
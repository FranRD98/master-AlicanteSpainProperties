
<h3 class="main-title subtitle">{$lng_precios_mensuales}</h3>

<ul class="list-group">
    
    {foreach from=$nombreMeses item=mes key=k}
        {assign var="i" value=$k+1}
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <b>{$mes}</b> 
            <span class="badge bg-primary badge-pill">{$property[0]["precio_`$i`_prop"]|number_format:0:",":"."} €</span>
        </li>
    {/foreach}
    {*
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <b>{assign var="timestamp" value={getTimestamp month=1 day=10}}{$timestamp|mes}</b> 
        <span class="badge bg-primary badge-pill">{$property[0].precio_1_prop|number_format:0:",":"."} €</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <b>{assign var="timestamp" value={getTimestamp month=2 day=10}}{$timestamp|mes}</b> 
        <span class="badge bg-primary badge-pill">{$property[0].precio_2_prop|number_format:0:",":"."} €</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <b>{assign var="timestamp" value={getTimestamp month=3 day=10}}{$timestamp|mes}</b> 
        <span class="badge bg-primary badge-pill">{$property[0].precio_3_prop|number_format:0:",":"."} €</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <b>{assign var="timestamp" value={getTimestamp month=4 day=10}}{$timestamp|mes}</b> 
        <span class="badge bg-primary badge-pill">{$property[0].precio_4_prop|number_format:0:",":"."} €</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <b>{assign var="timestamp" value={getTimestamp month=5 day=10}}{$timestamp|mes}</b> 
        <span class="badge bg-primary badge-pill">{$property[0].precio_5_prop|number_format:0:",":"."} €</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <b>{assign var="timestamp" value={getTimestamp month=6 day=10}}{$timestamp|mes}</b> 
        <span class="badge bg-primary badge-pill">{$property[0].precio_6_prop|number_format:0:",":"."} €</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <b>{assign var="timestamp" value={getTimestamp month=7 day=10}}{$timestamp|mes}</b> 
        <span class="badge bg-primary badge-pill">{$property[0].precio_7_prop|number_format:0:",":"."} €</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <b>{assign var="timestamp" value={getTimestamp month=8 day=10}}{$timestamp|mes}</b> 
        <span class="badge bg-primary badge-pill">{$property[0].precio_8_prop|number_format:0:",":"."} €</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <b>{assign var="timestamp" value={getTimestamp month=9 day=10}}{$timestamp|mes}</b> 
        <span class="badge bg-primary badge-pill">{$property[0].precio_9_prop|number_format:0:",":"."} €</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <b>{assign var="timestamp" value={getTimestamp month=19 day=10}}{$timestamp|mes}</b> 
        <span class="badge bg-primary badge-pill">{$property[0].precio_10_prop|number_format:0:",":"."} €</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <b>{assign var="timestamp" value={getTimestamp month=11 day=10}}{$timestamp|mes}</b> 
        <span class="badge bg-primary badge-pill">{$property[0].precio_11_prop|number_format:0:",":"."} €</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <b>{assign var="timestamp" value={getTimestamp month=12 day=10}}{$timestamp|mes}</b> 
        <span class="badge bg-primary badge-pill">{$property[0].precio_12_prop|number_format:0:",":"."} €</span>
    </li>
    *}
</ul>

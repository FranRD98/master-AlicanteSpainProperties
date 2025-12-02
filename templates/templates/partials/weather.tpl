<div class="weather">
    {section name=wt loop=$weather}
        <img src="/media/images/weather/{$weather[wt][0]}.png" alt="{$weather[wt][1]}">
        <b>{$weather[wt][2]}<sup>º</sup></b>
        <span class="name">{$weather[wt][1]}</span>
        {* <span class="pronostico"><span class="max">{$weather[wt][3]}<sup>º</sup></span> <span class="min">{$weather[wt][4]}<sup>º</sup></span></span> *}
    {/section}
</div>
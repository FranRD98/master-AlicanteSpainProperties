{if $property[0].titulo == ''}
    <h1 class="main-title">
        <span class="text-muted">
            <span>{$property[0].area}</span> · <span> {$property[0].town}</span> 
        </span>
        
         <small>
            <span>{$property[0].type}</span> ·
            <span>{$property[0].sale}</span>
         </small>
    </h1>
{else}
    <h2 class="main-title">

        <span class="text-muted">
            <span>{$property[0].area}</span> · <span> {$property[0].town}</span>
         </span>


         <small>
        <span>{$property[0].type}</span> ·
        <span>{$property[0].sale}</span>
         </small>
    </h2>
{/if}


       <div class="iconos">

            <ul>
                {if {$property[0].m2_prop|number_format:0:",":"."} > 0}
                    <li>
                        <img src="/media/images/website/properties/house.svg">
                        <span> {$property[0].m2_prop|number_format:0:",":"."}m<sup>2</sup></span>
                    </li>
                {/if}
                {if {$property[0].m2p_prop|number_format:0:",":"."} > 0}
                    <li>
                        <img src="/media/images/website/properties/plano.svg">
                        <span class="m2p">{$property[0].m2p_prop|number_format:0:",":"."}m<sup>2</sup></span>
                    </li>
                {/if}
                {if {$property[0].habitaciones_prop|number_format:0:",":"."} > 0}
                    <li>
                        <img src="/media/images/website/properties/bed.svg"> 
                        <span class="beds">{$property[0].habitaciones_prop|number_format:0:",":"."}</span>
                    </li>
                {/if}
                {if {$property[0].aseos_prop|number_format:0:",":"."} > 0}
                    <li>
                        <img src="/media/images/website/properties/bath.svg">
                        <span class="baths">{$property[0].aseos_prop|number_format:0:",":"."}</span>
                    </li>
                {/if}
                {if {$property[0].aseos2_prop|number_format:0:",":"."} > 0}
                    <li>
                        <img src="/media/images/website/icon-aseo.png" alt="{$lng_aseos}" />
                        <span class="baths">{$property[0].aseos2_prop|number_format:0:",":"."}</span>
                    </li>
                {/if}
                {if $property[0].piscina_prop != ''}
                    <li>
                        <img src="/media/images/website/properties/pool.svg">
                         <span>{$property[0].piscina_prop}</span>
                    </li>
                {/if}
                {if $property[0].parking_prop != ''}
                    <li>
                         <img src="/media/images/website/properties/garaje.svg">
                         <span>{$property[0].parking_prop}</span>
                    </li>
                {/if}
            </ul>

    </div>
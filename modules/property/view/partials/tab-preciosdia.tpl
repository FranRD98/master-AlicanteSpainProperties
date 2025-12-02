
<h3 class="main-title subtitle">{$lng_precios_por_dia}</h3>


<table class="table table-striped table-bordered table-sm">
    <tbody>
        {section name=prc loop=$precios}
        <tr>
            <td>
                <b>
                    <i class="fal fa-calendar-alt"></i> {$precios[prc].from_prc|date_format:"%e  %B  %Y"|capitalize}
                    <i class="far fa-long-arrow-alt-right"></i>
                    <i class="fal fa-calendar-alt"></i> {$precios[prc].to_prc|date_format:"%e  %B  %Y"|capitalize}
                </b>
            </td>
            <td>{$precios[prc].price_prc|number_format:"0":",":"."} €</td>
        </tr>
        {/section}
    </tbody>
</table>
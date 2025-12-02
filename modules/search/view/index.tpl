{include file="header.tpl"}

<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-content">
                    <h1 class="main-title">{$pages[0].titulo}</h1>
                    {$pagetext}
                    <form action="{$urlStart}{$url_properties}/" method="get" id="searchHomeForm"  role="form" class="validate buscador_avanzado">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <div class="form-group mb-10">
                                            <input type="text" name="ter" id="ter" class="form-control" value="{$smarty.get.ter|default:''}" placeholder="placeholder="{$lng_buscar} {$lng_propiedades}"">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group mb-2 d-grid">
                                            <button type="submit" class="btn btn-primary">Buscar propiedades</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        {* @group SEC - REFERENCIA *}
                                        <div class="form-group mb-3">
                                            <label for="rf">{$lng_referencia}:</label>
                                            <input type="text" name="rf" id="rf" class="form-control" value="{if isset($smarty.get.rf) }{$smarty.get.rf}{/if}" placeholder="{$lng_reference}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        {* @group SEC - ESTADO *}
                                        <div class="form-group mb-3">
                                            <label for="st">{$lng_estado}:</label>
                                            <select name="st[]" id="st" class="form-control">
                                                <option value="">{$lng_todos}</option>
                                                {section name=st loop=$status}
                                                    {if $status[st].visible}
                                                        <option value="{$status[st].id}" {if $smarty.get.st == $status[st].id}selected{/if}>{$status[st].sale}</option>
                                                    {/if}
                                                {/section}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        {* @group SEC - TIPO *}
                                        <div class="form-group mb-3">
                                            <label for="tp">{$lng_tipo}:</label>
                                                <select name="tp[]" id="tp" multiple class="form-control select2">
                                                {* <option value="" {if isset($smarty.get.tp) && $smarty.get.tp == ''}selected{/if}>{$lng_todos}</option> *}
                                                {section name=tp loop=$type}
                                                    {if {$type[tp].type|utf8_decode} != 'Array'}
                                                        <option value="{$type[tp].id_type}" {if isset($smarty.get.tp) && $smarty.get.tp == $type[tp].id_type}selected{/if}>{$type[tp].type}</option>
                                                    {/if}
                                                {/section}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-4">
                                        {* @group SEC - PROVINCIA *}
                                        <div class="form-group mb-3">
                                            <label for="lopr">{$lng_provincia}:</label>
                                            <select name="lopr[]" id="lopr" multiple class="form-control select2">
                                                {* <option value="">{$lng_todos}</option> *}
                                                {section name=lz loop=$province}
                                                    <option value="{$province[lz].id}" {if isset($smarty.get.lopr) && $smarty.get.lopr == $province[lz].id}selected{/if}>{$province[lz].province}</option>
                                                {/section}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        {* @group SEC - CIUDAD *}
                                        <div class="form-group mb-3">
                                            <label for="loct">{$lng_ciudad}:</label>
                                                <select name="loct[]" id="loct" multiple class="form-control select2">
                                                {* <option value="">{$lng_todos}</option> *}
                                                {section name=lz loop=$city}
                                                    <option value="{$city[lz].id}" {if isset($smarty.get.loct) && $smarty.get.loct == $city[lz].id}selected{/if}>{$city[lz].area}</option>
                                                {/section}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        {* @group SEC - ZONA *}
                                        <div class="form-group mb-3">
                                            <label for="lozn">{$lng_zona}:</label>
                                            <select name="lozn[]" id="lozn" multiple class="form-control select2">
                                                {* <option value="">{$lng_todos}</option> *}
                                                {section name=lz loop=$localizacion}
                                                    <option value="{$localizacion[lz].id}" {if isset($smarty.get.lozn) && $smarty.get.lozn == $localizacion[lz].id}selected{/if}>{$localizacion[lz].town}</option>
                                                {/section}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-4">

                                {* @group SEC - PRECIO DESDE *}
                                <div class="form-group mb-3">
                                    <label for="prds">{$lng_precio_desde}</label>
                                    <select name="prds" id="prds" class="form-control prds">
                                        <option value="" {if isset($smarty.get.prds) && $smarty.get.prds == ''}selected{/if}>{$lng_todos}</option>
                                        <option value="200" {if isset($smarty.get.prds) && $smarty.get.prds == 200}selected{/if}>200 €</option>
                                        <option value="400" {if isset($smarty.get.prds) && $smarty.get.prds == 400}selected{/if}>400 €</option>
                                        <option value="600" {if isset($smarty.get.prds) && $smarty.get.prds == 600}selected{/if}>600 €</option>
                                        <option value="800" {if isset($smarty.get.prds) && $smarty.get.prds == 800}selected{/if}>800 €</option>
                                        <option value="1000" {if isset($smarty.get.prds) && $smarty.get.prds == 1000}selected{/if}>1.000 €</option>
                                        <option value="1200" {if isset($smarty.get.prds) && $smarty.get.prds == 1200}selected{/if}>1.200 €</option>
                                        <option value="1400" {if isset($smarty.get.prds) && $smarty.get.prds == 1400}selected{/if}>1.400 €</option>
                                        <option value="1600" {if isset($smarty.get.prds) && $smarty.get.prds == 1600}selected{/if}>1.600 €</option>
                                        <option value="1800" {if isset($smarty.get.prds) && $smarty.get.prds == 1800}selected{/if}>1.800 €</option>
                                        <option value="2000" {if isset($smarty.get.prds) && $smarty.get.prds == 2000}selected{/if}>2.000 €</option>
                                        <option value="3000" {if isset($smarty.get.prds) && $smarty.get.prds == 3000}selected{/if}>+3.000 €</option>
                                        <option value="50000" {if isset($smarty.get.prds) && $smarty.get.prds == 50000}selected{/if}>50.000 €</option>
                                        <option value="100000" {if isset($smarty.get.prds) && $smarty.get.prds == '100000'}selected{/if}>100.000€</option>
                                        <option value="150000" {if isset($smarty.get.prds) && $smarty.get.prds == 150000}selected{/if}>150.000 €</option>
                                        <option value="200000" {if isset($smarty.get.prds) && $smarty.get.prds == 200000}selected{/if}>200.000 €</option>
                                        <option value="250000" {if isset($smarty.get.prds) && $smarty.get.prds == 250000}selected{/if}>250.000 €</option>
                                        <option value="300000" {if isset($smarty.get.prds) && $smarty.get.prds == 300000}selected{/if}>300.000 €</option>
                                        <option value="350000" {if isset($smarty.get.prds) && $smarty.get.prds == 350000}selected{/if}>350.000 €</option>
                                        <option value="400000" {if isset($smarty.get.prds) && $smarty.get.prds == 400000}selected{/if}>400.000 €</option>
                                        <option value="450000" {if isset($smarty.get.prds) && $smarty.get.prds == 450000}selected{/if}>450.000 €</option>
                                        <option value="500000" {if isset($smarty.get.prds) && $smarty.get.prds == 500000}selected{/if}>500.000 €</option>
                                        <option value="550000" {if isset($smarty.get.prds) && $smarty.get.prds == 550000}selected{/if}>550.000 €</option>
                                        <option value="600000" {if isset($smarty.get.prds) && $smarty.get.prds == 600000}selected{/if}>600.000 €</option>
                                        <option value="650000" {if isset($smarty.get.prds) && $smarty.get.prds == 650000}selected{/if}>650.000 €</option>
                                        <option value="700000" {if isset($smarty.get.prds) && $smarty.get.prds == 700000}selected{/if}>700.000 €</option>
                                        <option value="1000000" {if isset($smarty.get.prds) && $smarty.get.prds == 1000000}selected{/if}>+1.000.000 €</option>
                                    </select>
                                </div>
                                {* @group SEC - PRECIO HASTA *}
                                <div class="form-group mb-3">
                                    <label for="prhs">{$lng_precio_hasta}</label>
                                    <select name="prhs" id="prhs" class="form-control prhs">
                                        <option value=""        {if isset($smarty.get.prhs) && $smarty.get.prhs == ""}selected{/if}>{$lng_todos}</option>
                                        <option value="200"     {if isset($smarty.get.prhs) && $smarty.get.prhs == 200}selected{/if}>200 €</option>
                                        <option value="400"     {if isset($smarty.get.prhs) && $smarty.get.prhs == 400}selected{/if}>400 €</option>
                                        <option value="600"     {if isset($smarty.get.prhs) && $smarty.get.prhs == 600}selected{/if}>600 €</option>
                                        <option value="800"     {if isset($smarty.get.prhs) && $smarty.get.prhs == 800}selected{/if}>800 €</option>
                                        <option value="1000"    {if isset($smarty.get.prhs) && $smarty.get.prhs == 1000}selected{/if}>1.000 €</option>
                                        <option value="1200"    {if isset($smarty.get.prhs) && $smarty.get.prhs == 1200}selected{/if}>1.200 €</option>
                                        <option value="1400"    {if isset($smarty.get.prhs) && $smarty.get.prhs == 1400}selected{/if}>1.400 €</option>
                                        <option value="1600"    {if isset($smarty.get.prhs) && $smarty.get.prhs == 1600}selected{/if}>1.600 €</option>
                                        <option value="1800"    {if isset($smarty.get.prhs) && $smarty.get.prhs == 1800}selected{/if}>1.800 €</option>
                                        <option value="2000"    {if isset($smarty.get.prhs) && $smarty.get.prhs == 2000}selected{/if}>2.000 €</option>
                                        <option value="3000"    {if isset($smarty.get.prhs) && $smarty.get.prhs == 3000}selected{/if}>+3.000 €</option>
                                        <option value="50000"   {if isset($smarty.get.prhs) && $smarty.get.prhs == 50000}selected{/if}>50.000 €</option>
                                        <option value="100000"  {if isset($smarty.get.prhs) && $smarty.get.prhs == '100000'}selected{/if}>100.000€</option>
                                        <option value="150000"  {if isset($smarty.get.prhs) && $smarty.get.prhs == 150000}selected{/if}>150.000 €</option>
                                        <option value="200000"  {if isset($smarty.get.prhs) && $smarty.get.prhs == 200000}selected{/if}>200.000 €</option>
                                        <option value="250000"  {if isset($smarty.get.prhs) && $smarty.get.prhs == 250000}selected{/if}>250.000 €</option>
                                        <option value="300000"  {if isset($smarty.get.prhs) && $smarty.get.prhs == 300000}selected{/if}>300.000 €</option>
                                        <option value="350000"  {if isset($smarty.get.prhs) && $smarty.get.prhs == 350000}selected{/if}>350.000 €</option>
                                        <option value="400000"  {if isset($smarty.get.prhs) && $smarty.get.prhs == 400000}selected{/if}>400.000 €</option>
                                        <option value="450000"  {if isset($smarty.get.prhs) && $smarty.get.prhs == 450000}selected{/if}>450.000 €</option>
                                        <option value="500000"  {if isset($smarty.get.prhs) && $smarty.get.prhs == 500000}selected{/if}>500.000 €</option>
                                        <option value="550000"  {if isset($smarty.get.prhs) && $smarty.get.prhs == 550000}selected{/if}>550.000 €</option>
                                        <option value="600000"  {if isset($smarty.get.prhs) && $smarty.get.prhs == 600000}selected{/if}>600.000 €</option>
                                        <option value="650000"  {if isset($smarty.get.prhs) && $smarty.get.prhs == 650000}selected{/if}>650.000 €</option>
                                        <option value="700000"  {if isset($smarty.get.prhs) && $smarty.get.prhs == 700000}selected{/if}>700.000 €</option>
                                        <option value="1000000" {if isset($smarty.get.prhs) && $smarty.get.prhs == 1000000}selected{/if}>+1.000.000 €</option>
                                    </select>
                                </div>
                                {* @group SEC - NUEVO *}
                                <div class="form-group mb-3">
                                    <label for="nw">{$lng_nuevo}</label>
                                    <select name="nw" id="nw" class="form-control">
                                        <option value="" selected>{$lng_todos}</option>
                                        <option value="1">{$lng_si}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-4">
                                {* @group SEC - HABITACIONES *}
                                <div class="mb-3">
                                    <label for="bd">{$lng_habitaciones}:</label>
                                    <select name="bd" id="bd" class="form-control">
                                        <option value="" {if isset($smarty.get.bd) && $smarty.get.bd == ''}selected{/if}>{$lng_todos}</option>
                                        {for $i=1 to 5}
                                            <option value="{$i}" {if isset($smarty.get.bd) &&  $smarty.get.bd == $i}selected{/if}>{if $i == 5}+{/if}{$i}</option>
                                        {/for}
                                    </select>
                                </div>
                                {* @group SEC - BAÑOS *}
                                <div class="form-group mb-3">
                                    <label for="bt">{$lng_banos}:</label>
                                    <select name="bt" id="bt" class="form-control">
                                        <option value="" {if isset($smarty.get.bt) && $smarty.get.bt == ''}selected{/if}>{$lng_todos}</option>
                                        {for $i=1 to 5}
                                            <option value="{$i}" {if $smarty.get.bt == $i}selected{/if}>{if $i == 5}+{/if}{$i}</option>
                                        {/for}
                                    </select>
                                </div>
                                {* @group SEC - PISCINA *}
                                <div class="form-group mb-3">
                                    <label for="po">{$lng_piscina}</label>
                                    <select name="po" id="po" class="form-control">
                                        <option value="" selected>{$lng_todos}</option>
                                        <option value="0">{$lng_no}</option>
                                        <option value="1">{$lng_si}</option>
                                    </select>
                                </div>
                                {* @group SEC - PAÍS *}
                                {* <div class="mb-3">
                                    <label for="locun">{$lng_pais}:</label>
                                    <select name="locun[]" id="locun" class="form-control">
                                        <option value="">{$lng_todos}</option>
                                        {section name=lz loop=$country}
                                            <option value="{$country[lz].id}" {if $smarty.get.locun == $country[lz].id}selected{/if}>{$country[lz].country}</option>
                                        {/section}
                                    </select>
                                </div> *}
                            </div>
                            <div class="col-lg-4">
                                {* @group SEC - M2 *}
                                <div class="form-group mb-3">
                                    <label for="m2ut">M<sup>2</sup> {$lng_construidos}:</label>
                                    <select name="m2ut" id="m2ut" class="form-control">
                                        <option value="0" {if isset($smarty.get.m2ut) && $smarty.get.m2ut == 0}selected{/if}>{$lng_todos}</option>
                                        <option value="1" {if isset($smarty.get.m2ut) && $smarty.get.m2ut == 1}selected{/if}>0-90 m<sup>2</sup></option>
                                        <option value="2" {if isset($smarty.get.m2ut) && $smarty.get.m2ut == 2}selected{/if}>90-120 m<sup>2</sup></option>
                                        <option value="3" {if isset($smarty.get.m2ut) && $smarty.get.m2ut == 3}selected{/if}>120-200 m<sup>2</sup></option>
                                        <option value="4" {if isset($smarty.get.m2ut) && $smarty.get.m2ut == 4}selected{/if}>+200 m<sup>2</sup></option>
                                    </select>
                                </div>
                                {* @group SEC - M2 PARCELA *}
                                <div class="form-group mb-3">
                                    <label for="m2pl">M<sup>2</sup> {$lng_parcela}:</label>
                                    <select name="m2pl" id="m2pl" class="form-control">
                                        <option value="0" {if isset($smarty.get.m2pl) && $smarty.get.m2pl == 0}selected{/if}>{$lng_todos}</option>
                                        <option value="1" {if isset($smarty.get.m2pl) && $smarty.get.m2pl == 1}selected{/if}>0-1.000 m<sup>2</sup></option>
                                        <option value="2" {if isset($smarty.get.m2pl) && $smarty.get.m2pl == 2}selected{/if}>1.000-2.000 m<sup>2</sup></option>
                                        <option value="3" {if isset($smarty.get.m2pl) && $smarty.get.m2pl == 3}selected{/if}>2.000-5.000 m<sup>2</sup></option>
                                        <option value="4" {if isset($smarty.get.m2pl) && $smarty.get.m2pl == 4}selected{/if}>5.000-10.000 m<sup>2</sup></option>
                                        <option value="5" {if isset($smarty.get.m2pl) && $smarty.get.m2pl == 5}selected{/if}>10.000-20.000 m<sup>2</sup></option>
                                        <option value="6" {if isset($smarty.get.m2pl) && $smarty.get.m2pl == 6}selected{/if}>+20.000 m<sup>2</sup></option>
                                    </select>
                                </div>
                                {* @group SEC - ORIENTACIÓN *}
                                <div class="form-group mb-3">
                                    <label for="or">{$lng_orientacion}:</label>
                                    <select name="or" id="or" class="form-control">
                                        <option value="">{$lng_todos}</option>
                                        <option value="o-n">{$lng_o_n}</option>
                                        <option value="o-ne">{$lng_o_ne}</option>
                                        <option value="o-e">{$lng_o_e}</option>
                                        <option value="o-se">{$lng_o_se}</option>
                                        <option value="o-s">{$lng_o_s}</option>
                                        <option value="o-so">{$lng_o_so}</option>
                                        <option value="o-o">{$lng_o_o}</option>
                                        <option value="o-no">{$lng_o_no}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        {* @group SEC - BOTONERA *}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <input type="hidden" name="langx" id="langx" value="{$lang}">
                                    <input type="hidden" name="date" id="date" value="{$smarty.now}" />
                                    <hr>
                                    <input type="submit" class="btn btn-primary btn-sm float-end" value="{$lng_buscar_propiedades}">
                                    <div class="result">{$lng_se_han_encontrado} <span></span> {$lng_propiedades}</div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{include file="footer.tpl"}

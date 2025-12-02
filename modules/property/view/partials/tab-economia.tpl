<div class="modal" tabindex="-1" role="dialog" id="economyModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="row py-4">
                <div class="col-xl-10 offset-xl-1">
                     <div class="modal-header bg-white border-0 px-0">
                        <h3 class="subtitle my-2">{$lng_economia}</h3>
                        <a class="close btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fal fa-times"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="p-4 p-xl-0">
                <div class="row">
                    <div class="col-12 col-xl-10 offset-xl-1">
                        <p class="mb-3">{$lng_texto_conversor_divisas}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 offset-md-0 col-xl-5 offset-xl-1">
                        <form name="formCalc" method="post" id="formCalc" class="prop-contact validate clearfix mb-4 mb-xl-5">
                            <h3 class="subtitle my-3">{$lng_calcular_hipoteca}</h3>
                            <div class="mb-3">
                                <label for="muamount">{$lng_cantidad}:</label>
                                <input id="muamount" size="12" type="text" name="muamount" value="{$property[0].precio}" class="form-control required">
                            </div>
                            <div class="mb-3">
                                <label for="muinterest">{$lng_interes}:</label>
                                <input id="muinterest" size="5" type="text" name="muinterest" value="3.5" class="form-control required">
                            </div>
                            <div class="mb-3">
                                <label for="muterm">{$lng_duracion}:</label>
                                <div class="relative">
                                    <select name="muterm" id="muterm" class="form-control required">
                                        <option value="1">1 {$lng_ano}</option>
                                        <option value="2">2 {$lng_anos}</option>
                                        <option value="3">3 {$lng_anos}</option>
                                        <option value="4">4 {$lng_anos}</option>
                                        <option value="5">5 {$lng_anos}</option>
                                        <option value="6">6 {$lng_anos}</option>
                                        <option value="7">7 {$lng_anos}</option>
                                        <option value="8">8 {$lng_anos}</option>
                                        <option value="9">9 {$lng_anos}</option>
                                        <option value="10">10 {$lng_anos}</option>
                                        <option value="11">11 {$lng_anos}</option>
                                        <option value="12">12 {$lng_anos}</option>
                                        <option value="13">13 {$lng_anos}</option>
                                        <option value="14">14 {$lng_anos}</option>
                                        <option value="15">15 {$lng_anos}</option>
                                        <option value="16">16 {$lng_anos}</option>
                                        <option value="17">17 {$lng_anos}</option>
                                        <option value="18">18 {$lng_anos}</option>
                                        <option value="19">19 {$lng_anos}</option>
                                        <option value="20" selected="">20 {$lng_anos}</option>
                                        <option value="21">21 {$lng_anos}</option>
                                        <option value="22">22 {$lng_anos}</option>
                                        <option value="23">23 {$lng_anos}</option>
                                        <option value="24">24 {$lng_anos}</option>
                                        <option value="25">25 {$lng_anos}</option>
                                        <option value="26">26 {$lng_anos}</option>
                                        <option value="27">27 {$lng_anos}</option>
                                        <option value="28">28 {$lng_anos}</option>
                                        <option value="29">29 {$lng_anos}</option>
                                        <option value="30">30 {$lng_anos}</option>
                                    </select>
                                </div>
                            </div>
                            <button type="button" name="calc" id="calc" class="btn btn-primary btn-block btn-black-all btn-form" style="margin-top: 20px;">{$lng_calcular}</button>
                            <!-- <div class="mb-3">
                            <label for="txtinterest">{$lng_intereses}:</label>
                            <input id="txtinterest" size="12" type="text" name="txtinterest" class="form-control">
                            </div> -->
                            <div class="mb-3 pagos-mensuales">
                                <label for="txtrepay">{$lng_sus_pagos_mensuales_seran}:</label>
                                <input id="txtrepay" size="12" type="text" name="txtrepay" class="form-control">
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 col-xl-5">
                        <div class="ps-5">
                            <h3 class="subtitle my-3">{$lng_cambio_de_divisas}</h3>
                            {$exchange}
                            {if $property[0].suma_prop != ''}
                                <h2>Suma/IBI</h2>
                                {$property[0].suma_prop} €
                            {/if}
                            {if $property[0].gastos_prop != ''}
                                <h2>{$lng_gastos}</h2>
                                {$property[0].gastos_prop} €
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
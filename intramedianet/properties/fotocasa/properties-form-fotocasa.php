<div class="row">

    <div class="col-md-12">
        <div class="form-check form-switch form-switch-md pt-2" dir="ltr" <?php if ($expFotoCasa == 0) { ?>style="opacity: .5;"<?php } ?>>
            <input type="checkbox" name="export_fotocasa_prop" id="export_fotocasa_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['export_fotocasa_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_fotocasa_prop']),"1"))) {echo "checked";} ?> <?php if ($expFotoCasa == 0) { ?>disabled<?php } ?>>
            <label class="form-check-label" for="export_fotocasa_prop"><?php __('Exportar a Fotocasa'); ?></label>
            <?php echo $tNGs->displayFieldError("properties_properties", "export_fotocasa_prop"); ?>
        </div>
        <?php if ($expFotoCasa == 1) { ?>
            <div class="checkbox">
                <b><?php __('Campos obligatorios para la exportación a Fotocasa'); ?>:</b> <small class="text-muted">(<?php __('Hacer click en el botón "ACTUALIZAR Y SEGUIR EDITANDO" para ver la información actualizada'); ?>)</small> <br>
                <?php if ($row_rsproperties_properties['referencia_prop']) { ?>
                    <span class="text-success">
                        <i class="fa-regular fa-check"></i>
                <?php } else { ?>
                    <span class="text-danger">
                        <i class="fa-regular fa-times"></i>
                <?php } ?>
                <?php __('Referencia'); ?></span> |

                <?php if ($row_rsproperties_properties['localidad_prop']) { ?>
                    <span class="text-success">
                        <i class="fa-regular fa-check"></i>
                <?php } else { ?>
                    <span class="text-danger">
                        <i class="fa-regular fa-times"></i>
                <?php } ?>
                <?php __('Localización'); ?></span> |

                <?php if ($row_rsproperties_properties['lat_long_gp_prop']) { ?>
                    <span class="text-success">
                        <i class="fa-regular fa-check"></i>
                <?php } else { ?>
                    <span class="text-danger">
                        <i class="fa-regular fa-times"></i>
                <?php } ?>
                <?php __('Latitud y longitud'); ?></span> |

                <?php if ($row_rsproperties_properties['preci_reducidoo_prop']) { ?>
                    <span class="text-success">
                        <i class="fa-regular fa-check"></i>
                <?php } else { ?>
                    <span class="text-danger">
                        <i class="fa-regular fa-times"></i>
                <?php } ?>
                <?php __('Precio'); ?></span> |

                <?php if ($row_rsproperties_properties['m2_prop']) { ?>
                    <span class="text-success">
                        <i class="fa-regular fa-check"></i>
                <?php } else { ?>
                    <span class="text-danger">
                        <i class="fa-regular fa-times"></i>
                <?php } ?>
                <?php if ($lang_adm == 'es') { ?><?php __('M2'); ?> <?php __('Útiles'); ?><?php } else { ?><?php __('Útiles'); ?> <?php __('M2'); ?><?php } ?></span>
            </div>
        <?php } ?>
    </div>
</div>
<?php if ($expFotoCasa == 1) { ?>
<?php
    global $row_rsproperties_properties;
    $selectedFotocasaFields = json_decode($row_rsproperties_properties['export_fotocasa_fields_prop'], true);
    $fotocasaFields = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/fotocasaFields.php');

    $fotocasaTypes = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/DIC/DIC_BuildingType.php');
    $fotocasaSubTypes = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/DIC/DIC_BuildingSubType.php');
    $fotocasaStatus = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/DIC/DIC_PropertyStatus.php');
    $fotocasaTransactionType = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/DIC/DIC_TransactionType.php');
    $fotocasaPaymentPeriodicity = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/DIC/DIC_PaymentPeriodicity.php');
    $fotocasaExpirationCause = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/DIC/DIC_ExpirationCause.php');
    $fotocasaPromotionType = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/fotocasa/DIC/DIC_PromotionType.php');
?>
<div id="basicFotocasa" <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_fotocasa_prop']),"0"))) { ?>style="display: none;"<?php } ?> >
    <hr>
    <div class="row">
        <div class="col-md-2">
            <div class="mb-4">
                <label for="export_fotocasa_fields_prop[TransactionTypeId]" class="form-label"><?php __('Tipo de transacción'); ?> *:</label>
                <select name="export_fotocasa_fields_prop[TransactionTypeId]" id="fotocasaTransactionTypeId" class="select2">
                    <option value="" <?php if (!(strcmp("", $selectedFotocasaFields['TransactionTypeId']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                    <?php foreach ($fotocasaTransactionType as $key => $field) { ?>
                        <option value="<?php echo $key; ?>"<?php if (!(strcmp($key, $selectedFotocasaFields['TransactionTypeId']))) {echo "selected=\"selected\"";} ?>><?php echo $field; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-2" id="fotocasaPaymentPeriodicityId"
            <?php if ( !(strcmp("", $selectedFotocasaFields['TransactionTypeId'])) || ($selectedFotocasaFields['TransactionTypeId'] == 1 || $selectedFotocasaFields['TransactionTypeId'] == 4) ) {?> style="display: none;" <?php } ?>>
            <div class="mb-4">
                <label for="export_fotocasa_fields_prop[PaymentPeriodicityId]" class="form-label"><?php __('Periocidad del Pago'); ?> *:</label>
                <select name="export_fotocasa_fields_prop[PaymentPeriodicityId]" id="fotocasa_PaymentPeriodicityId" class="select2">
                    <option value="" <?php if (!(strcmp("", $selectedFotocasaFields['PaymentPeriodicityId']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                    <?php foreach ($fotocasaPaymentPeriodicity as $key => $field) { ?>
                        <option value="<?php echo $key; ?>"<?php if (!(strcmp($key, $selectedFotocasaFields['PaymentPeriodicityId']))) {echo "selected=\"selected\"";} ?>><?php echo $field; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-4">
                <label for="export_fotocasa_fields_prop[TypeId]" class="form-label"><?php __('Tipo de Propiedad'); ?> *:</label>
                <select name="export_fotocasa_fields_prop[TypeId]" id="fotocasaTypeId" class="select2">
                    <option value="" <?php if (!(strcmp("", $selectedFotocasaFields['TypeId']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                    <?php foreach ($fotocasaTypes as $key => $field) { ?>
                        <option value="<?php echo $key; ?>"<?php if (!(strcmp($key, $selectedFotocasaFields['TypeId']))) {echo "selected=\"selected\"";} ?>><?php echo $field; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-2" id="fotocasaSubType" <?php if ( !(strcmp("", $selectedFotocasaFields['TypeId'])) ) {?> style="display: none;" <?php } ?>>
            <div class="mb-4">
                <label for="export_fotocasa_fields_prop[SubTypeId]" class="form-label"><?php __('SubTipo'); ?> (<?php __('Opcional'); ?>):</label>
                <select name="export_fotocasa_fields_prop[SubTypeId]" id="fotocasaSubTypeId" class="form-control">
                    <option value="" <?php if (!(strcmp("", $selectedFotocasaFields['SubTypeId']))) {echo "selected=\"selected\"";} ?>><?php echo __('Debe seleccionar un tipo'); ?></option>
                    <?php foreach ($fotocasaSubTypes as $key1 => $values) { ?>
                        <?php foreach ($values as $key => $field) { ?>
                            <option value="<?php echo $key; ?>"<?php if (!(strcmp($key, $selectedFotocasaFields['SubTypeId']))) {echo "selected=\"selected\"";} ?>><?php echo $field; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-4">
                <label for="export_fotocasa_fields_prop[PropertyStatusId]" class="form-label"><?php __('Estado'); ?> *:</label>
                <select name="export_fotocasa_fields_prop[PropertyStatusId]" id="fotocasaPropertyStatusId" class="select2">
                    <option value="" <?php if (!(strcmp("", $selectedFotocasaFields['PropertyStatusId']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                    <?php foreach ($fotocasaStatus as $key => $field) { ?>
                        <option value="<?php echo $key; ?>"<?php if (!(strcmp($key, $selectedFotocasaFields['PropertyStatusId']))) {echo "selected=\"selected\"";} ?>><?php echo $field; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-2" id="fotocasaExpiracion" <?php if (!(strcmp("", $selectedFotocasaFields['PropertyStatusId'])) || $selectedFotocasaFields['PropertyStatusId'] != 4) {?> style="display: none;" <?php } ?>>
            <div class="mb-4">
                <label for="export_fotocasa_fields_prop[ExpirationCauseId]" class="form-label"><?php __('Motivo de Expiración'); ?>:</label>
                <select name="export_fotocasa_fields_prop[ExpirationCauseId]" id="fotocasaExpirationCauseId" class="select2">
                    <option value="" <?php if (!(strcmp("", $selectedFotocasaFields['ExpirationCauseId']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                    <?php foreach ($fotocasaExpirationCause as $key => $field) { ?>
                        <option value="<?php echo $key; ?>"<?php if (!(strcmp($key, $selectedFotocasaFields['ExpirationCauseId']))) {echo "selected=\"selected\"";} ?>><?php echo $field; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <?php if ( isset($fotocasaDatos["promotion"]) && $fotocasaDatos["promotion"] == 1) { ?>
            <div class="col-md-2">
                <div class="mb-4">
                    <div class="form-check form-switch form-switch-md" dir="ltr">
                        <input type="checkbox" name="export_fotocasa_fields_prop[IsPromotion]" id="export_fotocasa_fields_prop[IsPromotion]" value="1" class="form-check-input" <?php if ( isset( $selectedFotocasaFields["IsPromotion"] ) && $selectedFotocasaFields["IsPromotion"] == 1 ) {echo "checked";} ?>>
                        <label class="form-check-label" for="export_fotocasa_fields_prop[IsPromotion]"><?php __('Es una Promoción'); ?></label>
                    </div>
                </div>
                <div class="mb-4" id="fotocasaPromotionType" <?php if ( !isset( $selectedFotocasaFields["IsPromotion"] ) && $selectedFotocasaFields["IsPromotion"] == 0 ) { ?>style="display:none;"<?php } ?>>
                    <label for="export_fotocasa_fields_prop[PromotionType]" class="form-label"><?php __('Tipo de Promoción'); ?>:</label>
                    <select name="export_fotocasa_fields_prop[PromotionType]" id="fotocasa_PromotionType" class="select2">
                        <option value="" <?php if (!(strcmp("", $fotocasaPromotionType['PromotionType']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($fotocasaPromotionType as $key => $field) { ?>
                            <option value="<?php echo $key; ?>"<?php if (!(strcmp($key, $selectedFotocasaFields['PromotionType']))) {echo "selected=\"selected\"";} ?>><?php echo $field; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        <?php } ?>
        <div class="col-md-2">
            <div class="">
                <div class="form-check form-switch form-switch-md" dir="ltr">
                    <input type="checkbox" name="export_fotocasa_fields_prop[IsNewConstruction]" id="export_fotocasa_fields_prop[IsNewConstruction]" value="1" class="form-check-input" <?php if ( isset( $selectedFotocasaFields["IsNewConstruction"] ) && $selectedFotocasaFields["IsNewConstruction"] == 1 ) {echo "checked";} ?>>
                    <label class="form-check-label" for="export_fotocasa_fields_prop[IsNewConstruction]"><?php __('Nueva construcción'); ?></label>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="featuresFotocasa"
<?php if (
        !(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_fotocasa_prop']),"0")) ||
        !(strcmp("", $selectedFotocasaFields['TransactionTypeId'])) ||
        !(strcmp("", $selectedFotocasaFields['TypeId'])) ||
        !(strcmp("", $selectedFotocasaFields['PropertyStatusId']))
    ) { ?>
        style="display: none;"
<?php } ?> >
    <hr>
    <p class="leadx"><b>Las siguientes son opciones específicas de Fotocasa dependiendo el tipo de propiedad. Marque las que crea conveniente:</b></p>
    <div class="row">
        <?php foreach ($fotocasaFields as $idField => $field) { ?>
            <?php
            $hideField = false;
            $dataShowType = "";
            if( isset($field["showOn"]) && $field["showOn"] != "") {
                $dataShow = "data-show='".json_encode($field["showOn"])."'";
                foreach ($field["showOn"] as $tp => $exceptionArr) {
                    if( !in_array( $selectedFotocasaFields[$tp], $exceptionArr )) {
                        $hideField = true;
                    }
                }
            }?>
            <?php if( (isset($field["show"]) && $field["show"] == 1 ) ){ ?>
                <div class="col-md-2" <?php echo $dataShow; ?> <?php if ($hideField) {?>style="display:none;"<?php } ?>>
                    <?php if( isset($field["type"]) && ($field["type"] == "text" || $field["type"] == "int")){ ?>
                        <div class="mb-4">
                            <label for="export_fotocasa_fields_prop[PropertyFeature][<?php echo $idField; ?>]" class="form-label"><?php echo $field["name"]; ?>:</label>
                            <input type="text" name="export_fotocasa_fields_prop[PropertyFeature][<?php echo $idField; ?>]" id="export_fotocasa_fields_prop[PropertyFeature][<?php echo $idField; ?>]"
                            value="<?php if (isset( $selectedFotocasaFields["PropertyFeature"][$idField] ) && $selectedFotocasaFields["PropertyFeature"][$idField] != "") { echo $selectedFotocasaFields["PropertyFeature"][$idField]; }?>"
                            maxlength="255" class="form-control">
                            <?php if( isset($field["comment"]) && $field["comment"] != "" ){ ?>
                                <small class="help-block" style="font-size: 11px;"><?php echo $field["comment"]; ?></small>
                            <?php } ?>
                        </div>
                    <?php } else if( isset($field["type"]) && $field["type"] == "bool"){ ?>
                        <div class="mb-4">
                            <div class="form-check form-switch form-switch-md" dir="ltr">
                                <input type="checkbox" name="export_fotocasa_fields_prop[PropertyFeature][<?php echo $idField; ?>]" id="fotocasa_<?php echo $idField; ?>" value="1" class="form-check-input" <?php if ( isset( $selectedFotocasaFields["PropertyFeature"][$idField] ) && $selectedFotocasaFields["PropertyFeature"][$idField] == 1 ) {echo "checked";} ?>>
                                <label class="form-check-label" for="fotocasa_<?php echo $idField; ?>"><?php echo $field["name"]; ?></label>
                            </div>
                            <?php if( isset($field["comment"]) && $field["comment"] != "" ){ ?>
                                <small class="text-muted" style="font-size: 11px;"><?php echo $field["comment"]; ?></small>
                            <?php } ?>
                        </div>
                    <?php } else if( isset($field["type"]) && $field["type"] == "list"){ ?>
                        <div class="mb-4">
                            <label for="export_fotocasa_fields_prop[PropertyFeature][<?php echo $idField; ?>]" class="form-label"><?php echo $field["name"]; ?>:</label>
                            <select name="export_fotocasa_fields_prop[PropertyFeature][<?php echo $idField; ?>]" id="export_fotocasa_fields_prop[PropertyFeature][<?php echo $idField; ?>]" class="select2">
                                <option value="" <?php if (!isset( $selectedFotocasaFields["PropertyFeature"][$idField] ) ) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                                <?php foreach ($field["options"] as $id => $value) { ?>
                                <option value="<?php echo $id; ?>"<?php if ( isset( $selectedFotocasaFields["PropertyFeature"][$idField] ) && $selectedFotocasaFields["PropertyFeature"][$idField] == $id ) {echo "SELECTED";} ?>><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                            <?php if( isset($field["comment"]) && $field["comment"] != "" ){ ?>
                                <small class="help-block" style="font-size: 11px;"><?php echo $field["comment"]; ?></small>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <?php if( $field == "separator" || (isset($field["type"]) && $field["type"] == "separator") ){ ?>
                    <div <?php echo $dataShow; ?> <?php if ($hideField) {?>style="display:none;"<?php } ?>>
                        <div class="clearfix"></div>
                        <br>
                        <?php if( isset($field["title"]) && $field["title"] != "" ){ ?>
                            <div class="col-xs-12" >
                                <strong><?php echo $field["title"]; ?></strong>
                                <hr style="margin-top: 0;">
                            </div>
                            <div class="clearfix"></div>
                        <?php } ?>
                    </div>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    </div>
</div>
<script type="text/javascript">
    var fotocasaSubTypes = <?php echo json_encode($fotocasaSubTypes); ?>;
</script>
<?php } ?>

<script type="text/javascript">
    selectOne = "<?php echo NXT_getResource("Select one..."); ?>";
</script>

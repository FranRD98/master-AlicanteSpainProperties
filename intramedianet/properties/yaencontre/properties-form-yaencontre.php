<div class="row">

    <div class="col-md-12">
        <div class="form-check form-switch form-switch-md pt-2" dir="ltr" <?php if ($expYaencontre == 0) { ?>style="opacity: .5;"<?php } ?>>
            <input type="checkbox" name="export_yaencontre_prop" id="export_yaencontre_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['export_yaencontre_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_yaencontre_prop']),"1"))) {echo "checked";} ?> <?php if ($expYaencontre == 0) { ?>disabled<?php } ?>>
            <label class="form-check-label" for="export_yaencontre_prop"><?php __('Exportar a Yaencontre'); ?></label>
            <?php echo $tNGs->displayFieldError("properties_properties", "export_yaencontre_prop"); ?>
        </div>
        <?php if ($expYaencontre == 1) { ?>
            <div class="checkbox">
                <b><?php __('Campos obligatorios para la exportación a Yaencontre'); ?>:</b> <small class="text-muted">(<?php __('Hacer click en el botón "ACTUALIZAR Y SEGUIR EDITANDO" para ver la información actualizada'); ?>)</small> <br>
                <?php if ($row_rsproperties_properties['lat_long_gp_prop'] != '') { ?>
                    <span class="text-success">
                        <i class="fa fa-check"></i>
                <?php } else { ?>
                    <span class="text-danger">
                        <i class="fa fa-times"></i>
                <?php } ?>
                <?php __('Latitud y longitud'); ?></span>
            </div>
        <?php } ?>
    </div>
</div>
<?php if ($expYaencontre == 1) { ?>
<?php
    global $row_rsproperties_properties;
    $selectedYaencontreFields = json_decode($row_rsproperties_properties['export_yaencontre_fields_prop'], true);
    $xmlStatus = simplexml_load_file($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/yaencontre/DIC/status.xml');
    $xmlTypes = simplexml_load_file($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/yaencontre/DIC/types.xml');
    $idealistaFields = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/yaencontre/DIC/DIC_Fields.php');
?>
<div id="basicYaencontre" <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_yaencontre_prop']),"0"))) { ?>style="display: none;"<?php } ?> >
<hr>
    <div class="row">
        <div class="col-md-2">
            <div class="mb-4">
                <label for="export_yaencontre_fields_prop[operationType]" class="form-label"><?php __('Estatus'); ?> <span style="color:red">*</span>:</label>
                <select name="export_yaencontre_fields_prop[operationType]" id="idealistaoperationType" class="select2">
                    <option value="" <?php if (!(strcmp("", $selectedYaencontreFields['operationType']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                    <?php foreach ($xmlStatus as $field) { ?>
                        <option value="<?php echo $field['id']; ?>"<?php if (!(strcmp($field['id'], $selectedYaencontreFields['operationType']))) {echo "selected=\"selected\"";} ?>><?php echo $field['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-4">
                <label for="export_yaencontre_fields_prop[propertyType]" class="form-label"><?php __('Tipo'); ?> <span style="color:red">*</span>:</label>
                <select name="export_yaencontre_fields_prop[propertyType]" id="fotocasapropertyType" class="select2">
                    <option value="" <?php if (!(strcmp("", $selectedYaencontreFields['propertyType']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                    <?php foreach ($xmlTypes as $field) { ?>
                        <option value="<?php echo $field['id']; ?>"<?php if (!(strcmp($field['id'], $selectedYaencontreFields['propertyType']))) {echo "selected=\"selected\"";} ?>><?php echo $field['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-4">
                <div class="checkbox mt-4">
                    <div class="form-check form-switch form-switch-md" dir="ltr">
                        <input type="checkbox" name="idealista_fields_prop[IsNewConstruction]" id="idealista_IsNewConstruction" value="1" class="form-check-input" <?php if ( isset( $selectedYaencontreFields["IsNewConstruction"] ) && $selectedYaencontreFields["IsNewConstruction"] == 1 ) {echo "checked";} ?> <?php if ($expYaencontre == 0) { ?>disabled<?php } ?>>
                        <label class="form-check-label" for="alarm_prop"><?php __('Nueva construcción'); ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <?php foreach ($idealistaFields as $key => $value): ?>
            <div class="col-md-4">
                <div class="">
                    <div class="checkbox mt-4">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input type="checkbox" name="export_yaencontre_fields_prop[PropertyFeature][<?php echo $key; ?>]" id="idealistay_<?php echo $key; ?>" value="1" class="form-check-input" <?php if ( isset( $selectedYaencontreFields["PropertyFeature"][$key] ) && $selectedYaencontreFields["PropertyFeature"][$key] == 1 ) {echo "checked";} ?> <?php if ($expYaencontre == 0) { ?>disabled<?php } ?>>
                            <label class="form-check-label" for="idealistay_<?php echo $key; ?>"><?php echo $value; ?></label>
                        </div>
                    </div>
                    <?php if( isset($field["comment"]) && $field["comment"] != "" ){ ?>
                        <small class="text-muted" style="font-size: 11px;"><?php echo $field["comment"]; ?></small>
                    <?php } ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>

<script type="text/javascript">
    var fotocasaSubTypes = <?php echo json_encode($idealistaSubTypes); ?>;
</script>
<?php } ?>

<script type="text/javascript">
    selectOne = "<?php echo NXT_getResource("Select one..."); ?>";
</script>

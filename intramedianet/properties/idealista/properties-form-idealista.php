<div class="row">

    <div class="col-md-12">
        <div class="form-check form-switch form-switch-md pt-2" dir="ltr" <?php if ($expIdealista == 0) { ?>style="opacity: .5;"<?php } ?>>
            <input type="checkbox" name="idealista_prop" id="idealista_prop" value="1" class="form-check-input" <?php if (isset($row_rsproperties_properties['idealista_prop']) && !(strcmp(KT_escapeAttribute($row_rsproperties_properties['idealista_prop']),"1"))) {echo "checked";} ?> <?php if ($expIdealista == 0) { ?>disabled<?php } ?>>
            <label class="form-check-label" for="idealista_prop"><?php __('Exportar a Idealista'); ?></label>
            <?php echo $tNGs->displayFieldError("properties_properties", "idealista_prop"); ?>
        </div>
        <?php if ($expIdealista == 1) { ?>
            <div class="checkbox">
                <b><?php __('Campos obligatorios para la exportación a Idealista'); ?>:</b> <small class="text-muted">(<?php __('Hacer click en el botón "ACTUALIZAR Y SEGUIR EDITANDO" para ver la información actualizada'); ?>)</small> <br>
                <small><?php __('Texto idealista req'); ?></small><br>
                <?php if ($row_rsproperties_properties['referencia_prop']) { ?>
                    <span class="text-success">
                        <i class="fa fa-check"></i>
                <?php } else { ?>
                    <span class="text-danger">
                        <i class="fa fa-times"></i>
                <?php } ?>
                <?php __('Referencia'); ?></span> |

                <!-- <?php if ($row_rsproperties_properties['direccion_prop']) { ?>
                    <span class="text-success">
                        <i class="fa fa-check"></i>
                <?php } else { ?>
                    <span class="text-danger">
                        <i class="fa fa-times"></i>
                <?php } ?>
                <?php __('Dirección'); ?></span> | -->

                <?php if ($row_rsproperties_properties['preci_reducidoo_prop']) { ?>
                    <span class="text-success">
                        <i class="fa fa-check"></i>
                <?php } else { ?>
                    <span class="text-danger">
                        <i class="fa fa-times"></i>
                <?php } ?>
                <?php __('Precio'); ?></span> |

                <?php if ($row_rsproperties_properties['habitaciones_prop']) { ?>
                    <span class="text-success">
                        <i class="fa fa-check"></i>
                <?php } else { ?>
                    <span class="text-danger">
                        <i class="fa fa-times"></i>
                <?php } ?>
                <?php __('Habitaciones'); ?></span> |

                <?php if ($row_rsproperties_properties['aseos_prop']) { ?>
                    <span class="text-success">
                        <i class="fa fa-check"></i>
                <?php } else { ?>
                    <span class="text-danger">
                        <i class="fa fa-times"></i>
                <?php } ?>
                <?php __('Aseos'); ?></span> |

                <?php if ($row_rsproperties_properties['m2_prop']) { ?>
                    <span class="text-success">
                        <i class="fa fa-check"></i>
                <?php } else { ?>
                    <span class="text-danger">
                        <i class="fa fa-times"></i>
                <?php } ?>
                <?php if ($lang_adm == 'es') { ?><?php __('M2'); ?> <?php __('Útiles'); ?><?php } else { ?><?php __('Útiles'); ?> <?php __('M2'); ?><?php } ?></span>
            </div>
        <?php } ?>
    </div>
</div>
<?php if ($expIdealista == 1) { ?>
<?php
    global $row_rsproperties_properties;
    $selectedIdealistaFields = json_decode($row_rsproperties_properties['idealista_fields_prop'], true);
    $idealistaFields = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/idealista/DIC/DIC_Fields.php');
    $idealistaStatus = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/idealista/DIC/DIC_Status.php');
    $idealistaTypes = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/idealista/DIC/DIC_Types.php');
    $idealistaInt = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/idealista/DIC/DIC_Int.php');
    $idealistaConserv = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/idealista/DIC/DIC_Conser.php');
    $idealistaHeating = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/idealista/DIC/DIC_Heating.php');
?>
<div id="basicIdealista" <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties['idealista_prop']),"0"))) { ?>style="display: none;"<?php } ?> >
    <hr>
    <div class="row">
        <div class="col-md-2">
            <div class="mb-4">
                <label for="idealista_fields_prop[operationType]" class="form-label"><?php __('Estatus'); ?> <span style="color:red">*</span>:</label>
                <select name="idealista_fields_prop[operationType]" id="idealistaoperationType" class="select2">
                    <option value="" <?php if (!(strcmp("", $selectedIdealistaFields['operationType']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                    <?php foreach ($idealistaStatus as $key => $field) { ?>
                        <option value="<?php echo $key; ?>"<?php if (!(strcmp($key, $selectedIdealistaFields['operationType']))) {echo "selected=\"selected\"";} ?>><?php echo $field; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-4">
                <label for="idealista_fields_prop[featuresType]" class="form-label"><?php __('Tipo'); ?> <span style="color:red">*</span>:</label>
                <select name="idealista_fields_prop[featuresType]" id="fotocasafeaturesType" class="select2">
                    <option value="" <?php if (!(strcmp("", $selectedIdealistaFields['featuresType']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                    <?php foreach ($idealistaTypes as $key => $field) { ?>
                        <option value="<?php echo $key; ?>"<?php if (!(strcmp($key, $selectedIdealistaFields['featuresType']))) {echo "selected=\"selected\"";} ?>><?php echo $field; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-4">
                <label for="idealista_fields_prop[featuresWindowsLocation]" class="form-label"><?php __('Interior/Exterior'); ?>:</label>
                <select name="idealista_fields_prop[featuresWindowsLocation]" id="fotocasafeaturesWindowsLocation" class="select2">
                    <option value="" <?php if (!(strcmp("", $selectedIdealistaFields['featuresWindowsLocation']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                    <?php foreach ($idealistaInt as $key => $field) { ?>
                        <option value="<?php echo $key; ?>"<?php if (!(strcmp($key, $selectedIdealistaFields['featuresWindowsLocation']))) {echo "selected=\"selected\"";} ?>><?php echo $field; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-4">
                <label for="idealista_fields_prop[featuresConservation]" class="form-label"><?php __('Estado'); ?>:</label>
                <select name="idealista_fields_prop[featuresConservation]" id="fotocasafeaturesConservation" class="select2">
                    <option value="" <?php if (!(strcmp("", $selectedIdealistaFields['featuresConservation']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                    <?php foreach ($idealistaConserv as $key => $field) { ?>
                        <option value="<?php echo $key; ?>"<?php if (!(strcmp($key, $selectedIdealistaFields['featuresConservation']))) {echo "selected=\"selected\"";} ?>><?php echo $field; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-4">
                <div class="checkbox mt-4">
                    <div class="form-check form-switch form-switch-md" dir="ltr">
                        <input type="checkbox" name="idealista_fields_prop[IsNewConstruction]" id="idealista_IsNewConstruction" value="1" class="form-check-input" <?php if ( isset( $selectedIdealistaFields["IsNewConstruction"] ) && $selectedIdealistaFields["IsNewConstruction"] == 1 ) {echo "checked";} ?> <?php if ($expIdealista == 0) { ?>disabled<?php } ?> >
                        <label class="form-check-label" for="idealista_IsNewConstruction"><?php __('Nueva construcción'); ?></label>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="mb-4">
                <label for="idealista_fields_prop[addressLocalidad]" class="form-label"><?php __('Localidad'); ?> <span style="color:red">*</span>:</label>
                <input type="text" name="idealista_fields_prop[addressLocalidad]" id="fotocasaaddressLocalidad" value="<?php echo $selectedIdealistaFields['addressLocalidad'] ?>" class="form-control">
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-4">
                <label for="idealista_fields_prop[addressCalle]" class="form-label"><?php __('Nombre de la calle / Via'); ?> <span style="color:red">*</span>:</label>
                <input type="text" name="idealista_fields_prop[addressCalle]" id="fotocasaaddressCalle" value="<?php echo $selectedIdealistaFields['addressCalle'] ?>" class="form-control">
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-4">
                <label for="idealista_fields_prop[addressNumero]" class="form-label"><?php __('Número'); ?> <span style="color:red">*</span>:</label>
                <input type="text" name="idealista_fields_prop[addressNumero]" id="fotocasaaddressNumero" value="<?php echo $selectedIdealistaFields['addressNumero'] ?>" class="form-control">
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-4">
                <label for="idealista_fields_prop[addressPlanta]" class="form-label"><?php __('Planta'); ?>:</label>
                <input type="text" name="idealista_fields_prop[addressPlanta]" id="fotocasaaddressPlanta" value="<?php echo $selectedIdealistaFields['addressPlanta'] ?>" class="form-control">
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-4">
                <label for="idealista_fields_prop[addressPostalCode]" class="form-label"><?php __('Código Postal'); ?> <span style="color:red">*</span>:</label>
                <input type="text" name="idealista_fields_prop[addressPostalCode]" id="fotocasaaddressPostalCode" value="<?php echo $selectedIdealistaFields['addressPostalCode'] ?>" class="form-control">
            </div>
        </div>
        <div class="col-md-2">
            <a href="https://www.correos.es/es/es/herramientas/codigos-postales/detalle" target="_blank" class="btn btn-primary w-100 mt-0 mt-lg-3"><?php __('Buscar código postal'); ?></a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-2">
            <div class="mb-4">
                <label for="idealista_fields_prop[featuresHeating]" class="form-label"><?php __('Calefacción'); ?>:</label>
                <select name="idealista_fields_prop[featuresHeating]" id="fotocasafeaturesHeating" class="select2">
                    <option value="" <?php if (!(strcmp("", $selectedIdealistaFields['featuresHeating']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                    <?php foreach ($idealistaHeating as $key => $field) { ?>
                        <option value="<?php echo $key; ?>"<?php if (!(strcmp($key, $selectedIdealistaFields['featuresHeating']))) {echo "selected=\"selected\"";} ?>><?php echo $field; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <?php foreach ($idealistaFields as $key => $value): ?>
            <div class="col-md-4">
                <div class="mb-4">
                    <div class="checkbox">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input type="checkbox" name="idealista_fields_prop[PropertyFeature][<?php echo $key; ?>]" id="idealista_<?php echo $key; ?>" value="1" class="form-check-input" <?php if ( isset( $selectedIdealistaFields["PropertyFeature"][$key] ) && $selectedIdealistaFields["PropertyFeature"][$key] == 1 ) {echo "checked";} ?>  <?php if ($expIdealista == 0) { ?>disabled<?php } ?>>
                            <label class="form-check-label" for="idealista_<?php echo $key; ?>"><?php echo $value; ?></label>
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

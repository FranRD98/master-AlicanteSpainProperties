<hr style="border-top-width: 10px;">

<div class="row">
    <div class="col-md-6">
        <div class="checkbox" <?php if ($expRightmove == 0) { ?>style="opacity: .5;"<?php } ?>>
            <div class="form-check form-switch form-switch-md pt-2" dir="ltr">
                <input type="checkbox" name="export_rightmove_prop" id="export_rightmove_prop" value="1" class="form-check-input" <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_rightmove_prop']),"1"))) {echo "checked";} ?>>
                <label class="form-check-label" for="export_rightmove_prop"><?php __('Exportar a Rightmove'); ?></label>
                <?php echo $tNGs->displayFieldError("properties_properties", "export_rightmove_prop"); ?>
            </div>
            <hr>
        </div>
    </div>
</div>

<?php if ($expRightmove == 1) { ?>
    <?php
        global $row_rsproperties_properties;
        $selectedRightmoveFields = json_decode($row_rsproperties_properties['export_rightmove_fields_prop'], true);

        $rightmoveTypes = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_Types.php');
        ksort($rightmoveTypes);
        $rightmoveAccessibilites = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_Accessibilites.php');
        ksort($rightmoveAccessibilites);
        $rightmoveAreaUnits = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_AreaUnits.php');
        ksort($rightmoveAreaUnits);
        $rightmoveChannels = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_Channels.php');
        ksort($rightmoveChannels);
        $rightmoveCommercialUseClasses = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_CommercialUseClasses.php');
        ksort($rightmoveCommercialUseClasses);
        $rightmoveConditions = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_Conditions.php');
        ksort($rightmoveConditions);
        $rightmoveDimensionUnits = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_DimensionUnits.php');
        ksort($rightmoveDimensionUnits);
        $rightmoveDisplayTypes = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_DisplayTypes.php');
        ksort($rightmoveDisplayTypes);
        $rightmoveEntranceFloors = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_EntranceFloors.php');
        ksort($rightmoveEntranceFloors);
        $rightmoveFeaturedPropertyTypes = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_FeaturedPropertyTypes.php');
        ksort($rightmoveFeaturedPropertyTypes);
        $rightmoveFurnishings = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_Furnishings.php');
        ksort($rightmoveFurnishings);
        $rightmoveHeatings = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_Heatings.php');
        ksort($rightmoveHeatings);
        $rightmoveLetTypes = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_LetTypes.php');
        ksort($rightmoveLetTypes);
        $rightmoveMediaTypes = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_MediaTypes.php');
        ksort($rightmoveMediaTypes);
        $rightmoveOutsideSpaces = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_OutsideSpaces.php');
        ksort($rightmoveOutsideSpaces);
        $rightmoveParkings = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_Parkings.php');
        ksort($rightmoveParkings);
        $rightmovePriceQualifiers = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_PriceQualifiers.php');
        ksort($rightmovePriceQualifiers);
        $rightmoveRemovalReasons = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_RemovalReasons.php');
        ksort($rightmoveRemovalReasons);
        $rightmoveRentFrequencies = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_RentFrequencies.php');
        ksort($rightmoveRentFrequencies);
        $rightmoveStampTexts = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_StampTexts.php');
        ksort($rightmoveStampTexts);
        $rightmoveStatuses = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_Statuses.php');
        ksort($rightmoveStatuses);
        $rightmoveTenureTypes = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_TenureTypes.php');
        ksort($rightmoveTenureTypes);
        $rightmoveCheckboxes = include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/rightmove/DIC/DIC_checkboxes.php');
    ?>
    <div id="basicRightmove" <?php if (!(strcmp(KT_escapeAttribute($row_rsproperties_properties['export_rightmove_prop']),"0"))) { ?>style="display: none;"<?php } ?>>
        <div class="row">
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[location]"><?php __('Localización'); ?> <span style="color:red">*</span>:</label>
                    <select name="export_rightmove_fields_prop[location]" id="rightmovelocation" class="select2">
                        <option value="" <?php if (!(strcmp("", $selectedRightmoveFields['location']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php do { ?>
                            <option value="<?php echo $row_rsRMlocs['id_rml']; ?>"<?php if (!(strcmp($row_rsRMlocs['id_rml'], $selectedRightmoveFields['location']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsRMlocs['loc1_rml']; ?> &raquo; <?php echo $row_rsRMlocs['loc2_rml']; ?> &raquo; <?php echo $row_rsRMlocs['loc3_rml']; ?> &raquo; <?php echo $row_rsRMlocs['loc4_rml']; ?></option>
                        <?php } while ($row_rsRMlocs = mysqli_fetch_assoc($rsRMlocs)); ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[type]"><?php __('Tipo'); ?> <span style="color:red">*</span>:</label>
                    <select name="export_rightmove_fields_prop[type]" id="rightmovetype" class="select2">
                        <option value="" <?php if (!(strcmp("", $selectedRightmoveFields['type']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($rightmoveTypes as $key => $field) { ?>
                            <option value="<?php echo $field; ?>"<?php if (!(strcmp($field, $selectedRightmoveFields['type']))) {echo "selected=\"selected\"";} ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[statuses]"><?php __('Statuses'); ?>:</label>
                    <select name="export_rightmove_fields_prop[statuses]" id="rightmovestatuses" class="select2">
                        <option value="" <?php if (!(strcmp("", $selectedRightmoveFields['statuses']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($rightmoveStatuses as $key => $field) { ?>
                            <option value="<?php echo $field; ?>"<?php if (!(strcmp($field, $selectedRightmoveFields['statuses']))) {echo "selected=\"selected\"";} ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[pricequalifiers]"><?php __('Price Qualifiers'); ?>:</label>
                    <select name="export_rightmove_fields_prop[pricequalifiers]" id="rightmovepricequalifiers" class="select2">
                        <option value="" <?php if (!(strcmp("", $selectedRightmoveFields['pricequalifiers']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($rightmovePriceQualifiers as $key => $field) { ?>
                            <option value="<?php echo $field; ?>"<?php if (!(strcmp($field, $selectedRightmoveFields['pricequalifiers']))) {echo "selected=\"selected\"";} ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[dimensionunits]"><?php __('Dimension Units'); ?>:</label>
                    <select name="export_rightmove_fields_prop[dimensionunits]" id="rightmovedimensionunits" class="select2">
                        <option value="" <?php if (!(strcmp("", $selectedRightmoveFields['dimensionunits']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($rightmoveAreaUnits as $key => $field) { ?>
                            <option value="<?php echo $field; ?>"<?php if (!(strcmp($field, $selectedRightmoveFields['dimensionunits']))) {echo "selected=\"selected\"";} ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[areaunits]"><?php __('Area Units'); ?>:</label>
                    <select name="export_rightmove_fields_prop[areaunits]" id="rightmoveareaunits" class="select2">
                        <option value="" <?php if (!(strcmp("", $selectedRightmoveFields['areaunits']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($rightmoveAreaUnits as $key => $field) { ?>
                            <option value="<?php echo $field; ?>"<?php if (!(strcmp($field, $selectedRightmoveFields['areaunits']))) {echo "selected=\"selected\"";} ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[entrancefloors]"><?php __('Entrance Floors'); ?>:</label>
                    <select name="export_rightmove_fields_prop[entrancefloors]" id="rightmoveentrancefloors" class="select2">
                        <option value="" <?php if (!(strcmp("", $selectedRightmoveFields['entrancefloors']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($rightmoveEntranceFloors as $key => $field) { ?>
                            <option value="<?php echo $field; ?>"<?php if (!(strcmp($field, $selectedRightmoveFields['entrancefloors']))) {echo "selected=\"selected\"";} ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[conditions]"><?php __('Conditions'); ?>:</label>
                    <select name="export_rightmove_fields_prop[conditions]" id="rightmoveconditions" class="select2">
                        <option value="" <?php if (!(strcmp("", $selectedRightmoveFields['conditions']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($rightmoveConditions as $key => $field) { ?>
                            <option value="<?php echo $field; ?>"<?php if (!(strcmp($field, $selectedRightmoveFields['conditions']))) {echo "selected=\"selected\"";} ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[commercialuseclasses]"><?php __('Commercial Use Classes'); ?>:</label>
                    <select name="export_rightmove_fields_prop[commercialuseclasses]" id="rightmovecommercialuseclasses" class="select2">
                        <option value="" <?php if (!(strcmp("", $selectedRightmoveFields['commercialuseclasses']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($rightmoveCommercialUseClasses as $key => $field) { ?>
                            <option value="<?php echo $field; ?>"<?php if (!(strcmp($field, $selectedRightmoveFields['commercialuseclasses']))) {echo "selected=\"selected\"";} ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[accessibilites]"><?php __('Accessibilites'); ?>:</label>
                    <select name="export_rightmove_fields_prop[accessibilites][]" id="rightmoveaccessibilites" class="select2" multiple>
                        <option value="" <?php if (in_array('', (array)$selectedRightmoveFields['accessibilites'])) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($rightmoveAccessibilites as $key => $field) { ?>
                            <option value="<?php echo $field; ?>"<?php if (in_array($field, (array)$selectedRightmoveFields['accessibilites'])) {echo "selected=\"selected\"";} ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-md-12"></div>

            <?php foreach ($rightmoveCheckboxes as $value) { ?>
                <div class="col-md-4">

                    <div class="form-check form-switch form-switch-md pt-2" dir="ltr">
                        <input type="checkbox" name="export_rightmove_fields_prop[checkboxes][<?php echo $value; ?>]" id="fotocasa_<?php echo $value; ?>" value="1" class="form-check-input" <?php if ( isset( $selectedRightmoveFields["checkboxes"][$value] ) && $selectedRightmoveFields["checkboxes"][$value] == 1 ) {echo "checked";} ?>>
                        <label class="form-label" class="form-check-label" for="export_zoopla_prop"><?php echo __($value); ?></label>
                    </div>

                </div>
            <?php } ?>








            <?php /* ?>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[channels]"><?php __('Channels'); ?>:</label>
                    <select name="export_rightmove_fields_prop[channels]" id="rightmovechannels" class="select2">
                        <option value="" <?php if (!(strcmp("", $selectedRightmoveFields['channels']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($rightmoveChannels as $key => $field) { ?>
                            <option value="<?php echo $field; ?>"<?php if (!(strcmp($field, $selectedRightmoveFields['channels']))) {echo "selected=\"selected\"";} ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[displaytypes]"><?php __('Display Types'); ?>:</label>
                    <select name="export_rightmove_fields_prop[displaytypes]" id="rightmovedisplaytypes" class="select2">
                        <option value="" <?php if (!(strcmp("", $selectedRightmoveFields['displaytypes']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($rightmoveDisplayTypes as $key => $field) { ?>
                            <option value="<?php echo $field; ?>"<?php if (!(strcmp($field, $selectedRightmoveFields['displaytypes']))) {echo "selected=\"selected\"";} ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[featuredpropertytypes]"><?php __('Featured Property Types'); ?>:</label>
                    <select name="export_rightmove_fields_prop[featuredpropertytypes]" id="rightmovefeaturedpropertytypes" class="select2">
                        <option value="" <?php if (!(strcmp("", $selectedRightmoveFields['featuredpropertytypes']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($rightmoveFeaturedPropertyTypes as $key => $field) { ?>
                            <option value="<?php echo $field; ?>"<?php if (!(strcmp($field, $selectedRightmoveFields['featuredpropertytypes']))) {echo "selected=\"selected\"";} ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[furnishings]"><?php __('Furnishings'); ?>:</label>
                    <select name="export_rightmove_fields_prop[furnishings]" id="rightmovefurnishings" class="select2">
                        <option value="" <?php if (!(strcmp("", $selectedRightmoveFields['furnishings']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($rightmoveFurnishings as $key => $field) { ?>
                            <option value="<?php echo $field; ?>"<?php if (!(strcmp($field, $selectedRightmoveFields['furnishings']))) {echo "selected=\"selected\"";} ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[heatings]"><?php __('Heatings'); ?>:</label>
                    <select name="export_rightmove_fields_prop[heatings]" id="rightmoveheatings" class="select2">
                        <option value="" <?php if (!(strcmp("", $selectedRightmoveFields['heatings']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($rightmoveHeatings as $key => $field) { ?>
                            <option value="<?php echo $field; ?>"<?php if (!(strcmp($field, $selectedRightmoveFields['heatings']))) {echo "selected=\"selected\"";} ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[lettypes]"><?php __('Let Types'); ?>:</label>
                    <select name="export_rightmove_fields_prop[lettypes]" id="rightmovelettypes" class="select2">
                        <option value="" <?php if (!(strcmp("", $selectedRightmoveFields['lettypes']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($rightmoveLetTypes as $key => $field) { ?>
                            <option value="<?php echo $field; ?>"<?php if (!(strcmp($field, $selectedRightmoveFields['lettypes']))) {echo "selected=\"selected\"";} ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[mediatypes]"><?php __('Media Types'); ?>:</label>
                    <select name="export_rightmove_fields_prop[mediatypes]" id="rightmovemediatypes" class="select2">
                        <option value="" <?php if (!(strcmp("", $selectedRightmoveFields['mediatypes']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($rightmoveMediaTypes as $key => $field) { ?>
                            <option value="<?php echo $field; ?>"<?php if (!(strcmp($field, $selectedRightmoveFields['mediatypes']))) {echo "selected=\"selected\"";} ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[outsidespaces]"><?php __('Outside Spaces'); ?>:</label>
                    <select name="export_rightmove_fields_prop[outsidespaces]" id="rightmoveoutsidespaces" class="select2">
                        <option value="" <?php if (!(strcmp("", $selectedRightmoveFields['outsidespaces']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($rightmoveOutsideSpaces as $key => $field) { ?>
                            <option value="<?php echo $field; ?>"<?php if (!(strcmp($field, $selectedRightmoveFields['outsidespaces']))) {echo "selected=\"selected\"";} ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[parkings]"><?php __('Parkings'); ?>:</label>
                    <select name="export_rightmove_fields_prop[parkings]" id="rightmoveparkings" class="select2">
                        <option value="" <?php if (!(strcmp("", $selectedRightmoveFields['parkings']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($rightmoveParkings as $key => $field) { ?>
                            <option value="<?php echo $field; ?>"<?php if (!(strcmp($field, $selectedRightmoveFields['parkings']))) {echo "selected=\"selected\"";} ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[removalreasons]"><?php __('Removal Reasons'); ?>:</label>
                    <select name="export_rightmove_fields_prop[removalreasons]" id="rightmoveremovalreasons" class="select2">
                        <option value="" <?php if (!(strcmp("", $selectedRightmoveFields['removalreasons']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($rightmoveRemovalReasons as $key => $field) { ?>
                            <option value="<?php echo $field; ?>"<?php if (!(strcmp($field, $selectedRightmoveFields['removalreasons']))) {echo "selected=\"selected\"";} ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[rentfrequencies]"><?php __('Rent Frequencies'); ?>:</label>
                    <select name="export_rightmove_fields_prop[rentfrequencies]" id="rightmoverentfrequencies" class="select2">
                        <option value="" <?php if (!(strcmp("", $selectedRightmoveFields['rentfrequencies']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($rightmoveRentFrequencies as $key => $field) { ?>
                            <option value="<?php echo $field; ?>"<?php if (!(strcmp($field, $selectedRightmoveFields['rentfrequencies']))) {echo "selected=\"selected\"";} ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[stamptexts]"><?php __('Stamp texts'); ?>:</label>
                    <select name="export_rightmove_fields_prop[stamptexts]" id="rightmovestamptexts" class="select2">
                        <option value="" <?php if (!(strcmp("", $selectedRightmoveFields['stamptexts']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($rightmoveStampTexts as $key => $field) { ?>
                            <option value="<?php echo $field; ?>"<?php if (!(strcmp($field, $selectedRightmoveFields['stamptexts']))) {echo "selected=\"selected\"";} ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-4">
                    <label class="form-label" for="export_rightmove_fields_prop[tenuretypes]"><?php __('Tenure Types'); ?>:</label>
                    <select name="export_rightmove_fields_prop[tenuretypes]" id="rightmovetenuretypes" class="select2">
                        <option value="" <?php if (!(strcmp("", $selectedRightmoveFields['tenuretypes']))) {echo "selected=\"selected\"";} ?>><?php echo NXT_getResource("Select one..."); ?></option>
                        <?php foreach ($rightmoveTenureTypes as $key => $field) { ?>
                            <option value="<?php echo $field; ?>"<?php if (!(strcmp($field, $selectedRightmoveFields['tenuretypes']))) {echo "selected=\"selected\"";} ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <?php */ ?>
        </div>
    </div>
<?php } ?>

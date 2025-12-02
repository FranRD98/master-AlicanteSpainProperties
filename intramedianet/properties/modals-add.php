<div id="myModalProp" class="modal fade" tabindex="-1" aria-labelledby="myModalPropLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white pb-3" id="myModalPropLabel"><i class="fa-regular fa-plus me-2 fs-4"></i> <?php __('Añadir'); ?> <?php __('Inmueble'); ?></h5>
                <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <form id="formProp" action="/intramedianet/properties/properties-form.php" method="post" class="needs-validation" novalidate>
                <div class="modal-body bg-light">
                    <div class="form-group">
                        <label for="referencia_prop" class="form-label"><?php __('Referencia'); ?>:</label>
                        <input type="text" name="referencia_prop" id="referencia_prop" value="" size="32" maxlength="255" class="form-control required" required>
                        <div class="invalid-feedback">
                            <?php __('Este campo es obligatorio.'); ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-soft-primary">
                    <input type="submit" name="KT_Insert2" value="<?php echo NXT_getResource("Insert_FB"); ?>" class="btn btn-success btn-sm mt-4" />
                    <button type="button" class="btn btn-danger btn-sm mt-4" data-bs-dismiss="modal"><?php __('Cerrar'); ?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="myModalCli" class="modal fade" tabindex="-1" aria-labelledby="myModalCliLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white pb-3" id="myModalCliLabel"><i class="fa-regular fa-plus me-2 fs-4"></i> <?php __('Añadir'); ?> <?php __('Cliente'); ?></h5>
                <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <form id="formCli" action="/intramedianet/properties/clients-form.php" method="post" class="needs-validation" novalidate>
                <div class="modal-body bg-light">
                    <div class="mb-4">
                        <label for="nombre_cli" id="nameprom" class="form-label"><?php __('Nombre'); ?>:</label>
                        <input type="text" name="nombre_cli" id="nombre_cli" value="" size="32" maxlength="255" class="form-control required" required>
                        <div class="invalid-feedback">
                            <?php __('Este campo es obligatorio.'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="idioma_cli" class="form-label"><?php __('Idioma'); ?>:</label>
                        <select name="idioma_cli" id="idioma_cli" class="form-select required" required>
                            <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                            <?php
                            if ($lang_adm == 'es') {
                                $idiomas = array('ca' => 'Catalán', 'da' => 'Danés', 'de' => 'Alemán', 'el' => 'Griego', 'en' => 'Inglés', 'es' => 'Español', 'fi' => 'Finlandés', 'fr' => 'Francés', 'is' => 'Islandés', 'it' => 'Italiano', 'nl' => 'Holandés', 'no' => 'Noruego', 'pt' => 'Portugués', 'ru' => 'Ruso', 'se' => 'Sueco', 'zh' => 'Chino', 'pl' => 'Polaco');
                            } else {
                                $idiomas = array('ca' => 'Catalan', 'da' => 'Danish', 'de' => 'German', 'el' => 'Greek', 'en' => 'English', 'es' => 'Spanish', 'fi' => 'Finnish', 'fr' => 'French', 'is' => 'Icelandic', 'it' => 'Italian', 'nl' => 'Dutch', 'no' => 'Norwegian', 'pt' => 'Portuguese', 'ru' => 'Russian', 'se' => 'Swedish', 'zh' => 'Chinese', 'pl' => 'Polish');
                            }
                            foreach ($languages as $value) {
                                $selected = ((isset($row_rsproperties_client['idioma_cli'])) && (!(strcmp($value, $row_rsproperties_client['idioma_cli']))))?" SELECTED":"";
                                echo '<option value="'.$value.'"'.$selected.'>'.$idiomas[$value].'</option>';
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            <?php __('Este campo es obligatorio.'); ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-soft-primary">
                    <input type="submit" name="KT_Insert2" value="<?php echo NXT_getResource("Insert_FB"); ?>" class="btn btn-success btn-sm mt-4" />
                    <button type="button" class="btn btn-danger btn-sm mt-4" data-bs-dismiss="modal"><?php __('Cerrar'); ?></button>
                    <input type="hidden" name="fecha_alta_cli" id="fecha_alta_pro" value="<?php echo date("d-m-Y H:i:s") ?>">
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="myModalOwn" class="modal fade" tabindex="-1" aria-labelledby="myModalOwnLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white pb-3" id="myModalOwnLabel"><i class="fa-regular fa-plus me-2 fs-4"></i> <?php __('Añadir'); ?> <?php __('Propietario'); ?></h5>
                <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <form id="formOwn" action="/intramedianet/properties/owners-form.php" method="post" class="needs-validation" novalidate>
                <div class="modal-body bg-light">
                    <div class="mb-4">
                        <label for="nombre_pro" id="nameprom" class="form-label"><?php __('Nombre'); ?>:</label>
                        <input type="text" name="nombre_pro" id="nombre_pro" value="" size="32" maxlength="255" class="form-control required" required>
                        <div class="invalid-feedback">
                            <?php __('Este campo es obligatorio.'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="idioma_pro" class="form-label"><?php __('Idioma'); ?>:</label>
                        <select name="idioma_pro" id="idioma_pro" class="form-select required" required>
                            <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                            <?php
                            if ($lang_adm == 'es') {
                                $idiomas = array('ca' => 'Catalán', 'da' => 'Danés', 'de' => 'Alemán', 'el' => 'Griego', 'en' => 'Inglés', 'es' => 'Español', 'fi' => 'Finlandés', 'fr' => 'Francés', 'is' => 'Islandés', 'it' => 'Italiano', 'nl' => 'Holandés', 'no' => 'Noruego', 'pt' => 'Portugués', 'ru' => 'Ruso', 'se' => 'Sueco', 'zh' => 'Chino', 'pl' => 'Polaco');
                            } else {
                                $idiomas = array('ca' => 'Catalan', 'da' => 'Danish', 'de' => 'German', 'el' => 'Greek', 'en' => 'English', 'es' => 'Spanish', 'fi' => 'Finnish', 'fr' => 'French', 'is' => 'Icelandic', 'it' => 'Italian', 'nl' => 'Dutch', 'no' => 'Norwegian', 'pt' => 'Portuguese', 'ru' => 'Russian', 'se' => 'Swedish', 'zh' => 'Chinese', 'pl' => 'Polish');
                            }
                            foreach ($languages as $value) {
                                $selected = ((isset($row_rsproperties_client['idioma_pro'])) && (!(strcmp($value, $row_rsproperties_client['idioma_pro']))))?" SELECTED":"";
                                echo '<option value="'.$value.'"'.$selected.'>'.$idiomas[$value].'</option>';
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            <?php __('Este campo es obligatorio.'); ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-soft-primary">
                    <input type="submit" name="KT_Insert2" value="<?php echo NXT_getResource("Insert_FB"); ?>" class="btn btn-success btn-sm mt-4" />
                    <button type="button" class="btn btn-danger btn-sm mt-4" data-bs-dismiss="modal"><?php __('Cerrar'); ?></button>
                    <input type="hidden" name="fecha_alta_pro" id="fecha_alta_pro" value="<?php echo date("d-m-Y H:i:s") ?>">
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

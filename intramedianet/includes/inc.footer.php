            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo date('Y'); ?> ©
                        <?php if ($xmlImport == 0): ?>
                            Mediaelx Digital Agency
                        <?php else: ?>
                            Mediaelx Let's Inmo
                        <?php endif ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Design & Develop by Mediaelx
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<div class="customizer-setting">
    <div class="btn btn-primary btn-rounded btn-icon btn p-2 opacity-50" id="back-top">
        <i class="fa-solid fa-up"></i>
    </div>
</div>

<?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/modals-add.php' ); ?>

<!-- JAVASCRIPT -->
<script>
    var applang = '<?php echo $lang_adm; ?>';
</script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="/intramedianet/includes/resources/lang_<?php echo $lang_adm; ?>.js?<?php echo filemtime($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/lang_' . $lang_adm . '.js'); ?>"></script>

<!--jQuery cookie-->
<script src="/intramedianet/includes/assets/_custom/vendor/jquery.cookie/jquery.cookie.js"></script>

<!--select2 cdn-->
<script src="https://cdn.jsdelivr.net/npm/select2@3.5.1/select2.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script> -->


<script src="/intramedianet/includes/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/intramedianet/includes/assets/libs/simplebar/simplebar.min.js"></script>
<script src="/intramedianet/includes/assets/libs/node-waves/waves.min.js"></script>
<script src="/intramedianet/includes/assets/libs/feather-icons/feather.min.js"></script>
<script src="/intramedianet/includes/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
<script src="/intramedianet/includes/assets/js/plugins.js"></script><!-- Sweet Alerts js -->
<script src="/intramedianet/includes/assets/libs/flatpickr/l10n/es.js"></script>
<script src="/intramedianet/includes/assets/libs/flatpickr/l10n/default.js"></script>
<script src="/intramedianet/includes/assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="/intramedianet/includes/assets/_custom/vendor/pwstrength-bootstrap-1.2.5.js"></script>

<!--datatable js-->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>
<!--
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
 -->
<script src="/intramedianet/includes/assets/js/pages/datatables.init.js"></script>

<!-- prismjs plugin -->
<script src="/intramedianet/includes/assets/libs/prismjs/prism.js"></script>

<!-- validation plugin -->
<script src="/intramedianet/includes/assets/js/pages/form-validation.init.js"></script>

<!--Plupload cdn-->
<script src="/intramedianet/includes/assets/_custom/vendor/plupload.full.min.js"></script>
<script src="/intramedianet/includes/assets/_custom/vendor/jquery.plupload.queue.min.js"></script>
<?php if ($lang_adm != 'en'): ?>
<script src="/intramedianet/includes/resources/plupload_<?php echo $lang_adm; ?>.js"></script>
<?php endif ?>

<!-- Redactor js-->
<script src="/intramedianet/includes/assets/_custom/vendor/redactor/redactor.min.js"></script>
<script src="/intramedianet/includes/assets/_custom/vendor/redactor/langs/<?php echo $lang_adm; ?>.js"></script>
<script src="/intramedianet/includes/assets/_custom/vendor/redactor/plugins/fontcolor/fontcolor.min.js"></script>
<script src="/intramedianet/includes/assets/_custom/vendor/redactor/plugins/alignment/alignment.min.js"></script>
<script src="/intramedianet/includes/assets/_custom/vendor/redactor/plugins/table/table.min.js"></script>
<script src="/intramedianet/includes/assets/_custom/vendor/redactor/plugins/fullscreen/fullscreen.min.js"></script>
<script src="/intramedianet/includes/assets/_custom/vendor/redactor/plugins/counter/counter.min.js"></script>
<script src="/intramedianet/includes/assets/_custom/vendor/codemirror/codemirror.js"></script>
<script src="/intramedianet/includes/assets/_custom/vendor/codemirror/addon/edit/matchbrackets.js"></script>
<script src="/intramedianet/includes/assets/_custom/vendor/codemirror/addon/fold/xml-fold.js"></script>
<script src="/intramedianet/includes/assets/_custom/vendor/codemirror/addon/edit/matchtags.js"></script>
<script src="/intramedianet/includes/assets/_custom/vendor/codemirror/addon/edit/closetag.js"></script>
<script src="/intramedianet/includes/assets/_custom/vendor/codemirror/mode/xml/xml.js"></script>
<script src="/intramedianet/includes/assets/_custom/vendor/codemirror/mode/css/css.js"></script>
<script src="/intramedianet/includes/assets/_custom/vendor/codemirror/mode/javascript/javascript.js"></script>
<script src="/intramedianet/includes/assets/_custom/vendor/codemirror/mode/htmlmixed/htmlmixed.js"></script>

<!-- Textcounter js-->
<script src="/intramedianet/includes/assets/_custom/vendor/textcounter.js"></script>

<!-- Sweet alert init js-->
<script src="/intramedianet/includes/assets/js/pages/sweetalerts.init.js"></script>

<!-- Gmap3 -->
<script src="https://maps.google.com/maps/api/js?key=<?php echo $googleMapsApiKey ?>"></script>
<script src="/intramedianet/includes/assets/_custom/vendor/gmap3.min.js"></script>

<!-- Nestable -->
<script src="/intramedianet/includes/assets/_custom/vendor/jquery.nestable.js"></script>

<!-- Sortablejs -->
<script src="/intramedianet/includes/assets/libs/sortablejs/Sortable.min.js"></script>

<!-- Minicolors -->
<script src="/intramedianet/includes/assets/_custom/vendor/jquery-minicolors/jquery.minicolors.min.js"></script>

<!-- rater-js plugin -->
<script src="/intramedianet/includes/assets/libs/rater-js/index.js"></script>

<!-- Ekko-lightbox -->
<script src="/intramedianet/includes/assets/_custom/vendor/ekko-lightbox/dist/ekko-lightbox.js"></script>

<!-- jQuery UI js -->
<script src="/intramedianet/includes/assets/_custom/vendor/jquery-ui-1.11.3.custom/jquery-ui.min.js"></script>
<script src="/intramedianet/includes/assets/_custom/vendor/jqueryui-touch-punch/jquery.ui.touch-punch.min.js"></script>

<!-- calendar min js -->
<script src="/intramedianet/includes/assets/_custom/vendor/moment/moment.js"></script>
<script src="/intramedianet/includes/assets/_custom/vendor/fullcalendar/dist/fullcalendar.js"></script>

<!-- App js -->
<script src="/intramedianet/includes/assets/js/app.js"></script>

<script src="/intramedianet/includes/assets/_custom/custom.js?id=<?php echo trim(file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/version.md')); ?>"></script>

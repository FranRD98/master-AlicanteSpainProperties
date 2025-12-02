<?php

// Cargamos la conexión a MySql
require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php' );


$query_rsEmails = "

SELECT
properties_log_mails_props.id_log,
GROUP_CONCAT(properties_properties.id_prop) as id_prop,
GROUP_CONCAT(properties_properties.referencia_prop) as referencia_prop,
properties_log_mails_props.type_log,
(SELECT nombre_usr FROM users WHERE id_usr = usr_log) AS usr_log,
properties_log_mails_props.text_log,
properties_log_mails_props.date_log
FROM properties_log_mails_props
LEFT OUTER JOIN properties_properties ON properties_log_mails_props.prop_id_log = properties_properties.id_prop
WHERE id_log = '".$_GET['id']."'
GROUP BY date_log
ORDER BY date_log DESC


";
$rsEmails = mysqli_query($inmoconn,$query_rsEmails) or die(mysqli_error());
$row_rsEmails = mysqli_fetch_assoc($rsEmails);
$totalRows_rsEmails = mysqli_num_rows($rsEmails);
?>
<div class="modal-header bg-primary">
    <h5 class="modal-title text-white pb-3" id="myModal2Label"><i class="fa-regular fa-envelope me-2 fs-4"></i> <?php echo $row_rsEmails['email_log']; ?></h5>
    <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
</div>
<div class="modal-body bg-light">
    <?php echo $row_rsEmails['text_log'] ?>
</div>
<div class="modal-footer bg-soft-primary">
    <a href="#" class="btn btn-danger btn-sm mt-4" data-bs-dismiss="modal"><!-- data-dismiss="modal" -->
    <?php __('Cerrar'); ?>
    </a>
</div>

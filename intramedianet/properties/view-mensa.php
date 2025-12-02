<?php

// Cargamos la conexión a MySql
require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
require_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php' );


$query_rsEmails = "
SELECT
properties_log_mails.id_log,
(SELECT CONCAT_WS('', nombre_cli, ' ', apellidos_cli, ' -  <small>', email_cli, '</small>') FROM properties_client WHERE email_cli = email_log LIMIT 1) as email_log,
properties_log_mails.type_log,
(SELECT nombre_usr FROM users WHERE id_usr = usr_log LIMIT 1) AS usr_log,
properties_log_mails.text_log,
properties_log_mails.date_log
FROM properties_log_mails
WHERE id_log = '".$_GET['id']."'
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

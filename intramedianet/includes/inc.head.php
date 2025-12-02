<meta name="version" content="<?php echo file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/version.md'); ?>">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php __('Administración'); ?> &raquo; <?php echo $_SERVER['HTTP_HOST'] ?></title>

<!-- Layout config Js -->
<script src="/intramedianet/includes/assets/js/layout.js"></script>
<!-- Bootstrap Css -->
<link href="/intramedianet/includes/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="/intramedianet/includes/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<!--datatable css-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
<!--datatable responsive css-->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css">
<!-- Sweet Alert css-->
<link href="/intramedianet/includes/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<!-- Select2 Css-->
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@3.5.1/select2.css" rel="stylesheet" /> -->
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@3.5.1/select2-bootstrap.css" rel="stylesheet" /> -->
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
<!-- Plupload Css-->
<link href="/intramedianet/includes/assets/_custom/vendor/jquery.plupload.queue.css" rel="stylesheet" />
<!-- Minicolors Css-->
<link href="/intramedianet/includes/assets/_custom/vendor/jquery-minicolors/jquery.minicolors.css" rel="stylesheet" />
<!-- Redactor Css-->
<link href="/intramedianet/includes/assets/_custom/vendor/redactor/redactor.css" rel="stylesheet" />
<!-- Codemirror Css-->
<link href="/intramedianet/includes/assets/_custom/vendor/codemirror/codemirror.css" rel="stylesheet" />
<link href="/intramedianet/includes/assets/_custom/vendor/codemirror/oceanic-next.css" rel="stylesheet" />
<!-- fullcalendar css -->
<link href="/intramedianet/includes/assets/_custom/vendor/fullcalendar/dist/fullcalendar.css" rel="stylesheet" type="text/css" />
<!-- Ekko-lightbox css -->
<link href="/intramedianet/includes/assets/_custom/vendor/ekko-lightbox/dist/ekko-lightbox.min.css" rel="stylesheet" type="text/css" />
<?php if ($actLestinmo == 0): ?>
    <!-- App Css-->
    <link href="/intramedianet/includes/assets/css/app.min.css?id=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/assets/css/app.min.css'); ?>" id="app-style" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="/intramedianet/includes/assets/css/custom.min.css?id=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/assets/css/custom.min.css'); ?>" id="app-style" rel="stylesheet" type="text/css" />
<?php else: ?>
    <!-- App Css-->
    <link href="/intramedianet/includes/assets/css/app-letsinmo.min.css?id=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/assets/css/app-letsinmo.min.css'); ?>" id="app-style" rel="stylesheet" type="text/css" />
    <link href="/intramedianet/includes/assets/css/custom-letsinmo.min.css?id=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/assets/css/custom-letsinmo.min.css'); ?>" id="app-style" rel="stylesheet" type="text/css" />
<?php endif ?>

<!-- App favicon -->
<link rel="apple-touch-icon" sizes="57x57" href="/intramedianet/includes/assets/favicons/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/intramedianet/includes/assets/favicons/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/intramedianet/includes/assets/favicons/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/intramedianet/includes/assets/favicons/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/intramedianet/includes/assets/favicons/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/intramedianet/includes/assets/favicons/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/intramedianet/includes/assets/favicons/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/intramedianet/includes/assets/favicons/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/intramedianet/includes/assets/favicons/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/intramedianet/includes/assets/favicons/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/intramedianet/includes/assets/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/intramedianet/includes/assets/favicons/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/intramedianet/includes/assets/favicons/favicon-16x16.png">
<link rel="manifest" href="/intramedianet/includes/assets/favicons/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/intramedianet/includes/assets/favicons/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">


<!--[if IE]>
<link href="/intramedianet/includes/assets/favicons/favicon.ico">favicon.ico" rel="icon" />
<![endif]-->

<script>
    var admiName = '<?php echo $_SESSION["kt_login_name"] ?>';
    var non = '<?php echo $lang['No'] ?>';
    var canDel = <?php echo ($_SESSION['kt_login_level'] == 9)?1:0; ?>;
    var checkPagdirt = 0;
</script>
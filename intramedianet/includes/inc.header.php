<!-- Begin page -->

<?php 

if(preg_match('/\/ferias\//', $_SERVER['PHP_SELF']))
{
    $showMainNav = false;
} 
else 
{
    $showMainNav = true;
}
?>


<div id="layout-wrapper">

    <?php 

    if($showMainNav)
    {
        include 'inc.topbar.php';
        include 'inc.sidebar.php'; 
    }

    ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content ">

        <div class="page-content <?php if($showMainNav == false):?> px-1 py-4 mb-4 <?php endif?>">
            <div class="container-fluid">

                <?php /* ?>
                <!-- start page title -->
                <!-- <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0"><?php echo $tileSec; ?></h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="/intramedianet/inicio/inicio.php"><?php __('Inicio'); ?></a></li>
                                    <?php echo $breadSecc; ?>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div> -->
                <!-- end page title -->
                <?php */ ?>



        <?php /* ?>
        <?php
        switch ($_SESSION['kt_login_level']) {
        case '7':
        include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header-agente.php' );
        break;
        case '8':
        include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header-empleado.php' );
        break;
        default:
        include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header-admin.php' );
        break;
        }
        ?>
        <?php */ ?>

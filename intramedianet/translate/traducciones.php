<?php

error_reporting(E_ALL);
ini_set("display_errors", 0);

// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the common classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

// Make unified connection variable
$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_inmoconn, "../../");
//Grand Levels: Level
$restrict->addLevel("10");
$restrict->addLevel("9");
$restrict->addLevel("8");
$restrict->addLevel("7");
$restrict->Execute();
//End Restrict Access To Page

if(@isset($_GET['lang']) && $_GET['lang'] != '' && $_GET['lang'] != $language) {
    $urlStart = '/' . $_GET['lang'] . '/';
} else {
    $urlStart = '/';
}

$langStrEnd = array();

include( $_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$_GET['lang'].".php");


if($_SERVER['REQUEST_METHOD'] == "POST") {

    require_once($_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$_GET['lang'].".php");
    $langStrEnd = array_merge($langStr, $_POST);

    $ret = '';
    $ret .= "<?php\n";
    foreach($_POST as $key => $value) {
        if($key != 'update') {
            $key = str_replace('_', ' ', (string)$key);
            // $ret .= '$langStr["'.$key.'"] = "'. $value .'";'."\n";
            if (in_array($key, array("NombreMeses", "NombreMesesCortos", "NombreDias", "NombreDiasCortos"))) {
                $ret .= '$langStr["'.(string)$key.'"] = \''. stripslashes($value).'\';'."\n";
            } else {
                $value = str_replace('"', '\"', stripslashes($value));
                $ret .= '$langStr["'.(string)$key.'"] = "'. $value .'";'."\n";
            }
        }
    }
    $ret .= "?>";

    // print_r($_POST);
    // echo $ret;
    // die();

    // $myFile = $_SERVER["DOCUMENT_ROOT"] . "/resources/lang_".$_GET['lang'].".php";
    // $fh = fopen($myFile, 'w') or die("no se puede abrir el archivo de idioma");
    // fwrite($fh, $ret);
    // fclose($fh);

    header("Location: traducciones.php?lang=".$_GET['lang']."&u=ok2");

}

if ( isset($_GET['u']) && $_GET['u'] == 'ok2') {
    sleep(4);
    header("Location: traducciones.php?lang=".$_GET['lang']."&u=ok");
}

function output_file($file, $name, $mime_type='')
{
 /*
 This function takes a path to a file to output ($file),
 the filename that the browser will see ($name) and
 the MIME type of the file ($mime_type, optional).

 If you want to do something on download abort/finish,
 register_shutdown_function('function_name');
 */
 if(!is_readable($file)) die('File not found or inaccessible!');

 $size = filesize($file);
 $name = rawurldecode($name);

 /* Figure out the MIME type (if not specified) */
 $known_mime_types=array(
    "pdf" => "application/pdf",
    "txt" => "text/plain",
    "html" => "text/html",
    "htm" => "text/html",
    "exe" => "application/octet-stream",
    "zip" => "application/zip",
    "doc" => "application/msword",
    "xls" => "application/vnd.ms-excel",
    "ppt" => "application/vnd.ms-powerpoint",
    "gif" => "image/gif",
    "png" => "image/png",
    "jpeg"=> "image/jpg",
    "jpg" =>  "image/jpg",
    "php" => "text/plain"
 );

 if($mime_type==''){
     $file_extension = strtolower(substr(strrchr($file,"."),1));
     if(array_key_exists($file_extension, $known_mime_types)){
        $mime_type=$known_mime_types[$file_extension];
     } else {
        $mime_type="application/force-download";
     };
 };

 @ob_end_clean(); //turn off output buffering to decrease cpu usage

 // required for IE, otherwise Content-Disposition may be ignored
 if(ini_get('zlib.output_compression'))
  ini_set('zlib.output_compression', 'Off');

 header('Content-Type: ' . $mime_type);
 header('Content-Disposition: attachment; filename="'.$name.'"');
 header("Content-Transfer-Encoding: binary");
 header('Accept-Ranges: bytes');

 /* The three lines below basically make the
    download non-cacheable */
 header("Cache-control: private");
 header('Pragma: private');
 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

 // multipart-download and download resuming support
 if(isset($_SERVER['HTTP_RANGE']))
 {
    list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
    list($range) = explode(",",$range,2);
    list($range, $range_end) = explode("-", $range);
    $range=intval($range);
    if(!$range_end) {
        $range_end=$size-1;
    } else {
        $range_end=intval($range_end);
    }

    $new_length = $range_end-$range+1;
    header("HTTP/1.1 206 Partial Content");
    header("Content-Length: $new_length");
    header("Content-Range: bytes $range-$range_end/$size");
 } else {
    $new_length=$size;
    header("Content-Length: ".$size);
 }

 /* output the file itself */
 $chunksize = 1*(1024*1024); //you may want to change this
 $bytes_send = 0;
 if ($file = fopen($file, 'r'))
 {
    if(isset($_SERVER['HTTP_RANGE']))
    fseek($file, $range);

    while(!feof($file) &&
        (!connection_aborted()) &&
        ($bytes_send<$new_length)
          )
    {
        $buffer = fread($file, $chunksize);
        print($buffer); //echo($buffer); // is also possible
        flush();
        $bytes_send += strlen($buffer);
    }
 fclose($file);
 } else die('Error - can not open file.');

die();
}



if(isset($_GET['dwn']) && $_GET['dwn'] == 'ok') {

    $ret = '';
    foreach($langStr as $key => $value) {
            $ret .= "\n$key\n\n\n---------------------------------------------------------------------------------------------------------------------------\n";
    }

    $myFile = "textos.txt";
    $fh = fopen($myFile, 'w') or die("no se puede abrir el archivo de traducción");
    fwrite($fh, $ret);
    fclose($fh);


    set_time_limit(0);
    output_file($myFile, 'textos-'.$_GET['lang'].'.txt', 'text/plain');

}

?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include("../includes/inc.head.php"); ?>

</head>

<body>

    <?php include("../includes/inc.header.php"); ?>

    <form method="post" id="form" action="traducciones.php?lang=<?php echo $_GET['lang'] ?>" class="needs-validation" novalidate>

        <div class="row">
            <div class="col-lg-12">
                <div class="card position-relative">
                    <div class="card-header align-items-center d-flex card-header-fix">
                        <h4 class="card-title mb-0 flex-grow-1"><i class="fa-regular fa-language"></i> <?php echo __('Traducciones'); ?></h4>
                        <div class="flex-shrink-0">
                            <button type="submit" name="update" value="<?php echo NXT_getResource("Update_FB"); ?>" class="btn btn-success btn-sm"><i class="fa-regular fa-floppy-disk fa-fw me-1"></i><span class="d-none d-lg-inline-block">  <?php echo NXT_getResource("Update_FB"); ?></span></button>
                            <a href="traducciones.php?lang=<?php echo $_GET['lang'] ?>&dwn=ok" class="btn btn-primary btn-sm"><i class="fa-regular fa-download me-1"></i> <?php __('Descargar texto para traductor'); ?></a>
                        </div>
                    </div>
                    <div class="card-body">

                        <?php if(@isset($_GET['u']) && $_GET['u'] == 'ok') { ?>
                        <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                            <i class="fa-regular fa-check label-icon"></i> <?php __('La traducción se ha actualizado correctamente'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss=" alert" aria-label="Close"></button>
                        </div>
                        <?php } ?>

                        <div class="d-none d-md-block">
                            <ul class="nav nav-tabs mb-3" role="tablist">
                                <?php foreach($languages as $value) { ?>
                                <li class="nav-item" role="presentation">
                                    <a href="traducciones.php?lang=<?php echo $value ?>" class="nav-link<?php if($value == $_GET['lang']) { ?> active<?php } ?>">
                                        <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value ?>.svg" alt="" style="height: 18px;">
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>

                        <ul class="nav nav-pills nav-custom nav-custom-light mb-3 d-md-none" role="tablist">
                            <?php foreach($languages as $value) { ?>
                            <li class="nav-item" role="presentation">
                                <a href="traducciones.php?lang=<?php echo $value ?>" class="nav-link<?php if($value == $_GET['lang']) { ?> active<?php } ?>">
                                    <img src="/intramedianet/includes/assets/imgs/flags/<?php echo $value ?>.svg" alt="" style="height: 18px;">
                                </a>
                            </li>
                            <?php } ?>
                        </ul>

                        <div class="tab-pane">

                            <div class="tab-pane">

                                <br>

                                <div class="row">

                                    <?php
                                    $cnt1 = 1;
                                    foreach($langStr as $key => $value) {
                                        if($key != 'xxxxxxx') { ?>
                                    <div class="col-md-6">
                                        <?php $value = str_replace('urlStart', 'xx', $value); ?>
                                        <div class="mb-4">
                                          <label for="<?php echo $key; ?>" class="form-label required"><?php echo $key; ?>:</label>
                                          <div class="controls">
                                              <textarea name="<?php echo $key; ?>" id="<?php echo $key; ?>" cols="50" rows="3" class="form-control required" required><?php echo $value; ?></textarea>
                                               <div class="invalid-feedback">
                                                   <?php __('Este campo es obligatorio.'); ?>
                                               </div>
                                          </div>
                                        </div>
                                    </div>
                                    <?php echo @$cnt1++%2==0 ? '</div><div class="row">' : ""; ?>
                                    <?php } } ?>

                                 </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </form>

    <?php include("../includes/inc.footer.php"); ?>

</body>
</html>

<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);


// Cargamos la conexión a MySql
include($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

// Cargamos los idiomas de la administración
include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php');

// Load the tNG classes
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php');

// Load the KT_back class
require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/nxt/KT_back.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/simple-xlsx/src/SimpleXLSX.php');

require_once('parsecsv.lib.php');


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

if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == __('Subir CSV', true)) {


        if (isset($_POST['operacion_csv']) && $_POST['operacion_csv'] != '' ) {
          $_SESSION['operacion_csv'] = implode(',', $_POST['operacion_csv']);
        }

        if (isset($_POST['provincia_csv']) && $_POST['provincia_csv'] != '' ) {
          $_SESSION['provincia_csv'] = implode(',', $_POST['provincia_csv']);
        }
        if (isset($_POST['ciudad_csv']) && $_POST['ciudad_csv'] != '' ) {
          $_SESSION['ciudad_csv'] = implode(',', $_POST['ciudad_csv']);
        } 

        if (isset($_POST['referencia_cli']) && $_POST['referencia_cli'] != '' ) {
            $_SESSION['referencia_csv'] = $_POST['referencia_cli'];
        }

        if (isset($_POST['b_precio_desde_cli']) && $_POST['b_precio_desde_cli'] != '' ) {
             $_SESSION['precio_desde_csv'] = $_POST['b_precio_desde_cli'];
        }
        if (isset($_POST['b_precio_hasta_cli']) && $_POST['b_precio_hasta_cli'] != '' ) {
             $_SESSION['precio_hasta_csv'] = $_POST['b_precio_hasta_cli'];
        }


        $_SESSION['idioma_csv'] = $_POST['idioma_cli'];
         


    if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
        $fileName = $_FILES['uploadedFile']['name'];
        $fileSize = $_FILES['uploadedFile']['size'];
        $fileType = $_FILES['uploadedFile']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = 'csv.' . $fileExtension;
        $allowedfileExtensions = array('csv');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = './upload/';
            $dest_path = $uploadFileDir . $newFileName;
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                header("Location: clients-import.php?step=2");
            }
        }
    }
}


if ($_GET['step'] == 2) {
    $file = $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/properties/upload/csv.csv';

    $csv = new parseCSV();
    $csv->encoding('UTF-16', 'UTF-8');
    $csv->delimiter = "\t";
    $csv->parse($file);



    // echo "<pre>";
    // print_r($csv->data);
    // echo "</pre>";
    // die();
}




$query_rsSales = "SELECT * FROM properties_status ORDER BY status_".$lang_adm."_sta ASC";
$rsSales = mysqli_query($inmoconn, $query_rsSales) or die(mysqli_error());
$row_rsSales = mysqli_fetch_assoc($rsSales);
$totalRows_rsSales = mysqli_num_rows($rsSales);


$query_rsProvincias = "
 SELECT DISTINCT

    properties_loc1.name_".$lang_adm."_loc1 ,
    CASE WHEN properties_loc2.name_".$lang_adm."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang_adm."_loc2 ELSE province1.name_".$lang_adm."_loc2  END AS name_".$lang_adm."_loc2,
    CASE WHEN properties_loc3.name_".$lang_adm."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang_adm."_loc3 ELSE areas1.name_".$lang_adm."_loc3  END AS name_".$lang_adm."_loc3,
    CASE WHEN properties_loc4.name_".$lang_adm."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang_adm."_loc4 ELSE towns.name_".$lang_adm."_loc4  END AS name_".$lang_adm."_loc4,
    CASE WHEN properties_loc2.id_loc2 IS NOT NULL THEN properties_loc2.id_loc2 ELSE province1.id_loc2  END AS id_loc2

FROM properties_loc4 towns LEFT OUTER  JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
    LEFT OUTER  JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3

    LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2

    LEFT OUTER  JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1

    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4

WHERE properties_properties.activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0

GROUP BY id_loc2

ORDER BY name_".$lang_adm."_loc1, name_".$lang_adm."_loc2 ASC
";
$rsProvincias = mysqli_query($inmoconn, $query_rsProvincias) or die(mysqli_error());
$row_rsProvincias = mysqli_fetch_assoc($rsProvincias);
$totalRows_rsProvincias = mysqli_num_rows($rsProvincias);


$query_rsZonas = "
 SELECT DISTINCT

    properties_loc1.name_".$lang_adm."_loc1 ,
    CASE WHEN properties_loc2.name_".$lang_adm."_loc2 IS NOT NULL THEN properties_loc2.name_".$lang_adm."_loc2 ELSE province1.name_".$lang_adm."_loc2  END AS name_".$lang_adm."_loc2,
    CASE WHEN properties_loc3.name_".$lang_adm."_loc3 IS NOT NULL THEN properties_loc3.name_".$lang_adm."_loc3 ELSE areas1.name_".$lang_adm."_loc3  END AS name_".$lang_adm."_loc3,
    CASE WHEN properties_loc4.name_".$lang_adm."_loc4 IS NOT NULL THEN properties_loc4.name_".$lang_adm."_loc4 ELSE towns.name_".$lang_adm."_loc4  END AS name_".$lang_adm."_loc4,
    CASE WHEN properties_loc3.id_loc3 IS NOT NULL THEN properties_loc3.id_loc3 ELSE areas1.id_loc3  END AS id_loc3

FROM properties_loc4 towns LEFT OUTER  JOIN properties_properties ON properties_properties.localidad_prop = towns.id_loc4
    LEFT OUTER  JOIN properties_loc3 areas1 ON towns.loc3_loc4 = areas1.id_loc3
    LEFT OUTER JOIN properties_loc3 ON areas1.parent_loc3 = properties_loc3.id_loc3

    LEFT OUTER  JOIN properties_loc2 province1 ON areas1.loc2_loc3 = province1.id_loc2
    LEFT OUTER JOIN properties_loc2 ON province1.parent_loc2 = properties_loc2.id_loc2

    LEFT OUTER  JOIN properties_loc1 ON province1.loc1_loc2 = properties_loc1.id_loc1

    LEFT OUTER JOIN properties_loc4 ON towns.parent_loc4 = properties_loc4.id_loc4

WHERE properties_properties.activado_prop = 1  AND alquilado_prop = 0 AND vendido_prop = 0

GROUP BY id_loc3

ORDER BY name_".$lang_adm."_loc1, name_".$lang_adm."_loc2, name_".$lang_adm."_loc3, name_".$lang_adm."_loc4 ASC
";
$rsZonas = mysqli_query($inmoconn, $query_rsZonas) or die(mysqli_error());
$row_rsZonas = mysqli_fetch_assoc($rsZonas);
$totalRows_rsZonas = mysqli_num_rows($rsZonas);


?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

    <?php include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.head.php'); ?>

</head>

<body>

<?php include($_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header.php'); ?>

    <div id="second-nav">
        <h1 class="pull-left"><i class="fa fa-users"></i> <span><?php __('Clientes'); ?></span></h1>
        <div class="btn-toolbar pull-right" role="toolbar">
            <a href="clients.php?KT_back=1" class="btn btn-default btn-sm"> <?php __('Volver'); ?> </a>
        </div>
    </div>

    <div id="main-content">

        <div class="container-fluid">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title"><?php __('Importar'); ?> <?php __('Clientes'); ?> FACEBOOK</h3>
                </div>

                <div class="panel-body">

                    <?php if ($_GET['step'] == '') : ?>

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">1 - <?php __('Subir archivo'); ?></h3>
                        </div>
                        <div class="panel-body">

                            <form action="clients-import.php" method="post" enctype="multipart/form-data">

                            <div class="row">
                                <div class="col-lg-7">
                                    
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                  <label for="idioma_cli"><?php __('Idioma'); ?>:</label>
                                                  <select name="idioma_cli" id="idioma_cli" class="form-control required">
                                                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                                                      <?php
                                                      if ($lang_adm == 'es') {
                                                          $idiomas = array('ca' => 'Catalán', 'da' => 'Danés', 'de' => 'Alemán', 'el' => 'Griego', 'en' => 'Inglés', 'es' => 'Español', 'fi' => 'Finlandés', 'fr' => 'Francés', 'is' => 'Islandés', 'it' => 'Italiano', 'nl' => 'Holandés', 'no' => 'Noruego', 'pt' => 'Portugués', 'ru' => 'Ruso', 'se' => 'Sueco', 'zh' => 'Chino', 'pl' => 'Polaco');
                                                      } else {
                                                          $idiomas = array('ca' => 'Catalan', 'da' => 'Danish', 'de' => 'German', 'el' => 'Greek', 'en' => 'English', 'es' => 'Spanish', 'fi' => 'Finnish', 'fr' => 'French', 'is' => 'Icelandic', 'it' => 'Italian', 'nl' => 'Dutch', 'no' => 'Norwegian', 'pt' => 'Portuguese', 'ru' => 'Russian', 'se' => 'Swedish', 'zh' => 'Chinese', 'pl' => 'Polish');
                                                      }
                                                      foreach ($languages as $value) {
                                                     
                                                          echo '<option value="'.$value.'">'.$idiomas[$value].'</option>';
                                                      }
                                                      ?>
                                                  </select>
                                            </div>
                                        </div>
                                         <div class="col-lg-6">

                                          <div class="control-group">
                                              <label for="operacion_csv"><?php __('Operación'); ?>:</label>
                                              <div>
                                                  <select name="operacion_csv[]" id="operacion_csv" class="select2" multiple="multiple" data-placeholder="<?php echo NXT_getResource("Select one..."); ?>">
                                                      <?php
                                                      do {
                                                      ?>
                                                      <option value="<?php echo $row_rsSales['id_sta']?>">
                                                        <?php echo $row_rsSales['status_'.$lang_adm.'_sta']?></option>
                                                      <?php
                                                      } while ($row_rsSales = mysqli_fetch_assoc($rsSales ));
                                                        $rows = mysqli_num_rows($rsSales );
                                                        if($rows > 0) {
                                                            mysqli_data_seek($rsSales , 0);
                                                          $row_rsSales = mysqli_fetch_assoc($rsSales );
                                                        }
                                                      ?>
                                                  </select>
                                              </div>
                                          </div>
                                      </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">

                                              <div class="form-group">
                                                  <label for="provincia_csv"><?php __('Provincia'); ?>:</label>
                                                  <select name="provincia_csv[]" id="provincia_csv" class="select2" multiple="multiple" data-placeholder="<?php echo NXT_getResource("Select one..."); ?>">
                                                      <?php
                                                      do 
                                                      {
                                                      ?>
                                                      <option value="<?php echo $row_rsProvincias['id_loc2']?>">
                                                            <?php echo $row_rsProvincias['name_'.$lang_adm.'_loc1']; ?> &raquo; <?php echo $row_rsProvincias['name_'.$lang_adm.'_loc2']; ?>
                                                        </option>
                                                      <?php
                                                      } while ($row_rsProvincias = mysqli_fetch_assoc($rsProvincias ));
                                                      $rows = mysqli_num_rows($rsProvincias );
                                                      if($rows > 0) {
                                                      mysqli_data_seek($rsProvincias , 0);
                                                      $row_rsProvincias = mysqli_fetch_assoc($rsProvincias );
                                                      }
                                                      ?>
                                                  </select>
                                                  
                                              </div>

                                        </div>
                                          <div class="col-lg-6">

                                            <div class="form-group">
                                                <label for="ciudad_csv"><?php __('Ciudad'); ?>:</label>
                                                <select name="ciudad_csv[]" id="ciudad_csv" class="select2" multiple="multiple" data-placeholder="<?php echo NXT_getResource("Select one..."); ?>">
                                                    <?php
                                                    do {
                                                    ?>
                                                    <option value="<?php echo $row_rsZonas['id_loc3']?>">
                                                        <?php echo $row_rsZonas['name_'.$lang_adm.'_loc1']; ?> &raquo; <?php echo $row_rsZonas['name_'.$lang_adm.'_loc2']; ?> &raquo; <?php echo $row_rsZonas['name_'.$lang_adm.'_loc3']; ?>
                                                    </option>
                                                    <?php
                                                    } while ($row_rsZonas = mysqli_fetch_assoc($rsZonas ));
                                                    $rows = mysqli_num_rows($rsZonas );
                                                    if($rows > 0) {
                                                    mysqli_data_seek($rsZonas , 0);
                                                    $row_rsZonas = mysqli_fetch_assoc($rsZonas );
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                          </div>

                                           <div class="col-md-6">

                                                <div class="form-group">
                                                    <label for="b_precio_desde_cli"><?php __('Precio desde'); ?>:</label>
                                                    <input type="text" name="b_precio_desde_cli" id="b_precio_desde_cli" value="" size="32" maxlength="255" class="form-control">
                                                    
                                                </div>

                                                <small class="help-block"><?php __('Sin puntos ni comas ni símbolos €') ?></small>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <label for="b_precio_hasta_cli"><?php __('Precio hasta'); ?>:</label>
                                                    <input type="text" name="b_precio_hasta_cli" id="b_precio_hasta_cli" value="" size="32" maxlength="255" class="form-control">
                                                    
                                                </div>
                                                <small class="help-block"><?php __('Sin puntos ni comas ni símbolos €') ?></small>
                                            </div>



                                          <div class="col-lg-6">
                                                <div class="form-group">
                                                          <label for="pasaporte_cli"><?php __('Referencia'); ?>:</label>
                                                          <input type="text" name="referencia_cli" id="referencia_cli" size="32" maxlength="255" class="form-control">
                                                      </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="uploadedFile"><?php __('Seleccionar CSV'); ?></label>
                                            <input type="file" name="uploadedFile" id="uploadedFile" class="">
                                        </div>
                                        <input type="submit" name="uploadBtn" value="<?php __('Subir CSV'); ?>" class="btn btn-success ">
                                </div>
                            </div>
                            
                            </form>

                        </div>
                    </div>


                    <?php endif ?>



                    <?php if ($_GET['step'] == 2) : ?>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">2 - <?php __('Importando datos'); ?></h3>
                        </div>
                        <div class="panel-body">
                              <?php
                              
                              $contador = 0;

                              foreach ( $csv->data as $r ) 
                              {

                                // var_dump($r);
                                $campoMail = '';
                                $campoNombre = '';
                                $campoPhone = '';

                                $campoMail = '';
                                $campoNombre = '';
                                $campoPhone = '';

                                if(isset($r['e-mail'])) //versión en francés
                                {
                                    $campoMail = $r['e-mail'];
                                }
                                else 
                                {
                                    if(isset($r['email']))
                                    {
                                        $campoMail = $r['email']; //versión en inglés
                                    }
                                }

                                if(isset($r['nom_complet']))
                                {
                                    $campoNombre = $r['nom_complet']; //versión en francés
                                }
                                else 
                                {
                                    if(isset($r['full_name']))
                                    {
                                        $campoNombre = $r['full_name']; //versión en inglés
                                    }
                                }                                

                                if(isset($r['numéro_de_téléphone']))
                                {
                                    $campoPhone = $r['numéro_de_téléphone']; //versión en francés
                                }
                                else 
                                {
                                    if(isset($r['phone_number']))
                                    {
                                        $campoPhone = $r['phone_number']; //versión en inglés
                                    }
                                }


                                
                                $query_rsClientes = "SELECT id_cli FROM properties_client WHERE email_cli  = '".$campoMail."' OR skype_cli  = '".$campoMail."'";
                                $rsClientes = mysqli_query($inmoconn, $query_rsClientes) or die(mysqli_error());
                                $row_rsClientes = mysqli_fetch_assoc($rsClientes);
                                $totalRows_rsClientes = mysqli_num_rows($rsClientes);

                                if ($totalRows_rsClientes == 0 && $campoMail != '') 
                                {

                                    if($_SESSION['idioma_csv'] != '')
                                    {
                                        $langCli = $_SESSION['idioma_csv'];
                                    }
                                    else
                                    {
                                         //idioma por defecto Inglés.
                                        $langCli = 'En';
                                    }

                                    // Insertar en cliente:
                                    $query = "INSERT INTO properties_client SET ";
                                    $query .= "nombre_cli = '" . trim(mysqli_real_escape_string($inmoconn,$campoNombre)) . "', ";
                                    $query .= "idioma_cli = '" . $langCli  . "', ";
                                    $query .= "telefono_fijo_cli = '" . trim(mysqli_real_escape_string($inmoconn,str_replace("p:", "", $campoPhone))) . "', ";

                                    if($_SESSION['operacion_csv'] != '')
                                        $query .= "b_sale_cli = '" . $_SESSION['operacion_csv']. "', ";
                                    
                                    if($_SESSION['provincia_csv'] != '')
                                        $query .= "b_loc2_cli = '" . $_SESSION['provincia_csv']. "', ";

                                    if($_SESSION['ciudad_csv'] != '')
                                        $query .= "b_loc3_cli = '" . $_SESSION['ciudad_csv']. "', ";

                                    $query .= "fecha_alta_cli = '" . date("Y-m-d h:i", strtotime($r['created_time'])) . "', ";
                                    $query .= "email_cli = '" . trim(mysqli_real_escape_string($inmoconn,$campoMail)) . "', ";

                                    if($_SESSION['precio_desde_csv'] != '')
                                        $query .= "b_precio_desde_cli = '" . (int)trim(mysqli_real_escape_string($inmoconn,$_SESSION['precio_desde_csv'])) . "', ";

                                    if($_SESSION['precio_hasta_csv'] != '')
                                        $query .= "b_precio_hasta_cli = '" . (int)trim(mysqli_real_escape_string($inmoconn,$_SESSION['precio_hasta_csv'])) . "', ";
                                    


                                    $historial = "Form name: " . trim(mysqli_real_escape_string($inmoconn,$r['form_name']));

                                    if($_SESSION['referencia_csv'] != '')
                                            $historial .= "\n\r Ref: " . trim(mysqli_real_escape_string($inmoconn,$_SESSION['referencia_csv']));

                                    $query .= "historial_cli = '".$historial."', ";
           

                                    $query .= "como_nos_conocio_cli = '4' ";

                                    //echo $query . '<hr>';
                                    //die();

                                    
                                    $rsInsert = mysqli_query($inmoconn,$query) or die(mysqli_error());



                                    // $id = mysqli_insert_id($inmoconn);

                                    // en caso de tener newsletter 

                                    // require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/acumbamail/acumbamail.class.php');
                                    // if ($r['email'] != '') {
                                    //     $acumba = new AcumbamailAPI($keyAcumbamail);
                                    //     $acumba->addSubscriber($acumbamailIdListaClients[$langCli], array('email'  => trim(mysqli_real_escape_string($r['email'])) ));
                                    // }
                            


                                    $contador++; 

                                } else {
                                    echo "<p>".$campoMail.": ".__('ya existe en la base de datos', true)."</p>";
                                }

                              }
                            echo "<hr>".$contador." ".__('Clientes', true);
                            echo "<hr>".__('La importación ha finalizado correctamente.', true);
                            unset($_SESSION['ciudad_csv']);
                            unset($_SESSION['provincia_csv']);
                            unset($_SESSION['operacion_csv']);
                            unset($_SESSION['idioma_csv']);
                            unset($_SESSION['referencia_csv']);
                            unset($_SESSION['precio_desde_csv']);
                            unset($_SESSION['precio_hasta_csv']);


                              ?>
                        </div>
                    </div>
                    <?php endif ?>


                </div>

            </div>

        </div> <!--/.container-fluid -->

    </div> <!--#main-content -->

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

</body>
</html>

<?php
// Cargamos la conexión a MySql
include_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include_once( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

// Load the tNG classes
require_once( $_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php' );

// Make unified connection variable
$conn_inmoconn = new KT_connection($inmoconn, $database_inmoconn);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_inmoconn, "../../");
//Grand Levels: Level
$restrict->addLevel("10");
$restrict->addLevel("9");
$restrict->Execute();
//End Restrict Access To Page
if ($_GET['del'] != '') {
    unlink('./' . $_GET['del']);
    header("Location: backup.php");
}

/* backup the db OR just a table */
function backup_tables($host,$user,$pass,$name,$tables = '*')
{

    $link = mysqli_connect($host,$user,$pass,$name);

    //get all of the tables
    if($tables == '*')
    {
        $tables = array();
        $result = mysqli_query($link, 'SHOW TABLES');
        while($row = mysqli_fetch_row($result))
        {
            $tables[] = $row[0];
        }
    }
    else
    {
        $tables = is_array($tables) ? $tables : explode(',',$tables);
    }

    $return .= "SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";\n";
    $return .= "SET time_zone = \"+00:00\";\n\n";

    $return .= "/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\n";
    $return .= "/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\n";
    $return .= "/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\n";
    $return .= "/*!40101 SET NAMES utf8 */;\n\n";

    //cycle through
    foreach($tables as $table)
    {
        $result = mysqli_query($link, 'SELECT * FROM '.$table);
        $num_fields = mysqli_num_fields($result);

        $return.= 'DROP TABLE '.$table.';';
        $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE '.$table));
        $return.= "\n\n".$row2[1].";\n\n";

        for ($i = 0; $i < $num_fields; $i++)
        {
            while($row = mysqli_fetch_row($result))
            {
                $return.= 'INSERT INTO '.$table.' VALUES(';
                for($j=0; $j<$num_fields; $j++)
                {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = preg_replace("/\n/", "\\n", $row[$j]);
                    if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                    if ($j<($num_fields-1)) { $return.= ','; }
                }
                $return.= ");\n";
            }
        }
        $return.="\n\n\n";
    }

    //save file
    $handle = fopen('backup/db-backup-'.date("d-m-Y-H-i-s").'.sql','w+');
    fwrite($handle,$return);
    fclose($handle);
}

function formatBytes($bytes, $precision = 2) {

    //CHECK TO MAKE SURE A NUMBER WAS SENT
    if(!empty($bytes)) {

        //SET TEXT TITLES TO SHOW AT EACH LEVEL
        $s = array('bytes', 'kb', 'MB', 'GB', 'TB', 'PB');
        $e = floor(log($bytes)/log(1024));

        //CREATE COMPLETED OUTPUT
        $output = sprintf('%.2f '.$s[$e], ($bytes/pow(1024, floor($e))));

        //SEND OUTPUT TO BROWSER
        return $output;

    }
}

$mensa = '';
if ($_GET['b'] == 'ok') {
    backup_tables($hostname_inmoconn, $username_inmoconn, $password_inmoconn, $database_inmoconn);
    header("Location: backup.php?back=ok");
}

?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

  <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.head.php' ); ?>

</head>

<body>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header.php' ); ?>

    <div id="second-nav">
        <h1 class="pull-left"><i class="fa fa-database"></i> <span><?php __('Exportar Base de Datos'); ?></span></h1>
        <div class="btn-toolbar pull-right" role="toolbar">
            <a href="/intramedianet/xml/backup.php?b=ok" class="btn btn-success btn-sm"><?php __('Exportar Base de Datos'); ?></a>
        </div>
    </div>

    <div id="main-content">

        <div class="container-fluid">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title"><?php __('Exportar Base de Datos'); ?></h3>
                </div>

                <div class="panel-body">

                    <?php if($_GET['back'] == 'ok') { ?>
                    <div class="alert alert-success fade in">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                      <?php __('El backup se ha creado correctamente'); ?>.
                    </div>
                    <?php } ?>

                    <?php

                    $myDirectory = opendir("backup");

                    while($entryName = readdir($myDirectory)) {
                        $dirArray[] = $entryName;
                    }

                    closedir($myDirectory);

                    $indexCount   = count($dirArray);

                    rsort($dirArray);

                    if (substr($dirArray[0], 0, 1) != ".") {

                        print("<div id=\"records-tables_wrapper\" class=\"dataTables_wrapper form-inline dt-bootstrap no-footer\"><div class=\"row\"><div class=\"col-sm-12 table-responsive\"><table class=\"table table-striped table-bordered dataTable\" id=\"records-tables\">\n");

                        print("<thead><tr role=\"row\"><th class=\"sorting_disabled\">".__('Nombre', true)."</th><th class=\"sorting_disabled\">".__('Tamaño', true)."</th><th class=\"actions\" id=\"actions\"></th></tr></thead><tbody>\n");

                        for($index=0; $index < $indexCount; $index++) {
                            if (substr("$dirArray[$index]", 0, 1) != "."){ // don't list hidden files
                                print("<tr><td><a href=\"backup/$dirArray[$index]\" target=\"_blank\" class=\"btn btn-default\"><i class=\"fa fa-download\"></i> $dirArray[$index]</a></td>");
                                print("<td>");
                                print(formatBytes(filesize('backup/'.$dirArray[$index])));
                                print("</td>");
                                print("<td class=\"actions\">");
                                print("<a href=\"/intramedianet/xml/backup.php?del=backup/$dirArray[$index]\" target=\"_blank\" class=\"btn btn-danger btn-sm delrow\"><i class=\"fa fa-trash-o\"></i></a>");
                                print("</td>");
                                print("</tr>\n");
                            }
                        }
                        print("</tbody></table></div></div></div>\n");

                    } else {
                        __('No hay backups que mostrar');
                    }

                    ?>

                </div>

            </div>

        </div> <!--/.container-fluid -->

    </div> <!--#main-content -->

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

</body>
</html>

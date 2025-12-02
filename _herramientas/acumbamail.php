<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

set_time_limit(0);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/acumbamail/acumbamail.class.php');

if ($_GET['tablas'] != '') {
    if ($_GET['tablas'] == 'compradores') {
        
        $query_rsExport = "SELECT * FROM properties_client";
        $rsExport = mysqli_query($inmoconn,$query_rsExport) or die(mysqli_error());
        $row_rsExport = mysqli_fetch_assoc($rsExport);
        $totalRows_rsExport = mysqli_num_rows($rsExport);
        if ($totalRows_rsExport > 0) {
            do {
                if ($row_rsExport['email_cli'] != '' && $row_rsExport['idioma_cli'] != '' && $row_rsExport['newsletter_cli'] == 1) {
                    $acumba = new AcumbamailAPI($keyAcumbamail);
                    $acumba->addSubscriber($acumbamailIdListaClients[$row_rsExport['idioma_cli']], array(
                        'email'  => $row_rsExport['email_cli'],
                        'nombre'  => $row_rsExport['nombre_cli']
                    ));
                    
                    $query_rsUpdate = "UPDATE properties_client SET newsletter_cli = 1 WHERE id_cli = '".$row_rsExport['id_cli']."'";
                    $rsUpdate = mysqli_query($inmoconn,$query_rsUpdate) or die(mysqli_error());
                }
            } while ($row_rsExport = mysqli_fetch_assoc($rsExport));
            $mensa = 'ok';
        }
    } else {
        
        $query_rsExport = "SELECT * FROM properties_owner";
        $rsExport = mysqli_query($inmoconn,$query_rsExport) or die(mysqli_error());
        $row_rsExport = mysqli_fetch_assoc($rsExport);
        $totalRows_rsExport = mysqli_num_rows($rsExport);
        if ($totalRows_rsExport > 0) {
            do {
                if ($row_rsExport['email_pro'] != '' && $row_rsExport['idioma_pro'] != '' && $row_rsExport['newsletter_pro'] == 1) {
                    $acumba = new AcumbamailAPI($keyAcumbamail);
                    $acumba->addSubscriber($acumbamailIdListaOwners[$row_rsExport['idioma_pro']], array(
                        'email'  => $row_rsExport['email_pro'],
                        'nombre'  => $row_rsExport['nombre_pro']
                    ));
                    
                    $query_rsUpdate = "UPDATE properties_owner SET newsletter_pro = 1 WHERE id_pro = '".$row_rsExport['id_pro']."'";
                    $rsUpdate = mysqli_query($inmoconn,$query_rsUpdate) or die(mysqli_error());
                }
            } while ($row_rsExport = mysqli_fetch_assoc($rsExport));
            $mensa = 'ok';
        }
    }
}

$acumba = new AcumbamailAPI($keyAcumbamail);
$listas = $acumba->getLists();
krsort($listas);

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Acumbamail</title>
</head>

<body>
    <form action="acumbamail.php" method="get">
      <div class="container mt-5">
          <?php if ($mensa == 'ok'): ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  La exportación se ha realizado correctamente.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
          <?php endif ?>
          <hr>
          <div class="row">
              <div class="col">
                  <legend class="mb-0">Exportar a Acumbamail</legend>
              </div>
          </div>
          <hr>
          <div class="row">
              <div class="col-lg-9">
                  <div class="form-group mb-0">
                      <select name="tablas" id="tablas" class="form-control">
                          <option value="compradores" <?php if ('compradores' == $_GET['tablas']): ?>selected<?php endif ?>>Exportar compradores</option>
                          <option value="vendedores" <?php if ('vendedores' == $_GET['tablas']): ?>selected<?php endif ?>>Exportar vendedores</option>
                      </select>
                  </div>
              </div>
              <div class="col-lg-3">
                  <div class="form-group mb-0">
                      <button type="submit" class="btn btn-success form-control">Empezar</button>
                  </div>
              </div>
          </div>
          <hr>
      </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>

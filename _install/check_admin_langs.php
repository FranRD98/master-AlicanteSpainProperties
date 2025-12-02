
<!DOCTYPE html>
    <html>
    <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>Setup Check</title>
            <link rel="stylesheet" href="/css/check/css/bootstrap.min.css">
    </head>
    <body>

    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <div class="page-header">
                  <h1>Check <small>idiomas de la administración</small></h1>
                </div>

                <ul class="list-group">
                      <?php
                      $i = 0;
                      $enKeys = array();

                      include( $_SERVER["DOCUMENT_ROOT"] . "/intramedianet/includes/resources/lang_en.php");

                      foreach($lang as $key => $value) {
                          $enKeys[$key] = $key;
                      }

                      include( $_SERVER["DOCUMENT_ROOT"] . "/intramedianet/includes/resources/lang_es.php");

                      foreach($lang as $key => $value) {
                          if ($key != $enKeys[$key] && $key != 'xxxxxxxx') {
                              echo '<li class="list-group-item">' . $key . '</li>';
                              $i++;
                          }
                      }

                      if ($i == 0) {
                          echo '<li class="list-group-item text-success"><span class="lead">Todos las entradas están traducidas</span></li>';
                      }

                      ?>
                </ul>

            </div>

        </div>

    </div>

    </body>

</html>
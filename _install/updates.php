<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/_install/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.12.0/build/styles/default.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

    <style type="text/css">
       body {
            padding: 20px;
            background: #f9f9f9;
            font-family: 'Open Sans', sans-serif !important;
            font-size: 14px;
        }
        hr {
            margin: 20px 0;
            border-width: 3px;
        }
        .leyenda hr {
            margin: 5px 0;
            border-width: 1px;
        }
        .list-group-item i, .searchable i, .ver-index i, .leyenda i, .content .card-header i {
            margin-right: 5px;
            padding-right: 10px;
            border-right: 1px solid #D9DADA;
            margin-left: 5px;
            padding-left: 10px;
            border-left: 1px solid #D9DADA;
        }
        .list-group-item i {
            margin-left: 0;
            padding-left: 0;
            border-left: 0;
        }
        .list-group-item span {
            font-size: 8px;
            font-weight: 600;
        }
        .searchable li, .ver-index li {
            margin: 5px 0;
        }
        .badge {
            text-transform: uppercase;
            font-weight: 300;
            padding: 7px 10px;
        }
        .badge i {
            margin-right: 5px;
        }
        ol {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        ol li {
            counter-increment: step-counter;
            border-bottom: 1px solid rgba(40,43,46,.1);
            padding: 0 10px 5px;
            margin-bottom: 0;
        }
        ol li:last-child {
            border-width: 0px;
        }
        ol.searchable li {
            border-bottom: 1px solid rgba(40,43,46,.1);
            margin-bottom: 0;
        }
        ol.searchable li:last-child {
            border-width: 0px;
        }
        ol li::before {
          position: relative;
          top: -2px;
          content: counter(step-counter);
          margin-right: 10px;
          margin-top: 0;
          font-size: 70%;
          background-color: #282b2e;
          background-color: rgba(40,43,46,.4);
          color: white;
          font-weight: 500;
          padding: 1px 0;
          border-radius: 4px;
          display: inline-block;
          width: 30px;
          text-align: center;
        }
        ol li a {
            text-decoration: none !important;
        }
        /*CODE HIGHLIGHT */
        pre {
            margin: 0 !important;
            height: auto !important;
            line-height: .5em !important;
        }
        .hljs {
          color: #a9b7c6;
          background: #282b2e;
          border-radius: 4px;
          display: block;
          overflow-x: auto;
          padding: 0 20px;
          margin: 0;
          line-height: 1.3em;
        }

        .hljs-number,
        .hljs-literal,
        .hljs-symbol,
        .hljs-bullet {
          color: #6897BB;
        }

        .hljs-keyword,
        .hljs-selector-tag,
        .hljs-deletion {
          color: #cc7832;
        }

        .hljs-variable,
        .hljs-template-variable,
        .hljs-link {
          color: #629755;
        }

        .hljs-comment,
        .hljs-quote {
          color: #808080;
        }

        .hljs-meta {
          color: #bbb529;
        }

        .hljs-string,
        .hljs-attribute,
        .hljs-addition {
          color: #6A8759;
        }

        .hljs-section,
        .hljs-title,
        .hljs-type {
          color: #ffc66d;
        }

        .hljs-name,
        .hljs-selector-id,
        .hljs-selector-class {
          color: #e8bf6a;
        }

        .hljs-emphasis {
          font-style: italic;
        }

        .hljs-strong {
          font-weight: bold;
        }
    </style>

    <title>Updates</title>
  </head>
  <body>
    <div class="container-fluid border rounded bg-white ">
        <div class="row">
            <div class="col-md-3 p-3">
                <div class="nav list-group">
                    <a class="list-group-item <?php if ($_GET['v'] == ''): ?>active<?php endif ?>" href="/_install/updates.php">
                        <i class="far fa-list-ol"></i> Resumen
                    </a>
                    <?php
                    $path = $_SERVER["DOCUMENT_ROOT"] . '/_install/Updates';
                    $files = array_diff(scandir($path), array('.', '..'));
                    $i = 0;
                    ?>
                    <?php foreach (array_reverse($files) as $file) { ?>
                        <?php if (preg_match('/\.php/', $file) && !preg_match('/index\.php/', $file)): ?>
                            <a class="list-group-item <?php if ($file == @$_GET['v']): ?>active<?php endif ?>" href="/_install/updates.php?v=<?php echo $file; ?>">
                                <i class="fas fz-fw fa-code-branch"></i> <?php echo preg_replace(array('/\.php/', '/Updates-/'), array('', 'Versión: '), $file); ?>
                                <?php if ($file == @$_GET['v']): ?>
                                    <?php $version = preg_replace(array('/\.php/', '/Updates-/'), '', $file); ?>
                                <?php endif ?>
                                <?php
                                $content = file_get_contents($path . '/' . $file);
                                $doc = new DOMDocument();
                                $doc->loadHTML($content);
                                $doc->validateOnParse = true;
                                $txtTime = $doc->getElementById("proy-time")->textContent;
                                ?>
                                <!-- <?php if ($txtTime != 'Tiempo total estimado: una eternidad...'): ?>
                                    <span class="badge badge-secondary badge-pill float-right"><?php echo preg_replace(array('/Tiempo total estimado: /'), '', $txtTime); ?></span>
                                <?php endif ?> -->
                                <?php $i++; ?>
                            </a>
                        <?php endif ?>
                    <?php } ?>
                </div>
                <?php if ($version != '001' && $version != '002'): ?>
                <hr>
                <div class="alert alert-warning" role="alert" style="font-size: 12px;">
                    <i class="fas fa-exclamation-circle"></i> Recuerda remplazar la versión del archivo: <b>/versions.md</b>, por la versión: <b><?php echo $version; ?></b>
                </div>
                <?php endif ?>
                <hr>
                <div class="border rounded p-2 bg-light text-uppercase leyenda">
                    <small>
                        <i class="fas fa-bug text-danger"></i> &nbsp;&nbsp; Error
                        <hr>
                        <i class="fas fa-plus-circle text-success"></i> &nbsp;&nbsp; Mejora
                    </small>
                </div>
            </div>
            <div class="col-md-9 p-3">
                <?php if ($_GET['v'] != ''): ?>
                    <div class="content">
                        <?php $i = 0; ?>
                        <?php foreach (array_reverse($files) as $file) { ?>
                            <?php if ($file == @$_GET['v'] || (@$_GET['v'] == '' && $i++ == 0)): ?>
                                <?php
                                $txt = file_get_contents($path . '/' . $file);
                                echo preg_replace(array('/Master-/'), array('Versión: '),$txt);
                                ?>
                            <?php endif ?>
                        <?php } ?>
                    </div>
                <?php else: ?>
                    <div class="content-index">
                        <div class="card bg-light p-2">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" placeholder="Filtrar..." aria-label="Filtrar..." name="q" id="q">
                                    <div class="input-group-append">
                                        <button class="btn btn-danger reset-filter" type="button"> <i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                        </div>
                        <br>
                        <?php $i = 0; ?>
                        <?php foreach (array_reverse($files) as $file) { ?>
                            <?php if (preg_match('/\.index/', $file)): ?>
                                <?php
                                $txt = file_get_contents($path . '/' . $file);
                                echo preg_replace(array('/Master-/'), array('Versión: '),$txt);
                                ?>
                            <?php endif ?>
                        <?php } ?>
                    </div>

                <?php endif ?>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script   src="https://code.jquery.com/jquery-3.3.1.min.js"   integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="   crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.12.0/build/highlight.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
    <script>

    $(document).ready(function () {
        jQuery('.toTop, .ver-index a').click(function(e){
            e.preventDefault();
            if ($(this).attr('href') != '#') {
                $('html, body').animate({scrollTop : $($(this).attr('href')).offset().top}, 500);
            } else {
                $('html, body').animate({scrollTop : 0}, 500);
            }
            return false;
        });
    });
    (function ($) {
      jQuery.expr[':'].Contains = function(a,i,m){
          return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase())>=0;
      };
      function listFilter(list) {
        $('#q')
          .change( function () {
            var filter = $(this).val();
            if(filter) {
              $(list).find("a:not(:Contains(" + filter + "))").parent().slideUp('fast');
              $(list).find("a:Contains(" + filter + ")").parent().slideDown('fast');
            } else {
              $(list).find("li").slideDown();
            }
            return false;
          })
        .keyup( function () {
            $(this).change();
        });
      }
      $(function () {
        listFilter($(".searchable"));
      });
    }(jQuery));
    $('.reset-filter').click(function(e) {
        e.preventDefault();
        $('#q').val('').change();
    });
      </script>
  </body>
</html>
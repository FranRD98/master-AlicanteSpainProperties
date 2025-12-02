<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/conf/idiomas.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

function clean($text) {
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    return strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $text));
}

function getContents($str, $startDelimiter, $endDelimiter) {
  $contents = array();
  $startDelimiterLength = strlen($startDelimiter);
  $endDelimiterLength = strlen($endDelimiter);
  $startFrom = $contentStart = $contentEnd = 0;
  while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
    $contentStart += $startDelimiterLength;
    $contentEnd = strpos($str, $endDelimiter, $contentStart);
    if (false === $contentEnd) {
      break;
    }
    $contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
    $startFrom = $contentEnd + $endDelimiterLength;
  }
  return $contents;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Textos legales</title>
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
<head>
    <meta charset="UTF-8">
    <title>Textos legales</title>
</head>
<body>
    <div class="container-fluid border rounded bg-white ">
        <div class="row">
            <div class="col-md-3 p-3">

                <form method="POST">
                   <div class="form-group">
                      <select name="document" id="document" class="form-control form-control-sm">
                         <option value="">Seleccione un documento...</option>
                         <?php
                            $path = $_SERVER["DOCUMENT_ROOT"] . '/_herramientas/templates';
                            $files = array_diff(scandir($path), array('.', '..'));
                        ?>
                         <?php foreach ($files as $file) { ?>
                         <?php if (preg_match('/\.txt/', $file) && $file !== 'texto correos.txt'): ?>
                         <?php $sel = ($_GET['doc'] == $file) ? ' selected="selected"' : ''; ?>
                         <option value="<?php echo $file ?>" <?php echo $sel; ?>><?php echo ucfirst(str_replace(array('.txt', '_'), array('', ' '), $file)); ?></option>
                         <?php endif ?>
                         <?php } ?>
                      </select>
                      <?php if ($_GET['doc'] != '' && file_exists($_SERVER["DOCUMENT_ROOT"] . '/_herramientas/templates/' . $_GET['doc'])): ?>
                      <?php $doc_text = file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/_herramientas/templates/' . $_GET['doc']); ?>
                      <?php $doc_text = htmlentities($doc_text); ?>
                      <hr>
                      <?php $campos = getContents($doc_text, '@@', '@@'); ?>
                      <?php foreach (array_unique($campos) as $campo) { ?>
                      <?php $parts = explode('||', $campo) ?>
                      <div class="form-group">
                         <input type="text" class="form-control form-control-sm entrada-texto" name="<?php echo clean($parts[0]); ?>-txt" id="<?php echo clean($parts[0]); ?>-txt" placeholder="<?php echo $parts[0]; ?>">
                         <small class="form-text text-muted"><?php echo $parts[1]; ?></small>
                      </div>
                      <hr>
                      <?php $doc_text = str_replace('@@' . $campo . '@@', '<span class="' . clean($parts[0]) . '-span text-danger"></span>', $doc_text); ?>
                      <?php } ?>
                      <?php endif ?>
                   </div>
                   <?php if ($_GET['doc'] != '' && file_exists($_SERVER["DOCUMENT_ROOT"] . '/_herramientas/templates/' . $_GET['doc'])): ?>
                   <div class="form-group">
                      <input type="submit" class="btn btn-primary text-white" value="<?php if ($_GET['doc'] == 'texto correos.txt') {
                         echo 'Actualizar archivos';
                         } else {
                         echo 'Guardar texto';
                         }; ?>">
                   </div>
                   <?php endif ?>
                </form>
            </div>
            <div class="col-md-9 p-3">
                <?php if ($_GET['doc'] != '' && file_exists($_SERVER["DOCUMENT_ROOT"] . '/_herramientas/templates/' . $_GET['doc'])): ?>
                    <div class="card p-2">
                        <div class="card-bodyx card-body-txt">
                            <pre>
                                <code class="html">
<?php echo ($doc_text); ?>

                                </code>
                            </pre>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="lead">Selecciona un documento.</p>
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
        $('.entrada-texto').keyup(function () {
            $id = $(this).attr('id');
            $id = '.' + $id.replace('-txt', '-span');
            $($id).text($(this).val());
        });
        $('#document').change(function(e) {
            window.location = '/_herramientas/gdpr.php?doc=' + $(this).val();
        });
    </script>
</body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if ($_GET['doc'] != '' && file_exists($_SERVER["DOCUMENT_ROOT"] . '/_herramientas/templates/' . $_GET['doc'])) {
        $doc_text_final = file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/_herramientas/templates/' . $_GET['doc']);
        $doc_text_final = htmlentities($doc_text_final);
        $campos = getContents($doc_text_final, '@@', '@@');


        foreach (array_unique($campos) as $campo) {
            $parts = explode('||', $campo);


            $value = $_POST[clean($parts[0] . '-txt')];
            $doc_text_final = str_replace('@@' . $campo . '@@', $value, $doc_text_final);
        }


        $doc_text_final = html_entity_decode($doc_text_final);


        if ($_GET['doc'] == 'texto correos.txt') {
            // $templates = [
            //     $_SERVER["DOCUMENT_ROOT"] . '/includes/mailtemplates/template_acumba.html',
            //     $_SERVER["DOCUMENT_ROOT"] . '/includes/mailtemplates/template_semanal.html',
            //     $_SERVER["DOCUMENT_ROOT"] . '/includes/mailtemplates/template.html'
            // ];


            // foreach ($templates as $templatePath) {
            //   if (file_exists($templatePath)) {
            //         $templateContent = file_get_contents($templatePath);
            //         $updatedContent = str_replace('{AVISOLEGAL}', $doc_text_final, $templateContent);
            //         file_put_contents($templatePath, $updatedContent);
            //     }
            // }
        } else {


            $selected_document = $_GET['doc'];
            $document_ids = [
                'nota_legal.txt' => 10,
                'politica_privacidad.txt' => 12,
                'politica_cookies.txt' => 18
            ];


            if (array_key_exists($selected_document, $document_ids)) {
                $escaped_text = mysqli_real_escape_string($inmoconn, $doc_text_final);
                $content_lang_nws = "";
                foreach ($languages as $lang) {
                    $content_lang_nws .= "content_" . $lang . "_nws = '$escaped_text', ";
                }


                $content_lang_nws = rtrim($content_lang_nws, ', ');


                $id_nws = $document_ids[$selected_document];
                $query = "UPDATE news SET $content_lang_nws WHERE id_nws = $id_nws";


                mysqli_select_db($inmoconn, $database_inmoconn);
                $rTextInsert = mysqli_query($inmoconn, $query) or die(mysqli_error($inmoconn));
            }
        }
    }
}
?>
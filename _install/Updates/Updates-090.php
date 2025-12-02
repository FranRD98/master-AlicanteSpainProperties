<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 10-05-2022</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Añadidos videos y 360 a exportador fotocasa</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadidos videos y 360 a exportador fotocasa
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/fotocasa/fotocasaExportProperty.php:442
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
// EXPORTAR PLANOS
    $query_rsPlanos = &quot;SELECT * FROM properties_planos WHERE property_img = &apos;&quot;.$tNG-&gt;getColumnValue(&apos;id_prop&apos;).&quot;&apos; ORDER BY order_img&quot;;
    $rsPlanos = mysql_query($query_rsPlanos, $inmoconn) or die(mysql_error());
    $totalRows_rsPlanos = mysql_num_rows($rsPlanos);

    if( $totalRows_rsPlanos &gt; 0 ) {
        while ( $row_rsPlanos = mysql_fetch_assoc($rsPlanos) ) {
            $imgArr = array(
                &quot;TypeId&quot; =&gt; 23,
                &quot;Visible&quot; =&gt; 1,
                &quot;SortingId&quot; =&gt; $row_rsPlanos[&quot;order_img&quot;],
            );
            // A&#xd1;ADIMOS EL ALT COMO DESCRIPCI&#xd3;N SI existente
            if( isset($row_rsPlanos[&quot;alt_es_img&quot;]) &amp;&amp; $row_rsPlanos[&quot;alt_es_img&quot;] != &quot;&quot; ) {
                $imgArr[&quot;Description&quot;] = $row_rsPlanos[&quot;alt_es_img&quot;];
            }
            if ( preg_match(&quot;/https?:/&quot;, $row_rsPlanos[&quot;image_img&quot;]) ){
                $imgArr[&quot;Url&quot;] = $row_rsPlanos[&quot;image_img&quot;];
            } else {
                $imgArr[&quot;Url&quot;] = &apos;https://&apos;.$_SERVER[&apos;SERVER_NAME&apos;].&apos;/media/images/propertiesplanos/&apos;.$row_rsPlanos[&quot;image_img&quot;];
            }
            $ext = strtolower(pathinfo($row_rsPlanos[&apos;image_img&apos;], PATHINFO_EXTENSION));
            if( $ext == &quot;.&quot; || $ext == &quot;&quot;){
                $size = getimagesize($row_rsPlanos[&apos;image_img&apos;]);
                $ext = strtolower(str_replace(&apos;.&apos;,&apos;&apos;,image_type_to_extension($size[2])));
            }
            if( !isset($fotocasaFileType[$ext]) ){
                continue;
            }
            $imgArr[&quot;FileTypeId&quot;] = $fotocasaFileType[$ext];
            $export_fotocasa_fields_prop[&quot;PropertyDocument&quot;][] = $imgArr;
        };
    }
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
// EXPORTAR PLANOS
    $query_rsPlanos = &quot;SELECT * FROM properties_planos WHERE property_img = &apos;&quot;.$tNG-&gt;getColumnValue(&apos;id_prop&apos;).&quot;&apos; ORDER BY order_img&quot;;
    $rsPlanos = mysql_query($query_rsPlanos, $inmoconn) or die(mysql_error());
    $totalRows_rsPlanos = mysql_num_rows($rsPlanos);

    if( $totalRows_rsPlanos &gt; 0 ) {
        while ( $row_rsPlanos = mysql_fetch_assoc($rsPlanos) ) {
            $imgArr = array(
                &quot;TypeId&quot; =&gt; 23,
                &quot;Visible&quot; =&gt; 1,
                &quot;SortingId&quot; =&gt; $row_rsPlanos[&quot;order_img&quot;],
            );
            // A&#xd1;ADIMOS EL ALT COMO DESCRIPCI&#xd3;N SI existente
            if( isset($row_rsPlanos[&quot;alt_es_img&quot;]) &amp;&amp; $row_rsPlanos[&quot;alt_es_img&quot;] != &quot;&quot; ) {
                $imgArr[&quot;Description&quot;] = $row_rsPlanos[&quot;alt_es_img&quot;];
            }
            if ( preg_match(&quot;/https?:/&quot;, $row_rsPlanos[&quot;image_img&quot;]) ){
                $imgArr[&quot;Url&quot;] = $row_rsPlanos[&quot;image_img&quot;];
            } else {
                $imgArr[&quot;Url&quot;] = &apos;https://&apos;.$_SERVER[&apos;SERVER_NAME&apos;].&apos;/media/images/propertiesplanos/&apos;.$row_rsPlanos[&quot;image_img&quot;];
            }
            $ext = strtolower(pathinfo($row_rsPlanos[&apos;image_img&apos;], PATHINFO_EXTENSION));
            if( $ext == &quot;.&quot; || $ext == &quot;&quot;){
                $size = getimagesize($row_rsPlanos[&apos;image_img&apos;]);
                $ext = strtolower(str_replace(&apos;.&apos;,&apos;&apos;,image_type_to_extension($size[2])));
            }
            if( !isset($fotocasaFileType[$ext]) ){
                continue;
            }
            $imgArr[&quot;FileTypeId&quot;] = $fotocasaFileType[$ext];
            $export_fotocasa_fields_prop[&quot;PropertyDocument&quot;][] = $imgArr;
        };
    }
// EXPORTAR VIDEOS
    $query_rsVideos = &quot;SELECT * FROM properties_videos WHERE property_vid = &apos;&quot;.$tNG-&gt;getColumnValue(&apos;id_prop&apos;).&quot;&apos; ORDER BY order_vid&quot;;
    $rsVideos = mysql_query($query_rsVideos, $inmoconn) or die(mysql_error());
    $totalRows_rsVideos = mysql_num_rows($rsVideos);

    if( $totalRows_rsVideos &gt; 0 ) {
        while ( $row_rsVideos = mysql_fetch_assoc($rsVideos) ) {
            $imgArr = array(
                &quot;TypeId&quot; =&gt; 8,
                &quot;Visible&quot; =&gt; 1,
                &quot;SortingId&quot; =&gt; $row_rsVideos[&quot;order_vid&quot;],
            );
            $imgArr[&quot;Description&quot;] = &quot;video youtube&quot;;
            preg_match_all(&apos;/&lt;iframe[^&gt;]+src=([\&apos;&quot;])(?&lt;src&gt;.+?)\1[^&gt;]*&gt;/i&apos;, $row_rsVideos[&apos;video_vid&apos;], $result);
            $video = split(&apos;&amp;&apos;, $result[&apos;src&apos;][0]);
            $imgArr[&quot;Url&quot;] = echo str_replace(&quot;embed/&quot;,&quot;watch?v=&quot;, str_replace(&quot;?rel=0&quot;,&quot;&quot;, $video[0]));
            $imgArr[&quot;FileTypeId&quot;] = 17;
            $export_fotocasa_fields_prop[&quot;PropertyDocument&quot;][] = $imgArr;
        };
    }
// EXPORTAR 360
    $query_rs360 = &quot;SELECT * FROM properties_360 WHERE property_360 = &apos;&quot;.$tNG-&gt;getColumnValue(&apos;id_prop&apos;).&quot;&apos; ORDER BY order_360&quot;;
    $rs360 = mysql_query($query_rs360, $inmoconn) or die(mysql_error());
    $totalRows_rs360 = mysql_num_rows($rs360);

    if( $totalRows_rs360 &gt; 0 ) {
        while ( $row_rs360 = mysql_fetch_assoc($rs360) ) {
            $imgArr = array(
                &quot;TypeId&quot; =&gt; 7,
                &quot;Visible&quot; =&gt; 1,
                &quot;SortingId&quot; =&gt; $row_rs360[&quot;order_360&quot;],
            );
            $imgArr[&quot;Description&quot;] = &quot;tourvirtual&quot;;
            preg_match_all(&apos;/&lt;iframe[^&gt;]+src=([\&apos;&quot;])(?&lt;src&gt;.+?)\1[^&gt;]*&gt;/i&apos;, $row_rsVideos[&apos;video_360&apos;], $result);
            $imgArr[&quot;Url&quot;] = echo str_replace(&quot;embed/&quot;,&quot;watch?v=&quot;, str_replace(&quot;?rel=0&quot;,&quot;&quot;, $result[&apos;src&apos;][0]));
            $imgArr[&quot;FileTypeId&quot;] = 17;
            $imgArr[&quot;RoomTypeId&quot;] = 7;
            $export_fotocasa_fields_prop[&quot;PropertyDocument&quot;][] = $imgArr;
        };
    }
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

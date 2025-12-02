<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 13-01-2025</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec1"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadido nuevo sistema de exportación de Rightmove</a></li>
    </ol>
</div>

<div class="card">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadido nuevo sistema de exportación de Rightmove
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
Subimos la carpeta /intramedianet/properties/rightmove
            </code>
        </pre>
        <hr>
        Ejecutamos la query:
        <pre>
            <code class="sql">
ALTER TABLE `properties_properties` ADD COLUMN `export_rightmove_fields_prop` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL AFTER `export_rightmove_prop`
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/export-xml.php:72
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$rightmoveBranchId = &#039;000000000&#039;;
$rightmoveLimit = &#039;200&#039;;
$rightmoveFTP = &#039;ftp.rightmove.com&#039;;
$rightmoveFTPuser = &#039;mediaelx&#039;;
$rightmoveFTPpass = &#039;ZSAQJjjLp&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$rightmoveBranchId = &#039;&#039;;
$rightmoveNetworkId = &#039;13568&#039;;
$rightmove_cert = $_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/properties/rightmove/certs/mediaelxlive.pem&#039;;
$rightmove_cert_password = &#039;zKAEmALZc7&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:787
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
//end Trigger_Fotocasa_Fields trigger
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
//end Trigger_Fotocasa_Fields trigger

//start Trigger_Rightmove_Fields trigger
//remove this line if you want to edit the code by hand
function Trigger_Rightmove_Fields(&amp;$tNG) {
    $tNG-&gt;setColumnValue( &#039;export_rightmove_fields_prop&#039;, json_encode( $tNG-&gt;getColumnValue(&#039;export_rightmove_fields_prop&#039;) ) );
}
//end Trigger_Rightmove_Fields trigger
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:885
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
//end Trigger_CheckUnique trigger
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
//end Trigger_CheckUnique trigger

function sendRightmove($strJSON, $strURL, $strCertFile, $strCertPass, $boolDebug = false) {
    $resCurl = curl_init();

    if($boolDebug){
        curl_setopt($resCurl, CURLOPT_VERBOSE, 1);
    }

    curl_setopt($resCurl, CURLOPT_URL, $strURL);
    curl_setopt($resCurl, CURLOPT_CERTINFO, 1);
    curl_setopt($resCurl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($resCurl, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($resCurl, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($resCurl, CURLOPT_FAILONERROR, 1);
    curl_setopt($resCurl, CURLOPT_SSLCERT, $strCertFile);
    curl_setopt($resCurl, CURLOPT_SSLCERTTYPE, &#039;PEM&#039;);
    curl_setopt($resCurl, CURLOPT_SSLCERTPASSWD, $strCertPass);
    curl_setopt($resCurl, CURLOPT_POST, 1);
    curl_setopt($resCurl, CURLOPT_HTTPHEADER, array(&#039;Content-Type: application/json&#039;));
    curl_setopt($resCurl, CURLOPT_POSTFIELDS, $strJSON);
    $strResponse = curl_exec($resCurl);

    return json_decode($strResponse);
}

//start Trigger_Rightmove_Update trigger
//remove this line if you want to edit the code by hand
function Trigger_Rightmove_Update(&amp;$tNG) {

    global $database_inmoconn, $inmoconn, $languages, $rightmoveDatos, $rightmoveNetworkId, $rightmoveBranchId, $rightmove_ew_build_id, $rightmove_cert, $rightmove_cert_password;

    if ( $tNG-&gt;getColumnValue(&#039;export_rightmove_prop&#039;) ==  1 &amp;&amp;
         $tNG-&gt;getColumnValue(&#039;activado_prop&#039;) == 1 &amp;&amp;
         $tNG-&gt;getColumnValue(&#039;vendido_prop&#039;) == 0 &amp;&amp;
         $tNG-&gt;getColumnValue(&#039;reservado_prop&#039;) == 0 &amp;&amp;
         $tNG-&gt;getColumnValue(&#039;alquilado_prop&#039;) == 0
     ) {
        $export_rightmove_fields_prop = json_decode($tNG-&gt;getColumnValue(&#039;export_rightmove_fields_prop&#039;), true);
        ob_start();
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/properties/rightmove/properties-rightmove.php&#039;);
        $json = ob_get_contents();
        ob_end_clean();

        $result =  sendRightmove($json, &#039;https://adfapi.rightmove.co.uk/v1/property/overseassendpropertydetails&#039;, $rightmove_cert, $rightmove_cert_password, false);

        if ($result-&gt;success == 1) {
          $_SESSION[&#039;fc_statusRightmove&#039;] = $result-&gt;message;
        } else {
          $_SESSION[&#039;fc_statusRightmove&#039;] = $result-&gt;message;
        }
    } else {

        ob_start();
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/properties/rightmove/properties-rightmove-get.php&#039;);
        $json = ob_get_contents();
        ob_end_clean();

        $result =  sendRightmove($json, &#039;https://adfapi.rightmove.co.uk/v1/property/getbranchpropertylist&#039;, $rightmove_cert, $rightmove_cert_password, false);

        $deleteProp = 0;

        foreach ($result-&gt;property as $value) {
            if ($tNG-&gt;getColumnValue(&#039;referencia_prop&#039;) == $value-&gt;agent_ref) {
                $deleteProp = 1;
            }
        }

        if ($deleteProp == 1) {

            $export_rightmove_fields_prop = json_decode($tNG-&gt;getColumnValue(&#039;export_rightmove_fields_prop&#039;), true);

            ob_start();
            include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/properties/rightmove/properties-rightmove-remove.php&#039;);
            $json = ob_get_contents();
            ob_end_clean();

            $result =  sendRightmove($json, &#039;https://adfapi.rightmove.co.uk/v1/property/removeproperty&#039;, $rightmove_cert, $rightmove_cert_password, false);

            if ($result-&gt;success == 1) {
              $_SESSION[&#039;fc_statusRightmove&#039;] = $result-&gt;message;
            } else {
              $_SESSION[&#039;fc_statusRightmove&#039;] = $result-&gt;message;
            }
        }
    }
}
//end Trigger_Fotocasa_Update trigger

//start Trigger_Rightmove_Delete trigger
//remove this line if you want to edit the code by hand
function Trigger_Rightmove_Delete(&amp;$tNG) {

    global $database_inmoconn, $inmoconn, $languages, $rightmoveDatos, $rightmoveNetworkId, $rightmoveBranchId, $rightmove_ew_build_id, $rightmove_cert, $rightmove_cert_password;

    ob_start();
    include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/properties/rightmove/properties-rightmove-get.php&#039;);
    $json = ob_get_contents();
    ob_end_clean();

    $result =  sendRightmove($json, &#039;https://adfapi.rightmove.co.uk/v1/property/getbranchpropertylist&#039;, $rightmove_cert, $rightmove_cert_password, false);

    $deleteProp = 0;

    foreach ($result-&gt;property as $value) {
        if ($tNG-&gt;getColumnValue(&#039;referencia_prop&#039;) == $value-&gt;agent_ref) {
            $deleteProp = 1;
        }
    }

    if ($deleteProp == 1) {

        $export_rightmove_fields_prop = json_decode($tNG-&gt;getColumnValue(&#039;export_rightmove_fields_prop&#039;), true);

        ob_start();
        include($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/properties/rightmove/properties-rightmove-remove.php&#039;);
        $json = ob_get_contents();
        ob_end_clean();

        $result =  sendRightmove($json, &#039;https://adfapi.rightmove.co.uk/v1/property/removeproperty&#039;, $rightmove_cert, $rightmove_cert_password, false);

        if ($result-&gt;success == 1) {
          $_SESSION[&#039;fc_statusRightmove&#039;] = $result-&gt;message;
        } else {
          $_SESSION[&#039;fc_statusRightmove&#039;] = $result-&gt;message;
        }
    }

}
//end Trigger_Rightmove_Delete trigger
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1052
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($expYaencontre == 1) {
    $ins_properties_properties-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_Yaencontre_Fields&quot;, 10);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($expYaencontre == 1) {
    $ins_properties_properties-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_Yaencontre_Fields&quot;, 10);
}
if ($expRightmove == 1) {
    $ins_properties_properties-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_Rightmove_Fields&quot;, 7);
    $ins_properties_properties-&gt;registerTrigger(&quot;AFTER&quot;, &quot;Trigger_Rightmove_Update&quot;, 60);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1192
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($expRightmove == 1) {
$ins_properties_properties-&gt;addColumn(&quot;export_rightmove_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_rightmove_prop&quot;, &quot;0&quot;);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($expRightmove == 1) {
$ins_properties_properties-&gt;addColumn(&quot;export_rightmove_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_rightmove_prop&quot;, &quot;0&quot;);
$ins_properties_properties-&gt;addColumn(&quot;export_rightmove_fields_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;export_rightmove_fields_prop&quot;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1302
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($expYaencontre == 1) {
    $upd_properties_properties-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_Yaencontre_Fields&quot;, 10);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($expYaencontre == 1) {
    $upd_properties_properties-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_Yaencontre_Fields&quot;, 10);
}
if ($expRightmove == 1) {
$upd_properties_properties-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_Rightmove_Fields&quot;, 10);
$upd_properties_properties-&gt;registerTrigger(&quot;AFTER&quot;, &quot;Trigger_Rightmove_Update&quot;, 60);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1441
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($expRightmove == 1) {
$upd_properties_properties-&gt;addColumn(&quot;export_rightmove_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_rightmove_prop&quot;);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($expRightmove == 1) {
$upd_properties_properties-&gt;addColumn(&quot;export_rightmove_prop&quot;, &quot;CHECKBOX_1_0_TYPE&quot;, &quot;POST&quot;, &quot;export_rightmove_prop&quot;);
$upd_properties_properties-&gt;addColumn(&quot;export_rightmove_fields_prop&quot;, &quot;STRING_TYPE&quot;, &quot;POST&quot;, &quot;export_rightmove_fields_prop&quot;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1545
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ($expFotoCasa == 1) {
    $del_properties_properties-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_Fotocasa_Delete&quot;, 10);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if ($expFotoCasa == 1) {
    $del_properties_properties-&gt;registerTrigger(&quot;BEFORE&quot;, &quot;Trigger_Fotocasa_Delete&quot;, 10);
}
if ($expRightmove == 1) {
    $del_properties_properties-&gt;registerTrigger(&quot;AFTER&quot;, &quot;Trigger_Rightmove_Delete&quot;, 10);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:1377
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;!-- RESPUESTA FOTOCASA --&gt;
&lt;?php if (isset($_SESSION[&#039;fc_status&#039;]) &amp;&amp; $_SESSION[&#039;fc_status&#039;] != &#039;&#039;) { ?&gt;
    &lt;div class=&quot;alert alert-&lt;?php if($_SESSION[&#039;fc_status&#039;][&quot;StatusCode&quot;] &gt;= 300){echo &quot;danger&quot;;}else{ echo &quot;success&quot;;} ?&gt; alert-dismissible alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
        &lt;i class=&quot;fa-regular fa-circle-&lt;?php if($_SESSION[&#039;fc_status&#039;][&quot;StatusCode&quot;] &gt;= 300){echo &quot;exclamation&quot;;}else{ echo &quot;check&quot;;} ?&gt; label-icon&quot;&gt;&lt;/i&gt; Fotocasa: &lt;?php echo __($_SESSION[&#039;fc_status&#039;][&quot;Message&quot;],1) ?&gt;
        &lt;button type=&quot;button&quot; class=&quot;btn-close&quot; data-bs-dismiss=&quot;alert&quot; aria-label=&quot;Close&quot;&gt;&lt;/button&gt;
    &lt;/div&gt;
    &lt;?php unset($_SESSION[&#039;fc_status&#039;]); ?&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;!-- RESPUESTA FOTOCASA --&gt;
&lt;?php if (isset($_SESSION[&#039;fc_status&#039;]) &amp;&amp; $_SESSION[&#039;fc_status&#039;] != &#039;&#039;) { ?&gt;
    &lt;div class=&quot;alert alert-&lt;?php if($_SESSION[&#039;fc_status&#039;][&quot;StatusCode&quot;] &gt;= 300){echo &quot;danger&quot;;}else{ echo &quot;success&quot;;} ?&gt; alert-dismissible alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
        &lt;i class=&quot;fa-regular fa-circle-&lt;?php if($_SESSION[&#039;fc_status&#039;][&quot;StatusCode&quot;] &gt;= 300){echo &quot;exclamation&quot;;}else{ echo &quot;check&quot;;} ?&gt; label-icon&quot;&gt;&lt;/i&gt; Fotocasa: &lt;?php echo __($_SESSION[&#039;fc_status&#039;][&quot;Message&quot;],1) ?&gt;
        &lt;button type=&quot;button&quot; class=&quot;btn-close&quot; data-bs-dismiss=&quot;alert&quot; aria-label=&quot;Close&quot;&gt;&lt;/button&gt;
    &lt;/div&gt;
    &lt;?php unset($_SESSION[&#039;fc_status&#039;]); ?&gt;
&lt;?php } ?&gt;

&lt;!-- RESPUESTA RIGHTMOVE --&gt;
&lt;?php if ($_SESSION[&#039;fc_statusRightmove&#039;] != &#039;&#039;) { ?&gt;
    &lt;div class=&quot;alert alert-success alert-block&quot;&gt;
        &lt;button type=&quot;button&quot; class=&quot;close&quot; data-dismiss=&quot;alert&quot;&gt;&amp;times;&lt;/button&gt;
        Rightmove: &lt;?php echo __($_SESSION[&#039;fc_statusRightmove&#039;]); ?&gt;
    &lt;/div&gt;
    &lt;?php unset($_SESSION[&#039;fc_statusRightmove&#039;]); ?&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:4030
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;hr style=&quot;border-top: 5px solid rgb(233, 235, 236)!important; margin-top: 25px !important;&quot;&gt;

&lt;div class=&quot;row&quot;&gt;

    &lt;div class=&quot;col-md-6&quot;&gt;

        &lt;div class=&quot;form-check form-switch form-switch-md pt-2&quot; dir=&quot;ltr&quot; &lt;?php if ($expRightmove == 0) { ?&gt;style=&quot;opacity: .5;&quot;&lt;?php } ?&gt;&gt;
            &lt;input type=&quot;checkbox&quot; name=&quot;export_rightmove_prop&quot; id=&quot;export_rightmove_prop&quot; value=&quot;1&quot; class=&quot;form-check-input&quot; &lt;?php if (isset($row_rsproperties_properties[&#039;export_rightmove_prop&#039;]) &amp;&amp; !(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;export_rightmove_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; &lt;?php if ($expRightmove == 0) { ?&gt;disabled&lt;?php } ?&gt;&gt;
            &lt;label class=&quot;form-check-label&quot; for=&quot;export_rightmove_prop&quot;&gt;&lt;?php __(&#039;Exportar a Rightmove&#039;); ?&gt;&lt;/label&gt;
            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;export_rightmove_prop&quot;); ?&gt;
        &lt;/div&gt;

    &lt;/div&gt;

    &lt;div class=&quot;col-md-6&quot;&gt;

        &lt;div class=&quot;form-check form-switch form-switch-md pt-2&quot; dir=&quot;ltr&quot; &lt;?php if ($expZoopla == 0) { ?&gt;style=&quot;opacity: .5;&quot;&lt;?php } ?&gt;&gt;
            &lt;input type=&quot;checkbox&quot; name=&quot;export_zoopla_prop&quot; id=&quot;export_zoopla_prop&quot; value=&quot;1&quot; class=&quot;form-check-input&quot; &lt;?php if (isset($row_rsproperties_properties[&#039;export_zoopla_prop&#039;]) &amp;&amp; !(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;export_zoopla_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; &lt;?php if ($expZoopla == 0) { ?&gt;disabled&lt;?php } ?&gt;&gt;
            &lt;label class=&quot;form-check-label&quot; for=&quot;export_zoopla_prop&quot;&gt;&lt;?php __(&#039;Exportar a Zoopla&#039;); ?&gt;&lt;/label&gt;
            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;export_zoopla_prop&quot;); ?&gt;
        &lt;/div&gt;

    &lt;/div&gt;

&lt;/div&gt;

&lt;?php if ($expRightmove == 1 || $expZoopla == 1) { ?&gt;
&lt;p class=&quot;leadx&quot;&gt;&lt;?php __(&#039;RM1&#039;); ?&gt;&lt;/p&gt;
&lt;p&gt;&lt;?php __(&#039;RM2&#039;); ?&gt;&lt;/p&gt;

&lt;div class=&quot;row&quot;&gt;
    &lt;div class=&quot;col-md-6&quot;&gt;
        &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;rightmove_loc_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
            &lt;label for=&quot;rightmove_loc_prop&quot;&gt;&lt;?php __(&#039;Localizaci&oacute;n&#039;); ?&gt;:&lt;/label&gt;
            &lt;div class=&quot;controls&quot;&gt;
                &lt;select name=&quot;rightmove_loc_prop&quot; id=&quot;rightmove_loc_prop&quot; class=&quot;select2&quot;&gt;
                    &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                    &lt;?php
          do {
          ?&gt;
                    &lt;option value=&quot;&lt;?php echo $row_rsRMlocs[&#039;id_rml&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsRMlocs[&#039;id_rml&#039;], $row_rsproperties_properties[&#039;rightmove_loc_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsRMlocs[&#039;loc1_rml&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_rsRMlocs[&#039;loc2_rml&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_rsRMlocs[&#039;loc3_rml&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_rsRMlocs[&#039;loc4_rml&#039;]; ?&gt;&lt;/option&gt;
                    &lt;?php
          } while ($row_rsRMlocs = mysqli_fetch_assoc($rsRMlocs));
          $rows = mysqli_num_rows($rsRMlocs);
          if($rows &gt; 0) {
          mysqli_data_seek($rsRMlocs, 0);
          $row_rsRMlocs = mysqli_fetch_assoc($rsRMlocs);
          }
          ?&gt;
                &lt;/select&gt;
                &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;rightmove_loc_prop&quot;); ?&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class=&quot;col-md-6&quot;&gt;
        &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;rightmove_tipo_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
            &lt;label for=&quot;rightmove_tipo_prop&quot;&gt;&lt;?php __(&#039;Tipo&#039;); ?&gt;:&lt;/label&gt;
            &lt;div class=&quot;controls&quot;&gt;
                &lt;select name=&quot;rightmove_tipo_prop&quot; id=&quot;rightmove_tipo_prop&quot; class=&quot;select2&quot;&gt;
                    &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                    &lt;?php
                    do {
                    ?&gt;
                    &lt;option value=&quot;&lt;?php echo $row_rsRMtipo[&#039;id_rmt&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsRMtipo[&#039;id_rmt&#039;], $row_rsproperties_properties[&#039;rightmove_tipo_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsRMtipo[&#039;tipo_rmt&#039;]?&gt;&lt;/option&gt;
                    &lt;?php
                    } while ($row_rsRMtipo = mysqli_fetch_assoc($rsRMtipo));
                      $rows = mysqli_num_rows($rsRMtipo);
                      if($rows &gt; 0) {
                          mysqli_data_seek($rsRMtipo, 0);
                        $row_rsRMtipo = mysqli_fetch_assoc($rsRMtipo);
                      }
                    ?&gt;
                &lt;/select&gt;
                &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;rightmove_tipo_prop&quot;); ?&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;?php } ?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;hr style=&quot;border-top: 5px solid rgb(233, 235, 236)!important; margin-top: 25px !important;&quot;&gt;

&lt;div class=&quot;row&quot;&gt;

    &lt;div class=&quot;col-md-6&quot;&gt;

        &lt;div class=&quot;form-check form-switch form-switch-md pt-2&quot; dir=&quot;ltr&quot; &lt;?php if ($expZoopla == 0) { ?&gt;style=&quot;opacity: .5;&quot;&lt;?php } ?&gt;&gt;
            &lt;input type=&quot;checkbox&quot; name=&quot;export_zoopla_prop&quot; id=&quot;export_zoopla_prop&quot; value=&quot;1&quot; class=&quot;form-check-input&quot; &lt;?php if (isset($row_rsproperties_properties[&#039;export_zoopla_prop&#039;]) &amp;&amp; !(strcmp(KT_escapeAttribute($row_rsproperties_properties[&#039;export_zoopla_prop&#039;]),&quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt; &lt;?php if ($expZoopla == 0) { ?&gt;disabled&lt;?php } ?&gt;&gt;
            &lt;label class=&quot;form-check-label&quot; for=&quot;export_zoopla_prop&quot;&gt;&lt;?php __(&#039;Exportar a Zoopla&#039;); ?&gt;&lt;/label&gt;
            &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;export_zoopla_prop&quot;); ?&gt;
        &lt;/div&gt;

    &lt;/div&gt;

&lt;/div&gt;

&lt;?php if ($expRightmove == 1 || $expZoopla == 1) { ?&gt;
&lt;p class=&quot;leadx&quot;&gt;&lt;?php __(&#039;RM1&#039;); ?&gt;&lt;/p&gt;
&lt;p&gt;&lt;?php __(&#039;RM2&#039;); ?&gt;&lt;/p&gt;

&lt;div class=&quot;row&quot;&gt;
    &lt;div class=&quot;col-md-6&quot;&gt;
        &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;rightmove_loc_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
            &lt;label for=&quot;rightmove_loc_prop&quot;&gt;&lt;?php __(&#039;Localizaci&oacute;n&#039;); ?&gt;:&lt;/label&gt;
            &lt;div class=&quot;controls&quot;&gt;
                &lt;select name=&quot;rightmove_loc_prop&quot; id=&quot;rightmove_loc_prop&quot; class=&quot;select2&quot;&gt;
                    &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                    &lt;?php
          do {
          ?&gt;
                    &lt;option value=&quot;&lt;?php echo $row_rsRMlocs[&#039;id_rml&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsRMlocs[&#039;id_rml&#039;], $row_rsproperties_properties[&#039;rightmove_loc_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsRMlocs[&#039;loc1_rml&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_rsRMlocs[&#039;loc2_rml&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_rsRMlocs[&#039;loc3_rml&#039;]; ?&gt; &amp;raquo; &lt;?php echo $row_rsRMlocs[&#039;loc4_rml&#039;]; ?&gt;&lt;/option&gt;
                    &lt;?php
          } while ($row_rsRMlocs = mysqli_fetch_assoc($rsRMlocs));
          $rows = mysqli_num_rows($rsRMlocs);
          if($rows &gt; 0) {
          mysqli_data_seek($rsRMlocs, 0);
          $row_rsRMlocs = mysqli_fetch_assoc($rsRMlocs);
          }
          ?&gt;
                &lt;/select&gt;
                &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;rightmove_loc_prop&quot;); ?&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class=&quot;col-md-6&quot;&gt;
        &lt;div class=&quot;form-group &lt;?php if($tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;rightmove_tipo_prop&quot;) != &#039;&#039;) { ?&gt;has-error&lt;?php } ?&gt;&quot;&gt;
            &lt;label for=&quot;rightmove_tipo_prop&quot;&gt;&lt;?php __(&#039;Tipo&#039;); ?&gt;:&lt;/label&gt;
            &lt;div class=&quot;controls&quot;&gt;
                &lt;select name=&quot;rightmove_tipo_prop&quot; id=&quot;rightmove_tipo_prop&quot; class=&quot;select2&quot;&gt;
                    &lt;option value=&quot;&quot;&gt;&lt;?php echo NXT_getResource(&quot;Select one...&quot;); ?&gt;&lt;/option&gt;
                    &lt;?php
                    do {
                    ?&gt;
                    &lt;option value=&quot;&lt;?php echo $row_rsRMtipo[&#039;id_rmt&#039;]?&gt;&quot;&lt;?php if (!(strcmp($row_rsRMtipo[&#039;id_rmt&#039;], $row_rsproperties_properties[&#039;rightmove_tipo_prop&#039;]))) {echo &quot;SELECTED&quot;;} ?&gt;&gt;&lt;?php echo $row_rsRMtipo[&#039;tipo_rmt&#039;]?&gt;&lt;/option&gt;
                    &lt;?php
                    } while ($row_rsRMtipo = mysqli_fetch_assoc($rsRMtipo));
                      $rows = mysqli_num_rows($rsRMtipo);
                      if($rows &gt; 0) {
                          mysqli_data_seek($rsRMtipo, 0);
                        $row_rsRMtipo = mysqli_fetch_assoc($rsRMtipo);
                      }
                    ?&gt;
                &lt;/select&gt;
                &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_properties&quot;, &quot;rightmove_tipo_prop&quot;); ?&gt;
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;?php } ?&gt;

&lt;hr style=&quot;border-top: 5px solid rgb(233, 235, 236)!important; margin-top: 25px !important;&quot;&gt;

&lt;!-- Rightmove --&gt;
&lt;?php require($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/intramedianet/properties/rightmove/properties-form-rightmove.php&#039;); ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php
            </code>
        </pre>
        Añadimos antes de cerrar la etiqueta &lt;body&gt;:
        <pre>
            <code class="php">
&lt;script&gt;
// Si cambia el checkbox de idealista muestra el formulario
$(&#039;#export_rightmove_prop&#039;).change(function(e) {
  e.preventDefault();
  if ($(this).is(&#039;:checked&#039;) == true) {
    $(&#039;#basicRightmove&#039;).fadeIn(&#039;slow&#039;);
  }  else{
    $(&#039;#basicRightmove&#039;).fadeOut(&#039;slow&#039;);
  }
});
&lt;/script&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php
            </code>
        </pre>
        Añadimos:
        <pre>
            <code class="php">
$lang[&#039;business_for_sale&#039;] = &#039;Business for sale&#039;;
$lang[&#039;golf_course_on_site_or_within_10_minutes_walk&#039;] = &#039;Golf course on site or within 10 minutes walk&#039;;
$lang[&#039;golf_course_within_a_20_minute_drive&#039;] = &#039;Golf course within a 20 minute drive&#039;;
$lang[&#039;at_beach_or_within_10_minute_walk&#039;] = &#039;At beach or within 10 minute walk&#039;;
$lang[&#039;beach_within_a_20_minute_drive&#039;] = &#039;Beach within a 20 minute drive&#039;;
$lang[&#039;at_ski_field_or_within_10_minutes_walk&#039;] = &#039;At ski field or within 10 minutes walk&#039;;
$lang[&#039;ski_field_within_a_45_minute_drive&#039;] = &#039;Ski field within a 45 minute drive&#039;;
$lang[&#039;sea_view&#039;] = &#039;Sea view&#039;;
$lang[&#039;air_conditioning&#039;] = &#039;Air conditioning&#039;;
$lang[&#039;security_system&#039;] = &#039;Security system&#039;;
$lang[&#039;gated_entry&#039;] = &#039;Gated entry&#039;;
$lang[&#039;balcony&#039;] = &#039;Balcony&#039;;
$lang[&#039;ground_floor_terrace&#039;] = &#039;Ground floor terrace&#039;;
$lang[&#039;roof_terrace&#039;] = &#039;Roof terrace&#039;;
$lang[&#039;hot_tub&#039;] = &#039;Hot tub&#039;;
$lang[&#039;log_fireplace&#039;] = &#039;Log fireplace&#039;;
$lang[&#039;private_beach&#039;] = &#039;Private beach&#039;;
$lang[&#039;Statuses&#039;] = &#039;Statuses&#039;;
$lang[&#039;Price Qualifiers&#039;] = &#039;Price Qualifiers&#039;;
$lang[&#039;Dimension Units&#039;] = &#039;Dimension Units&#039;;
$lang[&#039;Area Units&#039;] = &#039;Area Units&#039;;
$lang[&#039;Entrance Floors&#039;] = &#039;Entrance Floors&#039;;
$lang[&#039;Conditions&#039;] = &#039;Conditions&#039;;
$lang[&#039;Commercial Use Classes&#039;] = &#039;Commercial Use Classes&#039;;
$lang[&#039;Accessibilites&#039;] = &#039;Accessibilites&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        Añadimos:
        <pre>
            <code class="php">
$lang[&#039;business_for_sale&#039;] = &#039;Negocio en venta&#039;;
$lang[&#039;golf_course_on_site_or_within_10_minutes_walk&#039;] = &#039;Campo de golf en el sitio o a 10 minutos a pie&#039;;
$lang[&#039;golf_course_within_a_20_minute_drive&#039;] = &#039;Campo de golf a 20 minutos en coche&#039;;
$lang[&#039;at_beach_or_within_10_minute_walk&#039;] = &#039;En la playa o a 10 minutos a pie&#039;;
$lang[&#039;beach_within_a_20_minute_drive&#039;] = &#039;Playa a 20 minutos en coche&#039;;
$lang[&#039;at_ski_field_or_within_10_minutes_walk&#039;] = &#039;En pista de esqu&iacute; o a 10 minutos a pie&#039;;
$lang[&#039;ski_field_within_a_45_minute_drive&#039;] = &#039;Pista de esqu&iacute; a 45 minutos en coche&#039;;
$lang[&#039;sea_view&#039;] = &#039;Vista al mar&#039;;
$lang[&#039;air_conditioning&#039;] = &#039;Aire acondicionado&#039;;
$lang[&#039;security_system&#039;] = &#039;Sistema de seguridad&#039;;
$lang[&#039;gated_entry&#039;] = &#039;Entrada cerrada&#039;;
$lang[&#039;balcony&#039;] = &#039;Balc&oacute;n&#039;;
$lang[&#039;ground_floor_terrace&#039;] = &#039;Terraza en planta baja&#039;;
$lang[&#039;roof_terrace&#039;] = &#039;Terraza en la azotea&#039;;
$lang[&#039;hot_tub&#039;] = &#039;Jacuzzi&#039;;
$lang[&#039;log_fireplace&#039;] = &#039;Chimenea de le&ntilde;a&#039;;
$lang[&#039;private_beach&#039;] = &#039;Playa privada&#039;;
$lang[&#039;Statuses&#039;] = &#039;Estados&#039;;
$lang[&#039;Price Qualifiers&#039;] = &#039;Calificadores de precio&#039;;
$lang[&#039;Dimension Units&#039;] = &#039;Unidades de dimensi&oacute;n&#039;;
$lang[&#039;Area Units&#039;] = &#039;Unidades de &aacute;rea&#039;;
$lang[&#039;Entrance Floors&#039;] = &#039;Plantas de entrada&#039;;
$lang[&#039;Conditions&#039;] = &#039;Condiciones&#039;;
$lang[&#039;Commercial Use Classes&#039;] = &#039;Clases de uso comercial&#039;;
$lang[&#039;Accessibilites&#039;] = &#039;Accesibilidades&#039;;
            </code>
        </pre>
        <hr>
        <div class="alert alert-warning" role="alert">
            <b>Si ya tiene Rightmove instalado hay que eliminar el cron.</b>
        </div>
        <div class="alert alert-info" role="alert">
            <b>No se puede activar hasta que el cliente nos ha pasado el branch ID y Alex ha avisado a Rightmove. Pedirle a Alex que avise a Rightmove y os confirme que puedes activarlo.</b>
        </div>
        <div class="alert alert-info" role="alert">
            <b>Si necesitas hacerlo para PHP 5.6 puedes encontrarlo en cbpropertysales.co.uk. Los pasos son los mismos pero hay ciertas llamadas diferentes.</b>
        </div>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 28-10-2025</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec1"><i class="fas fz-fw fa-bug text-danger"></i> Ajustes promociones</a></li>
    </ol>
</div>

<div class="card">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Ajustes promociones
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/new.php:369
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$features = getRecords(&quot;
SELECT CASE WHEN properties_features_priv.feature_&quot;.$lang.&quot;_feat IS NOT NULL THEN properties_features_priv.feature_&quot;.$lang.&quot;_feat ELSE features.feature_&quot;.$lang.&quot;_feat  END AS feat
   FROM promotions_promotions_feature INNER JOIN properties_features_priv features ON promotions_promotions_feature.feature = features.id_feat LEFT OUTER JOIN properties_features_priv ON features.parent_feat = properties_features_priv.id_feat
   WHERE promotions_promotions_feature.promotion = &#039;&quot;.simpleSanitize(($tokens[1])).&quot;&#039; ORDER BY properties_features_priv.order_feat ASC&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$features = getRecords(&quot;
SELECT CASE WHEN properties_features_priv.feature_&quot;.$lang.&quot;_feat IS NOT NULL THEN properties_features_priv.feature_&quot;.$lang.&quot;_feat ELSE features.feature_&quot;.$lang.&quot;_feat  END AS feat
   FROM promotions_promotions_feature INNER JOIN properties_features_priv features ON promotions_promotions_feature.feature = features.id_feat LEFT OUTER JOIN properties_features_priv ON features.parent_feat = properties_features_priv.id_feat
   WHERE promotions_promotions_feature.promotion = &#039;&quot;.simpleSanitize(($tokens[1])).&quot;&#039; ORDER BY feat ASC&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/new.php:832
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
precio_12_prop,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
precio_12_prop,
entraga_date_prop,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/new.php:877
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
ORDER BY order_img, RAND()
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
ORDER BY id_prop
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/pdf.php:95
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$features = getRecords(&quot;
    SELECT CASE WHEN properties_features.feature_&quot; . $_GET[&#039;lang&#039;] . &quot;_feat IS NOT NULL THEN properties_features.feature_&quot; . $_GET[&#039;lang&#039;] . &quot;_feat ELSE features.feature_&quot; . $_GET[&#039;lang&#039;] . &quot;_feat  END AS feat
    FROM promotions_promotions_feature INNER JOIN properties_features features ON promotions_promotions_feature.feature = features.id_feat LEFT OUTER JOIN properties_features ON features.parent_feat = properties_features.id_feat
    WHERE promotions_promotions_feature.promotion = &#039;&quot; . simpleSanitize($_GET[&#039;p&#039;]) . &quot;&#039; ORDER BY feat ASC LIMIT 10
&quot;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$features = getRecords(&quot;
    SELECT CASE WHEN properties_features_priv.feature_&quot; . $_GET[&#039;lang&#039;] . &quot;_feat IS NOT NULL THEN properties_features_priv.feature_&quot; . $_GET[&#039;lang&#039;] . &quot;_feat ELSE features.feature_&quot; . $_GET[&#039;lang&#039;] . &quot;_feat  END AS feat
    FROM promotions_promotions_feature INNER JOIN properties_features_priv features ON promotions_promotions_feature.feature = features.id_feat LEFT OUTER JOIN properties_features_priv ON features.parent_feat = properties_features_priv.id_feat
    WHERE promotions_promotions_feature.promotion = &#039;&quot; . simpleSanitize($_GET[&#039;p&#039;]) . &quot;&#039; ORDER BY feat ASC LIMIT 10
&quot;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/promociones/view/partials/tab-caracteristicas.tpl:61
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
{section name=ft loop=$features}
    {if {$features[ft].feat} != &#039;&#039;}
        &lt;div class=&quot;col-12 col-lg-4 col-sm-6 mb-2&quot;&gt;&lt;i class=&quot;fas fa-check&quot;&gt;&lt;/i&gt; {$features[ft].feat}&lt;/div&gt;
    {/if}
{/section}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
{if $similares[0].entraga_date_prop != &#039;&#039;}
&lt;div class=&quot;col-12 col-lg-4 col-sm-6 mb-2&quot;&gt;&lt;i class=&quot;fas fa-check&quot;&gt;&lt;/i&gt;&lt;strong&gt;{$lng_fecha_de_entrega}:&lt;/strong&gt; {$similares[0].entraga_date_prop}&lt;/div&gt;
{/if}
{section name=ft loop=$features}
    {if {$features[ft].feat} != &#039;&#039;}
        &lt;div class=&quot;col-12 col-lg-4 col-sm-6 mb-2&quot;&gt;&lt;i class=&quot;fas fa-check&quot;&gt;&lt;/i&gt; {$features[ft].feat}&lt;/div&gt;
    {/if}
{/section}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
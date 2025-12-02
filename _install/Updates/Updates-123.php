<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 29-05-2025</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec1"><i class="fas fz-fw fa-bug text-danger"></i> No mostrar plantillas email semanal en dropdow de plantillas</a></li>
        <li><a href="#sec2"><i class="fas fz-fw fa-bug text-danger"></i> Falta campo asunto en envios desde criterios de búsqueda</a></li>
        <li><a href="#sec3"><i class="fas fz-fw fa-bug text-danger"></i> Añadir costas a ciudades</a></li>
        <li><a href="#sec4"><i class="fas fz-fw fa-bug text-danger"></i> Añadir {CLIENTES} a newsletter manual</a></li>
        <li><a href="#sec5"><i class="fas fz-fw fa-bug text-danger"></i> Muestra html en plantillas de email</a></li>
        <li><a href="#sec6"><i class="fas fz-fw fa-bug text-danger"></i> Nombre columna Móvil en listado en vez de teléfono 2</a></li>
        <li><a href="#sec7"><i class="fas fz-fw fa-plus-circle text-success"></i> Cerrar Localizaciones y Tipos en Master</a></li>
        <li><a href="#sec8"><i class="fas fz-fw fa-bug text-danger"></i> Reportes Buyers / Acceso directos a tareas y citas</a></li>
        <li><a href="#sec9"><i class="fas fz-fw fa-bug text-danger"></i> Error en reporte de propietario</a></li>
        <li><a href="#sec10"><i class="fas fz-fw fa-plus-circle text-success"></i> Nueva plantilla de emails</a></li>
        <li><a href="#sec11"><i class="fas fz-fw fa-bug text-danger"></i> Fallo Habihub al marcar a 1 el campo force_hide_prop</a></li>
        <li><a href="#sec12"><i class="fas fz-fw fa-bug text-danger"></i> Fallo al añadir imagenes en los archivos de inicio</a></li>
        <li><a href="#sec13"><i class="fas fz-fw fa-bug text-danger"></i> No funciona el selector de idiomas al editar archivos a una noticia</a></li>
        <li><a href="#sec14"><i class="fas fz-fw fa-bug text-danger"></i> Fallo al importar de inmovilla</a></li>
        <li><a href="#sec15"><i class="fas fz-fw fa-bug text-danger"></i> Compartir en redes en Noticias</a></li>
        <li><a href="#sec16"><i class="fas fz-fw fa-bug text-danger"></i> Nuevo informe de propietarios</a></li>
        <!-- <li><a href="#sec17"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadido archivo LLMS.txt para las ias</a></li> -->
        <li><a href="#sec18"><i class="fas fz-fw fa-bug text-danger"></i> Error master valoraciones</a></li>
        <li><a href="#sec19"><i class="fas fz-fw fa-bug text-danger"></i> Fallo en los 3 modals nuevos de Status, Collaborator y Source compradores</a></li>
        <li><a href="#sec20"><i class="fas fz-fw fa-bug text-danger"></i> Fallo Sources</a></li>
        <li><a href="#sec21"><i class="fas fz-fw fa-bug text-danger"></i> Error al añadir emojis en las metas de las noticias</a></li>
        <li><a href="#sec22"><i class="fas fz-fw fa-bug text-danger"></i> Actualización archivos para inmovilla</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> No mostrar plantillas email semanal en dropdow de plantillas
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:142
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsTemplates = &quot;SELECT * FROM templates ORDER BY name_&quot;.$lang_adm.&quot;_tmpl ASC&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsTemplates = &quot;SELECT * FROM templates WHERE week_tmpl = 0 ORDER BY name_&quot;.$lang_adm.&quot;_tmpl ASC&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:148
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query_rsTemplates = &quot;SELECT * FROM templates ORDER BY name_&quot;.$lang_adm.&quot;_tmpl ASC&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsTemplates = &quot;SELECT * FROM templates WHERE week_tmpl = 0 ORDER BY name_&quot;.$lang_adm.&quot;_tmpl ASC&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec2">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> Falta campo asunto en envios desde criterios de búsqueda
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:2657
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;hr&gt;

&lt;div class=&quot;col-md-12&quot;&gt;
  &lt;div class=&quot;form-group&quot;&gt;
    &lt;label for=&quot;email_cli&quot;&gt;&lt;?php __(&#039;Comentario&#039;); ?&gt;:&lt;/label&gt;
    &lt;div class=&quot;controls&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;hr&gt;

&lt;div class=&quot;form-group mb-3&quot;&gt;
    &lt;label for=&quot;subjcrt&quot;&gt;&lt;?php __(&#039;Asunto&#039;); ?&gt;:&lt;/label&gt;
    &lt;input type=&quot;text&quot; name=&quot;subjcrt&quot; id=&quot;subjcrt&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot; placeholder=&quot;&lt;?php __(&#039;Asunto&#039;) ?&gt;&quot;&gt;
&lt;/div&gt;

&lt;div class=&quot;col-md-12&quot;&gt;
  &lt;div class=&quot;form-group&quot;&gt;
    &lt;label for=&quot;email_cli&quot;&gt;&lt;?php __(&#039;Comentario&#039;); ?&gt;:&lt;/label&gt;
    &lt;div class=&quot;controls&quot;&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:3713
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;.btn-txt2&#039;).click(function(e) {
    e.preventDefault();
    if ($(&#039;#txt2&#039;).val() == &#039;&#039;) {
        alert(&#039;&lt;?php __(&#039;Seleccione un texto&#039;); ?&gt;&#039;);
        $(&#039;#txt2&#039;).focus();
        return false;
    }
    var txt = intr_txt[$(&#039;#idioma_cli&#039;).val()+$(&#039;#txt2&#039;).val()].replace(&#039;{{PROPERTY}}&#039;, &#039;&#039;);
    $(&#039;#comment&#039;).redactor(&#039;source.setCode&#039;, txt);
    return false;
});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;.btn-txt2&#039;).click(function(e) {
    e.preventDefault();
    if ($(&#039;#txt2&#039;).val() == &#039;&#039;) {
        alert(&#039;&lt;?php __(&#039;Seleccione un texto&#039;); ?&gt;&#039;);
        $(&#039;#txt2&#039;).focus();
        return false;
    }
    $(&#039;#subjcrt&#039;).val(intr_sub[$(&#039;#idioma_cli&#039;).val()+$(&#039;#txt2&#039;).val()]);
    var txt = intr_txt[$(&#039;#idioma_cli&#039;).val()+$(&#039;#txt2&#039;).val()].replace(&#039;{{PROPERTY}}&#039;, &#039;&#039;);
    $(&#039;#comment&#039;).redactor(&#039;source.setCode&#039;, txt);
    return false;
});
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/clients-form.js:465
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
url: &quot;clients-send2.php?ids=&quot; + values + &#039;&amp;email=&#039; + $(&#039;#email_cli&#039;).val() + &#039;&amp;cco=&#039; + $(&#039;#ccoSrch&#039;).val() + &#039;&amp;comment=&#039; + encodeURIComponent($(&#039;#comment&#039;).val().replace(/\r?\n/g, &quot;&lt;br&gt;&quot;)) + &#039;&amp;tipo=1&amp;lang=&#039; + sendLang + &#039;&amp;usr=&#039; + idClient + &#039;&amp;&#039; + $(&#039;#btnsendcont&#039;).find(&#039;select, textarea, input&#039;).serialize(),
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
url: &quot;clients-send2.php?ids=&quot; + values + &#039;&amp;email=&#039; + $(&#039;#email_cli&#039;).val() + &#039;&amp;cco=&#039; + $(&#039;#ccoSrch&#039;).val() + &#039;&amp;subject=&#039; + $(&#039;#subjcrt&#039;).val() + &#039;&amp;comment=&#039; + encodeURIComponent($(&#039;#comment&#039;).val().replace(/\r?\n/g, &quot;&lt;br&gt;&quot;)) + &#039;&amp;tipo=1&amp;lang=&#039; + sendLang + &#039;&amp;usr=&#039; + idClient + &#039;&amp;&#039; + $(&#039;#btnsendcont&#039;).find(&#039;select, textarea, input&#039;).serialize(),
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-send2.php:172
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$subject = $langStr[&#039;Propiedades recomendadas&#039;] .&#039; - &#039; . $_SERVER[&#039;HTTP_HOST&#039;];
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$subject = $langStr[&#039;Propiedades recomendadas&#039;] .&#039; - &#039; . $_SERVER[&#039;HTTP_HOST&#039;];

if ($_GET[&#039;subject&#039;] != &#039;&#039;) {
    $subject = $_GET[&#039;subject&#039;];
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec3">
        <span class="badge badge-dark">3</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadir costas a ciudades
    </h6>
    <div class="card-body">
        Ejecutar las queries;
        <pre>
            <code class="sql">
TRUNCATE TABLE `properties_loc3`;
INSERT INTO `properties_loc3` VALUES
    (8125, 1, NULL, NULL, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, 2),
    (8135, 1, NULL, NULL, &#039;Pinar de Campoverde&#039;, &#039;Pinar de Campoverde&#039;, &#039;Pinar de Campoverde&#039;, &#039;Pinar de Campoverde&#039;, &#039;Pinar de Campoverde&#039;, &#039;Pinar de Campoverde&#039;, &#039;Pinar de Campoverde&#039;, &#039;Pinar de Campoverde&#039;, &#039;Pinar de Campoverde&#039;, &#039;Pinar de Campoverde&#039;, &#039;Pinar de Campoverde&#039;, &#039;Pinar de Campoverde&#039;, &#039;Pinar de Campoverde&#039;, &#039;Pinar de Campoverde&#039;, &#039;Pinar de Campoverde&#039;, &#039;Pinar de Campoverde&#039;, 2),
    (8136, 1, NULL, NULL, &#039;Torrellano&#039;, &#039;Torrellano&#039;, &#039;Torrellano&#039;, &#039;Torrellano&#039;, &#039;Torrellano&#039;, &#039;Torrellano&#039;, &#039;Torrellano&#039;, &#039;Torrellano&#039;, &#039;Torrellano&#039;, &#039;Torrellano&#039;, &#039;Torrellano&#039;, &#039;Torrellano&#039;, &#039;Torrellano&#039;, &#039;Torrellano&#039;, &#039;Torrellano&#039;, &#039;Torrellano&#039;, 2),
    (8137, 1, NULL, NULL, &#039;Elche&#039;, &#039;Elche&#039;, &#039;Elche&#039;, &#039;Elche&#039;, &#039;Elche&#039;, &#039;Elche&#039;, &#039;Elche&#039;, &#039;Elche&#039;, &#039;Elche&#039;, &#039;Elche&#039;, &#039;Elche&#039;, &#039;Elche&#039;, &#039;Elche&#039;, &#039;Elche&#039;, &#039;Elche&#039;, &#039;Elche&#039;, 2),
    (8138, 1, NULL, NULL, &#039;Elche Pedan&iacute;as&#039;, &#039;Elche Pedan&iacute;as&#039;, &#039;Elche Pedan&iacute;as&#039;, &#039;Elche Pedan&iacute;as&#039;, &#039;Elche Pedan&iacute;as&#039;, &#039;Elche Pedan&iacute;as&#039;, &#039;Elche Pedan&iacute;as&#039;, &#039;Elche Pedan&iacute;as&#039;, &#039;Elche Pedan&iacute;as&#039;, &#039;Elche Pedan&iacute;as&#039;, &#039;Elche Pedan&iacute;as&#039;, &#039;Elche Pedan&iacute;as&#039;, &#039;Elche Pedan&iacute;as&#039;, &#039;Elche Pedan&iacute;as&#039;, &#039;Elche Pedan&iacute;as&#039;, &#039;Elche Pedan&iacute;as&#039;, 2),
    (8139, 1, NULL, NULL, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, &#039;Santa Pola&#039;, 2),
    (8140, 1, NULL, NULL, &#039;Arenales del Sol&#039;, &#039;Arenales del Sol&#039;, &#039;Arenales del Sol&#039;, &#039;Arenales del Sol&#039;, &#039;Arenales del Sol&#039;, &#039;Arenales del Sol&#039;, &#039;Arenales del Sol&#039;, &#039;Arenales del Sol&#039;, &#039;Arenales del Sol&#039;, &#039;Arenales del Sol&#039;, &#039;Arenales del Sol&#039;, &#039;Arenales del Sol&#039;, &#039;Arenales del Sol&#039;, &#039;Arenales del Sol&#039;, &#039;Arenales del Sol&#039;, &#039;Arenales del Sol&#039;, 2),
    (8141, 1, NULL, NULL, &#039;Alicante&#039;, &#039;Alicante&#039;, &#039;Alicante&#039;, &#039;Alicante&#039;, &#039;Alicante&#039;, &#039;Alicante&#039;, &#039;Alicante&#039;, &#039;Alicante&#039;, &#039;Alicante&#039;, &#039;Alicante&#039;, &#039;Alicante&#039;, &#039;Alicante&#039;, &#039;Alicante&#039;, &#039;Alicante&#039;, &#039;Alicante&#039;, &#039;Alicante&#039;, 2),
    (8142, 1, NULL, NULL, &#039;Pedreguer&#039;, &#039;Pedreguer&#039;, &#039;Pedreguer&#039;, &#039;Pedreguer&#039;, &#039;Pedreguer&#039;, &#039;Pedreguer&#039;, &#039;Pedreguer&#039;, &#039;Pedreguer&#039;, &#039;Pedreguer&#039;, &#039;Pedreguer&#039;, &#039;Pedreguer&#039;, &#039;Pedreguer&#039;, &#039;Pedreguer&#039;, &#039;Pedreguer&#039;, &#039;Pedreguer&#039;, &#039;Pedreguer&#039;, 1),
    (8143, 1, NULL, NULL, &#039;Calpe&#039;, &#039;Calpe&#039;, &#039;Calpe&#039;, &#039;Calpe&#039;, &#039;Calpe&#039;, &#039;Calpe&#039;, &#039;Calpe&#039;, &#039;Calpe&#039;, &#039;Calpe&#039;, &#039;Calpe&#039;, &#039;Calpe&#039;, &#039;Calpe&#039;, &#039;Calpe&#039;, &#039;Calpe&#039;, &#039;Calpe&#039;, &#039;Calpe&#039;, 1),
    (8144, 1, NULL, NULL, &#039;Denia&#039;, &#039;Denia&#039;, &#039;Denia&#039;, &#039;Denia&#039;, &#039;Denia&#039;, &#039;Denia&#039;, &#039;Denia&#039;, &#039;Denia&#039;, &#039;Denia&#039;, &#039;Denia&#039;, &#039;Denia&#039;, &#039;Denia&#039;, &#039;Denia&#039;, &#039;Denia&#039;, &#039;Denia&#039;, &#039;Denia&#039;, 1),
    (8145, 1, NULL, NULL, &#039;J&aacute;vea&#039;, &#039;J&aacute;vea&#039;, &#039;J&aacute;vea&#039;, &#039;J&aacute;vea&#039;, &#039;J&aacute;vea&#039;, &#039;J&aacute;vea&#039;, &#039;J&aacute;vea&#039;, &#039;J&aacute;vea&#039;, &#039;J&aacute;vea&#039;, &#039;J&aacute;vea&#039;, &#039;J&aacute;vea&#039;, &#039;J&aacute;vea&#039;, &#039;J&aacute;vea&#039;, &#039;J&aacute;vea&#039;, &#039;J&aacute;vea&#039;, &#039;J&aacute;vea&#039;, 1),
    (8146, 1, NULL, NULL, &#039;Ondara&#039;, &#039;Ondara&#039;, &#039;Ondara&#039;, &#039;Ondara&#039;, &#039;Ondara&#039;, &#039;Ondara&#039;, &#039;Ondara&#039;, &#039;Ondara&#039;, &#039;Ondara&#039;, &#039;Ondara&#039;, &#039;Ondara&#039;, &#039;Ondara&#039;, &#039;Ondara&#039;, &#039;Ondara&#039;, &#039;Ondara&#039;, &#039;Ondara&#039;, 1),
    (8147, 1, NULL, NULL, &#039;La Nuc&iacute;a&#039;, &#039;La Nuc&iacute;a&#039;, &#039;La Nuc&iacute;a&#039;, &#039;La Nuc&iacute;a&#039;, &#039;La Nuc&iacute;a&#039;, &#039;La Nuc&iacute;a&#039;, &#039;La Nuc&iacute;a&#039;, &#039;La Nuc&iacute;a&#039;, &#039;La Nuc&iacute;a&#039;, &#039;La Nuc&iacute;a&#039;, &#039;La Nuc&iacute;a&#039;, &#039;La Nuc&iacute;a&#039;, &#039;La Nuc&iacute;a&#039;, &#039;La Nuc&iacute;a&#039;, &#039;La Nuc&iacute;a&#039;, &#039;La Nuc&iacute;a&#039;, 1),
    (8148, 1, NULL, NULL, &#039;Polop&#039;, &#039;Polop&#039;, &#039;Polop&#039;, &#039;Polop&#039;, &#039;Polop&#039;, &#039;Polop&#039;, &#039;Polop&#039;, &#039;Polop&#039;, &#039;Polop&#039;, &#039;Polop&#039;, &#039;Polop&#039;, &#039;Polop&#039;, &#039;Polop&#039;, &#039;Polop&#039;, &#039;Polop&#039;, &#039;Polop&#039;, 1),
    (8149, 1, NULL, NULL, &#039;Alfas del P&iacute;&#039;, &#039;Alfas del P&iacute;&#039;, &#039;Alfas del P&iacute;&#039;, &#039;Alfas del P&iacute;&#039;, &#039;Alfas del P&iacute;&#039;, &#039;Alfas del P&iacute;&#039;, &#039;Alfas del P&iacute;&#039;, &#039;Alfas del P&iacute;&#039;, &#039;Alfas del P&iacute;&#039;, &#039;Alfas del P&iacute;&#039;, &#039;Alfas del P&iacute;&#039;, &#039;Alfas del P&iacute;&#039;, &#039;Alfas del P&iacute;&#039;, &#039;Alfas del P&iacute;&#039;, &#039;Alfas del P&iacute;&#039;, &#039;Alfas del P&iacute;&#039;, 1),
    (8150, 1, NULL, NULL, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, 2),
    (8151, 1, NULL, NULL, &#039;Rojales&#039;, &#039;Rojales&#039;, &#039;Rojales&#039;, &#039;Rojales&#039;, &#039;Rojales&#039;, &#039;Rojales&#039;, &#039;Rojales&#039;, &#039;Rojales&#039;, &#039;Rojales&#039;, &#039;Rojales&#039;, &#039;Rojales&#039;, &#039;Rojales&#039;, &#039;Rojales&#039;, &#039;Rojales&#039;, &#039;Rojales&#039;, &#039;Rojales&#039;, 2),
    (8152, 3, NULL, NULL, &#039;Miramar&#039;, &#039;Miramar&#039;, &#039;Miramar&#039;, &#039;Miramar&#039;, &#039;Miramar&#039;, &#039;Miramar&#039;, &#039;Miramar&#039;, &#039;Miramar&#039;, &#039;Miramar&#039;, &#039;Miramar&#039;, &#039;Miramar&#039;, &#039;Miramar&#039;, &#039;Miramar&#039;, &#039;Miramar&#039;, &#039;Miramar&#039;, &#039;Miramar&#039;, 5),
    (8153, 3, NULL, NULL, &#039;Valencia&#039;, &#039;Valencia&#039;, &#039;Valencia&#039;, &#039;Valencia&#039;, &#039;Valencia&#039;, &#039;Valencia&#039;, &#039;Valencia&#039;, &#039;Valencia&#039;, &#039;Valencia&#039;, &#039;Valencia&#039;, &#039;Valencia&#039;, &#039;Valencia&#039;, &#039;Valencia&#039;, &#039;Valencia&#039;, &#039;Valencia&#039;, &#039;Valencia&#039;, 5),
    (8154, 1, NULL, NULL, &#039;Castalla&#039;, &#039;Castalla&#039;, &#039;Castalla&#039;, &#039;Castalla&#039;, &#039;Castalla&#039;, &#039;Castalla&#039;, &#039;Castalla&#039;, &#039;Castalla&#039;, &#039;Castalla&#039;, &#039;Castalla&#039;, &#039;Castalla&#039;, &#039;Castalla&#039;, &#039;Castalla&#039;, &#039;Castalla&#039;, &#039;Castalla&#039;, &#039;Castalla&#039;, 1),
    (8155, 1, NULL, NULL, &#039;Benidorm&#039;, &#039;Benidorm&#039;, &#039;Benidorm&#039;, &#039;Benidorm&#039;, &#039;Benidorm&#039;, &#039;Benidorm&#039;, &#039;Benidorm&#039;, &#039;Benidorm&#039;, &#039;Benidorm&#039;, &#039;Benidorm&#039;, &#039;Benidorm&#039;, &#039;Benidorm&#039;, &#039;Benidorm&#039;, &#039;Benidorm&#039;, &#039;Benidorm&#039;, &#039;Benidorm&#039;, 1),
    (8156, 1, NULL, NULL, &#039;Redov&aacute;n&#039;, &#039;Redov&aacute;n&#039;, &#039;Redov&aacute;n&#039;, &#039;Redov&aacute;n&#039;, &#039;Redov&aacute;n&#039;, &#039;Redov&aacute;n&#039;, &#039;Redov&aacute;n&#039;, &#039;Redov&aacute;n&#039;, &#039;Redov&aacute;n&#039;, &#039;Redov&aacute;n&#039;, &#039;Redov&aacute;n&#039;, &#039;Redov&aacute;n&#039;, &#039;Redov&aacute;n&#039;, &#039;Redov&aacute;n&#039;, &#039;Redov&aacute;n&#039;, &#039;Redov&aacute;n&#039;, 2),
    (8157, 1, NULL, NULL, &#039;Rebolledo&#039;, &#039;Rebolledo&#039;, &#039;Rebolledo&#039;, &#039;Rebolledo&#039;, &#039;Rebolledo&#039;, &#039;Rebolledo&#039;, &#039;Rebolledo&#039;, &#039;Rebolledo&#039;, &#039;Rebolledo&#039;, &#039;Rebolledo&#039;, &#039;Rebolledo&#039;, &#039;Rebolledo&#039;, &#039;Rebolledo&#039;, &#039;Rebolledo&#039;, &#039;Rebolledo&#039;, &#039;Rebolledo&#039;, 2),
    (8158, 1, NULL, NULL, &#039;Elda&#039;, &#039;Elda&#039;, &#039;Elda&#039;, &#039;Elda&#039;, &#039;Elda&#039;, &#039;Elda&#039;, &#039;Elda&#039;, &#039;Elda&#039;, &#039;Elda&#039;, &#039;Elda&#039;, &#039;Elda&#039;, &#039;Elda&#039;, &#039;Elda&#039;, &#039;Elda&#039;, &#039;Elda&#039;, &#039;Elda&#039;, 6),
    (8159, 1, NULL, NULL, &#039;Altet&#039;, &#039;Altet&#039;, &#039;Altet&#039;, &#039;Altet&#039;, &#039;Altet&#039;, &#039;Altet&#039;, &#039;Altet&#039;, &#039;Altet&#039;, &#039;Altet&#039;, &#039;Altet&#039;, &#039;Altet&#039;, &#039;Altet&#039;, &#039;Altet&#039;, &#039;Altet&#039;, &#039;Altet&#039;, &#039;Altet&#039;, 2),
    (8160, 1, NULL, NULL, &#039;Bigastro&#039;, &#039;Bigastro&#039;, &#039;Bigastro&#039;, &#039;Bigastro&#039;, &#039;Bigastro&#039;, &#039;Bigastro&#039;, &#039;Bigastro&#039;, &#039;Bigastro&#039;, &#039;Bigastro&#039;, &#039;Bigastro&#039;, &#039;Bigastro&#039;, &#039;Bigastro&#039;, &#039;Bigastro&#039;, &#039;Bigastro&#039;, &#039;Bigastro&#039;, &#039;Bigastro&#039;, 2),
    (8161, 1, NULL, NULL, &#039;Albatera&#039;, &#039;Albatera&#039;, &#039;Albatera&#039;, &#039;Albatera&#039;, &#039;Albatera&#039;, &#039;Albatera&#039;, &#039;Albatera&#039;, &#039;Albatera&#039;, &#039;Albatera&#039;, &#039;Albatera&#039;, &#039;Albatera&#039;, &#039;Albatera&#039;, &#039;Albatera&#039;, &#039;Albatera&#039;, &#039;Albatera&#039;, &#039;Albatera&#039;, 2),
    (8162, 1, NULL, NULL, &#039;Algorfa&#039;, &#039;Algorfa&#039;, &#039;Algorfa&#039;, &#039;Algorfa&#039;, &#039;Algorfa&#039;, &#039;Algorfa&#039;, &#039;Algorfa&#039;, &#039;Algorfa&#039;, &#039;Algorfa&#039;, &#039;Algorfa&#039;, &#039;Algorfa&#039;, &#039;Algorfa&#039;, &#039;Algorfa&#039;, &#039;Algorfa&#039;, &#039;Algorfa&#039;, &#039;Algorfa&#039;, 2),
    (8163, 1, NULL, NULL, &#039;Algue&ntilde;a&#039;, &#039;Algue&ntilde;a&#039;, &#039;Algue&ntilde;a&#039;, &#039;Algue&ntilde;a&#039;, &#039;Algue&ntilde;a&#039;, &#039;Algue&ntilde;a&#039;, &#039;Algue&ntilde;a&#039;, &#039;Algue&ntilde;a&#039;, &#039;Algue&ntilde;a&#039;, &#039;Algue&ntilde;a&#039;, &#039;Algue&ntilde;a&#039;, &#039;Algue&ntilde;a&#039;, &#039;Algue&ntilde;a&#039;, &#039;Algue&ntilde;a&#039;, &#039;Algue&ntilde;a&#039;, &#039;Algue&ntilde;a&#039;, 6),
    (8164, 1, NULL, NULL, &#039;Finestrat&#039;, &#039;Finestrat&#039;, &#039;Finestrat&#039;, &#039;Finestrat&#039;, &#039;Finestrat&#039;, &#039;Finestrat&#039;, &#039;Finestrat&#039;, &#039;Finestrat&#039;, &#039;Finestrat&#039;, &#039;Finestrat&#039;, &#039;Finestrat&#039;, &#039;Finestrat&#039;, &#039;Finestrat&#039;, &#039;Finestrat&#039;, &#039;Finestrat&#039;, &#039;Finestrat&#039;, 1),
    (8165, 3, NULL, NULL, &#039;Oliva&#039;, &#039;Oliva&#039;, &#039;Oliva&#039;, &#039;Oliva&#039;, &#039;Oliva&#039;, &#039;Oliva&#039;, &#039;Oliva&#039;, &#039;Oliva&#039;, &#039;Oliva&#039;, &#039;Oliva&#039;, &#039;Oliva&#039;, &#039;Oliva&#039;, &#039;Oliva&#039;, &#039;Oliva&#039;, &#039;Oliva&#039;, &#039;Oliva&#039;, 5),
    (8166, 1, NULL, NULL, &#039;San Isidro&#039;, &#039;San Isidro&#039;, &#039;San Isidro&#039;, &#039;San Isidro&#039;, &#039;San Isidro&#039;, &#039;San Isidro&#039;, &#039;San Isidro&#039;, &#039;San Isidro&#039;, &#039;San Isidro&#039;, &#039;San Isidro&#039;, &#039;San Isidro&#039;, &#039;San Isidro&#039;, &#039;San Isidro&#039;, &#039;San Isidro&#039;, &#039;San Isidro&#039;, &#039;San Isidro&#039;, 2),
    (8167, 1, NULL, NULL, &#039;Benitachell - Poble Nou&#039;, &#039;Benitachell - Poble Nou&#039;, &#039;Benitachell - Poble Nou&#039;, &#039;Benitachell - Poble Nou&#039;, &#039;Benitachell - Poble Nou&#039;, &#039;Benitachell - Poble Nou&#039;, &#039;Benitachell - Poble Nou&#039;, &#039;Benitachell - Poble Nou&#039;, &#039;Benitachell - Poble Nou&#039;, &#039;Benitachell - Poble Nou&#039;, &#039;Benitachell - Poble Nou&#039;, &#039;Benitachell - Poble Nou&#039;, &#039;Benitachell - Poble Nou&#039;, &#039;Benitachell - Poble Nou&#039;, &#039;Benitachell - Poble Nou&#039;, &#039;Benitachell - Poble Nou&#039;, 1),
    (8168, 1, NULL, NULL, &#039;El Campello&#039;, &#039;El Campello&#039;, &#039;El Campello&#039;, &#039;El Campello&#039;, &#039;El Campello&#039;, &#039;El Campello&#039;, &#039;El Campello&#039;, &#039;El Campello&#039;, &#039;El Campello&#039;, &#039;El Campello&#039;, &#039;El Campello&#039;, &#039;El Campello&#039;, &#039;El Campello&#039;, &#039;El Campello&#039;, &#039;El Campello&#039;, &#039;El Campello&#039;, 1),
    (8169, 1, NULL, NULL, &#039;Benissa&#039;, &#039;Benissa&#039;, &#039;Benissa&#039;, &#039;Benissa&#039;, &#039;Benissa&#039;, &#039;Benissa&#039;, &#039;Benissa&#039;, &#039;Benissa&#039;, &#039;Benissa&#039;, &#039;Benissa&#039;, &#039;Benissa&#039;, &#039;Benissa&#039;, &#039;Benissa&#039;, &#039;Benissa&#039;, &#039;Benissa&#039;, &#039;Benissa&#039;, 1),
    (8170, 1, NULL, NULL, &#039;Guardamar del Segura&#039;, &#039;Guardamar del Segura&#039;, &#039;Guardamar del Segura&#039;, &#039;Guardamar del Segura&#039;, &#039;Guardamar del Segura&#039;, &#039;Guardamar del Segura&#039;, &#039;Guardamar del Segura&#039;, &#039;Guardamar del Segura&#039;, &#039;Guardamar del Segura&#039;, &#039;Guardamar del Segura&#039;, &#039;Guardamar del Segura&#039;, &#039;Guardamar del Segura&#039;, &#039;Guardamar del Segura&#039;, &#039;Guardamar del Segura&#039;, &#039;Guardamar del Segura&#039;, &#039;Guardamar del Segura&#039;, 2),
    (8171, 1, NULL, NULL, &#039;Urbanova&#039;, &#039;Urbanova&#039;, &#039;Urbanova&#039;, &#039;Urbanova&#039;, &#039;Urbanova&#039;, &#039;Urbanova&#039;, &#039;Urbanova&#039;, &#039;Urbanova&#039;, &#039;Urbanova&#039;, &#039;Urbanova&#039;, &#039;Urbanova&#039;, &#039;Urbanova&#039;, &#039;Urbanova&#039;, &#039;Urbanova&#039;, &#039;Urbanova&#039;, &#039;Urbanova&#039;, 2),
    (8172, 1, NULL, NULL, &#039;Els Poblets&#039;, &#039;Els Poblets&#039;, &#039;Els Poblets&#039;, &#039;Els Poblets&#039;, &#039;Els Poblets&#039;, &#039;Els Poblets&#039;, &#039;Els Poblets&#039;, &#039;Els Poblets&#039;, &#039;Els Poblets&#039;, &#039;Els Poblets&#039;, &#039;Els Poblets&#039;, &#039;Els Poblets&#039;, &#039;Els Poblets&#039;, &#039;Els Poblets&#039;, &#039;Els Poblets&#039;, &#039;Els Poblets&#039;, 1),
    (8173, 1, NULL, NULL, &#039;Altea&#039;, &#039;Altea&#039;, &#039;Altea&#039;, &#039;Altea&#039;, &#039;Altea&#039;, &#039;Altea&#039;, &#039;Altea&#039;, &#039;Altea&#039;, &#039;Altea&#039;, &#039;Altea&#039;, &#039;Altea&#039;, &#039;Altea&#039;, &#039;Altea&#039;, &#039;Altea&#039;, &#039;Altea&#039;, &#039;Altea&#039;, 1),
    (8174, 1, NULL, NULL, &#039;Vergel&#039;, &#039;Vergel&#039;, &#039;Vergel&#039;, &#039;Vergel&#039;, &#039;Vergel&#039;, &#039;Vergel&#039;, &#039;Vergel&#039;, &#039;Vergel&#039;, &#039;Vergel&#039;, &#039;Vergel&#039;, &#039;Vergel&#039;, &#039;Vergel&#039;, &#039;Vergel&#039;, &#039;Vergel&#039;, &#039;Vergel&#039;, &#039;Vergel&#039;, 1),
    (8175, 1, NULL, NULL, &#039;Onil&#039;, &#039;Onil&#039;, &#039;Onil&#039;, &#039;Onil&#039;, &#039;Onil&#039;, &#039;Onil&#039;, &#039;Onil&#039;, &#039;Onil&#039;, &#039;Onil&#039;, &#039;Onil&#039;, &#039;Onil&#039;, &#039;Onil&#039;, &#039;Onil&#039;, &#039;Onil&#039;, &#039;Onil&#039;, &#039;Onil&#039;, 6),
    (8176, 1, NULL, NULL, &#039;Orihuela&#039;, &#039;Orihuela&#039;, &#039;Orihuela&#039;, &#039;Orihuela&#039;, &#039;Orihuela&#039;, &#039;Orihuela&#039;, &#039;Orihuela&#039;, &#039;Orihuela&#039;, &#039;Orihuela&#039;, &#039;Orihuela&#039;, &#039;Orihuela&#039;, &#039;Orihuela&#039;, &#039;Orihuela&#039;, &#039;Orihuela&#039;, &#039;Orihuela&#039;, &#039;Orihuela&#039;, 2),
    (8177, 1, NULL, NULL, &#039;San Vicente del Raspeig&#039;, &#039;San Vicente del Raspeig&#039;, &#039;San Vicente del Raspeig&#039;, &#039;San Vicente del Raspeig&#039;, &#039;San Vicente del Raspeig&#039;, &#039;San Vicente del Raspeig&#039;, &#039;San Vicente del Raspeig&#039;, &#039;San Vicente del Raspeig&#039;, &#039;San Vicente del Raspeig&#039;, &#039;San Vicente del Raspeig&#039;, &#039;San Vicente del Raspeig&#039;, &#039;San Vicente del Raspeig&#039;, &#039;San Vicente del Raspeig&#039;, &#039;San Vicente del Raspeig&#039;, &#039;San Vicente del Raspeig&#039;, &#039;San Vicente del Raspeig&#039;, 2),
    (8178, 1, NULL, NULL, &#039;San Miguel de Salinas&#039;, &#039;San Miguel de Salinas&#039;, &#039;San Miguel de Salinas&#039;, &#039;San Miguel de Salinas&#039;, &#039;San Miguel de Salinas&#039;, &#039;San Miguel de Salinas&#039;, &#039;San Miguel de Salinas&#039;, &#039;San Miguel de Salinas&#039;, &#039;San Miguel de Salinas&#039;, &#039;San Miguel de Salinas&#039;, &#039;San Miguel de Salinas&#039;, &#039;San Miguel de Salinas&#039;, &#039;San Miguel de Salinas&#039;, &#039;San Miguel de Salinas&#039;, &#039;San Miguel de Salinas&#039;, &#039;San Miguel de Salinas&#039;, 2),
    (8179, 1, NULL, NULL, &#039;Hond&oacute;n de los Fr&aacute;iles&#039;, &#039;Hond&oacute;n de los Fr&aacute;iles&#039;, &#039;Hond&oacute;n de los Fr&aacute;iles&#039;, &#039;Hond&oacute;n de los Fr&aacute;iles&#039;, &#039;Hond&oacute;n de los Fr&aacute;iles&#039;, &#039;Hond&oacute;n de los Fr&aacute;iles&#039;, &#039;Hond&oacute;n de los Fr&aacute;iles&#039;, &#039;Hond&oacute;n de los Fr&aacute;iles&#039;, &#039;Hond&oacute;n de los Fr&aacute;iles&#039;, &#039;Hond&oacute;n de los Fr&aacute;iles&#039;, &#039;Hond&oacute;n de los Fr&aacute;iles&#039;, &#039;Hond&oacute;n de los Fr&aacute;iles&#039;, &#039;Hond&oacute;n de los Fr&aacute;iles&#039;, &#039;Hond&oacute;n de los Fr&aacute;iles&#039;, &#039;Hond&oacute;n de los Fr&aacute;iles&#039;, &#039;Hond&oacute;n de los Fr&aacute;iles&#039;, 6),
    (8180, 1, NULL, NULL, &#039;Hond&oacute;n de las Nieves&#039;, &#039;Hond&oacute;n de las Nieves&#039;, &#039;Hond&oacute;n de las Nieves&#039;, &#039;Hond&oacute;n de las Nieves&#039;, &#039;Hond&oacute;n de las Nieves&#039;, &#039;Hond&oacute;n de las Nieves&#039;, &#039;Hond&oacute;n de las Nieves&#039;, &#039;Hond&oacute;n de las Nieves&#039;, &#039;Hond&oacute;n de las Nieves&#039;, &#039;Hond&oacute;n de las Nieves&#039;, &#039;Hond&oacute;n de las Nieves&#039;, &#039;Hond&oacute;n de las Nieves&#039;, &#039;Hond&oacute;n de las Nieves&#039;, &#039;Hond&oacute;n de las Nieves&#039;, &#039;Hond&oacute;n de las Nieves&#039;, &#039;Hond&oacute;n de las Nieves&#039;, 6),
    (8181, 1, NULL, NULL, &#039;Benferri&#039;, &#039;Benferri&#039;, &#039;Benferri&#039;, &#039;Benferri&#039;, &#039;Benferri&#039;, &#039;Benferri&#039;, &#039;Benferri&#039;, &#039;Benferri&#039;, &#039;Benferri&#039;, &#039;Benferri&#039;, &#039;Benferri&#039;, &#039;Benferri&#039;, &#039;Benferri&#039;, &#039;Benferri&#039;, &#039;Benferri&#039;, &#039;Benferri&#039;, 2),
    (8182, 1, NULL, NULL, &#039;Villajoyosa&#039;, &#039;Villajoyosa&#039;, &#039;Villajoyosa&#039;, &#039;Villajoyosa&#039;, &#039;Villajoyosa&#039;, &#039;Villajoyosa&#039;, &#039;Villajoyosa&#039;, &#039;Villajoyosa&#039;, &#039;Villajoyosa&#039;, &#039;Villajoyosa&#039;, &#039;Villajoyosa&#039;, &#039;Villajoyosa&#039;, &#039;Villajoyosa&#039;, &#039;Villajoyosa&#039;, &#039;Villajoyosa&#039;, &#039;Villajoyosa&#039;, 1),
    (8183, 1, NULL, NULL, &#039;Pego&#039;, &#039;Pego&#039;, &#039;Pego&#039;, &#039;Pego&#039;, &#039;Pego&#039;, &#039;Pego&#039;, &#039;Pego&#039;, &#039;Pego&#039;, &#039;Pego&#039;, &#039;Pego&#039;, &#039;Pego&#039;, &#039;Pego&#039;, &#039;Pego&#039;, &#039;Pego&#039;, &#039;Pego&#039;, &#039;Pego&#039;, 1),
    (8184, 1, NULL, NULL, &#039;Villena&#039;, &#039;Villena&#039;, &#039;Villena&#039;, &#039;Villena&#039;, &#039;Villena&#039;, &#039;Villena&#039;, &#039;Villena&#039;, &#039;Villena&#039;, &#039;Villena&#039;, &#039;Villena&#039;, &#039;Villena&#039;, &#039;Villena&#039;, &#039;Villena&#039;, &#039;Villena&#039;, &#039;Villena&#039;, &#039;Villena&#039;, 6),
    (8185, 1, NULL, NULL, &#039;Rafal&#039;, &#039;Rafal&#039;, &#039;Rafal&#039;, &#039;Rafal&#039;, &#039;Rafal&#039;, &#039;Rafal&#039;, &#039;Rafal&#039;, &#039;Rafal&#039;, &#039;Rafal&#039;, &#039;Rafal&#039;, &#039;Rafal&#039;, &#039;Rafal&#039;, &#039;Rafal&#039;, &#039;Rafal&#039;, &#039;Rafal&#039;, &#039;Rafal&#039;, 2),
    (8186, 1, NULL, NULL, &#039;Teulada&#039;, &#039;Teulada&#039;, &#039;Teulada&#039;, &#039;Teulada&#039;, &#039;Teulada&#039;, &#039;Teulada&#039;, &#039;Teulada&#039;, &#039;Teulada&#039;, &#039;Teulada&#039;, &#039;Teulada&#039;, &#039;Teulada&#039;, &#039;Teulada&#039;, &#039;Teulada&#039;, &#039;Teulada&#039;, &#039;Teulada&#039;, &#039;Teulada&#039;, 1),
    (8187, 1, NULL, NULL, &#039;Jal&oacute;n&#039;, &#039;Jal&oacute;n&#039;, &#039;Jal&oacute;n&#039;, &#039;Jal&oacute;n&#039;, &#039;Jal&oacute;n&#039;, &#039;Jal&oacute;n&#039;, &#039;Jal&oacute;n&#039;, &#039;Jal&oacute;n&#039;, &#039;Jal&oacute;n&#039;, &#039;Jal&oacute;n&#039;, &#039;Jal&oacute;n&#039;, &#039;Jal&oacute;n&#039;, &#039;Jal&oacute;n&#039;, &#039;Jal&oacute;n&#039;, &#039;Jal&oacute;n&#039;, &#039;Jal&oacute;n&#039;, 1),
    (8188, 1, NULL, NULL, &#039;Callosa De Ensarri&agrave;&#039;, &#039;Callosa De Ensarri&agrave;&#039;, &#039;Callosa De Ensarri&agrave;&#039;, &#039;Callosa De Ensarri&agrave;&#039;, &#039;Callosa De Ensarri&agrave;&#039;, &#039;Callosa De Ensarri&agrave;&#039;, &#039;Callosa De Ensarri&agrave;&#039;, &#039;Callosa De Ensarri&agrave;&#039;, &#039;Callosa De Ensarri&agrave;&#039;, &#039;Callosa De Ensarri&agrave;&#039;, &#039;Callosa De Ensarri&agrave;&#039;, &#039;Callosa De Ensarri&agrave;&#039;, &#039;Callosa De Ensarri&agrave;&#039;, &#039;Callosa De Ensarri&agrave;&#039;, &#039;Callosa De Ensarri&agrave;&#039;, &#039;Callosa De Ensarri&agrave;&#039;, 1),
    (8189, 1, NULL, NULL, &#039;Aspe&#039;, &#039;Aspe&#039;, &#039;Aspe&#039;, &#039;Aspe&#039;, &#039;Aspe&#039;, &#039;Aspe&#039;, &#039;Aspe&#039;, &#039;Aspe&#039;, &#039;Aspe&#039;, &#039;Aspe&#039;, &#039;Aspe&#039;, &#039;Aspe&#039;, &#039;Aspe&#039;, &#039;Aspe&#039;, &#039;Aspe&#039;, &#039;Aspe&#039;, 2),
    (8190, 1, NULL, NULL, &#039;La Romana&#039;, &#039;La Romana&#039;, &#039;La Romana&#039;, &#039;La Romana&#039;, &#039;La Romana&#039;, &#039;La Romana&#039;, &#039;La Romana&#039;, &#039;La Romana&#039;, &#039;La Romana&#039;, &#039;La Romana&#039;, &#039;La Romana&#039;, &#039;La Romana&#039;, &#039;La Romana&#039;, &#039;La Romana&#039;, &#039;La Romana&#039;, &#039;La Romana&#039;, 6),
    (8191, 1, NULL, NULL, &#039;Monforte del Cid&#039;, &#039;Monforte del Cid&#039;, &#039;Monforte del Cid&#039;, &#039;Monforte del Cid&#039;, &#039;Monforte del Cid&#039;, &#039;Monforte del Cid&#039;, &#039;Monforte del Cid&#039;, &#039;Monforte del Cid&#039;, &#039;Monforte del Cid&#039;, &#039;Monforte del Cid&#039;, &#039;Monforte del Cid&#039;, &#039;Monforte del Cid&#039;, &#039;Monforte del Cid&#039;, &#039;Monforte del Cid&#039;, &#039;Monforte del Cid&#039;, &#039;Monforte del Cid&#039;, 2),
    (8192, 1, NULL, NULL, &#039;Novelda&#039;, &#039;Novelda&#039;, &#039;Novelda&#039;, &#039;Novelda&#039;, &#039;Novelda&#039;, &#039;Novelda&#039;, &#039;Novelda&#039;, &#039;Novelda&#039;, &#039;Novelda&#039;, &#039;Novelda&#039;, &#039;Novelda&#039;, &#039;Novelda&#039;, &#039;Novelda&#039;, &#039;Novelda&#039;, &#039;Novelda&#039;, &#039;Novelda&#039;, 6),
    (8193, 1, NULL, NULL, &#039;Busot&#039;, &#039;Busot&#039;, &#039;Busot&#039;, &#039;Busot&#039;, &#039;Busot&#039;, &#039;Busot&#039;, &#039;Busot&#039;, &#039;Busot&#039;, &#039;Busot&#039;, &#039;Busot&#039;, &#039;Busot&#039;, &#039;Busot&#039;, &#039;Busot&#039;, &#039;Busot&#039;, &#039;Busot&#039;, &#039;Busot&#039;, 1),
    (8194, 1, NULL, NULL, &#039;Muchamiel&#039;, &#039;Muchamiel&#039;, &#039;Muchamiel&#039;, &#039;Muchamiel&#039;, &#039;Muchamiel&#039;, &#039;Muchamiel&#039;, &#039;Muchamiel&#039;, &#039;Muchamiel&#039;, &#039;Muchamiel&#039;, &#039;Muchamiel&#039;, &#039;Muchamiel&#039;, &#039;Muchamiel&#039;, &#039;Muchamiel&#039;, &#039;Muchamiel&#039;, &#039;Muchamiel&#039;, &#039;Muchamiel&#039;, 1),
    (8195, 1, NULL, NULL, &#039;San Juan de Alicante&#039;, &#039;San Juan de Alicante&#039;, &#039;San Juan de Alicante&#039;, &#039;San Juan de Alicante&#039;, &#039;San Juan de Alicante&#039;, &#039;San Juan de Alicante&#039;, &#039;San Juan de Alicante&#039;, &#039;San Juan de Alicante&#039;, &#039;San Juan de Alicante&#039;, &#039;San Juan de Alicante&#039;, &#039;San Juan de Alicante&#039;, &#039;San Juan de Alicante&#039;, &#039;San Juan de Alicante&#039;, &#039;San Juan de Alicante&#039;, &#039;San Juan de Alicante&#039;, &#039;San Juan de Alicante&#039;, 2),
    (8196, 1, NULL, NULL, &#039;Catral&#039;, &#039;Catral&#039;, &#039;Catral&#039;, &#039;Catral&#039;, &#039;Catral&#039;, &#039;Catral&#039;, &#039;Catral&#039;, &#039;Catral&#039;, &#039;Catral&#039;, &#039;Catral&#039;, &#039;Catral&#039;, &#039;Catral&#039;, &#039;Catral&#039;, &#039;Catral&#039;, &#039;Catral&#039;, &#039;Catral&#039;, 2),
    (8197, 1, NULL, NULL, &#039;Beniarbeig&#039;, &#039;Beniarbeig&#039;, &#039;Beniarbeig&#039;, &#039;Beniarbeig&#039;, &#039;Beniarbeig&#039;, &#039;Beniarbeig&#039;, &#039;Beniarbeig&#039;, &#039;Beniarbeig&#039;, &#039;Beniarbeig&#039;, &#039;Beniarbeig&#039;, &#039;Beniarbeig&#039;, &#039;Beniarbeig&#039;, &#039;Beniarbeig&#039;, &#039;Beniarbeig&#039;, &#039;Beniarbeig&#039;, &#039;Beniarbeig&#039;, 1),
    (8198, 3, NULL, NULL, &#039;Gand&iacute;a&#039;, &#039;Gand&iacute;a&#039;, &#039;Gand&iacute;a&#039;, &#039;Gand&iacute;a&#039;, &#039;Gand&iacute;a&#039;, &#039;Gand&iacute;a&#039;, &#039;Gand&iacute;a&#039;, &#039;Gand&iacute;a&#039;, &#039;Gand&iacute;a&#039;, &#039;Gand&iacute;a&#039;, &#039;Gand&iacute;a&#039;, &#039;Gand&iacute;a&#039;, &#039;Gand&iacute;a&#039;, &#039;Gand&iacute;a&#039;, &#039;Gand&iacute;a&#039;, &#039;Gand&iacute;a&#039;, 1),
    (8199, 1, NULL, NULL, &#039;Gata de Gorgos&#039;, &#039;Gata de Gorgos&#039;, &#039;Gata de Gorgos&#039;, &#039;Gata de Gorgos&#039;, &#039;Gata de Gorgos&#039;, &#039;Gata de Gorgos&#039;, &#039;Gata de Gorgos&#039;, &#039;Gata de Gorgos&#039;, &#039;Gata de Gorgos&#039;, &#039;Gata de Gorgos&#039;, &#039;Gata de Gorgos&#039;, &#039;Gata de Gorgos&#039;, &#039;Gata de Gorgos&#039;, &#039;Gata de Gorgos&#039;, &#039;Gata de Gorgos&#039;, &#039;Gata de Gorgos&#039;, 1),
    (8200, 1, NULL, NULL, &#039;Vall de Gallinera&#039;, &#039;Vall de Gallinera&#039;, &#039;Vall de Gallinera&#039;, &#039;Vall de Gallinera&#039;, &#039;Vall de Gallinera&#039;, &#039;Vall de Gallinera&#039;, &#039;Vall de Gallinera&#039;, &#039;Vall de Gallinera&#039;, &#039;Vall de Gallinera&#039;, &#039;Vall de Gallinera&#039;, &#039;Vall de Gallinera&#039;, &#039;Vall de Gallinera&#039;, &#039;Vall de Gallinera&#039;, &#039;Vall de Gallinera&#039;, &#039;Vall de Gallinera&#039;, &#039;Vall de Gallinera&#039;, 1),
    (8201, 1, NULL, NULL, &#039;Alcoy&#039;, &#039;Alcoy&#039;, &#039;Alcoy&#039;, &#039;Alcoy&#039;, &#039;Alcoy&#039;, &#039;Alcoy&#039;, &#039;Alcoy&#039;, &#039;Alcoy&#039;, &#039;Alcoy&#039;, &#039;Alcoy&#039;, &#039;Alcoy&#039;, &#039;Alcoy&#039;, &#039;Alcoy&#039;, &#039;Alcoy&#039;, &#039;Alcoy&#039;, &#039;Alcoy&#039;, 1),
    (8202, 1, NULL, NULL, &#039;Alcalal&iacute;&#039;, &#039;Alcalal&iacute;&#039;, &#039;Alcalal&iacute;&#039;, &#039;Alcalal&iacute;&#039;, &#039;Alcalal&iacute;&#039;, &#039;Alcalal&iacute;&#039;, &#039;Alcalal&iacute;&#039;, &#039;Alcalal&iacute;&#039;, &#039;Alcalal&iacute;&#039;, &#039;Alcalal&iacute;&#039;, &#039;Alcalal&iacute;&#039;, &#039;Alcalal&iacute;&#039;, &#039;Alcalal&iacute;&#039;, &#039;Alcalal&iacute;&#039;, &#039;Alcalal&iacute;&#039;, &#039;Alcalal&iacute;&#039;, 1),
    (8203, 1, NULL, NULL, &#039;Jijona&#039;, &#039;Jijona&#039;, &#039;Jijona&#039;, &#039;Jijona&#039;, &#039;Jijona&#039;, &#039;Jijona&#039;, &#039;Jijona&#039;, &#039;Jijona&#039;, &#039;Jijona&#039;, &#039;Jijona&#039;, &#039;Jijona&#039;, &#039;Jijona&#039;, &#039;Jijona&#039;, &#039;Jijona&#039;, &#039;Jijona&#039;, &#039;Jijona&#039;, 1),
    (8204, 1, NULL, NULL, &#039;L\&#039;Alqueria Dansar&#039;, &#039;L\&#039;Alqueria Dansar&#039;, &#039;L\&#039;Alqueria Dansar&#039;, &#039;L\&#039;Alqueria Dansar&#039;, &#039;L\&#039;Alqueria Dansar&#039;, &#039;L\&#039;Alqueria Dansar&#039;, &#039;L\&#039;Alqueria Dansar&#039;, &#039;L\&#039;Alqueria Dansar&#039;, &#039;L\&#039;Alqueria Dansar&#039;, &#039;L\&#039;Alqueria Dansar&#039;, &#039;L\&#039;Alqueria Dansar&#039;, &#039;L\&#039;Alqueria Dansar&#039;, &#039;L\&#039;Alqueria Dansar&#039;, &#039;L\&#039;Alqueria Dansar&#039;, &#039;L\&#039;Alqueria Dansar&#039;, &#039;L\&#039;Alqueria Dansar&#039;, 6),
    (8205, 1, NULL, NULL, &#039;Cox&#039;, &#039;Cox&#039;, &#039;Cox&#039;, &#039;Cox&#039;, &#039;Cox&#039;, &#039;Cox&#039;, &#039;Cox&#039;, &#039;Cox&#039;, &#039;Cox&#039;, &#039;Cox&#039;, &#039;Cox&#039;, &#039;Cox&#039;, &#039;Cox&#039;, &#039;Cox&#039;, &#039;Cox&#039;, &#039;Cox&#039;, 2),
    (8206, 1, NULL, NULL, &#039;Daya Nueva&#039;, &#039;Daya Nueva&#039;, &#039;Daya Nueva&#039;, &#039;Daya Nueva&#039;, &#039;Daya Nueva&#039;, &#039;Daya Nueva&#039;, &#039;Daya Nueva&#039;, &#039;Daya Nueva&#039;, &#039;Daya Nueva&#039;, &#039;Daya Nueva&#039;, &#039;Daya Nueva&#039;, &#039;Daya Nueva&#039;, &#039;Daya Nueva&#039;, &#039;Daya Nueva&#039;, &#039;Daya Nueva&#039;, &#039;Daya Nueva&#039;, 2),
    (8207, 1, NULL, NULL, &#039;Petrer&#039;, &#039;Petrer&#039;, &#039;Petrer&#039;, &#039;Petrer&#039;, &#039;Petrer&#039;, &#039;Petrer&#039;, &#039;Petrer&#039;, &#039;Petrer&#039;, &#039;Petrer&#039;, &#039;Petrer&#039;, &#039;Petrer&#039;, &#039;Petrer&#039;, &#039;Petrer&#039;, &#039;Petrer&#039;, &#039;Petrer&#039;, &#039;Petrer&#039;, 6),
    (8208, 1, NULL, NULL, &#039;Almorad&iacute;&#039;, &#039;Almorad&iacute;&#039;, &#039;Almorad&iacute;&#039;, &#039;Almorad&iacute;&#039;, &#039;Almorad&iacute;&#039;, &#039;Almorad&iacute;&#039;, &#039;Almorad&iacute;&#039;, &#039;Almorad&iacute;&#039;, &#039;Almorad&iacute;&#039;, &#039;Almorad&iacute;&#039;, &#039;Almorad&iacute;&#039;, &#039;Almorad&iacute;&#039;, &#039;Almorad&iacute;&#039;, &#039;Almorad&iacute;&#039;, &#039;Almorad&iacute;&#039;, &#039;Almorad&iacute;&#039;, 2),
    (8209, 1, NULL, NULL, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, 2),
    (8210, 1, NULL, NULL, &#039;Pilar de la Horadada&#039;, &#039;Pilar de la Horadada&#039;, &#039;Pilar de la Horadada&#039;, &#039;Pilar de la Horadada&#039;, &#039;Pilar de la Horadada&#039;, &#039;Pilar de la Horadada&#039;, &#039;Pilar de la Horadada&#039;, &#039;Pilar de la Horadada&#039;, &#039;Pilar de la Horadada&#039;, &#039;Pilar de la Horadada&#039;, &#039;Pilar de la Horadada&#039;, &#039;Pilar de la Horadada&#039;, &#039;Pilar de la Horadada&#039;, &#039;Pilar de la Horadada&#039;, &#039;Pilar de la Horadada&#039;, &#039;Pilar de la Horadada&#039;, 2),
    (8211, 1, NULL, NULL, &#039;Orba&#039;, &#039;Orba&#039;, &#039;Orba&#039;, &#039;Orba&#039;, &#039;Orba&#039;, &#039;Orba&#039;, &#039;Orba&#039;, &#039;Orba&#039;, &#039;Orba&#039;, &#039;Orba&#039;, &#039;Orba&#039;, &#039;Orba&#039;, &#039;Orba&#039;, &#039;Orba&#039;, &#039;Orba&#039;, &#039;Orba&#039;, 6),
    (8212, 1, NULL, NULL, &#039;Montesinos&#039;, &#039;Montesinos&#039;, &#039;Montesinos&#039;, &#039;Montesinos&#039;, &#039;Montesinos&#039;, &#039;Montesinos&#039;, &#039;Montesinos&#039;, &#039;Montesinos&#039;, &#039;Montesinos&#039;, &#039;Montesinos&#039;, &#039;Montesinos&#039;, &#039;Montesinos&#039;, &#039;Montesinos&#039;, &#039;Montesinos&#039;, &#039;Montesinos&#039;, &#039;Montesinos&#039;, 2),
    (8213, 1, NULL, NULL, &#039;Granja de Rocamora&#039;, &#039;Granja de Rocamora&#039;, &#039;Granja de Rocamora&#039;, &#039;Granja de Rocamora&#039;, &#039;Granja de Rocamora&#039;, &#039;Granja de Rocamora&#039;, &#039;Granja de Rocamora&#039;, &#039;Granja de Rocamora&#039;, &#039;Granja de Rocamora&#039;, &#039;Granja de Rocamora&#039;, &#039;Granja de Rocamora&#039;, &#039;Granja de Rocamora&#039;, &#039;Granja de Rocamora&#039;, &#039;Granja de Rocamora&#039;, &#039;Granja de Rocamora&#039;, &#039;Granja de Rocamora&#039;, 2),
    (8214, 5, NULL, NULL, &#039;Torre Pacheco&#039;, &#039;Torre Pacheco&#039;, &#039;Torre Pacheco&#039;, &#039;Torre Pacheco&#039;, &#039;Torre Pacheco&#039;, &#039;Torre Pacheco&#039;, &#039;Torre Pacheco&#039;, &#039;Torre Pacheco&#039;, &#039;Torre Pacheco&#039;, &#039;Torre Pacheco&#039;, &#039;Torre Pacheco&#039;, &#039;Torre Pacheco&#039;, &#039;Torre Pacheco&#039;, &#039;Torre Pacheco&#039;, &#039;Torre Pacheco&#039;, &#039;Torre Pacheco&#039;, 3),
    (8215, 1, NULL, NULL, &#039;Benimantell&#039;, &#039;Benimantell&#039;, &#039;Benimantell&#039;, &#039;Benimantell&#039;, &#039;Benimantell&#039;, &#039;Benimantell&#039;, &#039;Benimantell&#039;, &#039;Benimantell&#039;, &#039;Benimantell&#039;, &#039;Benimantell&#039;, &#039;Benimantell&#039;, &#039;Benimantell&#039;, &#039;Benimantell&#039;, &#039;Benimantell&#039;, &#039;Benimantell&#039;, &#039;Benimantell&#039;, 1),
    (8216, 1, NULL, NULL, &#039;Formentera del Segura&#039;, &#039;Formentera del Segura&#039;, &#039;Formentera del Segura&#039;, &#039;Formentera del Segura&#039;, &#039;Formentera del Segura&#039;, &#039;Formentera del Segura&#039;, &#039;Formentera del Segura&#039;, &#039;Formentera del Segura&#039;, &#039;Formentera del Segura&#039;, &#039;Formentera del Segura&#039;, &#039;Formentera del Segura&#039;, &#039;Formentera del Segura&#039;, &#039;Formentera del Segura&#039;, &#039;Formentera del Segura&#039;, &#039;Formentera del Segura&#039;, &#039;Formentera del Segura&#039;, 2),
    (8217, 1, NULL, NULL, &#039;Dolores&#039;, &#039;Dolores&#039;, &#039;Dolores&#039;, &#039;Dolores&#039;, &#039;Dolores&#039;, &#039;Dolores&#039;, &#039;Dolores&#039;, &#039;Dolores&#039;, &#039;Dolores&#039;, &#039;Dolores&#039;, &#039;Dolores&#039;, &#039;Dolores&#039;, &#039;Dolores&#039;, &#039;Dolores&#039;, &#039;Dolores&#039;, &#039;Dolores&#039;, 2),
    (8218, 1, NULL, NULL, &#039;Ibi&#039;, &#039;Ibi&#039;, &#039;Ibi&#039;, &#039;Ibi&#039;, &#039;Ibi&#039;, &#039;Ibi&#039;, &#039;Ibi&#039;, &#039;Ibi&#039;, &#039;Ibi&#039;, &#039;Ibi&#039;, &#039;Ibi&#039;, &#039;Ibi&#039;, &#039;Ibi&#039;, &#039;Ibi&#039;, &#039;Ibi&#039;, &#039;Ibi&#039;, 6),
    (8219, 1, NULL, NULL, &#039;Benej&uacute;zar&#039;, &#039;Benej&uacute;zar&#039;, &#039;Benej&uacute;zar&#039;, &#039;Benej&uacute;zar&#039;, &#039;Benej&uacute;zar&#039;, &#039;Benej&uacute;zar&#039;, &#039;Benej&uacute;zar&#039;, &#039;Benej&uacute;zar&#039;, &#039;Benej&uacute;zar&#039;, &#039;Benej&uacute;zar&#039;, &#039;Benej&uacute;zar&#039;, &#039;Benej&uacute;zar&#039;, &#039;Benej&uacute;zar&#039;, &#039;Benej&uacute;zar&#039;, &#039;Benej&uacute;zar&#039;, &#039;Benej&uacute;zar&#039;, 2),
    (8220, 1, NULL, NULL, &#039;Agost&#039;, &#039;Agost&#039;, &#039;Agost&#039;, &#039;Agost&#039;, &#039;Agost&#039;, &#039;Agost&#039;, &#039;Agost&#039;, &#039;Agost&#039;, &#039;Agost&#039;, &#039;Agost&#039;, &#039;Agost&#039;, &#039;Agost&#039;, &#039;Agost&#039;, &#039;Agost&#039;, &#039;Agost&#039;, &#039;Agost&#039;, 6),
    (8221, 1, NULL, NULL, &#039;Crevillente&#039;, &#039;Crevillente&#039;, &#039;Crevillente&#039;, &#039;Crevillente&#039;, &#039;Crevillente&#039;, &#039;Crevillente&#039;, &#039;Crevillente&#039;, &#039;Crevillente&#039;, &#039;Crevillente&#039;, &#039;Crevillente&#039;, &#039;Crevillente&#039;, &#039;Crevillente&#039;, &#039;Crevillente&#039;, &#039;Crevillente&#039;, &#039;Crevillente&#039;, &#039;Crevillente&#039;, 2),
    (8222, 3, NULL, NULL, &#039;Sueca&#039;, &#039;Sueca&#039;, &#039;Sueca&#039;, &#039;Sueca&#039;, &#039;Sueca&#039;, &#039;Sueca&#039;, &#039;Sueca&#039;, &#039;Sueca&#039;, &#039;Sueca&#039;, &#039;Sueca&#039;, &#039;Sueca&#039;, &#039;Sueca&#039;, &#039;Sueca&#039;, &#039;Sueca&#039;, &#039;Sueca&#039;, &#039;Sueca&#039;, 5),
    (8223, 5, NULL, NULL, &#039;San Pedro del Pinatar&#039;, &#039;San Pedro del Pinatar&#039;, &#039;San Pedro del Pinatar&#039;, &#039;San Pedro del Pinatar&#039;, &#039;San Pedro del Pinatar&#039;, &#039;San Pedro del Pinatar&#039;, &#039;San Pedro del Pinatar&#039;, &#039;San Pedro del Pinatar&#039;, &#039;San Pedro del Pinatar&#039;, &#039;San Pedro del Pinatar&#039;, &#039;San Pedro del Pinatar&#039;, &#039;San Pedro del Pinatar&#039;, &#039;San Pedro del Pinatar&#039;, &#039;San Pedro del Pinatar&#039;, &#039;San Pedro del Pinatar&#039;, &#039;San Pedro del Pinatar&#039;, 3),
    (8224, 5, NULL, NULL, &#039;Fortuna&#039;, &#039;Fortuna&#039;, &#039;Fortuna&#039;, &#039;Fortuna&#039;, &#039;Fortuna&#039;, &#039;Fortuna&#039;, &#039;Fortuna&#039;, &#039;Fortuna&#039;, &#039;Fortuna&#039;, &#039;Fortuna&#039;, &#039;Fortuna&#039;, &#039;Fortuna&#039;, &#039;Fortuna&#039;, &#039;Fortuna&#039;, &#039;Fortuna&#039;, &#039;Fortuna&#039;, 6),
    (8225, 1, NULL, NULL, &#039;R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;R&agrave;fol D\&#039;Alm&uacute;nia&#039;, 6),
    (8226, 1, NULL, NULL, &#039;Benijofar&#039;, &#039;Benijofar&#039;, &#039;Benijofar&#039;, &#039;Benijofar&#039;, &#039;Benijofar&#039;, &#039;Benijofar&#039;, &#039;Benijofar&#039;, &#039;Benijofar&#039;, &#039;Benijofar&#039;, &#039;Benijofar&#039;, &#039;Benijofar&#039;, &#039;Benijofar&#039;, &#039;Benijofar&#039;, &#039;Benijofar&#039;, &#039;Benijofar&#039;, &#039;Benijofar&#039;, 2),
    (8227, 1, NULL, NULL, &#039;Tibi&#039;, &#039;Tibi&#039;, &#039;Tibi&#039;, &#039;Tibi&#039;, &#039;Tibi&#039;, &#039;Tibi&#039;, &#039;Tibi&#039;, &#039;Tibi&#039;, &#039;Tibi&#039;, &#039;Tibi&#039;, &#039;Tibi&#039;, &#039;Tibi&#039;, &#039;Tibi&#039;, &#039;Tibi&#039;, &#039;Tibi&#039;, &#039;Tibi&#039;, 6),
    (8228, 1, NULL, NULL, &#039;San Fulgencio&#039;, &#039;San Fulgencio&#039;, &#039;San Fulgencio&#039;, &#039;San Fulgencio&#039;, &#039;San Fulgencio&#039;, &#039;San Fulgencio&#039;, &#039;San Fulgencio&#039;, &#039;San Fulgencio&#039;, &#039;San Fulgencio&#039;, &#039;San Fulgencio&#039;, &#039;San Fulgencio&#039;, &#039;San Fulgencio&#039;, &#039;San Fulgencio&#039;, &#039;San Fulgencio&#039;, &#039;San Fulgencio&#039;, &#039;San Fulgencio&#039;, 2),
    (8230, 1, NULL, NULL, &#039;Ca&ntilde;ada&#039;, &#039;Ca&ntilde;ada&#039;, &#039;Ca&ntilde;ada&#039;, &#039;Ca&ntilde;ada&#039;, &#039;Ca&ntilde;ada&#039;, &#039;Ca&ntilde;ada&#039;, &#039;Ca&ntilde;ada&#039;, &#039;Ca&ntilde;ada&#039;, &#039;Ca&ntilde;ada&#039;, &#039;Ca&ntilde;ada&#039;, &#039;Ca&ntilde;ada&#039;, &#039;Ca&ntilde;ada&#039;, &#039;Ca&ntilde;ada&#039;, &#039;Ca&ntilde;ada&#039;, &#039;Ca&ntilde;ada&#039;, &#039;Ca&ntilde;ada&#039;, 6),
    (8231, 1, NULL, NULL, &#039;Salinas&#039;, &#039;Salinas&#039;, &#039;Salinas&#039;, &#039;Salinas&#039;, &#039;Salinas&#039;, &#039;Salinas&#039;, &#039;Salinas&#039;, &#039;Salinas&#039;, &#039;Salinas&#039;, &#039;Salinas&#039;, &#039;Salinas&#039;, &#039;Salinas&#039;, &#039;Salinas&#039;, &#039;Salinas&#039;, &#039;Salinas&#039;, &#039;Salinas&#039;, 6),
    (8232, 1, NULL, NULL, &#039;Torre de la Horadada&#039;, &#039;Torre de la Horadada&#039;, &#039;Torre de la Horadada&#039;, &#039;Torre de la Horadada&#039;, &#039;Torre de la Horadada&#039;, &#039;Torre de la Horadada&#039;, &#039;Torre de la Horadada&#039;, &#039;Torre de la Horadada&#039;, &#039;Torre de la Horadada&#039;, &#039;Torre de la Horadada&#039;, &#039;Torre de la Horadada&#039;, &#039;Torre de la Horadada&#039;, &#039;Torre de la Horadada&#039;, &#039;Torre de la Horadada&#039;, &#039;Torre de la Horadada&#039;, &#039;Torre de la Horadada&#039;, 2),
    (8233, 1, NULL, NULL, &#039;Jacarilla&#039;, &#039;Jacarilla&#039;, &#039;Jacarilla&#039;, &#039;Jacarilla&#039;, &#039;Jacarilla&#039;, &#039;Jacarilla&#039;, &#039;Jacarilla&#039;, &#039;Jacarilla&#039;, &#039;Jacarilla&#039;, &#039;Jacarilla&#039;, &#039;Jacarilla&#039;, &#039;Jacarilla&#039;, &#039;Jacarilla&#039;, &#039;Jacarilla&#039;, &#039;Jacarilla&#039;, &#039;Jacarilla&#039;, 2),
    (8234, 1, NULL, NULL, &#039;El R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;El R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;El R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;El R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;El R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;El R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;El R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;El R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;El R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;El R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;El R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;El R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;El R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;El R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;El R&agrave;fol D\&#039;Alm&uacute;nia&#039;, &#039;El R&agrave;fol D\&#039;Alm&uacute;nia&#039;, 6),
    (8235, 1, NULL, NULL, &#039;T&aacute;rbena&#039;, &#039;T&aacute;rbena&#039;, &#039;T&aacute;rbena&#039;, &#039;T&aacute;rbena&#039;, &#039;T&aacute;rbena&#039;, &#039;T&aacute;rbena&#039;, &#039;T&aacute;rbena&#039;, &#039;T&aacute;rbena&#039;, &#039;T&aacute;rbena&#039;, &#039;T&aacute;rbena&#039;, &#039;T&aacute;rbena&#039;, &#039;T&aacute;rbena&#039;, &#039;T&aacute;rbena&#039;, &#039;T&aacute;rbena&#039;, &#039;T&aacute;rbena&#039;, &#039;T&aacute;rbena&#039;, 6),
    (8236, 6, 8209, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, NULL, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, NULL, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, NULL, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, &#039;Orihuela Costa&#039;, 2),
    (8237, 6, NULL, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, NULL, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, NULL, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, NULL, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, &#039;Torrevieja&#039;, 2);
UNLOCK TABLES;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec4">
        <span class="badge badge-dark">4</span> <i class="fas fz-fw fa-bug text-danger"></i> Añadir {CLIENTES} a newsletter manual
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/acumbamail/usuarios-add.php:30
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$acumba-&gt;addSubscriber($_POST[&#039;list&#039;], array(&#039;email&#039;  =&gt; $_POST[&#039;email&#039;]));
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$acumba-&gt;addSubscriber($_POST[&#039;list&#039;], array(
    &#039;email&#039;  =&gt; $_POST[&#039;email&#039;],
    &#039;nombre&#039;  =&gt; $_POST[&#039;nombre&#039;]
));
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/acumbamail/usuarios.php:80
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;Email&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;Nombre&#039;); ?&gt;&lt;/th&gt;
&lt;th&gt;&lt;?php __(&#039;Email&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/acumbamail/usuarios.php:91
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;td &gt;&lt;?php echo $value[&#039;email&#039;] ?&gt;&lt;/td&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;td &gt;&lt;?php echo $value[&#039;nombre&#039;] ?&gt;&lt;/td&gt;
&lt;td &gt;&lt;?php echo $value[&#039;email&#039;] ?&gt;&lt;/td&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/acumbamail/usuarios.php:158
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group&quot;&gt;
    &lt;div class=&quot;form-group&quot;&gt;
        &lt;label for=&quot;email&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Email&#039;); ?&gt;:&lt;/label&gt;
        &lt;input type=&quot;email&quot; name=&quot;email&quot; id=&quot;email&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group mb-4&quot;&gt;
    &lt;div class=&quot;form-group&quot;&gt;
        &lt;label for=&quot;nombre&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Nombre&#039;); ?&gt;:&lt;/label&gt;
        &lt;input type=&quot;text&quot; name=&quot;nombre&quot; id=&quot;nombre&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;div class=&quot;form-group&quot;&gt;
    &lt;div class=&quot;form-group&quot;&gt;
        &lt;label for=&quot;email&quot; class=&quot;form-label&quot;&gt;&lt;?php __(&#039;Email&#039;); ?&gt;:&lt;/label&gt;
        &lt;input type=&quot;email&quot; name=&quot;email&quot; id=&quot;email&quot; value=&quot;&quot; size=&quot;32&quot; maxlength=&quot;255&quot; class=&quot;form-control&quot;&gt;
    &lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/acumbamail/newsletter.php:20
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$acumba-&gt;addSubscriber($acumbamailIdListaWebsite[$_GET[&#039;lang&#039;]], array(&#039;email&#039;  =&gt; $_GET[&#039;email&#039;]));
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$acumba-&gt;addSubscriber($acumbamailIdListaWebsite[$_GET[&#039;lang&#039;]], array(
    &#039;email&#039;  =&gt; $_GET[&#039;email&#039;],
    &#039;nombre&#039;  =&gt; $_GET[&#039;nombre&#039;]
));
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/acumbamail/index.php:156
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group&quot;&gt;
    &lt;textarea name=&quot;message&quot; id=&quot;message1&quot; cols=&quot;50&quot; rows=&quot;30&quot; class=&quot;wysiwyg required&quot; placeholder=&quot;&lt;?php __(&#039;Mensaje&#039;); ?&gt;&quot;&gt;&lt;/textarea&gt;
    &lt;div class=&quot;text-count&quot;&gt;&lt;/div&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;form-group&quot;&gt;
    &lt;textarea name=&quot;message&quot; id=&quot;message1&quot; cols=&quot;50&quot; rows=&quot;30&quot; class=&quot;wysiwyg required&quot; placeholder=&quot;&lt;?php __(&#039;Mensaje&#039;); ?&gt;&quot;&gt;&lt;/textarea&gt;
    &lt;div class=&quot;text-count&quot;&gt;&lt;/div&gt;
&lt;/div&gt;
&lt;div class=&quot;alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix mt-4&quot; role=&quot;alert&quot;&gt;
    &lt;i class=&quot;fa-regular fa-circle-info label-icon&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;insert_client_mail_acumba&#039;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/_herramientas/acumbamail.php:23
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$acumba-&gt;addSubscriber($acumbamailIdListaClients[$row_rsExport[&#039;idioma_cli&#039;]], array(&#039;email&#039;  =&gt; $row_rsExport[&#039;email_cli&#039;]));
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$acumba-&gt;addSubscriber($acumbamailIdListaClients[$row_rsExport[&#039;idioma_cli&#039;]], array(
    &#039;email&#039;  =&gt; $row_rsExport[&#039;email_cli&#039;],
    &#039;nombre&#039;  =&gt; $row_rsExport[&#039;nombre_cli&#039;]
));
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/_herramientas/acumbamail.php:44
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$acumba-&gt;addSubscriber($acumbamailIdListaOwners[$row_rsExport[&#039;idioma_pro&#039;]], array(&#039;email&#039;  =&gt; $row_rsExport[&#039;email_pro&#039;]));
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$acumba-&gt;addSubscriber($acumbamailIdListaOwners[$row_rsExport[&#039;idioma_pro&#039;]], array(
    &#039;email&#039;  =&gt; $row_rsExport[&#039;email_pro&#039;],
    &#039;nombre&#039;  =&gt; $row_rsExport[&#039;nombre_pro&#039;]
));
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;insert_client_mail_acumba&#039;] = &#039;Introduce *|NOMBRE|* donde quieras que aparezca el nombre del cliente (El nombre ha de haberse incluido en la lista de acumbamail)&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
$lang[&#039;insert_client_mail_acumba&#039;] = &#039;Insert *|NOMBRE|* wherever you want the client&rsquo;s name to appear (The name must have been included in the Acumbamail list).&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec5">
        <span class="badge badge-dark">5</span> <i class="fas fz-fw fa-bug text-danger"></i> Muestra html en plantillas de email
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:2923
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;textarea name=&quot;messagemail&quot; id=&quot;messagemail&quot; cols=&quot;30&quot; rows=&quot;15&quot; class=&quot;form-control&quot;&gt;&lt;/textarea&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;textarea name=&quot;messagemail&quot; id=&quot;messagemail&quot; cols=&quot;30&quot; rows=&quot;15&quot; class=&quot;form-control wysiwyg&quot;&gt;&lt;/textarea&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:3708
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var txt = intr_txt[$(&#039;#idioma_cli&#039;).val()+$(&#039;#txt&#039;).val()];
$(&#039;#messagemail&#039;).val(txt.replace(&#039;{{PROPERTY}}&#039;, &#039;{{PROPERTY-&#039; + $(&#039;#ref&#039;).val() + &#039;}}&#039;).replace(/(&lt;([^&gt;]+)&gt;)/gi, &quot;&quot;));
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var txt = intr_txt[$(&#039;#idioma_cli&#039;).val()+$(&#039;#txt&#039;).val()].replace(&#039;{{PROPERTY}}&#039;, &#039;&#039;);
$(&#039;#messagemail&#039;).redactor(&#039;source.setCode&#039;, txt);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/clients-form.js:1128
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
url: &quot;clients-send-email.php?subject=&quot; + $(&#039;#subjectSM&#039;).val() + &#039;&amp;message=&#039; + $(&#039;#messagemail&#039;).val().replace(/\r?\n/g, &quot;&lt;br&gt;&quot;) + &#039;&amp;email=&#039; + $(&#039;#email_cli&#039;).val() + &#039;&amp;cco=&#039; + $(&#039;#ccoEml&#039;).val() + &#039;&amp;tipo=7&amp;lang=&#039; + $(&#039;#idioma_cli&#039;).val() + &#039;&amp;usr=&#039; + idClient,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
url: &quot;clients-send-email.php?subject=&quot; + $(&#039;#subjectSM&#039;).val() + &#039;&amp;message=&#039; + encodeURIComponent($(&#039;#messagemail&#039;).val().replace(/\r?\n/g, &quot;&lt;br&gt;&quot;)) + &#039;&amp;email=&#039; + $(&#039;#email_cli&#039;).val() + &#039;&amp;cco=&#039; + $(&#039;#ccoEml&#039;).val() + &#039;&amp;tipo=7&amp;lang=&#039; + $(&#039;#idioma_cli&#039;).val() + &#039;&amp;usr=&#039; + idClient,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:1267
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;textarea name=&quot;messagemail&quot; id=&quot;messagemail&quot; cols=&quot;30&quot; rows=&quot;15&quot; class=&quot;form-control required&quot;&gt;&lt;/textarea&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;textarea name=&quot;messagemail&quot; id=&quot;messagemail&quot; cols=&quot;30&quot; rows=&quot;15&quot; class=&quot;form-control required wysiwyg&quot;&gt;&lt;/textarea&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-form.php:1588
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var txt = intr_txt[$(&#039;#idioma_pro&#039;).val()+$(&#039;#txt&#039;).val()];
$(&#039;#messagemail&#039;).val(txt.replace(&#039;{{PROPERTY}}&#039;, &#039;{{PROPERTY-&#039; + $(&#039;#ref&#039;).val() + &#039;}}&#039;).replace(/(&lt;([^&gt;]+)&gt;)/gi, &quot;&quot;));
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var txt = intr_txt[$(&#039;#idioma_cli&#039;).val()+$(&#039;#txt&#039;).val()].replace(&#039;{{PROPERTY}}&#039;, &#039;&#039;);
$(&#039;#messagemail&#039;).redactor(&#039;source.setCode&#039;, txt);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/owners-form.js:445
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
url: &quot;owners-send-email.php?subject=&quot;+$(&#039;#subjectSM&#039;).val()+&#039;&amp;cco=&#039; + $(&#039;#ccoSrch&#039;).val() + &#039;&amp;message=&#039;+$(&#039;#messagemail&#039;).val().replace( /\r?\n/g, &quot;&lt;br&gt;&quot; )+&#039;&amp;email=&#039;+$(&#039;#email_pro&#039;).val()+&#039;&amp;tipo=4&amp;lang=&#039; + $(&#039;#idioma_pro&#039;).val() + &#039;&amp;usr=&#039; + idOwner,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
url: &quot;owners-send-email.php?subject=&quot;+$(&#039;#subjectSM&#039;).val()+&#039;&amp;cco=&#039; + $(&#039;#ccoSrch&#039;).val() + &#039;&amp;message=&#039; + encodeURIComponent($(&#039;#messagemail&#039;).val().replace(/\r?\n/g, &quot;&lt;br&gt;&quot;)) + &#039;&amp;email=&#039;+$(&#039;#email_pro&#039;).val()+&#039;&amp;tipo=4&amp;lang=&#039; + $(&#039;#idioma_pro&#039;).val() + &#039;&amp;usr=&#039; + idOwner,
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners-send-email.php:37
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$body .= &#039;&lt;p&gt;&#039;.nl2br($_GET[&#039;message&#039;]).&#039;&lt;/p&gt;&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$body .= str_replace(&#039;&lt;br&gt;&#039;, &#039;&#039;, $_GET[&#039;message&#039;]);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec6">
        <span class="badge badge-dark">6</span> <i class="fas fz-fw fa-bug text-danger"></i> Nombre columna Móvil en listado en vez de teléfono 2
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients.php:60
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;M&oacute;vil&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;Tel&eacute;fono&#039;); ?&gt; 2&lt;/th&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/owners.php:60
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;M&oacute;vil&#039;); ?&gt;&lt;/th&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;th&gt;&lt;?php __(&#039;Tel&eacute;fono&#039;); ?&gt; 2&lt;/th&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec7">
        <span class="badge badge-dark">7</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Cerrar Localizaciones y Tipos en Master
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/loc1.php:42
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;loc1-form.php?KT_back=1&quot; class=&quot;btn btn-success btn-sm&quot;&gt;&lt;i class=&quot;fa-regular fa-plus me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($_SESSION[&#039;kt_login_user&#039;] == &#039;crm@mediaelx.net&#039;): ?&gt;
&lt;a href=&quot;loc1-form.php?KT_back=1&quot; class=&quot;btn btn-success btn-sm&quot;&gt;&lt;i class=&quot;fa-regular fa-plus me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;&lt;/a&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/loc1.php:47
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;card-body&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;card-body&quot;&gt;

    &lt;div class=&quot;alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
        &lt;i class=&quot;fa-regular fa-circle-info label-icon&quot;&gt;&lt;/i&gt;
        &lt;?php __(&#039;text_hide_locations&#039;); ?&gt;
    &lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/loc2.php:94
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;loc2-form.php?NxT_id_loc1=&lt;?php echo $_GET[&#039;NxT_id_loc1&#039;] ?&gt;&amp;NxT_id_loc2=&lt;?php echo $_GET[&#039;NxT_id_loc2&#039;] ?&gt;&amp;KT_back=1&quot; class=&quot;btn btn-success btn-sm&quot;&gt;&lt;i class=&quot;fa-regular fa-plus me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($_SESSION[&#039;kt_login_user&#039;] == &#039;crm@mediaelx.net&#039;): ?&gt;
&lt;a href=&quot;loc2-form.php?NxT_id_loc1=&lt;?php echo $_GET[&#039;NxT_id_loc1&#039;] ?&gt;&amp;NxT_id_loc2=&lt;?php echo $_GET[&#039;NxT_id_loc2&#039;] ?&gt;&amp;KT_back=1&quot; class=&quot;btn btn-success btn-sm&quot;&gt;&lt;i class=&quot;fa-regular fa-plus me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;&lt;/a&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/loc2.php:89
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;nav aria-label=&quot;breadcrumb&quot;&gt;
  &lt;ol class=&quot;breadcrumb p-3 py-2 bg-light&quot;&gt;
      &lt;li class=&quot;breadcrumb-item&quot;&gt;&lt;a href=&quot;/intramedianet/properties/loc1.php&quot;&gt;&lt;i class=&quot;fa-regular fa-earth-europe&quot;&gt;&lt;/i&gt; &lt;?php echo $row_rsparent1[&#039;country&#039;] ?&gt;&lt;/a&gt;&lt;/li&gt;
      &lt;li class=&quot;breadcrumb-item active&quot; aria-current=&quot;page&quot;&gt;&lt;?php __(&#039;Provincias&#039;); ?&gt;&lt;/li&gt;
  &lt;/ol&gt;
&lt;/nav&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;nav aria-label=&quot;breadcrumb&quot;&gt;
  &lt;ol class=&quot;breadcrumb p-3 py-2 bg-light&quot;&gt;
      &lt;li class=&quot;breadcrumb-item&quot;&gt;&lt;a href=&quot;/intramedianet/properties/loc1.php&quot;&gt;&lt;i class=&quot;fa-regular fa-earth-europe&quot;&gt;&lt;/i&gt; &lt;?php echo $row_rsparent1[&#039;country&#039;] ?&gt;&lt;/a&gt;&lt;/li&gt;
      &lt;li class=&quot;breadcrumb-item active&quot; aria-current=&quot;page&quot;&gt;&lt;?php __(&#039;Provincias&#039;); ?&gt;&lt;/li&gt;
  &lt;/ol&gt;
&lt;/nav&gt;

&lt;div class=&quot;alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
    &lt;i class=&quot;fa-regular fa-circle-info label-icon&quot;&gt;&lt;/i&gt;
    &lt;?php __(&#039;text_hide_locations&#039;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/loc3.php:94
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;loc3-form.php?NxT_id_loc1=&lt;?php echo $_GET[&#039;NxT_id_loc1&#039;] ?&gt;&amp;NxT_id_loc2=&lt;?php echo $_GET[&#039;NxT_id_loc2&#039;] ?&gt;&amp;KT_back=1&quot; class=&quot;btn btn-success btn-sm&quot;&gt;&lt;i class=&quot;fa-regular fa-plus me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($_SESSION[&#039;kt_login_user&#039;] == &#039;crm@mediaelx.net&#039;): ?&gt;
&lt;a href=&quot;loc3-form.php?NxT_id_loc1=&lt;?php echo $_GET[&#039;NxT_id_loc1&#039;] ?&gt;&amp;NxT_id_loc2=&lt;?php echo $_GET[&#039;NxT_id_loc2&#039;] ?&gt;&amp;KT_back=1&quot; class=&quot;btn btn-success btn-sm&quot;&gt;&lt;i class=&quot;fa-regular fa-plus me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;&lt;/a&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/loc3.php:102
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;nav aria-label=&quot;breadcrumb&quot;&gt;
  &lt;ol class=&quot;breadcrumb p-3 py-2 bg-light&quot;&gt;
      &lt;li class=&quot;breadcrumb-item&quot;&gt;&lt;a href=&quot;/intramedianet/properties/loc1.php&quot;&gt;&lt;i class=&quot;fa-regular fa-earth-europe&quot;&gt;&lt;/i&gt; &lt;?php echo $row_rsparent1[&#039;country&#039;] ?&gt;&lt;/a&gt;&lt;/li&gt;
      &lt;li class=&quot;breadcrumb-item&quot;&gt;&lt;a href=&quot;/intramedianet/properties/loc2.php?NxT_id_loc1=&lt;?php echo $_GET[&#039;NxT_id_loc1&#039;] ?&gt;&quot;&gt;&lt;?php echo $row_rsparent2[&#039;province&#039;] ?&gt;&lt;/a&gt;&lt;/li&gt;
      &lt;li class=&quot;breadcrumb-item active&quot; aria-current=&quot;page&quot;&gt;&lt;?php __(&#039;Ciudades&#039;); ?&gt;&lt;/li&gt;
  &lt;/ol&gt;
&lt;/nav&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;nav aria-label=&quot;breadcrumb&quot;&gt;
  &lt;ol class=&quot;breadcrumb p-3 py-2 bg-light&quot;&gt;
      &lt;li class=&quot;breadcrumb-item&quot;&gt;&lt;a href=&quot;/intramedianet/properties/loc1.php&quot;&gt;&lt;i class=&quot;fa-regular fa-earth-europe&quot;&gt;&lt;/i&gt; &lt;?php echo $row_rsparent1[&#039;country&#039;] ?&gt;&lt;/a&gt;&lt;/li&gt;
      &lt;li class=&quot;breadcrumb-item&quot;&gt;&lt;a href=&quot;/intramedianet/properties/loc2.php?NxT_id_loc1=&lt;?php echo $_GET[&#039;NxT_id_loc1&#039;] ?&gt;&quot;&gt;&lt;?php echo $row_rsparent2[&#039;province&#039;] ?&gt;&lt;/a&gt;&lt;/li&gt;
      &lt;li class=&quot;breadcrumb-item active&quot; aria-current=&quot;page&quot;&gt;&lt;?php __(&#039;Ciudades&#039;); ?&gt;&lt;/li&gt;
  &lt;/ol&gt;
&lt;/nav&gt;

&lt;div class=&quot;alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
  &lt;i class=&quot;fa-regular fa-circle-info label-icon&quot;&gt;&lt;/i&gt;
  &lt;?php __(&#039;text_hide_locations&#039;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/loc4.php:95
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;loc4-form.php?NxT_id_loc1=&lt;?php echo $_GET[&#039;NxT_id_loc1&#039;] ?&gt;&amp;NxT_id_loc2=&lt;?php echo $_GET[&#039;NxT_id_loc2&#039;] ?&gt;&amp;NxT_id_loc3=&lt;?php echo $_GET[&#039;NxT_id_loc3&#039;] ?&gt;&amp;KT_back=1&quot; class=&quot;btn btn-success btn-sm&quot;&gt;&lt;i class=&quot;fa-regular fa-plus me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($_SESSION[&#039;kt_login_user&#039;] == &#039;crm@mediaelx.net&#039;): ?&gt;
&lt;a href=&quot;loc4-form.php?NxT_id_loc1=&lt;?php echo $_GET[&#039;NxT_id_loc1&#039;] ?&gt;&amp;NxT_id_loc2=&lt;?php echo $_GET[&#039;NxT_id_loc2&#039;] ?&gt;&amp;NxT_id_loc3=&lt;?php echo $_GET[&#039;NxT_id_loc3&#039;] ?&gt;&amp;KT_back=1&quot; class=&quot;btn btn-success btn-sm&quot;&gt;&lt;i class=&quot;fa-regular fa-plus me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;&lt;/a&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/loc4.php:103
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;nav aria-label=&quot;breadcrumb&quot;&gt;
    &lt;ol class=&quot;breadcrumb p-3 py-2 bg-light&quot;&gt;
        &lt;li class=&quot;breadcrumb-item&quot;&gt;&lt;a href=&quot;/intramedianet/properties/loc1.php&quot;&gt;&lt;i class=&quot;fa-regular fa-earth-europe&quot;&gt;&lt;/i&gt; &lt;?php echo $row_rsparent1[&#039;country&#039;] ?&gt;&lt;/a&gt;&lt;/li&gt;
        &lt;li class=&quot;breadcrumb-item&quot;&gt;&lt;a href=&quot;/intramedianet/properties/loc2.php?NxT_id_loc1=&lt;?php echo $_GET[&#039;NxT_id_loc1&#039;] ?&gt;&quot;&gt;&lt;?php echo $row_rsparent2[&#039;province&#039;] ?&gt;&lt;/a&gt;&lt;/li&gt;
        &lt;li class=&quot;breadcrumb-item&quot;&gt;&lt;a href=&quot;/intramedianet/properties/loc3.php?NxT_id_loc1=&lt;?php echo $_GET[&#039;NxT_id_loc1&#039;] ?&gt;&amp;NxT_id_loc2=&lt;?php echo $_GET[&#039;NxT_id_loc2&#039;] ?&gt;&quot;&gt;&lt;?php echo $row_rsparent3[&#039;province&#039;] ?&gt;&lt;/a&gt;&lt;/li&gt;
        &lt;li class=&quot;breadcrumb-item active&quot; aria-current=&quot;page&quot;&gt;&lt;?php __(&#039;Zonas&#039;); ?&gt;&lt;/li&gt;
    &lt;/ol&gt;
&lt;/nav&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;nav aria-label=&quot;breadcrumb&quot;&gt;
    &lt;ol class=&quot;breadcrumb p-3 py-2 bg-light&quot;&gt;
        &lt;li class=&quot;breadcrumb-item&quot;&gt;&lt;a href=&quot;/intramedianet/properties/loc1.php&quot;&gt;&lt;i class=&quot;fa-regular fa-earth-europe&quot;&gt;&lt;/i&gt; &lt;?php echo $row_rsparent1[&#039;country&#039;] ?&gt;&lt;/a&gt;&lt;/li&gt;
        &lt;li class=&quot;breadcrumb-item&quot;&gt;&lt;a href=&quot;/intramedianet/properties/loc2.php?NxT_id_loc1=&lt;?php echo $_GET[&#039;NxT_id_loc1&#039;] ?&gt;&quot;&gt;&lt;?php echo $row_rsparent2[&#039;province&#039;] ?&gt;&lt;/a&gt;&lt;/li&gt;
        &lt;li class=&quot;breadcrumb-item&quot;&gt;&lt;a href=&quot;/intramedianet/properties/loc3.php?NxT_id_loc1=&lt;?php echo $_GET[&#039;NxT_id_loc1&#039;] ?&gt;&amp;NxT_id_loc2=&lt;?php echo $_GET[&#039;NxT_id_loc2&#039;] ?&gt;&quot;&gt;&lt;?php echo $row_rsparent3[&#039;province&#039;] ?&gt;&lt;/a&gt;&lt;/li&gt;
        &lt;li class=&quot;breadcrumb-item active&quot; aria-current=&quot;page&quot;&gt;&lt;?php __(&#039;Zonas&#039;); ?&gt;&lt;/li&gt;
    &lt;/ol&gt;
&lt;/nav&gt;

&lt;div class=&quot;alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
    &lt;i class=&quot;fa-regular fa-circle-info label-icon&quot;&gt;&lt;/i&gt;
    &lt;?php __(&#039;text_hide_locations&#039;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/types.php:42
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;types-form.php?KT_back=1&quot; class=&quot;btn btn-success btn-sm&quot;&gt;&lt;i class=&quot;fa-regular fa-plus me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if ($_SESSION[&#039;kt_login_user&#039;] == &#039;crm@mediaelx.net&#039;): ?&gt;
&lt;a href=&quot;types-form.php?KT_back=1&quot; class=&quot;btn btn-success btn-sm&quot;&gt;&lt;i class=&quot;fa-regular fa-plus me-1&quot;&gt;&lt;/i&gt; &lt;?php __(&#039;A&ntilde;adir&#039;); ?&gt;&lt;/a&gt;
&lt;?php endif ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/types.php:47
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;div class=&quot;card-body&quot;&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;div class=&quot;card-body&quot;&gt;

    &lt;div class=&quot;alert alert-info alert-dismissible alert-label-icon label-arrow fade show clearfix&quot; role=&quot;alert&quot;&gt;
        &lt;i class=&quot;fa-regular fa-circle-info label-icon&quot;&gt;&lt;/i&gt;
        &lt;?php __(&#039;text_hide_types&#039;); ?&gt;
    &lt;/div&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_es.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$lang[&#039;text_hide_locations&#039;] = &#039;&lt;p&gt;&lt;b&gt;EVITA DUPLICIDADES EN TUS LOCALIZACIONES&lt;/b&gt;&lt;/p&gt;&lt;p&gt;Para mantener la base de datos limpia y evitar errores en la gesti&oacute;n y exportaci&oacute;n de XML a otras agencias, hemos restringido la creaci&oacute;n de nuevas ciudades desde el CRM.&lt;/p&gt;&lt;p&gt;&iquest;Necesitas a&ntilde;adir una nueva localizaci&oacute;n?&lt;/p&gt;&lt;p&gt;&#x1f449; Escr&iacute;benos y la a&ntilde;adiremos por ti, asegur&aacute;ndonos de que no exista ya en el sistema.&lt;/p&gt;&lt;p&gt;Este peque&ntilde;o cambio mejora la organizaci&oacute;n de tu inmobiliaria y te evita problemas futuros con datos duplicados.&lt;/p&gt;&#039;;
$lang[&#039;text_hide_types&#039;] = &#039;&lt;p&gt;&lt;b&gt;EVITA DUPLICIDADES EN LOS TIPOS DE PROPIEDAD&lt;/b&gt;&lt;/p&gt;&lt;p&gt;Para mantener tu CRM bien organizado y evitar errores al exportar propiedades por XML, hemos desactivado la opci&oacute;n de crear nuevos tipos de propiedad desde el CRM.&lt;/p&gt;&lt;p&gt;&iquest;Quieres a&ntilde;adir un nuevo tipo?&lt;/p&gt;&lt;p&gt;&#x1f449; Escr&iacute;benos y lo a&ntilde;adiremos por ti, comprobando antes que no exista ya en el sistema.&lt;/p&gt;&lt;p&gt;As&iacute; evitamos duplicidades y garantizamos una gesti&oacute;n m&aacute;s clara y profesional de tus inmuebles.&lt;/p&gt;&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/resources/lang_en.php
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$lang[&#039;text_hide_locations&#039;] = &#039;&lt;p&gt;&lt;b&gt;AVOID DUPLICATE LOCATIONS IN YOUR CRM&lt;/b&gt;&lt;/p&gt;&lt;p&gt;To keep your database clean and prevent issues when managing or exporting XML files to other agencies, the option to create new cities directly from the CRM has been restricted.&lt;/p&gt;&lt;p&gt;Need to add a new location?&lt;/p&gt;&lt;p&gt;&#x1f449; Just contact us and we&rsquo;ll add it for you, making sure it&rsquo;s not already in the system.&lt;/p&gt;&lt;p&gt;This small change improves your agency&rsquo;s organisation and helps you avoid future problems with duplicated data.&lt;/p&gt;&#039;;
$lang[&#039;text_hide_types&#039;] = &#039;&lt;p&gt;&lt;b&gt;AVOID DUPLICATE PROPERTY TYPES&lt;/b&gt;&lt;/p&gt;&lt;p&gt;To keep your CRM well organised and avoid errors when exporting properties via XML, the option to create new property types from the CRM has been disabled.&lt;/p&gt;&lt;p&gt;Want to add a new type?&lt;/p&gt;&lt;p&gt;&#x1f449; Just contact us and we&rsquo;ll add it for you, after checking that it&rsquo;s not already in the system.&lt;/p&gt;&lt;p&gt;This way, we avoid duplicates and ensure a clearer, more professional property management process.&lt;/p&gt;&#039;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec8">
        <span class="badge badge-dark">8</span> <i class="fas fz-fw fa-bug text-danger"></i> Reportes Buyers / Acceso directos a tareas y citas
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:3152
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;table class=&quot;table table-striped table-bordered records-tables-simple4 align-middle&quot; id=&quot;tasks-table&quot;&gt;
    &lt;thead class=&quot;table-light&quot;&gt;
        &lt;tr&gt;
            &lt;th&gt;&lt;?php __(&#039;Propietario de la tarea&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Asunto&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Propiedad&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Fecha de vencimiento&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Prioridad&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Status&#039;); ?&gt;&lt;/th&gt;
        &lt;/tr&gt;
    &lt;/thead&gt;
    &lt;tbody&gt;
    &lt;?php do { ?&gt;
      &lt;tr&gt;
          &lt;td&gt;&lt;?php echo $row_rsTasks[&#039;admin_tsk&#039;]; ?&gt;&lt;/td&gt;
          &lt;td&gt;&lt;?php echo $row_rsTasks[&#039;subject_tsk&#039;]; ?&gt;&lt;/td&gt;
          &lt;td&gt;&lt;?php echo addRefs($row_rsTasks[&#039;property_tsk&#039;]); ?&gt;&lt;/td&gt;
          &lt;td data-sort=&quot;&lt;?php echo $row_rsTasks[&#039;date_due_tsk&#039;] ?&gt;&quot;&gt;&lt;?php echo date(&quot;d-m-Y&quot;, strtotime($row_rsTasks[&#039;date_due_tsk&#039;])); ?&gt;&lt;/td&gt;
          &lt;td&gt;&lt;?php __($row_rsTasks[&#039;priority_tsk&#039;]); ?&gt;&lt;/td&gt;
          &lt;td&gt;&lt;?php echo $row_rsTasks[&#039;status_tsk&#039;]; ?&gt;&lt;/td&gt;
      &lt;/tr&gt;
      &lt;?php } while ($row_rsTasks = mysqli_fetch_assoc($rsTasks)); ?&gt;
    &lt;/tbody&gt;
&lt;/table&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;table class=&quot;table table-striped table-bordered records-tables-simple4 align-middle&quot; id=&quot;tasks-table&quot;&gt;
    &lt;thead class=&quot;table-light&quot;&gt;
        &lt;tr&gt;
            &lt;th&gt;&lt;?php __(&#039;Propietario de la tarea&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Asunto&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Propiedad&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Fecha de vencimiento&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Prioridad&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;?php __(&#039;Status&#039;); ?&gt;&lt;/th&gt;
            &lt;th&gt;&lt;/th&gt;
        &lt;/tr&gt;
    &lt;/thead&gt;
    &lt;tbody&gt;
    &lt;?php do { ?&gt;
      &lt;tr&gt;
          &lt;td&gt;&lt;?php echo $row_rsTasks[&#039;admin_tsk&#039;]; ?&gt;&lt;/td&gt;
          &lt;td&gt;&lt;?php echo $row_rsTasks[&#039;subject_tsk&#039;]; ?&gt;&lt;/td&gt;
          &lt;td&gt;&lt;?php echo addRefs($row_rsTasks[&#039;property_tsk&#039;]); ?&gt;&lt;/td&gt;
          &lt;td data-sort=&quot;&lt;?php echo $row_rsTasks[&#039;date_due_tsk&#039;] ?&gt;&quot;&gt;&lt;?php echo date(&quot;d-m-Y&quot;, strtotime($row_rsTasks[&#039;date_due_tsk&#039;])); ?&gt;&lt;/td&gt;
          &lt;td&gt;&lt;?php __($row_rsTasks[&#039;priority_tsk&#039;]); ?&gt;&lt;/td&gt;
          &lt;td&gt;&lt;?php echo $row_rsTasks[&#039;status_tsk&#039;]; ?&gt;&lt;/td&gt;
          &lt;td&gt;&lt;a href=&quot;/intramedianet/tasks/tasks-form.php?id_tsk=&lt;?php echo $row_rsTasks[&#039;id_tsk&#039;]; ?&gt;&amp;amp;KT_back=1&quot; class=&quot;btn btn-primary btn-sm&quot;&gt;&lt;i class=&quot;fa-regular fa-eye&quot;&gt;&lt;/i&gt;&lt;/a&gt;&lt;/td&gt;
      &lt;/tr&gt;
      &lt;?php } while ($row_rsTasks = mysqli_fetch_assoc($rsTasks)); ?&gt;
    &lt;/tbody&gt;
&lt;/table&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php:3111
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;table class=&quot;table table-striped table-bordered records-tables-simple3 align-middle&quot; id=&quot;events-table&quot;&gt;
    &lt;thead class=&quot;table-light&quot;&gt;
    &lt;tr&gt;
        &lt;th&gt;&lt;?php __(&#039;T&iacute;tulo&#039;); ?&gt;&lt;/th&gt;
        &lt;th&gt;&lt;?php __(&#039;Categor&iacute;a&#039;); ?&gt;&lt;/th&gt;
        &lt;th&gt;&lt;?php __(&#039;Fecha inicio&#039;); ?&gt;&lt;/th&gt;
        &lt;th&gt;&lt;?php __(&#039;Fecha final&#039;); ?&gt;&lt;/th&gt;
        &lt;th&gt;&lt;?php __(&#039;Propiedades&#039;); ?&gt;&lt;/th&gt;
        &lt;th&gt;&lt;?php __(&#039;Administrador&#039;); ?&gt;&lt;/th&gt;
        &lt;th&gt;&lt;?php __(&#039;Lugar&#039;); ?&gt;&lt;/th&gt;
    &lt;/tr&gt;
    &lt;/thead&gt;
    &lt;tbody&gt;
    &lt;?php do { ?&gt;
      &lt;tr&gt;
          &lt;td&gt;&lt;?php echo $row_rsEvents[&#039;titulo_ct&#039;]; ?&gt;&lt;/td&gt;
          &lt;td&gt;&lt;span class=&quot;badge&quot; style=&quot;background: &lt;?php echo $row_rsEvents[&#039;color_ct&#039;]; ?&gt;;&quot;&gt;&lt;?php echo $row_rsEvents[&#039;cat&#039;]; ?&gt;&lt;/span&gt;&lt;/td&gt;
          &lt;td data-sort=&quot;&lt;?php echo $row_rsEvents[&#039;inicio_ct&#039;] ?&gt;&quot;&gt;&lt;?php echo date(&quot;d-m-Y H:i&quot;, strtotime($row_rsEvents[&#039;inicio_ct&#039;])); ?&gt;&lt;/td&gt;
          &lt;td data-sort=&quot;&lt;?php echo $row_rsEvents[&#039;final_ct&#039;] ?&gt;&quot;&gt;&lt;?php echo date(&quot;d-m-Y H:i&quot;, strtotime($row_rsEvents[&#039;final_ct&#039;])); ?&gt;&lt;/td&gt;
          &lt;td&gt;&lt;?php echo addRefs($row_rsEvents[&#039;property_ct&#039;]); ?&gt;&lt;/td&gt;
          &lt;td&gt;&lt;?php echo $row_rsEvents[&#039;nombre_usr&#039;]; ?&gt;&lt;/td&gt;
          &lt;td&gt;&lt;?php echo $row_rsEvents[&#039;lugar_ct&#039;]; ?&gt;&lt;/td&gt;
      &lt;/tr&gt;
      &lt;?php } while ($row_rsEvents = mysqli_fetch_assoc($rsEvents)); ?&gt;
    &lt;/tbody&gt;
&lt;/table&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;table class=&quot;table table-striped table-bordered records-tables-simple3 align-middle&quot; id=&quot;events-table&quot;&gt;
    &lt;thead class=&quot;table-light&quot;&gt;
    &lt;tr&gt;
        &lt;th&gt;&lt;?php __(&#039;T&iacute;tulo&#039;); ?&gt;&lt;/th&gt;
        &lt;th&gt;&lt;?php __(&#039;Categor&iacute;a&#039;); ?&gt;&lt;/th&gt;
        &lt;th&gt;&lt;?php __(&#039;Fecha inicio&#039;); ?&gt;&lt;/th&gt;
        &lt;th&gt;&lt;?php __(&#039;Fecha final&#039;); ?&gt;&lt;/th&gt;
        &lt;th&gt;&lt;?php __(&#039;Propiedades&#039;); ?&gt;&lt;/th&gt;
        &lt;th&gt;&lt;?php __(&#039;Administrador&#039;); ?&gt;&lt;/th&gt;
        &lt;th&gt;&lt;?php __(&#039;Lugar&#039;); ?&gt;&lt;/th&gt;
        &lt;th&gt;&lt;/th&gt;
    &lt;/tr&gt;
    &lt;/thead&gt;
    &lt;tbody&gt;
    &lt;?php do { ?&gt;
      &lt;tr&gt;
          &lt;td&gt;&lt;?php echo $row_rsEvents[&#039;titulo_ct&#039;]; ?&gt;&lt;/td&gt;
          &lt;td&gt;&lt;span class=&quot;badge&quot; style=&quot;background: &lt;?php echo $row_rsEvents[&#039;color_ct&#039;]; ?&gt;;&quot;&gt;&lt;?php echo $row_rsEvents[&#039;cat&#039;]; ?&gt;&lt;/span&gt;&lt;/td&gt;
          &lt;td data-sort=&quot;&lt;?php echo $row_rsEvents[&#039;inicio_ct&#039;] ?&gt;&quot;&gt;&lt;?php echo date(&quot;d-m-Y H:i&quot;, strtotime($row_rsEvents[&#039;inicio_ct&#039;])); ?&gt;&lt;/td&gt;
          &lt;td data-sort=&quot;&lt;?php echo $row_rsEvents[&#039;final_ct&#039;] ?&gt;&quot;&gt;&lt;?php echo date(&quot;d-m-Y H:i&quot;, strtotime($row_rsEvents[&#039;final_ct&#039;])); ?&gt;&lt;/td&gt;
          &lt;td&gt;&lt;?php echo addRefs($row_rsEvents[&#039;property_ct&#039;]); ?&gt;&lt;/td&gt;
          &lt;td&gt;&lt;?php echo $row_rsEvents[&#039;nombre_usr&#039;]; ?&gt;&lt;/td&gt;
          &lt;td&gt;&lt;?php echo $row_rsEvents[&#039;lugar_ct&#039;]; ?&gt;&lt;/td&gt;
          &lt;td&gt;&lt;a href=&quot;javascript:;&quot; class=&quot;btn btn-primary btn-sm edit-event&quot; data-id=&quot;&lt;?php echo $row_rsEvents[&#039;id_ct&#039;] ?&gt;&quot;&gt;&lt;i class=&quot;fa-regular fa-eye&quot;&gt;&lt;/i&gt;&lt;/a&gt;&lt;/td&gt;
      &lt;/tr&gt;
      &lt;?php } while ($row_rsEvents = mysqli_fetch_assoc($rsEvents)); ?&gt;
    &lt;/tbody&gt;
&lt;/table&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-form.php
            </code>
        </pre>
        Añadir al final:
        <pre>
            <code class="php">
&lt;script&gt;
$(document).on(&#039;click&#039;, &#039;.edit-event&#039;, function(e) {
  e.preventDefault();
  tb = $(this);
    $.get(&quot;/intramedianet/calendar/disp-datos.php?lang=&lt;?php echo $lang_adm ?&gt;&amp;id=&quot;+tb.data(&#039;id&#039;), function(data) {
      $(&#039;.add-cita&#039;).attr(&#039;name&#039;,&#039;KT_Update1&#039;);
      var jsonObject = $.parseJSON(data);
      $(&#039;#id_ct&#039;).val(jsonObject[0].id_ct);
      $(&#039;#categoria_ct&#039;).val(jsonObject[0].categoria_ct);
      $(&#039;#user_ct&#039;).val(jsonObject[0].user_ct);
      $(&#039;#users_ct&#039;).val(jsonObject[0].users_ct);
      $(&#039;#vendedores_ct&#039;).val(jsonObject[0].vendedores_ct);
      if (jsonObject[0].users_ct != null) {
          $.ajax({
              type: &#039;GET&#039;,
              dataType: &#039;json&#039;,
              url: &#039;/intramedianet/properties/properties-buyers-select-single.php?q=&#039; + jsonObject[0].users_ct
          }).then(function (data) {
            $(&quot;.select2clientes&quot;).select2(&#039;data&#039;, { id:data.id, text: data.text});
          });
      }
      if (jsonObject[0].vendedores_ct != null) {
          $.ajax({
              type: &#039;GET&#039;,
              dataType: &#039;json&#039;,
              url: &#039;/intramedianet/properties/properties-owners-select-single.php?q=&#039; + jsonObject[0].vendedores_ct
          }).then(function (data) {
            $(&quot;.select2vendors&quot;).select2(&#039;data&#039;, { id:data.id, text: data.text});
          });
      }
      if (jsonObject[0].property_ct != null) {
        $.ajax({
            type: &#039;GET&#039;,
            dataType: &#039;json&#039;,
            url: &#039;/intramedianet/properties/properties-references-select-multiple.php?q=&#039; + jsonObject[0].property_ct
        }).done(function (data) {
            $(&quot;.select2references&quot;).select2(&#039;data&#039;, data);
        });
      }
      $(&#039;#inicio_ct&#039;).val(jsonObject[0].inicio_ct);
      $(&#039;#final_ct&#039;).val(jsonObject[0].final_ct);
      $(&#039;#titulo_ct&#039;).val(jsonObject[0].titulo_ct);
      $(&#039;#lugar_ct&#039;).val(jsonObject[0].lugar_ct);
      $(&#039;#notas_ct&#039;).val(jsonObject[0].notas_ct);
      $(&#039;.select2&#039;).change();
    });
  $(&#039;#myModal&#039;).modal(&#039;show&#039;);
});
&lt;/script&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec9">
        <span class="badge badge-dark">9</span> <i class="fas fz-fw fa-bug text-danger"></i> Error en reporte de propietario
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-form.php:78
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
function encryptIt($idCli, $encryptionKey = &#039;DLusjkq6kkzRUbY7TVc7YH2RcT2&#039;)
{
    global $_SERVER;
    $ciphering = &quot;AES-128-CTR&quot;;
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_key = $_SERVER[&#039;HTTP_HOST&#039;];
    $encryption_iv = $_SERVER[&#039;HTTP_HOST&#039;];

    $encryption = openssl_encrypt($idCli, $ciphering,
            $encryption_key, $options, $encryption_iv);
    return $encryption;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
function encryptIt($idCli, $encryptionKey = &#039;DLusjkq6kkzRUbY7TVc7YH2RcT2&#039;)
{
    $ciphering = &quot;AES-128-CTR&quot;;
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;

    $encryption_iv = substr(hash(&#039;sha256&#039;, $_SERVER[&#039;HTTP_HOST&#039;]), 0, 16);
    $encryption_key = substr(hash(&#039;sha256&#039;, $encryptionKey), 0, 16);

    $encrypted = openssl_encrypt($idCli, $ciphering, $encryption_key, $options, $encryption_iv);

    // Base64 URL-safe: replace +/ with -_ and remove = padding
    return rtrim(strtr(base64_encode($encrypted), &#039;+/&#039;, &#039;-_&#039;), &#039;=&#039;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/reporte/reporte.php:3
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
function decryptIt($encryptedString, $key = &quot;DLusjkq6kkzRUbY7TVc7YH2RcT2&quot;) {
    $key = $_SERVER[&#039;HTTP_HOST&#039;];
    $encryption_key = hash(&#039;sha256&#039;, $key);
    list($encrypted_data, $iv) = explode(&#039;::&#039;, base64_decode($encryptedString), 2);
    $decrypted_data = openssl_decrypt($encrypted_data, &#039;aes-256-cbc&#039;, $encryption_key, 0, $iv);
    return unserialize($decrypted_data);
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
function decryptIt($encrypted, $encryptionKey = &#039;DLusjkq6kkzRUbY7TVc7YH2RcT2&#039;)
{
    $ciphering = &quot;AES-128-CTR&quot;;
    $options = 0;

    $encryption_iv = substr(hash(&#039;sha256&#039;, $_SERVER[&#039;HTTP_HOST&#039;]), 0, 16);
    $encryption_key = substr(hash(&#039;sha256&#039;, $encryptionKey), 0, 16);

    // Revert Base64 URL-safe to standard
    $encrypted = strtr($encrypted, &#039;-_&#039;, &#039;+/&#039;);
    $encrypted = base64_decode($encrypted);

    return openssl_decrypt($encrypted, $ciphering, $encryption_key, $options, $encryption_iv);
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec10">
        <span class="badge badge-dark">10</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Nueva plantilla de emails
    </h6>
    <div class="card-body">
        Añadidos los archivos:
        <pre>
            <code class="makefile">
/modules/mail_partials/property_rate_mini.php
            </code>
        </pre>
        <hr>
        Subimos la carpeta <code>/modules/webhook/</code> y activamos el webhook en acumba (<a href="https://acumbamail.com/smtp/webhook/" target="_blank">https://acumbamail.com/smtp/webhook/</a>) con las siguientes opciones:<br><br>
        <b>URL de Callback:</b> https://DOMINIO-CLIENTE/modules/webhook/webhook-acumba.php <br><br>
        <b>Y marcamos todos los checkbox:</b> Entregado, Hard Bounce, Soft Bounce, Queja Apertura y Clic
        <hr>
        Reescribir los archivos:
        <pre>
            <code class="makefile">
/_herramientas/gdpr.php
/includes/acumbamail/acumbamail.class.php
/includes/mailtemplates/template_semanal.html
/includes/mediaelx/functions.php
/intramedianet/acumbamail/index.php
/intramedianet/acumbamail/send.php
/intramedianet/busquedas/searchs-send.php
/intramedianet/calendar/send-citas.php
/intramedianet/demo/reminder.php
/intramedianet/ferias/clients-form.php
/intramedianet/forgot_password.php
/intramedianet/properties/_js/clients-form.js
/intramedianet/properties/_js/owners-form.js
/intramedianet/properties/bajada-send.php
/intramedianet/properties/clients-form.php
/intramedianet/properties/clients-send-email.php
/intramedianet/properties/clients-send-search-criteria.php
/intramedianet/properties/clients-send-welcome.php
/intramedianet/properties/clients-send.php
/intramedianet/properties/clients-send2.php
/intramedianet/properties/enquiries-send.php
/intramedianet/properties/getPropsList.php
/intramedianet/properties/owners-form.php
/intramedianet/properties/owners-send-email.php
/intramedianet/properties/owners-send-report.php
/intramedianet/properties/owners-send.php
/intramedianet/users/users-form.php
/intramedianet/webuser/users-form.php
/intramedianet/xml/importadores/_utils.php
/modules/contact/send-quote.php
/modules/contact/send-visita-virtual.php
/modules/contact/send.php
/modules/events/send.php
/modules/favorites/send-favs.php
/modules/login/forgot.php
/modules/login/register.php
/modules/mail_partials/ciu-acumba.php
/modules/mail_partials/news-acumba.php
/modules/mail_partials/prom-acumba.php
/modules/mail_partials/property_rate.php
/modules/mail_partials/unsubscribe.php
/modules/properties/search.php
/modules/property/bajada.php
/modules/property/enquiry.php
/modules/property/send-friend.php
/modules/reporte/send.php
/modules/vender/send-quote.php
/resources/lang_ca.php
/resources/lang_da.php
/resources/lang_de.php
/resources/lang_en.php
/resources/lang_es.php
/resources/lang_fi.php
/resources/lang_fr.php
/resources/lang_is.php
/resources/lang_nl.php
/resources/lang_no.php
/resources/lang_pl.php
/resources/lang_ru.php
/resources/lang_se.php
/resources/lang_zh.php
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/email.php:70
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
/*
|--------------------------------------------------------------------------
| Mail main color
|--------------------------------------------------------------------------
|
| El color principal del template de email
|
*/

$mailColor = &quot;#29bdef&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
/*
|--------------------------------------------------------------------------
| Mail main color
|--------------------------------------------------------------------------
|
| El color principal del template de email
|
*/

$mailColor = &quot;#29bdef&quot;;

/*
|--------------------------------------------------------------------------
| Mail secondary color
|--------------------------------------------------------------------------
|
| El color secundario del template de email
|
*/

$mailSecondaryColor = &quot;#000&quot;;
            </code>
        </pre>
        <hr>
        A tener en cuenta:
        <pre>
            <code class="makefile">
Ya no hay que generar los textos legales para los email
            </code>
        </pre>
        <hr>
        Añadir los textos:
        <pre>
            <code class="makefile">
/resources/lang_ca.php

$langStr[&quot;En tr&aacute;mite&quot;] = &quot;En tr&agrave;mit&quot;;
$langStr[&quot;&iquest;Te ha gustado esta casa? Val&oacute;rala aqu&iacute;&quot;] = &quot;T&#039;ha agradat aquesta casa? Valora-la aqu&iacute;&quot;;
$langStr[&quot;Est&aacute;s recibiendo este email porque solicitaste informaci&oacute;n o te suscribiste voluntariamente a nuestras comunicaciones comerciales.&quot;] = &quot;Est&agrave;s rebent aquest correu electr&ograve;nic perqu&egrave; vas sol&middot;licitar informaci&oacute; o et vas subscriure volunt&agrave;riament a les nostres comunicacions comercials.&quot;;
$langStr[&quot;Responsable&quot;] = &quot;Responsable del tractament&quot;;
$langStr[&quot;Consulta aqu&iacute; nuestra&quot;] = &quot;Consulta aqu&iacute; la nostra&quot;;
$langStr[&quot;Pol&iacute;tica de Privacidad&quot;] = &quot;Pol&iacute;tica de privacitat&quot;;
$langStr[&quot;Valora las casas que te hemos enviado&quot;] = &quot;Valora les cases que t&#039;hem enviat&quot;;
$langStr[&quot;Nos ayudas a enviarte solo lo que realmente te interesa&quot;] = &quot;Ens ajudes a enviar-te nom&eacute;s all&ograve; que realment t&#039;interessa&quot;;
$langStr[&quot;Leer m&aacute;s sobre esta noticia&quot;] = &quot;Llegeix m&eacute;s sobre aquesta not&iacute;cia&quot;;
$langStr[&quot;&iquest;Conoces esta zona?&quot;] = &quot;Coneixes aquesta zona?&quot;;
$langStr[&quot;Ver m&aacute;s sobre&quot;] = &quot;Veure m&eacute;s sobre&quot;;
$langStr[&quot;Promoci&oacute;n destacada&quot;] = &quot;Promoci&oacute; destacada&quot;;
$langStr[&quot;Ver viviendas de la promoci&oacute;n&quot;] = &quot;Veure habitatges de la promoci&oacute;&quot;;
$langStr[&quot;&iquest;Quieres ver m&aacute;s opciones?&quot;] = &quot;Vols veure m&eacute;s opcions?&quot;;
$langStr[&quot;Ver m&aacute;s propiedades&quot;] = &quot;Veure m&eacute;s propietats&quot;;
$langStr[&quot;Cu&eacute;ntanos qu&eacute; est&aacute;s buscando&quot;] = &quot;Explica&#039;ns qu&egrave; est&agrave;s buscant&quot;;
$langStr[&quot;Tambi&eacute;n te pueden interesar&quot;] = &quot;Tamb&eacute; et poden interessar&quot;;
$langStr[&quot;Estimado&quot;] = &quot;Benvolgut&quot;;
$langStr[&quot;Hemos registrado con &eacute;xito sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;Hem registrat les seves dades amb &egrave;xit.&lt;br&gt;Gr&agrave;cies per endavant pel seu inter&egrave;s!&quot;;
$langStr[&quot;Saludos cordiales.&quot;] = &quot;Cordialment&quot;;
$langStr[&quot;Te env&iacute;o propiedades que pueden interesarte&quot;] = &quot;T&#039;envio propietats que poden interessar-te&quot;;
$langStr[&quot;Estos son sus datos de acceso a la zona privada&quot;] = &quot;Aquests s&oacute;n les seves dades d&#039;acc&eacute;s a la zona privada&quot;;
$langStr[&quot;Confirmamos sus datos de acceso&quot;] = &quot;Confirmem les seves dades d&#039;acc&eacute;s&quot;;
$langStr[&quot;Para acceder a la zona privada de la web, haga clic en el siguiente enlace&quot;] = &quot;Per accedir a la zona privada del web, fes clic a l&#039;enlla&ccedil; seg&uuml;ent&quot;;
$langStr[&quot;Acceder a la zona privada del sitio web&quot;] = &quot;Accedir a la zona privada del lloc web&quot;;
$langStr[&quot;Nuevo usuario web&quot;] = &quot;Nou usuari web&quot;;
$langStr[&quot;Datos de acceso&quot;] = &quot;Dades d&#039;acc&eacute;s&quot;;
$langStr[&quot;Hemos registrado correctamente sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;Hem registrat correctament les seves dades.&lt;br&gt;Gr&agrave;cies per endavant pel seu inter&egrave;s!&quot;;

/resources/lang_da.php

$langStr[&quot;En tr&aacute;mite&quot;] = &quot;Under behandling&quot;;
$langStr[&quot;&iquest;Te ha gustado esta casa? Val&oacute;rala aqu&iacute;&quot;] = &quot;Kunne du lide dette hus? Bed&oslash;m det her&quot;;
$langStr[&quot;Est&aacute;s recibiendo este email porque solicitaste informaci&oacute;n o te suscribiste voluntariamente a nuestras comunicaciones comerciales.&quot;] = &quot;Du modtager denne e-mail, fordi du har anmodet om information eller frivilligt har tilmeldt dig vores kommercielle kommunikation.&quot;;
$langStr[&quot;Responsable&quot;] = &quot;Dataansvarlig&quot;;
$langStr[&quot;Consulta aqu&iacute; nuestra&quot;] = &quot;Se vores&quot;;
$langStr[&quot;Pol&iacute;tica de Privacidad&quot;] = &quot;Privatlivspolitik&quot;;
$langStr[&quot;Valora las casas que te hemos enviado&quot;] = &quot;Bed&oslash;m de boliger, vi har sendt dig&quot;;
$langStr[&quot;Nos ayudas a enviarte solo lo que realmente te interesa&quot;] = &quot;Hj&aelig;lp os med kun at sende dig det, du virkelig er interesseret i&quot;;
$langStr[&quot;Leer m&aacute;s sobre esta noticia&quot;] = &quot;L&aelig;s mere om denne nyhed&quot;;
$langStr[&quot;&iquest;Conoces esta zona?&quot;] = &quot;Kender du dette omr&aring;de?&quot;;
$langStr[&quot;Ver m&aacute;s sobre&quot;] = &quot;L&aelig;s mere om&quot;;
$langStr[&quot;Promoci&oacute;n destacada&quot;] = &quot;Fremh&aelig;vet tilbud&quot;;
$langStr[&quot;Ver viviendas de la promoci&oacute;n&quot;] = &quot;Se boliger i dette tilbud&quot;;
$langStr[&quot;&iquest;Quieres ver m&aacute;s opciones?&quot;] = &quot;Vil du se flere muligheder?&quot;;
$langStr[&quot;Ver m&aacute;s propiedades&quot;] = &quot;Se flere ejendomme&quot;;
$langStr[&quot;Cu&eacute;ntanos qu&eacute; est&aacute;s buscando&quot;] = &quot;Fort&aelig;l os, hvad du leder efter&quot;;
$langStr[&quot;Tambi&eacute;n te pueden interesar&quot;] = &quot;Disse kan ogs&aring; have din interesse&quot;;
$langStr[&quot;Estimado&quot;] = &quot;K&aelig;re&quot;;
$langStr[&quot;Hemos registrado con &eacute;xito sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;Vi har registreret dine oplysninger med succes.&lt;br&gt;Tak p&aring; forh&aring;nd for din interesse!&quot;;
$langStr[&quot;Saludos cordiales.&quot;] = &quot;Med venlig hilsen&quot;;
$langStr[&quot;Te env&iacute;o propiedades que pueden interesarte&quot;] = &quot;Jeg sender dig ejendomme, der kunne interessere dig&quot;;
$langStr[&quot;Estos son sus datos de acceso a la zona privada&quot;] = &quot;Her er dine loginoplysninger til det private omr&aring;de&quot;;
$langStr[&quot;Confirmamos sus datos de acceso&quot;] = &quot;Vi bekr&aelig;fter dine loginoplysninger&quot;;
$langStr[&quot;Para acceder a la zona privada de la web, haga clic en el siguiente enlace&quot;] = &quot;Klik p&aring; nedenst&aring;ende link for at f&aring; adgang til det private omr&aring;de p&aring; hjemmesiden&quot;;
$langStr[&quot;Acceder a la zona privada del sitio web&quot;] = &quot;Adgang til det private omr&aring;de p&aring; hjemmesiden&quot;;
$langStr[&quot;Nuevo usuario web&quot;] = &quot;Ny webbruger&quot;;
$langStr[&quot;Datos de acceso&quot;] = &quot;Loginoplysninger&quot;;
$langStr[&quot;Hemos registrado correctamente sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;Vi har registreret dine oplysninger korrekt.&lt;br&gt;Tak p&aring; forh&aring;nd for din interesse!&quot;;

/resources/lang_de.php

$langStr[&quot;En tr&aacute;mite&quot;] = &quot;In Bearbeitung&quot;;
$langStr[&quot;&iquest;Te ha gustado esta casa? Val&oacute;rala aqu&iacute;&quot;] = &quot;Hat dir dieses Haus gefallen? Bewerte es hier&quot;;
$langStr[&quot;Est&aacute;s recibiendo este email porque solicitaste informaci&oacute;n o te suscribiste voluntariamente a nuestras comunicaciones comerciales.&quot;] = &quot;Sie erhalten diese E-Mail, weil Sie Informationen angefordert oder sich freiwillig f&uuml;r unsere kommerziellen Mitteilungen angemeldet haben.&quot;;
$langStr[&quot;Responsable&quot;] = &quot;Verantwortlicher&quot;;
$langStr[&quot;Consulta aqu&iacute; nuestra&quot;] = &quot;Hier unsere&quot;;
$langStr[&quot;Pol&iacute;tica de Privacidad&quot;] = &quot;Datenschutzrichtlinie&quot;;
$langStr[&quot;Valora las casas que te hemos enviado&quot;] = &quot;Bewerten Sie die Immobilien, die wir Ihnen gesendet haben&quot;;
$langStr[&quot;Nos ayudas a enviarte solo lo que realmente te interesa&quot;] = &quot;Helfen Sie uns, Ihnen nur das zu senden, was Sie wirklich interessiert&quot;;
$langStr[&quot;Leer m&aacute;s sobre esta noticia&quot;] = &quot;Mehr &uuml;ber diese Nachricht lesen&quot;;
$langStr[&quot;&iquest;Conoces esta zona?&quot;] = &quot;Kennen Sie diese Gegend?&quot;;
$langStr[&quot;Ver m&aacute;s sobre&quot;] = &quot;Mehr erfahren &uuml;ber&quot;;
$langStr[&quot;Promoci&oacute;n destacada&quot;] = &quot;Hervorgehobene Aktion&quot;;
$langStr[&quot;Ver viviendas de la promoci&oacute;n&quot;] = &quot;Immobilien in dieser Entwicklung ansehen&quot;;
$langStr[&quot;&iquest;Quieres ver m&aacute;s opciones?&quot;] = &quot;M&ouml;chten Sie weitere Optionen sehen?&quot;;
$langStr[&quot;Ver m&aacute;s propiedades&quot;] = &quot;Weitere Immobilien ansehen&quot;;
$langStr[&quot;Cu&eacute;ntanos qu&eacute; est&aacute;s buscando&quot;] = &quot;Sagen Sie uns, wonach Sie suchen&quot;;

$langStr[&quot;Tambi&eacute;n te pueden interesar&quot;] = &quot;Das k&ouml;nnte Sie auch interessieren&quot;;
$langStr[&quot;Estimado&quot;] = &quot;Sehr geehrter&quot;;
$langStr[&quot;Hemos registrado con &eacute;xito sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;Ihre Daten wurden erfolgreich registriert.&lt;br&gt;Vielen Dank im Voraus f&uuml;r Ihr Interesse!&quot;;
$langStr[&quot;Saludos cordiales.&quot;] = &quot;Mit freundlichen Gr&uuml;&szlig;en&quot;;
$langStr[&quot;Te env&iacute;o propiedades que pueden interesarte&quot;] = &quot;Ich sende Ihnen Immobilien, die Sie interessieren k&ouml;nnten&quot;;
$langStr[&quot;Estos son sus datos de acceso a la zona privada&quot;] = &quot;Dies sind Ihre Zugangsdaten zum privaten Bereich&quot;;
$langStr[&quot;Confirmamos sus datos de acceso&quot;] = &quot;Wir best&auml;tigen Ihre Zugangsdaten&quot;;
$langStr[&quot;Para acceder a la zona privada de la web, haga clic en el siguiente enlace&quot;] = &quot;Um auf den privaten Bereich der Website zuzugreifen, klicken Sie auf den folgenden Link&quot;;
$langStr[&quot;Acceder a la zona privada del sitio web&quot;] = &quot;Zugang zum privaten Bereich der Website&quot;;
$langStr[&quot;Nuevo usuario web&quot;] = &quot;Neuer Web-Benutzer&quot;;
$langStr[&quot;Datos de acceso&quot;] = &quot;Zugangsdaten&quot;;
$langStr[&quot;Hemos registrado correctamente sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;Ihre Daten wurden erfolgreich registriert.&lt;br&gt;Vielen Dank im Voraus f&uuml;r Ihr Interesse!&quot;;

/resources/lang_en.php

$langStr[&quot;En tr&aacute;mite&quot;] = &quot;In process&quot;;
$langStr[&quot;&iquest;Te ha gustado esta casa? Val&oacute;rala aqu&iacute;&quot;] = &quot;Did you like this house? Rate it here&quot;;
$langStr[&quot;Est&aacute;s recibiendo este email porque solicitaste informaci&oacute;n o te suscribiste voluntariamente a nuestras comunicaciones comerciales.&quot;] = &quot;You are receiving this email because you requested information or voluntarily subscribed to our commercial communications.&quot;;
$langStr[&quot;Responsable&quot;] = &quot;Data Controller&quot;;
$langStr[&quot;Consulta aqu&iacute; nuestra&quot;] = &quot;Click here to review our&quot;;
$langStr[&quot;Pol&iacute;tica de Privacidad&quot;] = &quot;Privacy Policy&quot;;
$langStr[&quot;Valora las casas que te hemos enviado&quot;] = &quot;Rate the properties we have sent you&quot;;
$langStr[&quot;Nos ayudas a enviarte solo lo que realmente te interesa&quot;] = &quot;Help us send you only what truly interests you&quot;;
$langStr[&quot;Leer m&aacute;s sobre esta noticia&quot;] = &quot;Read more about this news&quot;;
$langStr[&quot;&iquest;Conoces esta zona?&quot;] = &quot;Discover this area&quot;;
$langStr[&quot;&iquest;Conoces esta zona?&quot;] = &quot;Do you know this area?&quot;;
$langStr[&quot;Ver m&aacute;s sobre&quot;] = &quot;Learn more about&quot;;
$langStr[&quot;Promoci&oacute;n destacada&quot;] = &quot;Featured promotion&quot;;
$langStr[&quot;Ver viviendas de la promoci&oacute;n&quot;] = &quot;View properties in this development&quot;;
$langStr[&quot;&iquest;Quieres ver m&aacute;s opciones?&quot;] = &quot;Would you like to see more options?&quot;;
$langStr[&quot;Ver m&aacute;s propiedades&quot;] = &quot;View more properties&quot;;
$langStr[&quot;Cu&eacute;ntanos qu&eacute; est&aacute;s buscando&quot;] = &quot;Tell us what you&#039;re looking for&quot;;
$langStr[&quot;Tambi&eacute;n te pueden interesar&quot;] = &quot;You may also be interested in&quot;;
$langStr[&quot;Estimado&quot;] = &quot;Dear&quot;;
$langStr[&quot;Hemos registrado con &eacute;xito sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;We have successfully registered your details.&lt;br&gt;Thank you in advance for your interest!&quot;;
$langStr[&quot;Saludos cordiales.&quot;] = &quot;Kind regards&quot;;
$langStr[&quot;Te env&iacute;o propiedades que pueden interesarte&quot;] = &quot;I send you properties that can interest you&quot;;
$langStr[&quot;Estos son sus datos de acceso a la zona privada&quot;] = &quot;These are your access data to private area&quot;;
$langStr[&quot;Confirmamos sus datos de acceso&quot;] = &quot;We confirm your login data&quot;;
$langStr[&quot;Para acceder a la zona privada de la web, haga clic en el siguiente enlace&quot;] = &quot;To access the private area of the web, click the link below&quot;;
$langStr[&quot;Acceder a la zona privada del sitio web&quot;] = &quot;Access the private area of the website&quot;;
$langStr[&quot;Nuevo usuario web&quot;] = &quot;New website user&quot;;
$langStr[&quot;Datos de acceso&quot;] = &quot;Login data&quot;;
$langStr[&quot;Hemos registrado correctamente sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;We have successfully registered your details.&lt;br&gt;Thank you in advance for your interest!&quot;;

/resources/lang_es.php

$langStr[&quot;En tr&aacute;mite&quot;] = &quot;En tr&aacute;mite&quot;;
$langStr[&quot;&iquest;Te ha gustado esta casa? Val&oacute;rala aqu&iacute;&quot;] = &quot;&iquest;Te ha gustado esta casa? Val&oacute;rala aqu&iacute;&quot;;
$langStr[&quot;Est&aacute;s recibiendo este email porque solicitaste informaci&oacute;n o te suscribiste voluntariamente a nuestras comunicaciones comerciales.&quot;] = &quot;Est&aacute;s recibiendo este email porque solicitaste informaci&oacute;n o te suscribiste voluntariamente a nuestras comunicaciones comerciales.&quot;;
$langStr[&quot;Responsable&quot;] = &quot;Responsable&quot;;
$langStr[&quot;Consulta aqu&iacute; nuestra&quot;] = &quot;Consulta aqu&iacute; nuestra&quot;;
$langStr[&quot;Pol&iacute;tica de Privacidad&quot;] = &quot;Pol&iacute;tica de Privacidad&quot;;
$langStr[&quot;Valora las casas que te hemos enviado&quot;] = &quot;Valora las casas que te hemos enviado&quot;;
$langStr[&quot;Nos ayudas a enviarte solo lo que realmente te interesa&quot;] = &quot;Nos ayudas a enviarte solo lo que realmente te interesa&quot;;
$langStr[&quot;Leer m&aacute;s sobre esta noticia&quot;] = &quot;Leer m&aacute;s sobre esta noticia&quot;;
$langStr[&quot;&iquest;Conoces esta zona?&quot;] = &quot;&iquest;Conoces esta zona?&quot;;
$langStr[&quot;&iquest;Conoces esta zona?&quot;] = &quot;&iquest;Conoces esta zona?&quot;;
$langStr[&quot;Ver m&aacute;s sobre&quot;] = &quot;Ver m&aacute;s sobre&quot;;
$langStr[&quot;Promoci&oacute;n destacada&quot;] = &quot;Promoci&oacute;n destacada&quot;;
$langStr[&quot;Ver viviendas de la promoci&oacute;n&quot;] = &quot;Ver viviendas de la promoci&oacute;n&quot;;
$langStr[&quot;&iquest;Quieres ver m&aacute;s opciones?&quot;] = &quot;&iquest;Quieres ver m&aacute;s opciones?&quot;;
$langStr[&quot;Ver m&aacute;s propiedades&quot;] = &quot;Ver m&aacute;s propiedades&quot;;
$langStr[&quot;Cu&eacute;ntanos qu&eacute; est&aacute;s buscando&quot;] = &quot;Cu&eacute;ntanos qu&eacute; est&aacute;s buscando&quot;;
$langStr[&quot;Tambi&eacute;n te pueden interesar&quot;] = &quot;Tambi&eacute;n te pueden interesar&quot;;
$langStr[&quot;Estimado&quot;] = &quot;Estimado&quot;;
$langStr[&quot;Hemos registrado con &eacute;xito sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;Hemos registrado con &eacute;xito sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;;
$langStr[&quot;Saludos cordiales.&quot;] = &quot;Saludos cordiales.&quot;;
$langStr[&quot;Te env&iacute;o propiedades que pueden interesarte&quot;] = &quot;Te env&iacute;o propiedades que pueden interesarte&quot;;
$langStr[&quot;Estos son sus datos de acceso a la zona privada&quot;] = &quot;Estos son sus datos de acceso a la zona privada&quot;;
$langStr[&quot;Confirmamos sus datos de acceso&quot;] = &quot;Confirmamos sus datos de acceso&quot;;
$langStr[&quot;Para acceder a la zona privada de la web, haga clic en el siguiente enlace&quot;] = &quot;Para acceder a la zona privada de la web, haga clic en el siguiente enlace&quot;;
$langStr[&quot;Acceder a la zona privada del sitio web&quot;] = &quot;Acceder a la zona privada del sitio web&quot;;
$langStr[&quot;Nuevo usuario web&quot;] = &quot;Nuevo usuario web&quot;;
$langStr[&quot;Datos de acceso&quot;] = &quot;Datos de acceso&quot;;
$langStr[&quot;Hemos registrado correctamente sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;Hemos registrado correctamente sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;;

/resources/lang_fi.php

$langStr[&quot;En tr&aacute;mite&quot;] = &quot;K&auml;sittelyss&auml;&quot;;
$langStr[&quot;&iquest;Te ha gustado esta casa? Val&oacute;rala aqu&iacute;&quot;] = &quot;Piditk&ouml; t&auml;st&auml; talosta? Arvostele se t&auml;&auml;ll&auml;&quot;;
$langStr[&quot;Est&aacute;s recibiendo este email porque solicitaste informaci&oacute;n o te suscribiste voluntariamente a nuestras comunicaciones comerciales.&quot;] = &quot;Saat t&auml;m&auml;n s&auml;hk&ouml;postin, koska pyysit tietoja tai tilasit vapaaehtoisesti kaupalliset viestimme.&quot;;
$langStr[&quot;Responsable&quot;] = &quot;Rekisterinpit&auml;j&auml;&quot;;
$langStr[&quot;Consulta aqu&iacute; nuestra&quot;] = &quot;Katso t&auml;st&auml; meid&auml;n&quot;;
$langStr[&quot;Pol&iacute;tica de Privacidad&quot;] = &quot;Tietosuojak&auml;yt&auml;nt&ouml;mme&quot;;
$langStr[&quot;Valora las casas que te hemos enviado&quot;] = &quot;Arvostele l&auml;hett&auml;m&auml;mme asunnot&quot;;
$langStr[&quot;Nos ayudas a enviarte solo lo que realmente te interesa&quot;] = &quot;Auta meit&auml; l&auml;hett&auml;m&auml;&auml;n sinulle vain se, mik&auml; oikeasti kiinnostaa sinua&quot;;
$langStr[&quot;Leer m&aacute;s sobre esta noticia&quot;] = &quot;Lue lis&auml;&auml; t&auml;st&auml; uutisesta&quot;;
$langStr[&quot;&iquest;Conoces esta zona?&quot;] = &quot;Tunnetko t&auml;m&auml;n alueen?&quot;;
$langStr[&quot;Ver m&aacute;s sobre&quot;] = &quot;Lue lis&auml;&auml; aiheesta&quot;;
$langStr[&quot;Promoci&oacute;n destacada&quot;] = &quot;Esittelyss&auml; oleva kohde&quot;;
$langStr[&quot;Ver viviendas de la promoci&oacute;n&quot;] = &quot;N&auml;yt&auml; t&auml;m&auml;n kampanjan asunnot&quot;;
$langStr[&quot;&iquest;Quieres ver m&aacute;s opciones?&quot;] = &quot;Haluatko n&auml;hd&auml; lis&auml;&auml; vaihtoehtoja?&quot;;
$langStr[&quot;Ver m&aacute;s propiedades&quot;] = &quot;N&auml;yt&auml; lis&auml;&auml; asuntoja&quot;;
$langStr[&quot;Cu&eacute;ntanos qu&eacute; est&aacute;s buscando&quot;] = &quot;Kerro meille, mit&auml; etsit&quot;;
$langStr[&quot;Tambi&eacute;n te pueden interesar&quot;] = &quot;N&auml;m&auml; saattavat my&ouml;s kiinnostaa sinua&quot;;
$langStr[&quot;Estimado&quot;] = &quot;Hyv&auml;&quot;;
$langStr[&quot;Hemos registrado con &eacute;xito sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;Tietosi on rekister&ouml;ity onnistuneesti.&lt;br&gt;Kiitos etuk&auml;teen mielenkiinnostasi!&quot;;
$langStr[&quot;Saludos cordiales.&quot;] = &quot;Yst&auml;v&auml;llisin terveisin&quot;;
$langStr[&quot;Te env&iacute;o propiedades que pueden interesarte&quot;] = &quot;L&auml;het&auml;n sinulle kiinteist&ouml;j&auml;, jotka saattavat kiinnostaa sinua&quot;;
$langStr[&quot;Estos son sus datos de acceso a la zona privada&quot;] = &quot;T&auml;ss&auml; ovat kirjautumistietosi yksityisalueelle&quot;;
$langStr[&quot;Confirmamos sus datos de acceso&quot;] = &quot;Vahvistamme kirjautumistietosi&quot;;
$langStr[&quot;Para acceder a la zona privada de la web, haga clic en el siguiente enlace&quot;] = &quot;P&auml;&auml;st&auml;ksesi yksityisalueelle, klikkaa alla olevaa linkki&auml;&quot;;
$langStr[&quot;Acceder a la zona privada del sitio web&quot;] = &quot;Siirry verkkosivuston yksityisalueelle&quot;;
$langStr[&quot;Nuevo usuario web&quot;] = &quot;Uusi verkkosivuston k&auml;ytt&auml;j&auml;&quot;;
$langStr[&quot;Datos de acceso&quot;] = &quot;Kirjautumistiedot&quot;;
$langStr[&quot;Hemos registrado correctamente sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;Tietosi on rekister&ouml;ity oikein.&lt;br&gt;Kiitos etuk&auml;teen mielenkiinnostasi!&quot;;

/resources/lang_fr.php

$langStr[&quot;En tr&aacute;mite&quot;] = &quot;En cours&quot;;
$langStr[&quot;&iquest;Te ha gustado esta casa? Val&oacute;rala aqu&iacute;&quot;] = &quot;Cette maison vous a plu ? &Eacute;valuez-la ici&quot;;
$langStr[&quot;Est&aacute;s recibiendo este email porque solicitaste informaci&oacute;n o te suscribiste voluntariamente a nuestras comunicaciones comerciales.&quot;] = &quot;Vous recevez cet e-mail parce que vous avez demand&eacute; des informations ou vous vous &ecirc;tes abonn&eacute; volontairement &agrave; nos communications commerciales.&quot;;
$langStr[&quot;Responsable&quot;] = &quot;Responsable du traitement&quot;;
$langStr[&quot;Consulta aqu&iacute; nuestra&quot;] = &quot;Consultez ici notre&quot;;
$langStr[&quot;Pol&iacute;tica de Privacidad&quot;] = &quot;Politique de confidentialit&eacute;&quot;;
$langStr[&quot;Valora las casas que te hemos enviado&quot;] = &quot;&Eacute;valuez les maisons que nous vous avons envoy&eacute;es&quot;;
$langStr[&quot;Nos ayudas a enviarte solo lo que realmente te interesa&quot;] = &quot;Aidez-nous &agrave; vous envoyer uniquement ce qui vous int&eacute;resse vraiment&quot;;
$langStr[&quot;Leer m&aacute;s sobre esta noticia&quot;] = &quot;En savoir plus sur cette actualit&eacute;&quot;;
$langStr[&quot;&iquest;Conoces esta zona?&quot;] = &quot;Connaissez-vous cette zone ?&quot;;
$langStr[&quot;Ver m&aacute;s sobre&quot;] = &quot;En savoir plus sur&quot;;
$langStr[&quot;Promoci&oacute;n destacada&quot;] = &quot;Promotion en vedette&quot;;
$langStr[&quot;Ver viviendas de la promoci&oacute;n&quot;] = &quot;Voir les propri&eacute;t&eacute;s de cette promotion&quot;;
$langStr[&quot;&iquest;Quieres ver m&aacute;s opciones?&quot;] = &quot;Souhaitez-vous voir plus d&#039;options ?&quot;;
$langStr[&quot;Ver m&aacute;s propiedades&quot;] = &quot;Voir plus de propri&eacute;t&eacute;s&quot;;
$langStr[&quot;Cu&eacute;ntanos qu&eacute; est&aacute;s buscando&quot;] = &quot;Dites-nous ce que vous recherchez&quot;;
$langStr[&quot;Tambi&eacute;n te pueden interesar&quot;] = &quot;Cela pourrait &eacute;galement vous int&eacute;resser&quot;;
$langStr[&quot;Estimado&quot;] = &quot;Cher&quot;;
$langStr[&quot;Hemos registrado con &eacute;xito sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;Nous avons bien enregistr&eacute; vos donn&eacute;es.&lt;br&gt;Merci d&#039;avance pour votre int&eacute;r&ecirc;t !&quot;;
$langStr[&quot;Saludos cordiales.&quot;] = &quot;Cordialement&quot;;
$langStr[&quot;Te env&iacute;o propiedades que pueden interesarte&quot;] = &quot;Je vous envoie des biens susceptibles de vous int&eacute;resser&quot;;
$langStr[&quot;Estos son sus datos de acceso a la zona privada&quot;] = &quot;Voici vos identifiants d&#039;acc&egrave;s &agrave; la zone priv&eacute;e&quot;;
$langStr[&quot;Confirmamos sus datos de acceso&quot;] = &quot;Nous confirmons vos identifiants&quot;;
$langStr[&quot;Para acceder a la zona privada de la web, haga clic en el siguiente enlace&quot;] = &quot;Pour acc&eacute;der &agrave; la zone priv&eacute;e du site, cliquez sur le lien ci-dessous&quot;;
$langStr[&quot;Acceder a la zona privada del sitio web&quot;] = &quot;Acc&eacute;der &agrave; la zone priv&eacute;e du site&quot;;
$langStr[&quot;Nuevo usuario web&quot;] = &quot;Nouvel utilisateur du site&quot;;
$langStr[&quot;Datos de acceso&quot;] = &quot;Identifiants&quot;;
$langStr[&quot;Hemos registrado correctamente sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;Vos donn&eacute;es ont &eacute;t&eacute; correctement enregistr&eacute;es.&lt;br&gt;Merci d&#039;avance pour votre int&eacute;r&ecirc;t !&quot;;

/resources/lang_is.php

$langStr[&quot;En tr&aacute;mite&quot;] = &quot;&Iacute; vinnslu&quot;;
$langStr[&quot;&iquest;Te ha gustado esta casa? Val&oacute;rala aqu&iacute;&quot;] = &quot;L&iacute;ka&eth;i &thorn;&eacute;r &thorn;etta h&uacute;s? Mettu &thorn;a&eth; h&eacute;r&quot;;
$langStr[&quot;Est&aacute;s recibiendo este email porque solicitaste informaci&oacute;n o te suscribiste voluntariamente a nuestras comunicaciones comerciales.&quot;] = &quot;&THORN;&uacute; f&aelig;r&eth; &thorn;ennan t&ouml;lvup&oacute;st vegna &thorn;ess a&eth; &thorn;&uacute; &oacute;ska&eth;ir eftir uppl&yacute;singum e&eth;a skr&aacute;&eth;ir &thorn;ig sj&aacute;lfviljug(ur) &iacute; vi&eth;skiptatilkynningar okkar.&quot;;
$langStr[&quot;Responsable&quot;] = &quot;&Aacute;byrg&eth;ara&eth;ili gagna&quot;;
$langStr[&quot;Consulta aqu&iacute; nuestra&quot;] = &quot;Sko&eth;a&eth;u stefnuna okkar&quot;;
$langStr[&quot;Pol&iacute;tica de Privacidad&quot;] = &quot;Pers&oacute;nuverndarstefna&quot;;
$langStr[&quot;Valora las casas que te hemos enviado&quot;] = &quot;Mettu h&uacute;sin sem vi&eth; sendum &thorn;&eacute;r&quot;;
$langStr[&quot;Nos ayudas a enviarte solo lo que realmente te interesa&quot;] = &quot;Hj&aacute;lpa&eth;u okkur a&eth; senda &thorn;&eacute;r a&eth;eins &thorn;a&eth; sem vekur &aacute;huga &thorn;inn&quot;;
$langStr[&quot;Leer m&aacute;s sobre esta noticia&quot;] = &quot;Lestu meira um &thorn;essa fr&eacute;tt&quot;;
$langStr[&quot;&iquest;Conoces esta zona?&quot;] = &quot;&THORN;ekkir &thorn;&uacute; &thorn;etta sv&aelig;&eth;i?&quot;;
$langStr[&quot;Ver m&aacute;s sobre&quot;] = &quot;Lestu meira um&quot;;
$langStr[&quot;Promoci&oacute;n destacada&quot;] = &quot;Valin kynning&quot;;
$langStr[&quot;Ver viviendas de la promoci&oacute;n&quot;] = &quot;Sko&eth;a&eth;u eignirnar &iacute; &thorn;essari kynningu&quot;;
$langStr[&quot;&iquest;Quieres ver m&aacute;s opciones?&quot;] = &quot;Viltu sj&aacute; fleiri valkosti?&quot;;
$langStr[&quot;Ver m&aacute;s propiedades&quot;] = &quot;Sj&aacute; fleiri eignir&quot;;
$langStr[&quot;Cu&eacute;ntanos qu&eacute; est&aacute;s buscando&quot;] = &quot;Seg&eth;u okkur hva&eth; &thorn;&uacute; ert a&eth; leita a&eth;&quot;;
$langStr[&quot;Tambi&eacute;n te pueden interesar&quot;] = &quot;&THORN;etta g&aelig;ti l&iacute;ka vaki&eth; &aacute;huga &thorn;inn&quot;;
$langStr[&quot;Estimado&quot;] = &quot;K&aelig;ri&quot;;
$langStr[&quot;Hemos registrado con &eacute;xito sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;Vi&eth; h&ouml;fum skr&aacute;&eth; g&ouml;gnin &thorn;&iacute;n me&eth; g&oacute;&eth;um &aacute;rangri.&lt;br&gt;Takk fyrir &aacute;hugann!&quot;;
$langStr[&quot;Saludos cordiales.&quot;] = &quot;Me&eth; bestu kve&eth;ju&quot;;
$langStr[&quot;Te env&iacute;o propiedades que pueden interesarte&quot;] = &quot;&Eacute;g sendi &thorn;&eacute;r eignir sem g&aelig;tu vaki&eth; &aacute;huga &thorn;inn&quot;;
$langStr[&quot;Estos son sus datos de acceso a la zona privada&quot;] = &quot;H&eacute;r eru a&eth;gangsuppl&yacute;singar &thorn;&iacute;nar a&eth; einkasv&aelig;&eth;inu&quot;;
$langStr[&quot;Confirmamos sus datos de acceso&quot;] = &quot;Vi&eth; sta&eth;festum a&eth;gangsuppl&yacute;singarnar &thorn;&iacute;nar&quot;;
$langStr[&quot;Para acceder a la zona privada de la web, haga clic en el siguiente enlace&quot;] = &quot;Til a&eth; f&aacute; a&eth;gang a&eth; einkasv&aelig;&eth;inu skaltu smella &aacute; hlekkinn h&eacute;r a&eth; ne&eth;an&quot;;
$langStr[&quot;Acceder a la zona privada del sitio web&quot;] = &quot;F&aacute; a&eth;gang a&eth; einkasv&aelig;&eth;i vefsins&quot;;
$langStr[&quot;Nuevo usuario web&quot;] = &quot;N&yacute;r notandi vefs&iacute;&eth;u&quot;;
$langStr[&quot;Datos de acceso&quot;] = &quot;A&eth;gangsuppl&yacute;singar&quot;;
$langStr[&quot;Hemos registrado correctamente sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;Vi&eth; h&ouml;fum skr&aacute;&eth; g&ouml;gnin &thorn;&iacute;n r&eacute;tt.&lt;br&gt;Takk fyrir &aacute;hugann!&quot;;

/resources/lang_nl.php

$langStr[&quot;En tr&aacute;mite&quot;] = &quot;In behandeling&quot;;
$langStr[&quot;&iquest;Te ha gustado esta casa? Val&oacute;rala aqu&iacute;&quot;] = &quot;Vond je dit huis leuk? Beoordeel het hier&quot;;
$langStr[&quot;Est&aacute;s recibiendo este email porque solicitaste informaci&oacute;n o te suscribiste voluntariamente a nuestras comunicaciones comerciales.&quot;] = &quot;Je ontvangt deze e-mail omdat je informatie hebt aangevraagd of je vrijwillig hebt geabonneerd op onze commerci&euml;le communicatie.&quot;;
$langStr[&quot;Responsable&quot;] = &quot;Verantwoordelijke&quot;;
$langStr[&quot;Consulta aqu&iacute; nuestra&quot;] = &quot;Bekijk hier onze&quot;;
$langStr[&quot;Pol&iacute;tica de Privacidad&quot;] = &quot;Privacybeleid&quot;;
$langStr[&quot;Valora las casas que te hemos enviado&quot;] = &quot;Beoordeel de huizen die we je hebben gestuurd&quot;;
$langStr[&quot;Nos ayudas a enviarte solo lo que realmente te interesa&quot;] = &quot;Help ons je alleen te sturen wat je echt interesseert&quot;;
$langStr[&quot;Leer m&aacute;s sobre esta noticia&quot;] = &quot;Lees meer over dit nieuws&quot;;
$langStr[&quot;&iquest;Conoces esta zona?&quot;] = &quot;Ken je deze buurt?&quot;;
$langStr[&quot;Ver m&aacute;s sobre&quot;] = &quot;Meer informatie over&quot;;
$langStr[&quot;Promoci&oacute;n destacada&quot;] = &quot;Uitgelichte promotie&quot;;
$langStr[&quot;Ver viviendas de la promoci&oacute;n&quot;] = &quot;Bekijk woningen in deze promotie&quot;;
$langStr[&quot;&iquest;Quieres ver m&aacute;s opciones?&quot;] = &quot;Wil je meer opties zien?&quot;;
$langStr[&quot;Ver m&aacute;s propiedades&quot;] = &quot;Bekijk meer woningen&quot;;
$langStr[&quot;Cu&eacute;ntanos qu&eacute; est&aacute;s buscando&quot;] = &quot;Vertel ons wat je zoekt&quot;;
$langStr[&quot;Tambi&eacute;n te pueden interesar&quot;] = &quot;Dit kan ook interessant voor je zijn&quot;;
$langStr[&quot;Estimado&quot;] = &quot;Beste&quot;;
$langStr[&quot;Hemos registrado con &eacute;xito sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;Je gegevens zijn succesvol geregistreerd.&lt;br&gt;Alvast bedankt voor je interesse!&quot;;
$langStr[&quot;Saludos cordiales.&quot;] = &quot;Met vriendelijke groet&quot;;
$langStr[&quot;Te env&iacute;o propiedades que pueden interesarte&quot;] = &quot;Ik stuur je woningen die je mogelijk interesseren&quot;;
$langStr[&quot;Estos son sus datos de acceso a la zona privada&quot;] = &quot;Dit zijn je toegangsgegevens voor de priv&eacute;zone&quot;;
$langStr[&quot;Confirmamos sus datos de acceso&quot;] = &quot;We bevestigen je toegangsgegevens&quot;;
$langStr[&quot;Para acceder a la zona privada de la web, haga clic en el siguiente enlace&quot;] = &quot;Klik op de onderstaande link om toegang te krijgen tot het priv&eacute;gedeelte van de website&quot;;
$langStr[&quot;Acceder a la zona privada del sitio web&quot;] = &quot;Toegang tot het priv&eacute;gedeelte van de website&quot;;
$langStr[&quot;Nuevo usuario web&quot;] = &quot;Nieuwe websitegebruiker&quot;;
$langStr[&quot;Datos de acceso&quot;] = &quot;Toegangsgegevens&quot;;
$langStr[&quot;Hemos registrado correctamente sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;Je gegevens zijn correct geregistreerd.&lt;br&gt;Alvast bedankt voor je interesse!&quot;;

/resources/lang_no.php

$langStr[&quot;En tr&aacute;mite&quot;] = &quot;Under behandling&quot;;
$langStr[&quot;&iquest;Te ha gustado esta casa? Val&oacute;rala aqu&iacute;&quot;] = &quot;Likte du dette huset? Vurder det her&quot;;
$langStr[&quot;Est&aacute;s recibiendo este email porque solicitaste informaci&oacute;n o te suscribiste voluntariamente a nuestras comunicaciones comerciales.&quot;] = &quot;Du mottar denne e-posten fordi du ba om informasjon eller frivillig abonnerte p&aring; v&aring;re kommersielle meldinger.&quot;;
$langStr[&quot;Responsable&quot;] = &quot;Behandlingsansvarlig&quot;;
$langStr[&quot;Consulta aqu&iacute; nuestra&quot;] = &quot;Se v&aring;r&quot;;
$langStr[&quot;Pol&iacute;tica de Privacidad&quot;] = &quot;Personvernerkl&aelig;ring&quot;;
$langStr[&quot;Valora las casas que te hemos enviado&quot;] = &quot;Vurder boligene vi har sendt deg&quot;;
$langStr[&quot;Nos ayudas a enviarte solo lo que realmente te interesa&quot;] = &quot;Hjelp oss med &aring; sende deg kun det du virkelig er interessert i&quot;;
$langStr[&quot;Leer m&aacute;s sobre esta noticia&quot;] = &quot;Les mer om denne nyheten&quot;;
$langStr[&quot;&iquest;Conoces esta zona?&quot;] = &quot;Kjenner du dette omr&aring;det?&quot;;
$langStr[&quot;Ver m&aacute;s sobre&quot;] = &quot;Les mer om&quot;;
$langStr[&quot;Promoci&oacute;n destacada&quot;] = &quot;Utvalgt kampanje&quot;;
$langStr[&quot;Ver viviendas de la promoci&oacute;n&quot;] = &quot;Se eiendommene i denne kampanjen&quot;;
$langStr[&quot;&iquest;Quieres ver m&aacute;s opciones?&quot;] = &quot;Vil du se flere alternativer?&quot;;
$langStr[&quot;Ver m&aacute;s propiedades&quot;] = &quot;Se flere eiendommer&quot;;
$langStr[&quot;Cu&eacute;ntanos qu&eacute; est&aacute;s buscando&quot;] = &quot;Fortell oss hva du leter etter&quot;;
$langStr[&quot;Tambi&eacute;n te pueden interesar&quot;] = &quot;Disse kan ogs&aring; v&aelig;re av interesse for deg&quot;;
$langStr[&quot;Estimado&quot;] = &quot;Kj&aelig;re&quot;;
$langStr[&quot;Hemos registrado con &eacute;xito sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;Vi har registrert opplysningene dine med hell.&lt;br&gt;Takk p&aring; forh&aring;nd for din interesse!&quot;;
$langStr[&quot;Saludos cordiales.&quot;] = &quot;Med vennlig hilsen&quot;;
$langStr[&quot;Te env&iacute;o propiedades que pueden interesarte&quot;] = &quot;Jeg sender deg eiendommer som kan v&aelig;re av interesse for deg&quot;;
$langStr[&quot;Estos son sus datos de acceso a la zona privada&quot;] = &quot;Her er dine tilgangsdata til det private omr&aring;det&quot;;
$langStr[&quot;Confirmamos sus datos de acceso&quot;] = &quot;Vi bekrefter dine p&aring;loggingsopplysninger&quot;;
$langStr[&quot;Para acceder a la zona privada de la web, haga clic en el siguiente enlace&quot;] = &quot;Klikk p&aring; lenken nedenfor for &aring; f&aring; tilgang til det private omr&aring;det p&aring; nettsiden&quot;;
$langStr[&quot;Acceder a la zona privada del sitio web&quot;] = &quot;Tilgang til det private omr&aring;det p&aring; nettstedet&quot;;
$langStr[&quot;Nuevo usuario web&quot;] = &quot;Ny nettbruker&quot;;
$langStr[&quot;Datos de acceso&quot;] = &quot;P&aring;loggingsopplysninger&quot;;
$langStr[&quot;Hemos registrado correctamente sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;Vi har registrert opplysningene dine korrekt.&lt;br&gt;Takk p&aring; forh&aring;nd for din interesse!&quot;;

/resources/lang_pl.php

$langStr[&quot;En tr&aacute;mite&quot;] = &quot;W toku&quot;;
$langStr[&quot;&iquest;Te ha gustado esta casa? Val&oacute;rala aqu&iacute;&quot;] = &quot;Podoba&#x142; Ci si&#x119; ten dom? Oce&#x144; go tutaj&quot;;
$langStr[&quot;Est&aacute;s recibiendo este email porque solicitaste informaci&oacute;n o te suscribiste voluntariamente a nuestras comunicaciones comerciales.&quot;] = &quot;Otrzymujesz ten e-mail, poniewa&#x17c; poprosi&#x142;e&#x15b; o informacje lub dobrowolnie zapisa&#x142;e&#x15b; si&#x119; na nasze wiadomo&#x15b;ci handlowe.&quot;;
$langStr[&quot;Responsable&quot;] = &quot;Administrator danych&quot;;
$langStr[&quot;Consulta aqu&iacute; nuestra&quot;] = &quot;Zobacz nasz&#x105;&quot;;
$langStr[&quot;Pol&iacute;tica de Privacidad&quot;] = &quot;Polityk&#x119; prywatno&#x15b;ci&quot;;
$langStr[&quot;Valora las casas que te hemos enviado&quot;] = &quot;Oce&#x144; domy, kt&oacute;re Ci wys&#x142;ali&#x15b;my&quot;;
$langStr[&quot;Nos ayudas a enviarte solo lo que realmente te interesa&quot;] = &quot;Pom&oacute;&#x17c; nam wysy&#x142;a&#x107; Ci tylko to, co naprawd&#x119; Ci&#x119; interesuje&quot;;
$langStr[&quot;Leer m&aacute;s sobre esta noticia&quot;] = &quot;Przeczytaj wi&#x119;cej o tej wiadomo&#x15b;ci&quot;;
$langStr[&quot;&iquest;Conoces esta zona?&quot;] = &quot;Znasz t&#x119; okolic&#x119;?&quot;;
$langStr[&quot;Ver m&aacute;s sobre&quot;] = &quot;Zobacz wi&#x119;cej o&quot;;
$langStr[&quot;Promoci&oacute;n destacada&quot;] = &quot;Polecana promocja&quot;;
$langStr[&quot;Ver viviendas de la promoci&oacute;n&quot;] = &quot;Zobacz nieruchomo&#x15b;ci w tej promocji&quot;;
$langStr[&quot;&iquest;Quieres ver m&aacute;s opciones?&quot;] = &quot;Chcesz zobaczy&#x107; wi&#x119;cej opcji?&quot;;
$langStr[&quot;Ver m&aacute;s propiedades&quot;] = &quot;Zobacz wi&#x119;cej nieruchomo&#x15b;ci&quot;;
$langStr[&quot;Cu&eacute;ntanos qu&eacute; est&aacute;s buscando&quot;] = &quot;Powiedz nam, czego szukasz&quot;;
$langStr[&quot;Tambi&eacute;n te pueden interesar&quot;] = &quot;To r&oacute;wnie&#x17c; mo&#x17c;e Ci&#x119; zainteresowa&#x107;&quot;;
$langStr[&quot;Estimado&quot;] = &quot;Szanowny&quot;;
$langStr[&quot;Hemos registrado con &eacute;xito sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;Twoje dane zosta&#x142;y pomy&#x15b;lnie zarejestrowane.&lt;br&gt;Dzi&#x119;kujemy za zainteresowanie!&quot;;
$langStr[&quot;Saludos cordiales.&quot;] = &quot;Z powa&#x17c;aniem&quot;;
$langStr[&quot;Te env&iacute;o propiedades que pueden interesarte&quot;] = &quot;Wysy&#x142;am Ci oferty nieruchomo&#x15b;ci, kt&oacute;re mog&#x105; Ci&#x119; zainteresowa&#x107;&quot;;
$langStr[&quot;Estos son sus datos de acceso a la zona privada&quot;] = &quot;Oto Twoje dane dost&#x119;powe do strefy prywatnej&quot;;
$langStr[&quot;Confirmamos sus datos de acceso&quot;] = &quot;Potwierdzamy Twoje dane dost&#x119;powe&quot;;
$langStr[&quot;Para acceder a la zona privada de la web, haga clic en el siguiente enlace&quot;] = &quot;Aby uzyska&#x107; dost&#x119;p do strefy prywatnej, kliknij poni&#x17c;szy link&quot;;
$langStr[&quot;Acceder a la zona privada del sitio web&quot;] = &quot;Wejd&#x17a; do strefy prywatnej serwisu&quot;;
$langStr[&quot;Nuevo usuario web&quot;] = &quot;Nowy u&#x17c;ytkownik strony&quot;;
$langStr[&quot;Datos de acceso&quot;] = &quot;Dane dost&#x119;powe&quot;;
$langStr[&quot;Hemos registrado correctamente sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;Twoje dane zosta&#x142;y poprawnie zarejestrowane.&lt;br&gt;Dzi&#x119;kujemy za zainteresowanie!&quot;;

/resources/lang_ru.php

$langStr[&quot;En tr&aacute;mite&quot;] = &quot;&#x412; &#x43f;&#x440;&#x43e;&#x446;&#x435;&#x441;&#x441;&#x435;&quot;;
$langStr[&quot;&iquest;Te ha gustado esta casa? Val&oacute;rala aqu&iacute;&quot;] = &quot;&#x412;&#x430;&#x43c; &#x43f;&#x43e;&#x43d;&#x440;&#x430;&#x432;&#x438;&#x43b;&#x441;&#x44f; &#x44d;&#x442;&#x43e;&#x442; &#x434;&#x43e;&#x43c;? &#x41e;&#x446;&#x435;&#x43d;&#x438;&#x442;&#x435; &#x435;&#x433;&#x43e; &#x437;&#x434;&#x435;&#x441;&#x44c;&quot;;
$langStr[&quot;Est&aacute;s recibiendo este email porque solicitaste informaci&oacute;n o te suscribiste voluntariamente a nuestras comunicaciones comerciales.&quot;] = &quot;&#x412;&#x44b; &#x43f;&#x43e;&#x43b;&#x443;&#x447;&#x438;&#x43b;&#x438; &#x44d;&#x442;&#x43e; &#x43f;&#x438;&#x441;&#x44c;&#x43c;&#x43e;, &#x43f;&#x43e;&#x442;&#x43e;&#x43c;&#x443; &#x447;&#x442;&#x43e; &#x437;&#x430;&#x43f;&#x440;&#x43e;&#x441;&#x438;&#x43b;&#x438; &#x438;&#x43d;&#x444;&#x43e;&#x440;&#x43c;&#x430;&#x446;&#x438;&#x44e; &#x438;&#x43b;&#x438; &#x434;&#x43e;&#x431;&#x440;&#x43e;&#x432;&#x43e;&#x43b;&#x44c;&#x43d;&#x43e; &#x43f;&#x43e;&#x434;&#x43f;&#x438;&#x441;&#x430;&#x43b;&#x438;&#x441;&#x44c; &#x43d;&#x430; &#x43d;&#x430;&#x448;&#x438; &#x43a;&#x43e;&#x43c;&#x43c;&#x435;&#x440;&#x447;&#x435;&#x441;&#x43a;&#x438;&#x435; &#x440;&#x430;&#x441;&#x441;&#x44b;&#x43b;&#x43a;&#x438;.&quot;;
$langStr[&quot;Responsable&quot;] = &quot;&#x41e;&#x442;&#x432;&#x435;&#x442;&#x441;&#x442;&#x432;&#x435;&#x43d;&#x43d;&#x43e;&#x435; &#x43b;&#x438;&#x446;&#x43e;&quot;;
$langStr[&quot;Consulta aqu&iacute; nuestra&quot;] = &quot;&#x41f;&#x43e;&#x441;&#x43c;&#x43e;&#x442;&#x440;&#x435;&#x442;&#x44c; &#x43d;&#x430;&#x448;&#x443;&quot;;
$langStr[&quot;Pol&iacute;tica de Privacidad&quot;] = &quot;&#x41f;&#x43e;&#x43b;&#x438;&#x442;&#x438;&#x43a;&#x443; &#x43a;&#x43e;&#x43d;&#x444;&#x438;&#x434;&#x435;&#x43d;&#x446;&#x438;&#x430;&#x43b;&#x44c;&#x43d;&#x43e;&#x441;&#x442;&#x438;&quot;;
$langStr[&quot;Valora las casas que te hemos enviado&quot;] = &quot;&#x41e;&#x446;&#x435;&#x43d;&#x438;&#x442;&#x435; &#x434;&#x43e;&#x43c;&#x430;, &#x43a;&#x43e;&#x442;&#x43e;&#x440;&#x44b;&#x435; &#x43c;&#x44b; &#x432;&#x430;&#x43c; &#x43e;&#x442;&#x43f;&#x440;&#x430;&#x432;&#x438;&#x43b;&#x438;&quot;;
$langStr[&quot;Nos ayudas a enviarte solo lo que realmente te interesa&quot;] = &quot;&#x41f;&#x43e;&#x43c;&#x43e;&#x433;&#x438;&#x442;&#x435; &#x43d;&#x430;&#x43c; &#x43e;&#x442;&#x43f;&#x440;&#x430;&#x432;&#x43b;&#x44f;&#x442;&#x44c; &#x442;&#x43e;&#x43b;&#x44c;&#x43a;&#x43e; &#x442;&#x43e;, &#x447;&#x442;&#x43e; &#x434;&#x435;&#x439;&#x441;&#x442;&#x432;&#x438;&#x442;&#x435;&#x43b;&#x44c;&#x43d;&#x43e; &#x432;&#x430;&#x441; &#x438;&#x43d;&#x442;&#x435;&#x440;&#x435;&#x441;&#x443;&#x435;&#x442;&quot;;
$langStr[&quot;Leer m&aacute;s sobre esta noticia&quot;] = &quot;&#x41f;&#x43e;&#x434;&#x440;&#x43e;&#x431;&#x43d;&#x435;&#x435; &#x43e;&#x431; &#x44d;&#x442;&#x43e;&#x439; &#x43d;&#x43e;&#x432;&#x43e;&#x441;&#x442;&#x438;&quot;;
$langStr[&quot;&iquest;Conoces esta zona?&quot;] = &quot;&#x412;&#x44b; &#x437;&#x43d;&#x430;&#x435;&#x442;&#x435; &#x44d;&#x442;&#x43e;&#x442; &#x440;&#x430;&#x439;&#x43e;&#x43d;?&quot;;
$langStr[&quot;Ver m&aacute;s sobre&quot;] = &quot;&#x423;&#x437;&#x43d;&#x430;&#x442;&#x44c; &#x431;&#x43e;&#x43b;&#x44c;&#x448;&#x435; &#x43e;&quot;;
$langStr[&quot;Promoci&oacute;n destacada&quot;] = &quot;&#x420;&#x435;&#x43a;&#x43e;&#x43c;&#x435;&#x43d;&#x434;&#x443;&#x435;&#x43c;&#x43e;&#x435; &#x43f;&#x440;&#x435;&#x434;&#x43b;&#x43e;&#x436;&#x435;&#x43d;&#x438;&#x435;&quot;;
$langStr[&quot;Ver viviendas de la promoci&oacute;n&quot;] = &quot;&#x41f;&#x43e;&#x441;&#x43c;&#x43e;&#x442;&#x440;&#x435;&#x442;&#x44c; &#x43e;&#x431;&#x44a;&#x435;&#x43a;&#x442;&#x44b; &#x438;&#x437; &#x44d;&#x442;&#x43e;&#x433;&#x43e; &#x43f;&#x440;&#x435;&#x434;&#x43b;&#x43e;&#x436;&#x435;&#x43d;&#x438;&#x44f;&quot;;
$langStr[&quot;&iquest;Quieres ver m&aacute;s opciones?&quot;] = &quot;&#x425;&#x43e;&#x442;&#x438;&#x442;&#x435; &#x443;&#x432;&#x438;&#x434;&#x435;&#x442;&#x44c; &#x431;&#x43e;&#x43b;&#x44c;&#x448;&#x435; &#x432;&#x430;&#x440;&#x438;&#x430;&#x43d;&#x442;&#x43e;&#x432;?&quot;;
$langStr[&quot;Ver m&aacute;s propiedades&quot;] = &quot;&#x41f;&#x43e;&#x441;&#x43c;&#x43e;&#x442;&#x440;&#x435;&#x442;&#x44c; &#x431;&#x43e;&#x43b;&#x44c;&#x448;&#x435; &#x43e;&#x431;&#x44a;&#x435;&#x43a;&#x442;&#x43e;&#x432;&quot;;
$langStr[&quot;Cu&eacute;ntanos qu&eacute; est&aacute;s buscando&quot;] = &quot;&#x420;&#x430;&#x441;&#x441;&#x43a;&#x430;&#x436;&#x438;&#x442;&#x435; &#x43d;&#x430;&#x43c;, &#x447;&#x442;&#x43e; &#x432;&#x44b; &#x438;&#x449;&#x435;&#x442;&#x435;&quot;;
$langStr[&quot;Tambi&eacute;n te pueden interesar&quot;] = &quot;&#x412;&#x430;&#x43c; &#x442;&#x430;&#x43a;&#x436;&#x435; &#x43c;&#x43e;&#x436;&#x435;&#x442; &#x431;&#x44b;&#x442;&#x44c; &#x438;&#x43d;&#x442;&#x435;&#x440;&#x435;&#x441;&#x43d;&#x43e;&quot;;
$langStr[&quot;Estimado&quot;] = &quot;&#x423;&#x432;&#x430;&#x436;&#x430;&#x435;&#x43c;&#x44b;&#x439;&quot;;
$langStr[&quot;Hemos registrado con &eacute;xito sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;&#x412;&#x430;&#x448;&#x438; &#x434;&#x430;&#x43d;&#x43d;&#x44b;&#x435; &#x443;&#x441;&#x43f;&#x435;&#x448;&#x43d;&#x43e; &#x437;&#x430;&#x440;&#x435;&#x433;&#x438;&#x441;&#x442;&#x440;&#x438;&#x440;&#x43e;&#x432;&#x430;&#x43d;&#x44b;.&lt;br&gt;&#x417;&#x430;&#x440;&#x430;&#x43d;&#x435;&#x435; &#x431;&#x43b;&#x430;&#x433;&#x43e;&#x434;&#x430;&#x440;&#x438;&#x43c; &#x437;&#x430; &#x432;&#x430;&#x448; &#x438;&#x43d;&#x442;&#x435;&#x440;&#x435;&#x441;!&quot;;
$langStr[&quot;Saludos cordiales.&quot;] = &quot;&#x421; &#x443;&#x432;&#x430;&#x436;&#x435;&#x43d;&#x438;&#x435;&#x43c;&quot;;
$langStr[&quot;Te env&iacute;o propiedades que pueden interesarte&quot;] = &quot;&#x42f; &#x43e;&#x442;&#x43f;&#x440;&#x430;&#x432;&#x43b;&#x44f;&#x44e; &#x432;&#x430;&#x43c; &#x43e;&#x431;&#x44a;&#x435;&#x43a;&#x442;&#x44b; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x438;, &#x43a;&#x43e;&#x442;&#x43e;&#x440;&#x44b;&#x435; &#x43c;&#x43e;&#x433;&#x443;&#x442; &#x432;&#x430;&#x441; &#x437;&#x430;&#x438;&#x43d;&#x442;&#x435;&#x440;&#x435;&#x441;&#x43e;&#x432;&#x430;&#x442;&#x44c;&quot;;
$langStr[&quot;Estos son sus datos de acceso a la zona privada&quot;] = &quot;&#x412;&#x43e;&#x442; &#x432;&#x430;&#x448;&#x438; &#x434;&#x430;&#x43d;&#x43d;&#x44b;&#x435; &#x434;&#x43b;&#x44f; &#x432;&#x445;&#x43e;&#x434;&#x430; &#x432; &#x43b;&#x438;&#x447;&#x43d;&#x44b;&#x439; &#x43a;&#x430;&#x431;&#x438;&#x43d;&#x435;&#x442;&quot;;
$langStr[&quot;Confirmamos sus datos de acceso&quot;] = &quot;&#x41c;&#x44b; &#x43f;&#x43e;&#x434;&#x442;&#x432;&#x435;&#x440;&#x436;&#x434;&#x430;&#x435;&#x43c; &#x432;&#x430;&#x448;&#x438; &#x434;&#x430;&#x43d;&#x43d;&#x44b;&#x435; &#x434;&#x43b;&#x44f; &#x432;&#x445;&#x43e;&#x434;&#x430;&quot;;
$langStr[&quot;Para acceder a la zona privada de la web, haga clic en el siguiente enlace&quot;] = &quot;&#x427;&#x442;&#x43e;&#x431;&#x44b; &#x432;&#x43e;&#x439;&#x442;&#x438; &#x432; &#x43b;&#x438;&#x447;&#x43d;&#x44b;&#x439; &#x43a;&#x430;&#x431;&#x438;&#x43d;&#x435;&#x442;, &#x43d;&#x430;&#x436;&#x43c;&#x438;&#x442;&#x435; &#x43d;&#x430; &#x441;&#x441;&#x44b;&#x43b;&#x43a;&#x443; &#x43d;&#x438;&#x436;&#x435;&quot;;
$langStr[&quot;Acceder a la zona privada del sitio web&quot;] = &quot;&#x412;&#x43e;&#x439;&#x442;&#x438; &#x432; &#x43b;&#x438;&#x447;&#x43d;&#x44b;&#x439; &#x43a;&#x430;&#x431;&#x438;&#x43d;&#x435;&#x442; &#x43d;&#x430; &#x441;&#x430;&#x439;&#x442;&#x435;&quot;;
$langStr[&quot;Nuevo usuario web&quot;] = &quot;&#x41d;&#x43e;&#x432;&#x44b;&#x439; &#x43f;&#x43e;&#x43b;&#x44c;&#x437;&#x43e;&#x432;&#x430;&#x442;&#x435;&#x43b;&#x44c; &#x441;&#x430;&#x439;&#x442;&#x430;&quot;;
$langStr[&quot;Datos de acceso&quot;] = &quot;&#x414;&#x430;&#x43d;&#x43d;&#x44b;&#x435; &#x434;&#x43b;&#x44f; &#x432;&#x445;&#x43e;&#x434;&#x430;&quot;;
$langStr[&quot;Hemos registrado correctamente sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;&#x412;&#x430;&#x448;&#x438; &#x434;&#x430;&#x43d;&#x43d;&#x44b;&#x435; &#x431;&#x44b;&#x43b;&#x438; &#x443;&#x441;&#x43f;&#x435;&#x448;&#x43d;&#x43e; &#x437;&#x430;&#x440;&#x435;&#x433;&#x438;&#x441;&#x442;&#x440;&#x438;&#x440;&#x43e;&#x432;&#x430;&#x43d;&#x44b;.&lt;br&gt;&#x417;&#x430;&#x440;&#x430;&#x43d;&#x435;&#x435; &#x431;&#x43b;&#x430;&#x433;&#x43e;&#x434;&#x430;&#x440;&#x438;&#x43c; &#x437;&#x430; &#x438;&#x43d;&#x442;&#x435;&#x440;&#x435;&#x441;!&quot;;

/resources/lang_se.php

$langStr[&quot;En tr&aacute;mite&quot;] = &quot;Under behandling&quot;;
$langStr[&quot;&iquest;Te ha gustado esta casa? Val&oacute;rala aqu&iacute;&quot;] = &quot;Gillade du det h&auml;r huset? Betygs&auml;tt det h&auml;r&quot;;
$langStr[&quot;Est&aacute;s recibiendo este email porque solicitaste informaci&oacute;n o te suscribiste voluntariamente a nuestras comunicaciones comerciales.&quot;] = &quot;Du f&aring;r detta e-postmeddelande eftersom du beg&auml;rt information eller frivilligt prenumererat p&aring; v&aring;ra kommersiella utskick.&quot;;
$langStr[&quot;Responsable&quot;] = &quot;Personuppgiftsansvarig&quot;;
$langStr[&quot;Consulta aqu&iacute; nuestra&quot;] = &quot;L&auml;s v&aring;r&quot;;
$langStr[&quot;Pol&iacute;tica de Privacidad&quot;] = &quot;Integritetspolicy&quot;;
$langStr[&quot;Valora las casas que te hemos enviado&quot;] = &quot;Betygs&auml;tt bost&auml;derna vi har skickat till dig&quot;;
$langStr[&quot;Nos ayudas a enviarte solo lo que realmente te interesa&quot;] = &quot;Hj&auml;lp oss att bara skicka det du verkligen &auml;r intresserad av&quot;;
$langStr[&quot;Leer m&aacute;s sobre esta noticia&quot;] = &quot;L&auml;s mer om denna nyhet&quot;;
$langStr[&quot;&iquest;Conoces esta zona?&quot;] = &quot;K&auml;nner du till det h&auml;r omr&aring;det?&quot;;
$langStr[&quot;Ver m&aacute;s sobre&quot;] = &quot;L&auml;s mer om&quot;;
$langStr[&quot;Promoci&oacute;n destacada&quot;] = &quot;Utvald kampanj&quot;;
$langStr[&quot;Ver viviendas de la promoci&oacute;n&quot;] = &quot;Se bost&auml;der i denna kampanj&quot;;
$langStr[&quot;&iquest;Quieres ver m&aacute;s opciones?&quot;] = &quot;Vill du se fler alternativ?&quot;;
$langStr[&quot;Ver m&aacute;s propiedades&quot;] = &quot;Se fler bost&auml;der&quot;;
$langStr[&quot;Cu&eacute;ntanos qu&eacute; est&aacute;s buscando&quot;] = &quot;Ber&auml;tta vad du letar efter&quot;;
$langStr[&quot;Tambi&eacute;n te pueden interesar&quot;] = &quot;Detta kan ocks&aring; vara av intresse f&ouml;r dig&quot;;
$langStr[&quot;Estimado&quot;] = &quot;K&auml;ra&quot;;
$langStr[&quot;Hemos registrado con &eacute;xito sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;Vi har registrerat dina uppgifter framg&aring;ngsrikt.&lt;br&gt;Tack p&aring; f&ouml;rhand f&ouml;r ditt intresse!&quot;;
$langStr[&quot;Saludos cordiales.&quot;] = &quot;Med v&auml;nliga h&auml;lsningar&quot;;
$langStr[&quot;Te env&iacute;o propiedades que pueden interesarte&quot;] = &quot;Jag skickar dig fastigheter som kan vara av intresse&quot;;
$langStr[&quot;Estos son sus datos de acceso a la zona privada&quot;] = &quot;H&auml;r &auml;r dina inloggningsuppgifter till den privata zonen&quot;;
$langStr[&quot;Confirmamos sus datos de acceso&quot;] = &quot;Vi bekr&auml;ftar dina inloggningsuppgifter&quot;;
$langStr[&quot;Para acceder a la zona privada de la web, haga clic en el siguiente enlace&quot;] = &quot;F&ouml;r att komma &aring;t den privata zonen p&aring; webbplatsen, klicka p&aring; l&auml;nken nedan&quot;;
$langStr[&quot;Acceder a la zona privada del sitio web&quot;] = &quot;G&aring; till den privata zonen p&aring; webbplatsen&quot;;
$langStr[&quot;Nuevo usuario web&quot;] = &quot;Ny webbplatsanv&auml;ndare&quot;;
$langStr[&quot;Datos de acceso&quot;] = &quot;Inloggningsuppgifter&quot;;
$langStr[&quot;Hemos registrado correctamente sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;Vi har registrerat dina uppgifter korrekt.&lt;br&gt;Tack p&aring; f&ouml;rhand f&ouml;r ditt intresse!&quot;;

/resources/lang_zh.php

$langStr[&quot;En tr&aacute;mite&quot;] = &quot;&#x5904;&#x7406;&#x4e2d;&quot;;
$langStr[&quot;&iquest;Te ha gustado esta casa? Val&oacute;rala aqu&iacute;&quot;] = &quot;&#x4f60;&#x559c;&#x6b22;&#x8fd9;&#x5957;&#x623f;&#x5b50;&#x5417;&#xff1f;&#x5728;&#x8fd9;&#x91cc;&#x8bc4;&#x5206;&quot;;
$langStr[&quot;Est&aacute;s recibiendo este email porque solicitaste informaci&oacute;n o te suscribiste voluntariamente a nuestras comunicaciones comerciales.&quot;] = &quot;&#x60a8;&#x6536;&#x5230;&#x6b64;&#x7535;&#x5b50;&#x90ae;&#x4ef6;&#x662f;&#x56e0;&#x4e3a;&#x60a8;&#x8bf7;&#x6c42;&#x4e86;&#x4fe1;&#x606f;&#x6216;&#x81ea;&#x613f;&#x8ba2;&#x9605;&#x4e86;&#x6211;&#x4eec;&#x7684;&#x5546;&#x4e1a;&#x901a;&#x8baf;&#x3002;&quot;;
$langStr[&quot;Responsable&quot;] = &quot;&#x6570;&#x636e;&#x63a7;&#x5236;&#x8005;&quot;;
$langStr[&quot;Consulta aqu&iacute; nuestra&quot;] = &quot;&#x70b9;&#x51fb;&#x6b64;&#x5904;&#x67e5;&#x770b;&#x6211;&#x4eec;&#x7684;&quot;;
$langStr[&quot;Pol&iacute;tica de Privacidad&quot;] = &quot;&#x9690;&#x79c1;&#x653f;&#x7b56;&quot;;
$langStr[&quot;Valora las casas que te hemos enviado&quot;] = &quot;&#x4e3a;&#x6211;&#x4eec;&#x53d1;&#x9001;&#x7ed9;&#x60a8;&#x7684;&#x623f;&#x6e90;&#x8bc4;&#x5206;&quot;;
$langStr[&quot;Nos ayudas a enviarte solo lo que realmente te interesa&quot;] = &quot;&#x5e2e;&#x52a9;&#x6211;&#x4eec;&#x53ea;&#x5411;&#x60a8;&#x53d1;&#x9001;&#x60a8;&#x771f;&#x6b63;&#x611f;&#x5174;&#x8da3;&#x7684;&#x5185;&#x5bb9;&quot;;
$langStr[&quot;Leer m&aacute;s sobre esta noticia&quot;] = &quot;&#x67e5;&#x770b;&#x66f4;&#x591a;&#x76f8;&#x5173;&#x8d44;&#x8baf;&quot;;
$langStr[&quot;&iquest;Conoces esta zona?&quot;] = &quot;&#x60a8;&#x4e86;&#x89e3;&#x8fd9;&#x4e2a;&#x533a;&#x57df;&#x5417;&#xff1f;&quot;;
$langStr[&quot;Ver m&aacute;s sobre&quot;] = &quot;&#x67e5;&#x770b;&#x66f4;&#x591a;&#x5173;&#x4e8e;&quot;;
$langStr[&quot;Promoci&oacute;n destacada&quot;] = &quot;&#x7cbe;&#x9009;&#x4f18;&#x60e0;&quot;;
$langStr[&quot;Ver viviendas de la promoci&oacute;n&quot;] = &quot;&#x67e5;&#x770b;&#x6b64;&#x4f18;&#x60e0;&#x4e2d;&#x7684;&#x623f;&#x6e90;&quot;;
$langStr[&quot;&iquest;Quieres ver m&aacute;s opciones?&quot;] = &quot;&#x60f3;&#x770b;&#x770b;&#x66f4;&#x591a;&#x9009;&#x62e9;&#x5417;&#xff1f;&quot;;
$langStr[&quot;Ver m&aacute;s propiedades&quot;] = &quot;&#x67e5;&#x770b;&#x66f4;&#x591a;&#x623f;&#x6e90;&quot;;
$langStr[&quot;Cu&eacute;ntanos qu&eacute; est&aacute;s buscando&quot;] = &quot;&#x544a;&#x8bc9;&#x6211;&#x4eec;&#x60a8;&#x5728;&#x5bfb;&#x627e;&#x4ec0;&#x4e48;&quot;;
$langStr[&quot;Tambi&eacute;n te pueden interesar&quot;] = &quot;&#x8fd9;&#x4e9b;&#x4e5f;&#x53ef;&#x80fd;&#x4f1a;&#x5f15;&#x8d77;&#x60a8;&#x7684;&#x5174;&#x8da3;&quot;;
$langStr[&quot;Estimado&quot;] = &quot;&#x5c0a;&#x656c;&#x7684;&quot;;
$langStr[&quot;Hemos registrado con &eacute;xito sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;&#x6211;&#x4eec;&#x5df2;&#x6210;&#x529f;&#x6ce8;&#x518c;&#x60a8;&#x7684;&#x4fe1;&#x606f;&#x3002;&lt;br&gt;&#x63d0;&#x524d;&#x611f;&#x8c22;&#x60a8;&#x7684;&#x5173;&#x6ce8;&#xff01;&quot;;
$langStr[&quot;Saludos cordiales.&quot;] = &quot;&#x6b64;&#x81f4;&#x656c;&#x793c;&quot;;
$langStr[&quot;Te env&iacute;o propiedades que pueden interesarte&quot;] = &quot;&#x6211;&#x4e3a;&#x60a8;&#x63a8;&#x8350;&#x4e00;&#x4e9b;&#x53ef;&#x80fd;&#x611f;&#x5174;&#x8da3;&#x7684;&#x623f;&#x6e90;&quot;;
$langStr[&quot;Estos son sus datos de acceso a la zona privada&quot;] = &quot;&#x4ee5;&#x4e0b;&#x662f;&#x60a8;&#x8fdb;&#x5165;&#x79c1;&#x4eba;&#x533a;&#x57df;&#x7684;&#x767b;&#x5f55;&#x4fe1;&#x606f;&quot;;
$langStr[&quot;Confirmamos sus datos de acceso&quot;] = &quot;&#x6211;&#x4eec;&#x786e;&#x8ba4;&#x60a8;&#x7684;&#x767b;&#x5f55;&#x4fe1;&#x606f;&quot;;
$langStr[&quot;Para acceder a la zona privada de la web, haga clic en el siguiente enlace&quot;] = &quot;&#x70b9;&#x51fb;&#x4e0b;&#x65b9;&#x94fe;&#x63a5;&#x5373;&#x53ef;&#x8fdb;&#x5165;&#x7f51;&#x7ad9;&#x79c1;&#x4eba;&#x533a;&#x57df;&quot;;
$langStr[&quot;Acceder a la zona privada del sitio web&quot;] = &quot;&#x8fdb;&#x5165;&#x7f51;&#x7ad9;&#x79c1;&#x4eba;&#x533a;&#x57df;&quot;;
$langStr[&quot;Nuevo usuario web&quot;] = &quot;&#x65b0;&#x7f51;&#x7ad9;&#x7528;&#x6237;&quot;;
$langStr[&quot;Datos de acceso&quot;] = &quot;&#x767b;&#x5f55;&#x4fe1;&#x606f;&quot;;
$langStr[&quot;Hemos registrado correctamente sus datos.&lt;br&gt;&iexcl;Gracias de antemano por su inter&eacute;s!&quot;] = &quot;&#x6211;&#x4eec;&#x5df2;&#x6210;&#x529f;&#x6ce8;&#x518c;&#x60a8;&#x7684;&#x4fe1;&#x606f;&#x3002;&lt;br&gt;&#x63d0;&#x524d;&#x611f;&#x8c22;&#x60a8;&#x7684;&#x5173;&#x6ce8;&#xff01;&quot;;

            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec11">
        <span class="badge badge-dark">11</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo Habihub al marcar a 1 el campo force_hide_prop
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/Habihub.php:207
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ((int)$property-&gt;restrictions-&gt;website == 0) {
    $query .= &quot;force_hide_prop = &#039;0&#039;, \n&quot;;
} else {
    $query .= &quot;force_hide_prop = &#039;1&#039;, \n&quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query_rsHide = &quot;SELECT id_prop, referencia_prop, force_hide_prop FROM properties_properties WHERE ref_xml_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((string)$property-&gt;ref)).&quot;&#039;&quot;;
$rsHide = mysqli_query($inmoconn,$query_rsHide) or die(mysqli_error() . &#039;&lt;hr&gt;&#039; . $query_rsHide);
$row_rsHide = mysqli_fetch_assoc($rsHide);
$totalRows_rsHide = mysqli_num_rows($rsHide);

if ($row_rsHide[&#039;force_hide_prop&#039;] == 1) {
    $query .= &quot;force_hide_prop = &#039;1&#039;, \n&quot;;
} else {
    if ((int)$property-&gt;restrictions-&gt;website == 0) {
        $query .= &quot;force_hide_prop = &#039;0&#039;, \n&quot;;
    } else {
        $query .= &quot;force_hide_prop = &#039;1&#039;, \n&quot;;
    }
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec12">
        <span class="badge badge-dark">12</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo al añadir imagenes en los archivos de inicio
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/inicio/inicio.php:71
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if (count($matches[0] &gt; 0)) {
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if (count($matches[0]) &gt; 0) {
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec13">
        <span class="badge badge-dark">13</span> <i class="fas fz-fw fa-bug text-danger"></i> No funciona el selector de idiomas al editar archivos a una noticia
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/news/files_langs.php:70
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$colname_rsImg = mysqli_real_escape_string($colname_rsImg);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$colname_rsImg = mysqli_real_escape_string($inmoconn, $colname_rsImg);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec14">
        <span class="badge badge-dark">14</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo al importar de inmovilla
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/Inmovilla.php:301
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
if ((int) $property-&gt;numfotos &gt; 0) {
    $imagesProp = array();
    for ($r=1; $r &lt;= $property-&gt;numfotos ; $r++) {
        $n = &#039;foto&#039; . $r;
        array_push($imagesProp, (string)$property-&gt;$n);
    }
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$imagesProp = array();

if ((int) $property-&gt;numfotos &gt; 0) {
    for ($r=1; $r &lt;= $property-&gt;numfotos ; $r++) {
        $n = &#039;foto&#039; . $r;
        array_push($imagesProp, (string)$property-&gt;$n);
    }
}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>


<div class="card mb-4">
    <h6 class="card-header" id="sec15">
        <span class="badge badge-dark">15</span> <i class="fas fz-fw fa-bug text-danger"></i> Compartir en redes en Noticias
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/modules/news/view/new.tpl:87
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a class=&quot;pe-4 pe-lg-5 d-inline-block facebook&quot; href=&quot;https://www.facebook.com/sharer/sharer.php?u=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}&quot; target=&quot;_blank&quot;&gt;
  facebook
&lt;/a&gt;
&lt;a class=&quot;pe-4 pe-lg-5 d-inline-block twitter&quot; href=&quot;https://www.twitter.com/share?url=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}&quot; target=&quot;_blank&quot;&gt;
   twitter
&lt;/a&gt;
&lt;a class=&quot;pe-4 pe-lg-5 d-inline-block linkedin&quot; href=&quot;https://www.linkedin.com/shareArticle?mini=true&amp;url=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}&amp;title=&amp;summary=&amp;source=&quot; target=&quot;_blank&quot;&gt;
   Linkedin
&lt;/a&gt;
&lt;a class=&quot;pe-4 pe-lg-5 d-inline-block pinterest&quot; href=&quot;http://pinterest.com/pin/create/button/?url=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}&quot; target=&quot;_blank&quot;&gt;
  Pinterest
&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;a class=&quot;facebook&quot; href=&quot;https://www.facebook.com/sharer/sharer.php?u=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}&quot; target=&quot;_blank&quot;&gt;
    &lt;i class=&quot;fab fa-facebook-f&quot;&gt;&lt;/i&gt;
&lt;/a&gt;
&lt;a class=&quot;twitter&quot; href=&quot;https://www.twitter.com/share?url=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}&quot; target=&quot;_blank&quot;&gt;
    &lt;i class=&quot;fab fa-x-twitter&quot;&gt;&lt;/i&gt;
&lt;/a&gt;
&lt;a class=&quot;linkedin&quot; href=&quot;https://www.linkedin.com/shareArticle?mini=true&amp;url=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}&amp;title=&amp;summary=&amp;source=&quot; target=&quot;_blank&quot;&gt;
    &lt;i class=&quot;fab fa-linkedin&quot;&gt;&lt;/i&gt;
&lt;/a&gt;
&lt;a  class=&quot;btn-whatsapp-property&quot; href=&quot;https://api.whatsapp.com/send?text=https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}&quot; target=&quot;_blank&quot;&gt;
    &lt;i class=&quot;fab fa-whatsapp&quot;&gt;&lt;/i&gt;
&lt;/a&gt;
&lt;a  class=&quot;telegram&quot; href=&quot;https://telegram.me/share/url?url={$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}&quot; target=&quot;_blank&quot;&gt;
    &lt;i class=&quot;fab fa-telegram-plane&quot;&gt;&lt;/i&gt;
&lt;/a&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>


<div class="card mb-4">
    <h6 class="card-header" id="sec16">
        <span class="badge badge-dark">16</span> <i class="fas fz-fw fa-bug text-danger"></i> Nuevo informe de propietarios
    </h6>
    <div class="card-body">
        Sustituir la carpeta <code>/modules/reporte/</code>
        <pre>
            <code class="makefile">
/modules/reporte/reporte.php
            </code>
        </pre>
        <hr>
        Añañir las traducciones:
        <pre>
            <code class="makefile">
/resources/lang_ca.php

$langStr[&quot;Informe de propiedad&quot;] = &quot;Informe de la propietat&quot;;
$langStr[&quot;Queremos que tengas toda la informaci&oacute;n sobre c&oacute;mo avanza la venta de tu vivienda.&lt;br&gt;&lt;br&gt;En este informe podr&aacute;s ver cu&aacute;ntas personas han visitado tu anuncio, cu&aacute;ntas se han interesado y c&oacute;mo est&aacute; funcionando la promoci&oacute;n.&quot;] = &quot;Volem que tinguis tota la informaci&oacute; sobre com avan&ccedil;a la venda del teu habitatge.&lt;br&gt;&lt;br&gt;En aquest informe podr&agrave;s veure quantes persones han visitat el teu anunci, quantes s&#039;han interessat i com est&agrave; funcionant la promoci&oacute;.&quot;;
$langStr[&quot;Adem&aacute;s, aqu&iacute; puedes ver c&oacute;mo hemos presentado tu casa online&quot;] = &quot;A m&eacute;s, aqu&iacute; pots veure com hem presentat la teva casa en l&iacute;nia&quot;;
$langStr[&quot;&iquest;Quieres cambiar algo del contenido o las fotos? Pincha aqu&iacute;&quot;] = &quot;Vols canviar alguna cosa del contingut o les fotos? Fes clic aqu&iacute;&quot;;
$langStr[&quot;Si tienes alguna duda o comentario, haz clic aqu&iacute; para ponerte en contacto con nosotros&quot;] = &quot;Si tens algun dubte o comentari, fes clic aqu&iacute; per posar-te en contacte amb nosaltres&quot;;
$langStr[&quot;Seguimos trabajando cada d&iacute;a para encontrar al comprador ideal para tu vivienda. Actualmente, la estamos promocionando activamente en nuestra p&aacute;gina web, a trav&eacute;s de nuestra red de contactos, en redes sociales, en campa&ntilde;as de anuncios online, soportes offline y en los principales portales inmobiliarios.&quot;] = &quot;Continuem treballant cada dia per trobar el comprador ideal per al teu habitatge. Actualment, l&#039;estem promocionant activament a la nostra p&agrave;gina web, a trav&eacute;s de la nostra xarxa de contactes, a les xarxes socials, en campanyes d&#039;anuncis en l&iacute;nia, suports fora de l&iacute;nia i als principals portals immobiliaris.&quot;;
$langStr[&quot;Dedicamos todos nuestros recursos para que tu casa encuentre comprador.&quot;] = &quot;Dediquem tots els nostres recursos perqu&egrave; la teva casa trobi comprador.&quot;;
$langStr[&quot;Estos son los datos que tenemos para ponernos en contacto contigo:&quot;] = &quot;Aquests s&oacute;n les dades que tenim per posar-nos en contacte amb tu:&quot;;
$langStr[&quot;Informe de la propiedad&quot;] = &quot;Informe de la propietat&quot;;
$langStr[&quot;D&iacute;as desde la publicaci&oacute;n del anuncio en nuestra web:&quot;] = &quot;Dies des de la publicaci&oacute; de l&#039;anunci a la nostra web:&quot;;
$langStr[&quot;Visualizaciones&quot;] = &quot;Visualitzacions&quot;;
$langStr[&quot;Seguimiento de la propiedad&quot;] = &quot;Seguiment de la propietat&quot;;
$langStr[&quot;Agenda de seguimiento&quot;] = &quot;Agenda de seguiment&quot;;
$langStr[&quot;text_report_1&quot;] = &quot;&#x1f4e9; Hem enviat nombrosos correus electr&ograve;nics a possibles compradors des de la nostra web. En aquest informe nom&eacute;s es mostren els enviaments autom&agrave;tics realitzats des del CRM, per&ograve; n&#039;hi ha molts m&eacute;s.&lt;br&gt;&lt;br&gt;&#x1f4de; A m&eacute;s, contactem amb clients tamb&eacute; per WhatsApp i trucades telef&ograve;niques, accions que no queden reflectides aqu&iacute; per&ograve; que formen part essencial del nostre treball diari.&lt;br&gt;&lt;br&gt;&#x1f4ec; Si desitges m&eacute;s informaci&oacute; sobre aquestes comunicacions, no dubtis en posar-te en contacte amb nosaltres.&quot;;
$langStr[&quot;text_report_2&quot;] = &quot;Estem fent tot el possible per aconseguir la venda de la teva casa: promoci&oacute; en portals, xarxes socials, contactes, anuncis... Tot i aix&iacute;, aspectes com el preu, l&#039;estat de l&#039;habitatge o la demanda a la zona poden influir en el nombre de contactes i en el temps de venda. Si ho consideres, podem revisar junts aquests punts per continuar avan&ccedil;ant amb for&ccedil;a en la venda de la teva casa.&quot;;
$langStr[&quot;text_report_3&quot;] = &quot;Gr&agrave;cies per confiar en nosaltres per gestionar la venda del teu habitatge!&quot;;
$langStr[&quot;Modificado&quot;] = &quot;Modificat&quot;;
$langStr[&quot;Listado&quot;] = &quot;Llistat&quot;;
$langStr[&quot;Consultas&quot;] = &quot;Consultes&quot;;
$langStr[&quot;Impreso&quot;] = &quot;Impr&egrave;s&quot;;

/resources/lang_da.php

$langStr[&quot;Informe de propiedad&quot;] = &quot;Ejendomsrapport&quot;;
$langStr[&quot;Queremos que tengas toda la informaci&oacute;n sobre c&oacute;mo avanza la venta de tu vivienda.&lt;br&gt;&lt;br&gt;En este informe podr&aacute;s ver cu&aacute;ntas personas han visitado tu anuncio, cu&aacute;ntas se han interesado y c&oacute;mo est&aacute; funcionando la promoci&oacute;n.&quot;] = &quot;Vi &oslash;nsker, at du har al information om, hvordan salget af din bolig skrider frem.&lt;br&gt;&lt;br&gt;I denne rapport kan du se, hvor mange personer der har set din annonce, hvor mange der har vist interesse, og hvordan promoveringen fungerer.&quot;;
$langStr[&quot;Adem&aacute;s, aqu&iacute; puedes ver c&oacute;mo hemos presentado tu casa online&quot;] = &quot;Her kan du ogs&aring; se, hvordan vi har pr&aelig;senteret dit hus online&quot;;
$langStr[&quot;&iquest;Quieres cambiar algo del contenido o las fotos? Pincha aqu&iacute;&quot;] = &quot;&Oslash;nsker du at &aelig;ndre noget i indholdet eller billederne? Klik her&quot;;
$langStr[&quot;Si tienes alguna duda o comentario, haz clic aqu&iacute; para ponerte en contacto con nosotros&quot;] = &quot;Hvis du har sp&oslash;rgsm&aring;l eller kommentarer, klik her for at kontakte os&quot;;
$langStr[&quot;Seguimos trabajando cada d&iacute;a para encontrar al comprador ideal para tu vivienda. Actualmente, la estamos promocionando activamente en nuestra p&aacute;gina web, a trav&eacute;s de nuestra red de contactos, en redes sociales, en campa&ntilde;as de anuncios online, soportes offline y en los principales portales inmobiliarios.&quot;] = &quot;Vi arbejder hver dag for at finde den ideelle k&oslash;ber til din bolig. I &oslash;jeblikket promoverer vi den aktivt p&aring; vores hjemmeside, gennem vores netv&aelig;rk, p&aring; sociale medier, i online annoncekampagner, offline medier og p&aring; de st&oslash;rste ejendomsportaler.&quot;;
$langStr[&quot;Dedicamos todos nuestros recursos para que tu casa encuentre comprador.&quot;] = &quot;Vi dedikerer alle vores ressourcer for at sikre, at dit hus finder en k&oslash;ber.&quot;;
$langStr[&quot;Estos son los datos que tenemos para ponernos en contacto contigo:&quot;] = &quot;Her er de oplysninger, vi har for at kontakte dig:&quot;;
$langStr[&quot;Informe de la propiedad&quot;] = &quot;Ejendomsrapport&quot;;
$langStr[&quot;D&iacute;as desde la publicaci&oacute;n del anuncio en nuestra web:&quot;] = &quot;Dage siden annoncen blev offentliggjort p&aring; vores hjemmeside:&quot;;
$langStr[&quot;Visualizaciones&quot;] = &quot;Visninger&quot;;
$langStr[&quot;Seguimiento de la propiedad&quot;] = &quot;Ejendomsopf&oslash;lgning&quot;;
$langStr[&quot;Agenda de seguimiento&quot;] = &quot;Opf&oslash;lgningsplan&quot;;
$langStr[&quot;text_report_1&quot;] = &quot;&#x1f4e9; Vi har sendt adskillige e-mails til potentielle k&oslash;bere fra vores hjemmeside. Denne rapport viser kun de automatiske e-mails sendt fra CRM, men der er mange flere.&lt;br&gt;&lt;br&gt;&#x1f4de; Derudover kontakter vi ogs&aring; kunder via WhatsApp og telefonopkald, handlinger der ikke er afspejlet her, men som er en v&aelig;sentlig del af vores daglige arbejde.&lt;br&gt;&lt;br&gt;&#x1f4ec; Hvis du &oslash;nsker mere information om disse kommunikationer, er du velkommen til at kontakte os.&quot;;
$langStr[&quot;text_report_2&quot;] = &quot;Vi g&oslash;r alt, hvad vi kan for at s&aelig;lge dit hus: promovering p&aring; portaler, sociale medier, kontakter, annoncer... Dog kan faktorer som pris, boligens tilstand eller eftersp&oslash;rgslen i omr&aring;det p&aring;virke antallet af kontakter og salgstiden. Hvis du &oslash;nsker det, kan vi gennemg&aring; disse punkter sammen for at forts&aelig;tte med at fremme salget af dit hus.&quot;;
$langStr[&quot;text_report_3&quot;] = &quot;Tak fordi du har tillid til os til at h&aring;ndtere salget af din bolig!&quot;;
$langStr[&quot;Modificado&quot;] = &quot;&AElig;ndret&quot;;
$langStr[&quot;Listado&quot;] = &quot;Oplistet&quot;;
$langStr[&quot;Consultas&quot;] = &quot;Foresp&oslash;rgsler&quot;;
$langStr[&quot;Impreso&quot;] = &quot;Udskrevet&quot;;

/resources/lang_de.php

$langStr[&quot;Informe de propiedad&quot;] = &quot;Immobilienbericht&quot;;
$langStr[&quot;Queremos que tengas toda la informaci&oacute;n sobre c&oacute;mo avanza la venta de tu vivienda.&lt;br&gt;&lt;br&gt;En este informe podr&aacute;s ver cu&aacute;ntas personas han visitado tu anuncio, cu&aacute;ntas se han interesado y c&oacute;mo est&aacute; funcionando la promoci&oacute;n.&quot;] = &quot;Wir m&ouml;chten, dass Sie alle Informationen dar&uuml;ber haben, wie der Verkauf Ihrer Immobilie voranschreitet.&lt;br&gt;&lt;br&gt;In diesem Bericht k&ouml;nnen Sie sehen, wie viele Personen Ihre Anzeige besucht haben, wie viele Interesse gezeigt haben und wie die Vermarktung funktioniert.&quot;;
$langStr[&quot;Adem&aacute;s, aqu&iacute; puedes ver c&oacute;mo hemos presentado tu casa online&quot;] = &quot;Au&szlig;erdem k&ouml;nnen Sie hier sehen, wie wir Ihr Haus online pr&auml;sentiert haben&quot;;
$langStr[&quot;&iquest;Quieres cambiar algo del contenido o las fotos? Pincha aqu&iacute;&quot;] = &quot;M&ouml;chten Sie etwas am Inhalt oder den Fotos &auml;ndern? Klicken Sie hier&quot;;
$langStr[&quot;Si tienes alguna duda o comentario, haz clic aqu&iacute; para ponerte en contacto con nosotros&quot;] = &quot;Wenn Sie Fragen oder Anmerkungen haben, klicken Sie hier, um mit uns Kontakt aufzunehmen&quot;;
$langStr[&quot;Seguimos trabajando cada d&iacute;a para encontrar al comprador ideal para tu vivienda. Actualmente, la estamos promocionando activamente en nuestra p&aacute;gina web, a trav&eacute;s de nuestra red de contactos, en redes sociales, en campa&ntilde;as de anuncios online, soportes offline y en los principales portales inmobiliarios.&quot;] = &quot;Wir arbeiten jeden Tag daran, den idealen K&auml;ufer f&uuml;r Ihre Immobilie zu finden. Derzeit bewerben wir sie aktiv auf unserer Website, &uuml;ber unser Kontaktnetzwerk, in sozialen Medien, in Online-Werbekampagnen, Offline-Medien und auf den wichtigsten Immobilienportalen.&quot;;
$langStr[&quot;Dedicamos todos nuestros recursos para que tu casa encuentre comprador.&quot;] = &quot;Wir setzen alle unsere Ressourcen ein, damit Ihr Haus einen K&auml;ufer findet.&quot;;
$langStr[&quot;Estos son los datos que tenemos para ponernos en contacto contigo:&quot;] = &quot;Dies sind die Daten, die wir haben, um mit Ihnen in Kontakt zu treten:&quot;;
$langStr[&quot;Informe de la propiedad&quot;] = &quot;Immobilienbericht&quot;;
$langStr[&quot;D&iacute;as desde la publicaci&oacute;n del anuncio en nuestra web:&quot;] = &quot;Tage seit der Ver&ouml;ffentlichung der Anzeige auf unserer Website:&quot;;
$langStr[&quot;Visualizaciones&quot;] = &quot;Aufrufe&quot;;
$langStr[&quot;Seguimiento de la propiedad&quot;] = &quot;Immobilienverfolgung&quot;;
$langStr[&quot;Agenda de seguimiento&quot;] = &quot;Verfolgungsplan&quot;;
$langStr[&quot;text_report_1&quot;] = &quot;&#x1f4e9; Wir haben zahlreiche E-Mails an potenzielle K&auml;ufer von unserer Website gesendet. Dieser Bericht zeigt nur die automatischen E-Mails, die vom CRM gesendet wurden, aber es gibt viele weitere.&lt;br&gt;&lt;br&gt;&#x1f4de; Dar&uuml;ber hinaus kontaktieren wir Kunden auch &uuml;ber WhatsApp und Telefonanrufe, Aktionen, die hier nicht angezeigt werden, aber ein wesentlicher Bestandteil unserer t&auml;glichen Arbeit sind.&lt;br&gt;&lt;br&gt;&#x1f4ec; Wenn Sie weitere Informationen &uuml;ber diese Kommunikationen w&uuml;nschen, z&ouml;gern Sie nicht, uns zu kontaktieren.&quot;;
$langStr[&quot;text_report_2&quot;] = &quot;Wir tun alles, um den Verkauf Ihres Hauses zu erreichen: Werbung auf Portalen, soziale Medien, Kontakte, Anzeigen... Dennoch k&ouml;nnen Aspekte wie der Preis, der Zustand der Immobilie oder die Nachfrage in der Region die Anzahl der Kontakte und die Verkaufszeit beeinflussen. Wenn Sie es w&uuml;nschen, k&ouml;nnen wir diese Punkte gemeinsam &uuml;berpr&uuml;fen, um den Verkauf Ihres Hauses weiterhin energisch voranzutreiben.&quot;;
$langStr[&quot;text_report_3&quot;] = &quot;Vielen Dank, dass Sie uns mit dem Verkauf Ihrer Immobilie betraut haben!&quot;;
$langStr[&quot;Modificado&quot;] = &quot;Ge&auml;ndert&quot;;
$langStr[&quot;Listado&quot;] = &quot;Gelistet&quot;;
$langStr[&quot;Consultas&quot;] = &quot;Anfragen&quot;;
$langStr[&quot;Impreso&quot;] = &quot;Gedruckt&quot;;

/resources/lang_en.php

$langStr[&quot;Informe de propiedad&quot;] = &quot;Property Report&quot;;
$langStr[&quot;Queremos que tengas toda la informaci&oacute;n sobre c&oacute;mo avanza la venta de tu vivienda.&lt;br&gt;&lt;br&gt;En este informe podr&aacute;s ver cu&aacute;ntas personas han visitado tu anuncio, cu&aacute;ntas se han interesado y c&oacute;mo est&aacute; funcionando la promoci&oacute;n.&quot;] = &quot;We want you to have all the information about how the sale of your property is progressing.&lt;br&gt;&lt;br&gt;In this report, you can see how many people have viewed your listing, how many have shown interest, and how the promotion is performing.&quot;;
$langStr[&quot;Adem&aacute;s, aqu&iacute; puedes ver c&oacute;mo hemos presentado tu casa online&quot;] = &quot;Additionally, here you can see how we have presented your house online&quot;;
$langStr[&quot;&iquest;Quieres cambiar algo del contenido o las fotos? Pincha aqu&iacute;&quot;] = &quot;Do you want to change any content or photos? Click here&quot;;
$langStr[&quot;Si tienes alguna duda o comentario, haz clic aqu&iacute; para ponerte en contacto con nosotros&quot;] = &quot;If you have any questions or comments, click here to contact us&quot;;
$langStr[&quot;Seguimos trabajando cada d&iacute;a para encontrar al comprador ideal para tu vivienda. Actualmente, la estamos promocionando activamente en nuestra p&aacute;gina web, a trav&eacute;s de nuestra red de contactos, en redes sociales, en campa&ntilde;as de anuncios online, soportes offline y en los principales portales inmobiliarios.&quot;] = &quot;We continue working every day to find the ideal buyer for your property. Currently, we are actively promoting it on our website, through our network of contacts, on social media, in online advertising campaigns, offline media, and on major real estate portals.&quot;;
$langStr[&quot;Dedicamos todos nuestros recursos para que tu casa encuentre comprador.&quot;] = &quot;We dedicate all our resources to ensure your house finds a buyer.&quot;;
$langStr[&quot;Estos son los datos que tenemos para ponernos en contacto contigo:&quot;] = &quot;These are the contact details we have to reach you:&quot;;
$langStr[&quot;Informe de la propiedad&quot;] = &quot;Property Report&quot;;
$langStr[&quot;D&iacute;as desde la publicaci&oacute;n del anuncio en nuestra web:&quot;] = &quot;Days since the listing was published on our website:&quot;;
$langStr[&quot;Visualizaciones&quot;] = &quot;Views&quot;;
$langStr[&quot;Seguimiento de la propiedad&quot;] = &quot;Property Follow-up&quot;;
$langStr[&quot;Agenda de seguimiento&quot;] = &quot;Follow-up Schedule&quot;;
$langStr[&quot;text_report_1&quot;] = &quot;&#x1f4e9; We have sent numerous emails to potential buyers from our website. This report only shows the automatic emails sent from the CRM, but there are many more.&lt;br&gt;&lt;br&gt;&#x1f4de; Additionally, we contact clients via WhatsApp and phone calls, actions that are not reflected here but are an essential part of our daily work.&lt;br&gt;&lt;br&gt;&#x1f4ec; If you would like more information about these communications, please do not hesitate to contact us.&quot;;
$langStr[&quot;text_report_2&quot;] = &quot;We are doing everything possible to sell your house: promoting it on portals, social media, contacts, advertisements... However, aspects such as the price, the condition of the property, or the demand in the area can influence the number of contacts and the time it takes to sell. If you consider it, we can review these points together to continue progressing strongly in the sale of your house.&quot;;
$langStr[&quot;text_report_3&quot;] = &quot;Thank you for trusting us to manage the sale of your property!&quot;;
$langStr[&quot;Modificado&quot;] = &quot;Modified&quot;;
$langStr[&quot;Listado&quot;] = &quot;Listed&quot;;
$langStr[&quot;Consultas&quot;] = &quot;Enquiries&quot;;
$langStr[&quot;Impreso&quot;] = &quot;Printed&quot;;

/resources/lang_es.php

$langStr[&quot;Informe de propiedad&quot;] = &quot;Informe de propiedad&quot;;
$langStr[&quot;Queremos que tengas toda la informaci&oacute;n sobre c&oacute;mo avanza la venta de tu vivienda.&lt;br&gt;&lt;br&gt;En este informe podr&aacute;s ver cu&aacute;ntas personas han visitado tu anuncio, cu&aacute;ntas se han interesado y c&oacute;mo est&aacute; funcionando la promoci&oacute;n.&quot;] = &quot;Queremos que tengas toda la informaci&oacute;n sobre c&oacute;mo avanza la venta de tu vivienda.&lt;br&gt;&lt;br&gt;En este informe podr&aacute;s ver cu&aacute;ntas personas han visitado tu anuncio, cu&aacute;ntas se han interesado y c&oacute;mo est&aacute; funcionando la promoci&oacute;n.&quot;;
$langStr[&quot;Adem&aacute;s, aqu&iacute; puedes ver c&oacute;mo hemos presentado tu casa online&quot;] = &quot;Adem&aacute;s, aqu&iacute; puedes ver c&oacute;mo hemos presentado tu casa online&quot;;
$langStr[&quot;&iquest;Quieres cambiar algo del contenido o las fotos? Pincha aqu&iacute;&quot;] = &quot;&iquest;Quieres cambiar algo del contenido o las fotos? Pincha aqu&iacute;&quot;;
$langStr[&quot;Si tienes alguna duda o comentario, haz clic aqu&iacute; para ponerte en contacto con nosotros&quot;] = &quot;Si tienes alguna duda o comentario, haz clic aqu&iacute; para ponerte en contacto con nosotros&quot;;
$langStr[&quot;Seguimos trabajando cada d&iacute;a para encontrar al comprador ideal para tu vivienda. Actualmente, la estamos promocionando activamente en nuestra p&aacute;gina web, a trav&eacute;s de nuestra red de contactos, en redes sociales, en campa&ntilde;as de anuncios online, soportes offline y en los principales portales inmobiliarios.&quot;] = &quot;Seguimos trabajando cada d&iacute;a para encontrar al comprador ideal para tu vivienda. Actualmente, la estamos promocionando activamente en nuestra p&aacute;gina web, a trav&eacute;s de nuestra red de contactos, en redes sociales, en campa&ntilde;as de anuncios online, soportes offline y en los principales portales inmobiliarios.&quot;;
$langStr[&quot;Dedicamos todos nuestros recursos para que tu casa encuentre comprador.&quot;] = &quot;Dedicamos todos nuestros recursos para que tu casa encuentre comprador.&quot;;
$langStr[&quot;Estos son los datos que tenemos para ponernos en contacto contigo:&quot;] = &quot;Estos son los datos que tenemos para ponernos en contacto contigo:&quot;;
$langStr[&quot;Informe de la propiedad&quot;] = &quot;Informe de la propiedad&quot;;
$langStr[&quot;D&iacute;as desde la publicaci&oacute;n del anuncio en nuestra web:&quot;] = &quot;D&iacute;as desde la publicaci&oacute;n del anuncio en nuestra web:&quot;;
$langStr[&quot;Visualizaciones&quot;] = &quot;Visualizaciones&quot;;
$langStr[&quot;Seguimiento de la propiedad&quot;] = &quot;Seguimiento de la propiedad&quot;;
$langStr[&quot;Agenda de seguimiento&quot;] = &quot;Agenda de seguimiento&quot;;
$langStr[&quot;text_report_1&quot;] = &quot;&#x1f4e9; Hemos enviado numerosos emails a posibles compradores desde nuestra web. En este informe solo se muestran los env&iacute;os autom&aacute;ticos realizados desde el CRM, pero hay muchos m&aacute;s.&lt;br&gt;&lt;br&gt;&#x1f4de; Adem&aacute;s, contactamos con clientes tambi&eacute;n por WhatsApp y llamadas telef&oacute;nicas, acciones que no quedan reflejadas aqu&iacute; pero que forman parte esencial de nuestro trabajo diario.&lt;br&gt;&lt;br&gt;&#x1f4ec; Si deseas m&aacute;s informaci&oacute;n sobre estas comunicaciones, no dudes en ponerte en contacto con nosotros.&quot;;
$langStr[&quot;text_report_2&quot;] = &quot;Estamos haciendo todo lo posible para lograr la venta de tu casa: promoci&oacute;n en portales, redes sociales, contactos, anuncios&hellip; Aun as&iacute;, aspectos como el precio, el estado de la vivienda o la demanda en la zona pueden influir en el n&uacute;mero de contactos y en el tiempo de venta. Si lo consideras, podemos revisar juntos estos puntos para seguir avanzando con fuerza en la venta de tu casa. &quot;;
$langStr[&quot;text_report_3&quot;] = &quot;&iexcl;&iexcl;Gracias por confiar en nosotros para gestionar la venta de tu vivienda!!&quot;;
$langStr["Modificado"] = "Modificado";
$langStr[&quot;Listado&quot;] = &quot;Listado&quot;;
$langStr[&quot;Consultas&quot;] = &quot;Consultas&quot;;
$langStr[&quot;Impreso&quot;] = &quot;Impreso&quot;;

/resources/lang_fi.php

$langStr[&quot;Informe de propiedad&quot;] = &quot;Kiinteist&ouml;raportti&quot;;
$langStr[&quot;Queremos que tengas toda la informaci&oacute;n sobre c&oacute;mo avanza la venta de tu vivienda.&lt;br&gt;&lt;br&gt;En este informe podr&aacute;s ver cu&aacute;ntas personas han visitado tu anuncio, cu&aacute;ntas se han interesado y c&oacute;mo est&aacute; funcionando la promoci&oacute;n.&quot;] = &quot;Haluamme, ett&auml; sinulla on kaikki tiedot siit&auml;, miten asuntosi myynti etenee.&lt;br&gt;&lt;br&gt;T&auml;ss&auml; raportissa n&auml;et, kuinka moni on katsonut ilmoitustasi, kuinka moni on ollut kiinnostunut ja miten markkinointi toimii.&quot;;
$langStr[&quot;Adem&aacute;s, aqu&iacute; puedes ver c&oacute;mo hemos presentado tu casa online&quot;] = &quot;Lis&auml;ksi n&auml;et t&auml;&auml;lt&auml;, miten olemme esitelleet kotisi verkossa&quot;;
$langStr[&quot;&iquest;Quieres cambiar algo del contenido o las fotos? Pincha aqu&iacute;&quot;] = &quot;Haluatko muuttaa sis&auml;lt&ouml;&auml; tai kuvia? Napsauta t&auml;st&auml;&quot;;
$langStr[&quot;Si tienes alguna duda o comentario, haz clic aqu&iacute; para ponerte en contacto con nosotros&quot;] = &quot;Jos sinulla on kysytt&auml;v&auml;&auml; tai kommentoitavaa, ota meihin yhteytt&auml; napsauttamalla t&auml;st&auml;&quot;;
$langStr[&quot;Seguimos trabajando cada d&iacute;a para encontrar al comprador ideal para tu vivienda. Actualmente, la estamos promocionando activamente en nuestra p&aacute;gina web, a trav&eacute;s de nuestra red de contactos, en redes sociales, en campa&ntilde;as de anuncios online, soportes offline y en los principales portales inmobiliarios.&quot;] = &quot;Teemme t&ouml;it&auml; p&auml;ivitt&auml;in l&ouml;yt&auml;&auml;ksemme ihanteellisen ostajan asunnollesi. T&auml;ll&auml; hetkell&auml; markkinoimme sit&auml; aktiivisesti verkkosivuillamme, kontaktiverkostossamme, sosiaalisessa mediassa, verkko- ja perinteisiss&auml; mainoskampanjoissa sek&auml; t&auml;rkeimmill&auml; asuntopalvelusivustoilla.&quot;;
$langStr[&quot;Dedicamos todos nuestros recursos para que tu casa encuentre comprador.&quot;] = &quot;K&auml;yt&auml;mme kaikki resurssimme, jotta kotisi l&ouml;yt&auml;&auml; ostajan.&quot;;
$langStr[&quot;Estos son los datos que tenemos para ponernos en contacto contigo:&quot;] = &quot;T&auml;ss&auml; ovat yhteystietosi, joita k&auml;yt&auml;mme ottaaksemme sinuun yhteytt&auml;:&quot;;
$langStr[&quot;Informe de la propiedad&quot;] = &quot;Kiinteist&ouml;raportti&quot;;
$langStr[&quot;D&iacute;as desde la publicaci&oacute;n del anuncio en nuestra web:&quot;] = &quot;P&auml;ivi&auml; ilmoituksen julkaisemisesta verkkosivuillamme:&quot;;
$langStr[&quot;Visualizaciones&quot;] = &quot;N&auml;ytt&ouml;kerrat&quot;;
$langStr[&quot;Seguimiento de la propiedad&quot;] = &quot;Kiinteist&ouml;n seuranta&quot;;
$langStr[&quot;Agenda de seguimiento&quot;] = &quot;Seuranta-aikataulu&quot;;
$langStr[&quot;text_report_1&quot;] = &quot;&#x1f4e9; Olemme l&auml;hett&auml;neet useita s&auml;hk&ouml;posteja mahdollisille ostajille verkkosivujemme kautta. T&auml;m&auml; raportti n&auml;ytt&auml;&auml; vain CRM:n kautta l&auml;hetetyt automaattiset viestit, mutta niit&auml; on paljon enemm&auml;n.&lt;br&gt;&lt;br&gt;&#x1f4de; Lis&auml;ksi otamme yhteytt&auml; asiakkaisiin my&ouml;s WhatsAppin ja puhelujen kautta, joita ei n&auml;ytet&auml; t&auml;ss&auml;, mutta jotka ovat t&auml;rke&auml; osa p&auml;ivitt&auml;ist&auml; ty&ouml;t&auml;mme.&lt;br&gt;&lt;br&gt;&#x1f4ec; Jos haluat lis&auml;tietoa viestinn&auml;st&auml;, ota rohkeasti yhteytt&auml;.&quot;;
$langStr[&quot;text_report_2&quot;] = &quot;Teemme kaikkemme myyd&auml;ksemme kotisi: mainonta portaaleissa, sosiaalisessa mediassa, kontakteissa, mainoksissa&hellip; Silti esimerkiksi hinta, asunnon kunto tai alueen kysynt&auml; voivat vaikuttaa kontaktien m&auml;&auml;r&auml;&auml;n ja myyntiaikaan. Halutessasi voimme tarkastella n&auml;it&auml; kohtia yhdess&auml; ja edist&auml;&auml; tehokkaasti myynti&auml;.&quot;;
$langStr[&quot;text_report_3&quot;] = &quot;Kiitos, ett&auml; luotit meihin asuntosi myynniss&auml;!&quot;;
$langStr[&quot;Modificado&quot;] = &quot;Muokattu&quot;;
$langStr[&quot;Listado&quot;] = &quot;Luetteloitu&quot;;
$langStr[&quot;Consultas&quot;] = &quot;Kyselyt&quot;;
$langStr[&quot;Impreso&quot;] = &quot;Tulostettu&quot;;

/resources/lang_fr.php

$langStr[&quot;Informe de propiedad&quot;] = &quot;Rapport de propri&eacute;t&eacute;&quot;;
$langStr[&quot;Queremos que tengas toda la informaci&oacute;n sobre c&oacute;mo avanza la venta de tu vivienda.&lt;br&gt;&lt;br&gt;En este informe podr&aacute;s ver cu&aacute;ntas personas han visitado tu anuncio, cu&aacute;ntas se han interesado y c&oacute;mo est&aacute; funcionando la promoci&oacute;n.&quot;] = &quot;Nous souhaitons que vous disposiez de toutes les informations sur l&#039;avancement de la vente de votre logement.&lt;br&gt;&lt;br&gt;Dans ce rapport, vous pourrez voir combien de personnes ont consult&eacute; votre annonce, combien ont manifest&eacute; de l&#039;int&eacute;r&ecirc;t et comment la promotion fonctionne.&quot;;
$langStr[&quot;Adem&aacute;s, aqu&iacute; puedes ver c&oacute;mo hemos presentado tu casa online&quot;] = &quot;De plus, vous pouvez voir ici comment nous avons pr&eacute;sent&eacute; votre maison en ligne&quot;;
$langStr[&quot;&iquest;Quieres cambiar algo del contenido o las fotos? Pincha aqu&iacute;&quot;] = &quot;Souhaitez-vous modifier le contenu ou les photos ? Cliquez ici&quot;;
$langStr[&quot;Si tienes alguna duda o comentario, haz clic aqu&iacute; para ponerte en contacto con nosotros&quot;] = &quot;Si vous avez des questions ou des commentaires, cliquez ici pour nous contacter&quot;;
$langStr[&quot;Seguimos trabajando cada d&iacute;a para encontrar al comprador ideal para tu vivienda. Actualmente, la estamos promocionando activamente en nuestra p&aacute;gina web, a trav&eacute;s de nuestra red de contactos, en redes sociales, en campa&ntilde;as de anuncios online, soportes offline y en los principales portales inmobiliarios.&quot;] = &quot;Nous continuons &agrave; travailler chaque jour pour trouver l&#039;acheteur id&eacute;al pour votre logement. Actuellement, nous le promouvons activement sur notre site web, via notre r&eacute;seau de contacts, sur les r&eacute;seaux sociaux, dans des campagnes publicitaires en ligne, des supports hors ligne et sur les principaux portails immobiliers.&quot;;
$langStr[&quot;Dedicamos todos nuestros recursos para que tu casa encuentre comprador.&quot;] = &quot;Nous consacrons toutes nos ressources pour que votre maison trouve un acheteur.&quot;;
$langStr[&quot;Estos son los datos que tenemos para ponernos en contacto contigo:&quot;] = &quot;Voici les informations que nous avons pour vous contacter :&quot;;
$langStr[&quot;Informe de la propiedad&quot;] = &quot;Rapport de la propri&eacute;t&eacute;&quot;;
$langStr[&quot;D&iacute;as desde la publicaci&oacute;n del anuncio en nuestra web:&quot;] = &quot;Jours depuis la publication de l&#039;annonce sur notre site web :&quot;;
$langStr[&quot;Visualizaciones&quot;] = &quot;Vues&quot;;
$langStr[&quot;Seguimiento de la propiedad&quot;] = &quot;Suivi de la propri&eacute;t&eacute;&quot;;
$langStr[&quot;Agenda de seguimiento&quot;] = &quot;Agenda de suivi&quot;;
$langStr[&quot;text_report_1&quot;] = &quot;&#x1f4e9; Nous avons envoy&eacute; de nombreux e-mails &agrave; des acheteurs potentiels depuis notre site web. Ce rapport ne montre que les envois automatiques effectu&eacute;s depuis le CRM, mais il y en a beaucoup d&#039;autres.&lt;br&gt;&lt;br&gt;&#x1f4de; De plus, nous contactons &eacute;galement les clients via WhatsApp et par appels t&eacute;l&eacute;phoniques, des actions qui ne sont pas refl&eacute;t&eacute;es ici mais qui font partie int&eacute;grante de notre travail quotidien.&lt;br&gt;&lt;br&gt;&#x1f4ec; Si vous souhaitez plus d&#039;informations sur ces communications, n&#039;h&eacute;sitez pas &agrave; nous contacter.&quot;;
$langStr[&quot;text_report_2&quot;] = &quot;Nous faisons tout notre possible pour vendre votre maison : promotion sur les portails, r&eacute;seaux sociaux, contacts, publicit&eacute;s... Cependant, des aspects tels que le prix, l&#039;&eacute;tat du logement ou la demande dans la zone peuvent influencer le nombre de contacts et le temps de vente. Si vous le souhaitez, nous pouvons revoir ensemble ces points pour continuer &agrave; progresser efficacement dans la vente de votre maison.&quot;;
$langStr[&quot;text_report_3&quot;] = &quot;Merci de nous faire confiance pour g&eacute;rer la vente de votre logement !&quot;;
$langStr[&quot;Modificado&quot;] = &quot;Modifi&eacute;&quot;;
$langStr[&quot;Listado&quot;] = &quot;R&eacute;pertori&eacute;&quot;;
$langStr[&quot;Consultas&quot;] = &quot;Demandes&quot;;
$langStr[&quot;Impreso&quot;] = &quot;Imprim&eacute;&quot;;

/resources/lang_is.php

$langStr[&quot;Informe de propiedad&quot;] = &quot;Eignask&yacute;rsla&quot;;
$langStr[&quot;Queremos que tengas toda la informaci&oacute;n sobre c&oacute;mo avanza la venta de tu vivienda.&lt;br&gt;&lt;br&gt;En este informe podr&aacute;s ver cu&aacute;ntas personas han visitado tu anuncio, cu&aacute;ntas se han interesado y c&oacute;mo est&aacute; funcionando la promoci&oacute;n.&quot;] = &quot;Vi&eth; viljum a&eth; &thorn;&uacute; hafir allar uppl&yacute;singar um hvernig sala eignar &thorn;innar gengur.&lt;br&gt;&lt;br&gt;&Iacute; &thorn;essari sk&yacute;rslu getur&eth;u s&eacute;&eth; hversu margir hafa sko&eth;a&eth; augl&yacute;singuna &thorn;&iacute;na, hversu margir hafa s&yacute;nt &aacute;huga og hvernig kynningin gengur.&quot;;
$langStr[&quot;Adem&aacute;s, aqu&iacute; puedes ver c&oacute;mo hemos presentado tu casa online&quot;] = &quot;H&eacute;r getur &thorn;&uacute; l&iacute;ka s&eacute;&eth; hvernig vi&eth; h&ouml;fum kynnt h&uacute;si&eth; &thorn;itt &aacute; netinu&quot;;
$langStr[&quot;&iquest;Quieres cambiar algo del contenido o las fotos? Pincha aqu&iacute;&quot;] = &quot;Viltu breyta einhverju &iacute; innihaldinu e&eth;a myndunum? Smelltu h&eacute;r&quot;;
$langStr[&quot;Si tienes alguna duda o comentario, haz clic aqu&iacute; para ponerte en contacto con nosotros&quot;] = &quot;Ef &thorn;&uacute; hefur einhverjar spurningar e&eth;a athugasemdir, smelltu h&eacute;r til a&eth; hafa samband vi&eth; okkur&quot;;
$langStr[&quot;Seguimos trabajando cada d&iacute;a para encontrar al comprador ideal para tu vivienda. Actualmente, la estamos promocionando activamente en nuestra p&aacute;gina web, a trav&eacute;s de nuestra red de contactos, en redes sociales, en campa&ntilde;as de anuncios online, soportes offline y en los principales portales inmobiliarios.&quot;] = &quot;Vi&eth; vinnum daglega a&eth; &thorn;v&iacute; a&eth; finna hinn fullkomna kaupanda fyrir eignina &thorn;&iacute;na. N&uacute;na erum vi&eth; a&eth; kynna hana virkt &aacute; vefs&iacute;&eth;u okkar, &iacute; gegnum tengslanet okkar, &aacute; samf&eacute;lagsmi&eth;lum, &iacute; netaugl&yacute;singaherfer&eth;um, prentu&eth;um augl&yacute;singum og &aacute; helstu fasteignavefs&iacute;&eth;um.&quot;;
$langStr[&quot;Dedicamos todos nuestros recursos para que tu casa encuentre comprador.&quot;] = &quot;Vi&eth; leggjum &ouml;ll okkar &uacute;rr&aelig;&eth;i &iacute; a&eth; finna kaupanda fyrir h&uacute;si&eth; &thorn;itt.&quot;;
$langStr[&quot;Estos son los datos que tenemos para ponernos en contacto contigo:&quot;] = &quot;H&eacute;r eru uppl&yacute;singarnar sem vi&eth; h&ouml;fum til a&eth; hafa samband vi&eth; &thorn;ig:&quot;;
$langStr[&quot;Informe de la propiedad&quot;] = &quot;Eignask&yacute;rsla&quot;;
$langStr[&quot;D&iacute;as desde la publicaci&oacute;n del anuncio en nuestra web:&quot;] = &quot;Dagar s&iacute;&eth;an augl&yacute;singin var birt &aacute; vefs&iacute;&eth;unni okkar:&quot;;
$langStr[&quot;Visualizaciones&quot;] = &quot;Sko&eth;anir&quot;;
$langStr[&quot;Seguimiento de la propiedad&quot;] = &quot;Eignareftirlit&quot;;
$langStr[&quot;Agenda de seguimiento&quot;] = &quot;Eftirlits&aacute;&aelig;tlun&quot;;
$langStr[&quot;text_report_1&quot;] = &quot;&#x1f4e9; Vi&eth; h&ouml;fum sent fj&ouml;lm&ouml;rg t&ouml;lvup&oacute;st til hugsanlegra kaupenda fr&aacute; vefs&iacute;&eth;u okkar. &THORN;essi sk&yacute;rsla s&yacute;nir a&eth;eins sj&aacute;lfvirkar sendingar fr&aacute; CRM kerfinu, en &thorn;a&eth; eru margir fleiri.&lt;br&gt;&lt;br&gt;&#x1f4de; Vi&eth; h&ouml;fum einnig samband vi&eth; vi&eth;skiptavini &iacute; gegnum WhatsApp og s&iacute;mt&ouml;l, a&eth;ger&eth;ir sem ekki eru s&yacute;ndar h&eacute;r en eru mikilv&aelig;gur hluti af daglegu starfi okkar.&lt;br&gt;&lt;br&gt;&#x1f4ec; Ef &thorn;&uacute; vilt f&aacute; frekari uppl&yacute;singar um &thorn;essi samskipti, ekki hika vi&eth; a&eth; hafa samband vi&eth; okkur.&quot;;
$langStr[&quot;text_report_2&quot;] = &quot;Vi&eth; gerum allt sem vi&eth; getum til a&eth; selja h&uacute;si&eth; &thorn;itt: kynning &aacute; vefs&iacute;&eth;um, samf&eacute;lagsmi&eth;lum, tengslum, augl&yacute;singum... Hins vegar geta &thorn;&aelig;ttir eins og ver&eth;, &aacute;stand eignarinnar e&eth;a eftirspurn &aacute; sv&aelig;&eth;inu haft &aacute;hrif &aacute; fj&ouml;lda tengili&eth;a og s&ouml;lut&iacute;ma. Ef &thorn;&uacute; vilt, getum vi&eth; fari&eth; yfir &thorn;essa &thorn;&aelig;tti saman til a&eth; halda &aacute;fram me&eth; krafti &iacute; s&ouml;lu h&uacute;ssins &thorn;&iacute;ns.&quot;;
$langStr[&quot;text_report_3&quot;] = &quot;Takk fyrir a&eth; treysta okkur fyrir s&ouml;lu eignarinnar &thorn;innar!&quot;;
$langStr[&quot;Modificado&quot;] = &quot;Breytt&quot;;
$langStr[&quot;Listado&quot;] = &quot;Skr&aacute;&eth;&quot;;
$langStr[&quot;Consultas&quot;] = &quot;Fyrirspurnir&quot;;
$langStr[&quot;Impreso&quot;] = &quot;Prenta&eth;&quot;;

/resources/lang_nl.php

$langStr[&quot;Informe de propiedad&quot;] = &quot;Eigendomrapport&quot;;
$langStr[&quot;Queremos que tengas toda la informaci&oacute;n sobre c&oacute;mo avanza la venta de tu vivienda.&lt;br&gt;&lt;br&gt;En este informe podr&aacute;s ver cu&aacute;ntas personas han visitado tu anuncio, cu&aacute;ntas se han interesado y c&oacute;mo est&aacute; funcionando la promoci&oacute;n.&quot;] = &quot;We willen dat je alle informatie hebt over hoe de verkoop van je woning verloopt.&lt;br&gt;&lt;br&gt;In dit rapport kun je zien hoeveel mensen je advertentie hebben bekeken, hoeveel interesse hebben getoond en hoe de promotie verloopt.&quot;;
$langStr[&quot;Adem&aacute;s, aqu&iacute; puedes ver c&oacute;mo hemos presentado tu casa online&quot;] = &quot;Hier kun je ook zien hoe we je huis online hebben gepresenteerd&quot;;
$langStr[&quot;&iquest;Quieres cambiar algo del contenido o las fotos? Pincha aqu&iacute;&quot;] = &quot;Wil je iets wijzigen in de inhoud of de foto&#039;s? Klik hier&quot;;
$langStr[&quot;Si tienes alguna duda o comentario, haz clic aqu&iacute; para ponerte en contacto con nosotros&quot;] = &quot;Als je vragen of opmerkingen hebt, klik hier om contact met ons op te nemen&quot;;
$langStr[&quot;Seguimos trabajando cada d&iacute;a para encontrar al comprador ideal para tu vivienda. Actualmente, la estamos promocionando activamente en nuestra p&aacute;gina web, a trav&eacute;s de nuestra red de contactos, en redes sociales, en campa&ntilde;as de anuncios online, soportes offline y en los principales portales inmobiliarios.&quot;] = &quot;We blijven elke dag werken om de ideale koper voor je woning te vinden. Momenteel promoten we deze actief op onze website, via ons netwerk, op sociale media, in online advertentiecampagnes, offline media en op de belangrijkste vastgoedportalen.&quot;;
$langStr[&quot;Dedicamos todos nuestros recursos para que tu casa encuentre comprador.&quot;] = &quot;We zetten al onze middelen in om ervoor te zorgen dat je huis een koper vindt.&quot;;
$langStr[&quot;Estos son los datos que tenemos para ponernos en contacto contigo:&quot;] = &quot;Dit zijn de gegevens die we hebben om contact met je op te nemen:&quot;;
$langStr[&quot;Informe de la propiedad&quot;] = &quot;Eigendomrapport&quot;;
$langStr[&quot;D&iacute;as desde la publicaci&oacute;n del anuncio en nuestra web:&quot;] = &quot;Dagen sinds de publicatie van de advertentie op onze website:&quot;;
$langStr[&quot;Visualizaciones&quot;] = &quot;Weergaven&quot;;
$langStr[&quot;Seguimiento de la propiedad&quot;] = &quot;Eigendom opvolging&quot;;
$langStr[&quot;Agenda de seguimiento&quot;] = &quot;Opvolgingsagenda&quot;;
$langStr[&quot;text_report_1&quot;] = &quot;&#x1f4e9; We hebben talloze e-mails gestuurd naar potenti&euml;le kopers via onze website. Dit rapport toont alleen de automatische verzendingen vanuit het CRM, maar er zijn er veel meer.&lt;br&gt;&lt;br&gt;&#x1f4de; Daarnaast nemen we ook contact op met klanten via WhatsApp en telefoongesprekken, acties die hier niet worden weergegeven maar een essentieel onderdeel zijn van ons dagelijkse werk.&lt;br&gt;&lt;br&gt;&#x1f4ec; Als je meer informatie wilt over deze communicatie, aarzel dan niet om contact met ons op te nemen.&quot;;
$langStr[&quot;text_report_2&quot;] = &quot;We doen er alles aan om de verkoop van je huis te realiseren: promotie op portalen, sociale media, contacten, advertenties... Toch kunnen aspecten zoals de prijs, de staat van de woning of de vraag in de regio invloed hebben op het aantal contacten en de verkoopduur. Als je dat wilt, kunnen we deze punten samen bekijken om de verkoop van je huis krachtig voort te zetten.&quot;;
$langStr[&quot;text_report_3&quot;] = &quot;Bedankt dat je ons vertrouwt met de verkoop van je woning!&quot;;
$langStr[&quot;Modificado&quot;] = &quot;Gewijzigd&quot;;
$langStr[&quot;Listado&quot;] = &quot;Gelist&quot;;
$langStr[&quot;Consultas&quot;] = &quot;Aanvragen&quot;;
$langStr[&quot;Impreso&quot;] = &quot;Afgedrukt&quot;;

/resources/lang_no.php

$langStr[&quot;Informe de propiedad&quot;] = &quot;Eiendomsrapport&quot;;
$langStr[&quot;Queremos que tengas toda la informaci&oacute;n sobre c&oacute;mo avanza la venta de tu vivienda.&lt;br&gt;&lt;br&gt;En este informe podr&aacute;s ver cu&aacute;ntas personas han visitado tu anuncio, cu&aacute;ntas se han interesado y c&oacute;mo est&aacute; funcionando la promoci&oacute;n.&quot;] = &quot;Vi &oslash;nsker at du skal ha full oversikt over hvordan salget av boligen din g&aring;r.&lt;br&gt;&lt;br&gt;I denne rapporten kan du se hvor mange som har bes&oslash;kt annonsen din, hvor mange som har vist interesse, og hvordan markedsf&oslash;ringen fungerer.&quot;;
$langStr[&quot;Adem&aacute;s, aqu&iacute; puedes ver c&oacute;mo hemos presentado tu casa online&quot;] = &quot;Her kan du ogs&aring; se hvordan vi har presentert boligen din p&aring; nettet&quot;;
$langStr[&quot;&iquest;Quieres cambiar algo del contenido o las fotos? Pincha aqu&iacute;&quot;] = &quot;Vil du endre noe i innholdet eller bildene? Klikk her&quot;;
$langStr[&quot;Si tienes alguna duda o comentario, haz clic aqu&iacute; para ponerte en contacto con nosotros&quot;] = &quot;Hvis du har sp&oslash;rsm&aring;l eller kommentarer, klikk her for &aring; kontakte oss&quot;;
$langStr[&quot;Seguimos trabajando cada d&iacute;a para encontrar al comprador ideal para tu vivienda. Actualmente, la estamos promocionando activamente en nuestra p&aacute;gina web, a trav&eacute;s de nuestra red de contactos, en redes sociales, en campa&ntilde;as de anuncios online, soportes offline y en los principales portales inmobiliarios.&quot;] = &quot;Vi jobber hver dag for &aring; finne den ideelle kj&oslash;peren til boligen din. For tiden markedsf&oslash;rer vi den aktivt p&aring; nettsiden v&aring;r, via kontaktnettverket v&aring;rt, i sosiale medier, i nettannonser, p&aring; trykte flater og p&aring; de st&oslash;rste eiendomsportalene.&quot;;
$langStr[&quot;Dedicamos todos nuestros recursos para que tu casa encuentre comprador.&quot;] = &quot;Vi setter inn alle v&aring;re ressurser for &aring; finne en kj&oslash;per til boligen din.&quot;;
$langStr[&quot;Estos son los datos que tenemos para ponernos en contacto contigo:&quot;] = &quot;Dette er kontaktinformasjonen vi har for &aring; komme i kontakt med deg:&quot;;
$langStr[&quot;Informe de la propiedad&quot;] = &quot;Rapport for eiendommen&quot;;
$langStr[&quot;D&iacute;as desde la publicaci&oacute;n del anuncio en nuestra web:&quot;] = &quot;Dager siden annonsen ble publisert p&aring; nettstedet v&aring;rt:&quot;;
$langStr[&quot;Visualizaciones&quot;] = &quot;Visninger&quot;;
$langStr[&quot;Seguimiento de la propiedad&quot;] = &quot;Oppf&oslash;lging av eiendommen&quot;;
$langStr[&quot;Agenda de seguimiento&quot;] = &quot;Oppf&oslash;lgingsplan&quot;;
$langStr[&quot;text_report_1&quot;] = &quot;&#x1f4e9; Vi har sendt en rekke e-poster til potensielle kj&oslash;pere via nettsiden v&aring;r. Denne rapporten viser bare de automatiske utsendelsene fra CRM-systemet, men det finnes mange flere.&lt;br&gt;&lt;br&gt;&#x1f4de; I tillegg tar vi kontakt med kunder via WhatsApp og telefonsamtaler &ndash; handlinger som ikke vises her, men som er en viktig del av v&aring;rt daglige arbeid.&lt;br&gt;&lt;br&gt;&#x1f4ec; Hvis du &oslash;nsker mer informasjon om disse kommunikasjonene, ikke n&oslash;l med &aring; ta kontakt med oss.&quot;;
$langStr[&quot;text_report_2&quot;] = &quot;Vi gj&oslash;r alt vi kan for &aring; selge boligen din: markedsf&oslash;ring p&aring; portaler, sosiale medier, nettverk, annonser... Likevel kan faktorer som pris, boligens tilstand eller ettersp&oslash;rselen i omr&aring;det p&aring;virke antall henvendelser og hvor lang tid det tar &aring; selge. Hvis du &oslash;nsker det, kan vi gjennomg&aring; disse punktene sammen og fortsette salgsprosessen med ny styrke.&quot;;
$langStr[&quot;text_report_3&quot;] = &quot;Takk for at du stoler p&aring; oss med salget av boligen din!&quot;;
$langStr[&quot;Modificado&quot;] = &quot;Endret&quot;;
$langStr[&quot;Listado&quot;] = &quot;Oppf&oslash;rt&quot;;
$langStr[&quot;Consultas&quot;] = &quot;Henvendelser&quot;;
$langStr[&quot;Impreso&quot;] = &quot;Skrevet ut&quot;;

/resources/lang_pl.php

$langStr[&quot;Informe de propiedad&quot;] = &quot;Raport nieruchomo&#x15b;ci&quot;;
$langStr[&quot;Queremos que tengas toda la informaci&oacute;n sobre c&oacute;mo avanza la venta de tu vivienda.&lt;br&gt;&lt;br&gt;En este informe podr&aacute;s ver cu&aacute;ntas personas han visitado tu anuncio, cu&aacute;ntas se han interesado y c&oacute;mo est&aacute; funcionando la promoci&oacute;n.&quot;] = &quot;Chcemy, aby&#x15b; mia&#x142; pe&#x142;ne informacje o post&#x119;pach w sprzeda&#x17c;y Twojego mieszkania.&lt;br&gt;&lt;br&gt;W tym raporcie mo&#x17c;esz zobaczy&#x107;, ile os&oacute;b odwiedzi&#x142;o Twoje og&#x142;oszenie, ile wyrazi&#x142;o zainteresowanie i jak przebiega promocja.&quot;;
$langStr[&quot;Adem&aacute;s, aqu&iacute; puedes ver c&oacute;mo hemos presentado tu casa online&quot;] = &quot;Tutaj mo&#x17c;esz r&oacute;wnie&#x17c; zobaczy&#x107;, jak zaprezentowali&#x15b;my Tw&oacute;j dom online&quot;;
$langStr[&quot;&iquest;Quieres cambiar algo del contenido o las fotos? Pincha aqu&iacute;&quot;] = &quot;Chcesz zmieni&#x107; co&#x15b; w tre&#x15b;ci lub zdj&#x119;ciach? Kliknij tutaj&quot;;
$langStr[&quot;Si tienes alguna duda o comentario, haz clic aqu&iacute; para ponerte en contacto con nosotros&quot;] = &quot;Je&#x15b;li masz jakiekolwiek pytania lub uwagi, kliknij tutaj, aby si&#x119; z nami skontaktowa&#x107;&quot;;
$langStr[&quot;Seguimos trabajando cada d&iacute;a para encontrar al comprador ideal para tu vivienda. Actualmente, la estamos promocionando activamente en nuestra p&aacute;gina web, a trav&eacute;s de nuestra red de contactos, en redes sociales, en campa&ntilde;as de anuncios online, soportes offline y en los principales portales inmobiliarios.&quot;] = &quot;Codziennie pracujemy nad znalezieniem idealnego kupca dla Twojego mieszkania. Obecnie aktywnie promujemy je na naszej stronie internetowej, poprzez nasz&#x105; sie&#x107; kontakt&oacute;w, w mediach spo&#x142;eczno&#x15b;ciowych, w kampaniach reklamowych online, w materia&#x142;ach offline i na g&#x142;&oacute;wnych portalach nieruchomo&#x15b;ci.&quot;;
$langStr[&quot;Dedicamos todos nuestros recursos para que tu casa encuentre comprador.&quot;] = &quot;Po&#x15b;wi&#x119;camy wszystkie nasze zasoby, aby Twoje mieszkanie znalaz&#x142;o nabywc&#x119;.&quot;;
$langStr[&quot;Estos son los datos que tenemos para ponernos en contacto contigo:&quot;] = &quot;Oto dane, kt&oacute;re posiadamy, aby si&#x119; z Tob&#x105; skontaktowa&#x107;:&quot;;
$langStr[&quot;Informe de la propiedad&quot;] = &quot;Raport nieruchomo&#x15b;ci&quot;;
$langStr[&quot;D&iacute;as desde la publicaci&oacute;n del anuncio en nuestra web:&quot;] = &quot;Dni od publikacji og&#x142;oszenia na naszej stronie:&quot;;
$langStr[&quot;Visualizaciones&quot;] = &quot;Wy&#x15b;wietlenia&quot;;
$langStr[&quot;Seguimiento de la propiedad&quot;] = &quot;&#x15a;ledzenie nieruchomo&#x15b;ci&quot;;
$langStr[&quot;Agenda de seguimiento&quot;] = &quot;Harmonogram &#x15b;ledzenia&quot;;
$langStr[&quot;text_report_1&quot;] = &quot;&#x1f4e9; Wys&#x142;ali&#x15b;my wiele e-maili do potencjalnych kupc&oacute;w z naszej strony internetowej. Ten raport pokazuje tylko automatyczne wysy&#x142;ki z CRM, ale jest ich znacznie wi&#x119;cej.&lt;br&gt;&lt;br&gt;&#x1f4de; Ponadto kontaktujemy si&#x119; z klientami r&oacute;wnie&#x17c; przez WhatsApp i rozmowy telefoniczne, dzia&#x142;ania te nie s&#x105; tutaj uwzgl&#x119;dnione, ale stanowi&#x105; istotn&#x105; cz&#x119;&#x15b;&#x107; naszej codziennej pracy.&lt;br&gt;&lt;br&gt;&#x1f4ec; Je&#x15b;li chcesz uzyska&#x107; wi&#x119;cej informacji na temat tych komunikat&oacute;w, skontaktuj si&#x119; z nami.&quot;;
$langStr[&quot;text_report_2&quot;] = &quot;Robimy wszystko, co w naszej mocy, aby sprzeda&#x107; Twoje mieszkanie: promocja na portalach, media spo&#x142;eczno&#x15b;ciowe, kontakty, reklamy... Jednak takie czynniki jak cena, stan mieszkania czy popyt w danym rejonie mog&#x105; wp&#x142;ywa&#x107; na liczb&#x119; kontakt&oacute;w i czas sprzeda&#x17c;y. Je&#x15b;li chcesz, mo&#x17c;emy wsp&oacute;lnie przeanalizowa&#x107; te kwestie, aby kontynuowa&#x107; sprzeda&#x17c; z pe&#x142;nym zaanga&#x17c;owaniem.&quot;;
$langStr[&quot;text_report_3&quot;] = &quot;Dzi&#x119;kujemy za zaufanie i powierzenie nam sprzeda&#x17c;y Twojego mieszkania!&quot;;
$langStr[&quot;Modificado&quot;] = &quot;Zmodyfikowano&quot;;
$langStr[&quot;Listado&quot;] = &quot;Wyszczeg&oacute;lnione&quot;;
$langStr[&quot;Consultas&quot;] = &quot;Zapytania&quot;;
$langStr[&quot;Impreso&quot;] = &quot;Wydrukowano&quot;;

/resources/lang_ru.php

$langStr[&quot;Informe de propiedad&quot;] = &quot;&#x41e;&#x442;&#x447;&#x435;&#x442; &#x43e; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x438;&quot;;
$langStr[&quot;Queremos que tengas toda la informaci&oacute;n sobre c&oacute;mo avanza la venta de tu vivienda.&lt;br&gt;&lt;br&gt;En este informe podr&aacute;s ver cu&aacute;ntas personas han visitado tu anuncio, cu&aacute;ntas se han interesado y c&oacute;mo est&aacute; funcionando la promoci&oacute;n.&quot;] = &quot;&#x41c;&#x44b; &#x445;&#x43e;&#x442;&#x438;&#x43c;, &#x447;&#x442;&#x43e;&#x431;&#x44b; &#x443; &#x432;&#x430;&#x441; &#x431;&#x44b;&#x43b;&#x430; &#x432;&#x441;&#x44f; &#x438;&#x43d;&#x444;&#x43e;&#x440;&#x43c;&#x430;&#x446;&#x438;&#x44f; &#x43e; &#x445;&#x43e;&#x434;&#x435; &#x43f;&#x440;&#x43e;&#x434;&#x430;&#x436;&#x438; &#x432;&#x430;&#x448;&#x435;&#x439; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x438;.&lt;br&gt;&lt;br&gt;&#x412; &#x44d;&#x442;&#x43e;&#x43c; &#x43e;&#x442;&#x447;&#x435;&#x442;&#x435; &#x432;&#x44b; &#x441;&#x43c;&#x43e;&#x436;&#x435;&#x442;&#x435; &#x443;&#x432;&#x438;&#x434;&#x435;&#x442;&#x44c;, &#x441;&#x43a;&#x43e;&#x43b;&#x44c;&#x43a;&#x43e; &#x43b;&#x44e;&#x434;&#x435;&#x439; &#x43f;&#x43e;&#x441;&#x435;&#x442;&#x438;&#x43b;&#x43e; &#x432;&#x430;&#x448;&#x435; &#x43e;&#x431;&#x44a;&#x44f;&#x432;&#x43b;&#x435;&#x43d;&#x438;&#x435;, &#x441;&#x43a;&#x43e;&#x43b;&#x44c;&#x43a;&#x43e; &#x438;&#x437; &#x43d;&#x438;&#x445; &#x437;&#x430;&#x438;&#x43d;&#x442;&#x435;&#x440;&#x435;&#x441;&#x43e;&#x432;&#x430;&#x43b;&#x438;&#x441;&#x44c; &#x438; &#x43a;&#x430;&#x43a; &#x43f;&#x440;&#x43e;&#x445;&#x43e;&#x434;&#x438;&#x442; &#x43f;&#x440;&#x43e;&#x434;&#x432;&#x438;&#x436;&#x435;&#x43d;&#x438;&#x435;.&quot;;
$langStr[&quot;Adem&aacute;s, aqu&iacute; puedes ver c&oacute;mo hemos presentado tu casa online&quot;] = &quot;&#x417;&#x434;&#x435;&#x441;&#x44c; &#x432;&#x44b; &#x442;&#x430;&#x43a;&#x436;&#x435; &#x43c;&#x43e;&#x436;&#x435;&#x442;&#x435; &#x443;&#x432;&#x438;&#x434;&#x435;&#x442;&#x44c;, &#x43a;&#x430;&#x43a; &#x43c;&#x44b; &#x43f;&#x440;&#x435;&#x434;&#x441;&#x442;&#x430;&#x432;&#x438;&#x43b;&#x438; &#x432;&#x430;&#x448; &#x434;&#x43e;&#x43c; &#x432; &#x438;&#x43d;&#x442;&#x435;&#x440;&#x43d;&#x435;&#x442;&#x435;&quot;;
$langStr[&quot;&iquest;Quieres cambiar algo del contenido o las fotos? Pincha aqu&iacute;&quot;] = &quot;&#x425;&#x43e;&#x442;&#x438;&#x442;&#x435; &#x438;&#x437;&#x43c;&#x435;&#x43d;&#x438;&#x442;&#x44c; &#x447;&#x442;&#x43e;-&#x442;&#x43e; &#x432; &#x441;&#x43e;&#x434;&#x435;&#x440;&#x436;&#x430;&#x43d;&#x438;&#x438; &#x438;&#x43b;&#x438; &#x444;&#x43e;&#x442;&#x43e;&#x433;&#x440;&#x430;&#x444;&#x438;&#x44f;&#x445;? &#x41d;&#x430;&#x436;&#x43c;&#x438;&#x442;&#x435; &#x437;&#x434;&#x435;&#x441;&#x44c;&quot;;
$langStr[&quot;Si tienes alguna duda o comentario, haz clic aqu&iacute; para ponerte en contacto con nosotros&quot;] = &quot;&#x415;&#x441;&#x43b;&#x438; &#x443; &#x432;&#x430;&#x441; &#x435;&#x441;&#x442;&#x44c; &#x432;&#x43e;&#x43f;&#x440;&#x43e;&#x441;&#x44b; &#x438;&#x43b;&#x438; &#x43a;&#x43e;&#x43c;&#x43c;&#x435;&#x43d;&#x442;&#x430;&#x440;&#x438;&#x438;, &#x43d;&#x430;&#x436;&#x43c;&#x438;&#x442;&#x435; &#x437;&#x434;&#x435;&#x441;&#x44c;, &#x447;&#x442;&#x43e;&#x431;&#x44b; &#x441;&#x432;&#x44f;&#x437;&#x430;&#x442;&#x44c;&#x441;&#x44f; &#x441; &#x43d;&#x430;&#x43c;&#x438;&quot;;
$langStr[&quot;Seguimos trabajando cada d&iacute;a para encontrar al comprador ideal para tu vivienda. Actualmente, la estamos promocionando activamente en nuestra p&aacute;gina web, a trav&eacute;s de nuestra red de contactos, en redes sociales, en campa&ntilde;as de anuncios online, soportes offline y en los principales portales inmobiliarios.&quot;] = &quot;&#x41c;&#x44b; &#x43f;&#x440;&#x43e;&#x434;&#x43e;&#x43b;&#x436;&#x430;&#x435;&#x43c; &#x435;&#x436;&#x435;&#x434;&#x43d;&#x435;&#x432;&#x43d;&#x43e; &#x440;&#x430;&#x431;&#x43e;&#x442;&#x430;&#x442;&#x44c;, &#x447;&#x442;&#x43e;&#x431;&#x44b; &#x43d;&#x430;&#x439;&#x442;&#x438; &#x438;&#x434;&#x435;&#x430;&#x43b;&#x44c;&#x43d;&#x43e;&#x433;&#x43e; &#x43f;&#x43e;&#x43a;&#x443;&#x43f;&#x430;&#x442;&#x435;&#x43b;&#x44f; &#x434;&#x43b;&#x44f; &#x432;&#x430;&#x448;&#x435;&#x439; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x438;. &#x412; &#x43d;&#x430;&#x441;&#x442;&#x43e;&#x44f;&#x449;&#x435;&#x435; &#x432;&#x440;&#x435;&#x43c;&#x44f; &#x43c;&#x44b; &#x430;&#x43a;&#x442;&#x438;&#x432;&#x43d;&#x43e; &#x43f;&#x440;&#x43e;&#x434;&#x432;&#x438;&#x433;&#x430;&#x435;&#x43c; &#x435;&#x435; &#x43d;&#x430; &#x43d;&#x430;&#x448;&#x435;&#x43c; &#x441;&#x430;&#x439;&#x442;&#x435;, &#x447;&#x435;&#x440;&#x435;&#x437; &#x43d;&#x430;&#x448;&#x443; &#x441;&#x435;&#x442;&#x44c; &#x43a;&#x43e;&#x43d;&#x442;&#x430;&#x43a;&#x442;&#x43e;&#x432;, &#x432; &#x441;&#x43e;&#x446;&#x438;&#x430;&#x43b;&#x44c;&#x43d;&#x44b;&#x445; &#x441;&#x435;&#x442;&#x44f;&#x445;, &#x432; &#x43e;&#x43d;&#x43b;&#x430;&#x439;&#x43d;-&#x440;&#x435;&#x43a;&#x43b;&#x430;&#x43c;&#x43d;&#x44b;&#x445; &#x43a;&#x430;&#x43c;&#x43f;&#x430;&#x43d;&#x438;&#x44f;&#x445;, &#x43e;&#x444;&#x43b;&#x430;&#x439;&#x43d;-&#x43c;&#x430;&#x442;&#x435;&#x440;&#x438;&#x430;&#x43b;&#x430;&#x445; &#x438; &#x43d;&#x430; &#x43e;&#x441;&#x43d;&#x43e;&#x432;&#x43d;&#x44b;&#x445; &#x43f;&#x43e;&#x440;&#x442;&#x430;&#x43b;&#x430;&#x445; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x438;.&quot;;
$langStr[&quot;Dedicamos todos nuestros recursos para que tu casa encuentre comprador.&quot;] = &quot;&#x41c;&#x44b; &#x438;&#x441;&#x43f;&#x43e;&#x43b;&#x44c;&#x437;&#x443;&#x435;&#x43c; &#x432;&#x441;&#x435; &#x43d;&#x430;&#x448;&#x438; &#x440;&#x435;&#x441;&#x443;&#x440;&#x441;&#x44b;, &#x447;&#x442;&#x43e;&#x431;&#x44b; &#x432;&#x430;&#x448; &#x434;&#x43e;&#x43c; &#x43d;&#x430;&#x448;&#x435;&#x43b; &#x43f;&#x43e;&#x43a;&#x443;&#x43f;&#x430;&#x442;&#x435;&#x43b;&#x44f;.&quot;;
$langStr[&quot;Estos son los datos que tenemos para ponernos en contacto contigo:&quot;] = &quot;&#x412;&#x43e;&#x442; &#x434;&#x430;&#x43d;&#x43d;&#x44b;&#x435;, &#x43a;&#x43e;&#x442;&#x43e;&#x440;&#x44b;&#x435; &#x443; &#x43d;&#x430;&#x441; &#x435;&#x441;&#x442;&#x44c;, &#x447;&#x442;&#x43e;&#x431;&#x44b; &#x441;&#x432;&#x44f;&#x437;&#x430;&#x442;&#x44c;&#x441;&#x44f; &#x441; &#x432;&#x430;&#x43c;&#x438;:&quot;;
$langStr[&quot;Informe de la propiedad&quot;] = &quot;&#x41e;&#x442;&#x447;&#x435;&#x442; &#x43e; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x438;&quot;;
$langStr[&quot;D&iacute;as desde la publicaci&oacute;n del anuncio en nuestra web:&quot;] = &quot;&#x414;&#x43d;&#x435;&#x439; &#x441; &#x43c;&#x43e;&#x43c;&#x435;&#x43d;&#x442;&#x430; &#x43f;&#x443;&#x431;&#x43b;&#x438;&#x43a;&#x430;&#x446;&#x438;&#x438; &#x43e;&#x431;&#x44a;&#x44f;&#x432;&#x43b;&#x435;&#x43d;&#x438;&#x44f; &#x43d;&#x430; &#x43d;&#x430;&#x448;&#x435;&#x43c; &#x441;&#x430;&#x439;&#x442;&#x435;:&quot;;
$langStr[&quot;Visualizaciones&quot;] = &quot;&#x41f;&#x440;&#x43e;&#x441;&#x43c;&#x43e;&#x442;&#x440;&#x44b;&quot;;
$langStr[&quot;Seguimiento de la propiedad&quot;] = &quot;&#x41e;&#x442;&#x441;&#x43b;&#x435;&#x436;&#x438;&#x432;&#x430;&#x43d;&#x438;&#x435; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x438;&quot;;
$langStr[&quot;Agenda de seguimiento&quot;] = &quot;&#x41f;&#x43b;&#x430;&#x43d; &#x43e;&#x442;&#x441;&#x43b;&#x435;&#x436;&#x438;&#x432;&#x430;&#x43d;&#x438;&#x44f;&quot;;
$langStr[&quot;text_report_1&quot;] = &quot;&#x1f4e9; &#x41c;&#x44b; &#x43e;&#x442;&#x43f;&#x440;&#x430;&#x432;&#x438;&#x43b;&#x438; &#x43c;&#x43d;&#x43e;&#x436;&#x435;&#x441;&#x442;&#x432;&#x43e; &#x44d;&#x43b;&#x435;&#x43a;&#x442;&#x440;&#x43e;&#x43d;&#x43d;&#x44b;&#x445; &#x43f;&#x438;&#x441;&#x435;&#x43c; &#x43f;&#x43e;&#x442;&#x435;&#x43d;&#x446;&#x438;&#x430;&#x43b;&#x44c;&#x43d;&#x44b;&#x43c; &#x43f;&#x43e;&#x43a;&#x443;&#x43f;&#x430;&#x442;&#x435;&#x43b;&#x44f;&#x43c; &#x441; &#x43d;&#x430;&#x448;&#x435;&#x433;&#x43e; &#x441;&#x430;&#x439;&#x442;&#x430;. &#x412; &#x44d;&#x442;&#x43e;&#x43c; &#x43e;&#x442;&#x447;&#x435;&#x442;&#x435; &#x43f;&#x43e;&#x43a;&#x430;&#x437;&#x430;&#x43d;&#x44b; &#x442;&#x43e;&#x43b;&#x44c;&#x43a;&#x43e; &#x430;&#x432;&#x442;&#x43e;&#x43c;&#x430;&#x442;&#x438;&#x447;&#x435;&#x441;&#x43a;&#x438;&#x435; &#x43e;&#x442;&#x43f;&#x440;&#x430;&#x432;&#x43a;&#x438; &#x438;&#x437; CRM, &#x43d;&#x43e; &#x438;&#x445; &#x433;&#x43e;&#x440;&#x430;&#x437;&#x434;&#x43e; &#x431;&#x43e;&#x43b;&#x44c;&#x448;&#x435;.&lt;br&gt;&lt;br&gt;&#x1f4de; &#x41a;&#x440;&#x43e;&#x43c;&#x435; &#x442;&#x43e;&#x433;&#x43e;, &#x43c;&#x44b; &#x441;&#x432;&#x44f;&#x437;&#x44b;&#x432;&#x430;&#x435;&#x43c;&#x441;&#x44f; &#x441; &#x43a;&#x43b;&#x438;&#x435;&#x43d;&#x442;&#x430;&#x43c;&#x438; &#x447;&#x435;&#x440;&#x435;&#x437; WhatsApp &#x438; &#x442;&#x435;&#x43b;&#x435;&#x444;&#x43e;&#x43d;&#x43d;&#x44b;&#x435; &#x437;&#x432;&#x43e;&#x43d;&#x43a;&#x438;, &#x44d;&#x442;&#x438; &#x434;&#x435;&#x439;&#x441;&#x442;&#x432;&#x438;&#x44f; &#x437;&#x434;&#x435;&#x441;&#x44c; &#x43d;&#x435; &#x43e;&#x442;&#x43e;&#x431;&#x440;&#x430;&#x436;&#x430;&#x44e;&#x442;&#x441;&#x44f;, &#x43d;&#x43e; &#x43e;&#x43d;&#x438; &#x44f;&#x432;&#x43b;&#x44f;&#x44e;&#x442;&#x441;&#x44f; &#x432;&#x430;&#x436;&#x43d;&#x43e;&#x439; &#x447;&#x430;&#x441;&#x442;&#x44c;&#x44e; &#x43d;&#x430;&#x448;&#x435;&#x439; &#x435;&#x436;&#x435;&#x434;&#x43d;&#x435;&#x432;&#x43d;&#x43e;&#x439; &#x440;&#x430;&#x431;&#x43e;&#x442;&#x44b;.&lt;br&gt;&lt;br&gt;&#x1f4ec; &#x415;&#x441;&#x43b;&#x438; &#x432;&#x44b; &#x445;&#x43e;&#x442;&#x438;&#x442;&#x435; &#x43f;&#x43e;&#x43b;&#x443;&#x447;&#x438;&#x442;&#x44c; &#x434;&#x43e;&#x43f;&#x43e;&#x43b;&#x43d;&#x438;&#x442;&#x435;&#x43b;&#x44c;&#x43d;&#x443;&#x44e; &#x438;&#x43d;&#x444;&#x43e;&#x440;&#x43c;&#x430;&#x446;&#x438;&#x44e; &#x43e;&#x431; &#x44d;&#x442;&#x438;&#x445; &#x43a;&#x43e;&#x43c;&#x43c;&#x443;&#x43d;&#x438;&#x43a;&#x430;&#x446;&#x438;&#x44f;&#x445;, &#x43d;&#x435; &#x441;&#x442;&#x435;&#x441;&#x43d;&#x44f;&#x439;&#x442;&#x435;&#x441;&#x44c; &#x441;&#x432;&#x44f;&#x437;&#x430;&#x442;&#x44c;&#x441;&#x44f; &#x441; &#x43d;&#x430;&#x43c;&#x438;.&quot;;
$langStr[&quot;text_report_2&quot;] = &quot;&#x41c;&#x44b; &#x434;&#x435;&#x43b;&#x430;&#x435;&#x43c; &#x432;&#x441;&#x435; &#x432;&#x43e;&#x437;&#x43c;&#x43e;&#x436;&#x43d;&#x43e;&#x435;, &#x447;&#x442;&#x43e;&#x431;&#x44b; &#x43f;&#x440;&#x43e;&#x434;&#x430;&#x442;&#x44c; &#x432;&#x430;&#x448; &#x434;&#x43e;&#x43c;: &#x43f;&#x440;&#x43e;&#x434;&#x432;&#x438;&#x436;&#x435;&#x43d;&#x438;&#x435; &#x43d;&#x430; &#x43f;&#x43e;&#x440;&#x442;&#x430;&#x43b;&#x430;&#x445;, &#x432; &#x441;&#x43e;&#x446;&#x438;&#x430;&#x43b;&#x44c;&#x43d;&#x44b;&#x445; &#x441;&#x435;&#x442;&#x44f;&#x445;, &#x447;&#x435;&#x440;&#x435;&#x437; &#x43a;&#x43e;&#x43d;&#x442;&#x430;&#x43a;&#x442;&#x44b;, &#x440;&#x435;&#x43a;&#x43b;&#x430;&#x43c;&#x443;... &#x41e;&#x434;&#x43d;&#x430;&#x43a;&#x43e; &#x442;&#x430;&#x43a;&#x438;&#x435; &#x444;&#x430;&#x43a;&#x442;&#x43e;&#x440;&#x44b;, &#x43a;&#x430;&#x43a; &#x446;&#x435;&#x43d;&#x430;, &#x441;&#x43e;&#x441;&#x442;&#x43e;&#x44f;&#x43d;&#x438;&#x435; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x438; &#x438;&#x43b;&#x438; &#x441;&#x43f;&#x440;&#x43e;&#x441; &#x432; &#x440;&#x430;&#x439;&#x43e;&#x43d;&#x435;, &#x43c;&#x43e;&#x433;&#x443;&#x442; &#x43f;&#x43e;&#x432;&#x43b;&#x438;&#x44f;&#x442;&#x44c; &#x43d;&#x430; &#x43a;&#x43e;&#x43b;&#x438;&#x447;&#x435;&#x441;&#x442;&#x432;&#x43e; &#x43a;&#x43e;&#x43d;&#x442;&#x430;&#x43a;&#x442;&#x43e;&#x432; &#x438; &#x432;&#x440;&#x435;&#x43c;&#x44f; &#x43f;&#x440;&#x43e;&#x434;&#x430;&#x436;&#x438;. &#x415;&#x441;&#x43b;&#x438; &#x432;&#x44b; &#x445;&#x43e;&#x442;&#x438;&#x442;&#x435;, &#x43c;&#x44b; &#x43c;&#x43e;&#x436;&#x435;&#x43c; &#x432;&#x43c;&#x435;&#x441;&#x442;&#x435; &#x43f;&#x435;&#x440;&#x435;&#x441;&#x43c;&#x43e;&#x442;&#x440;&#x435;&#x442;&#x44c; &#x44d;&#x442;&#x438; &#x43c;&#x43e;&#x43c;&#x435;&#x43d;&#x442;&#x44b;, &#x447;&#x442;&#x43e;&#x431;&#x44b; &#x43f;&#x440;&#x43e;&#x434;&#x43e;&#x43b;&#x436;&#x438;&#x442;&#x44c; &#x430;&#x43a;&#x442;&#x438;&#x432;&#x43d;&#x443;&#x44e; &#x43f;&#x440;&#x43e;&#x434;&#x430;&#x436;&#x443; &#x432;&#x430;&#x448;&#x435;&#x433;&#x43e; &#x434;&#x43e;&#x43c;&#x430;.&quot;;
$langStr[&quot;text_report_3&quot;] = &quot;&#x421;&#x43f;&#x430;&#x441;&#x438;&#x431;&#x43e; &#x437;&#x430; &#x434;&#x43e;&#x432;&#x435;&#x440;&#x438;&#x435; &#x432; &#x443;&#x43f;&#x440;&#x430;&#x432;&#x43b;&#x435;&#x43d;&#x438;&#x438; &#x43f;&#x440;&#x43e;&#x434;&#x430;&#x436;&#x435;&#x439; &#x432;&#x430;&#x448;&#x435;&#x439; &#x43d;&#x435;&#x434;&#x432;&#x438;&#x436;&#x438;&#x43c;&#x43e;&#x441;&#x442;&#x438;!&quot;;
$langStr[&quot;Modificado&quot;] = &quot;&#x418;&#x437;&#x43c;&#x435;&#x43d;&#x435;&#x43d;&#x43e;&quot;;
$langStr[&quot;Listado&quot;] = &quot;&#x412; &#x441;&#x43f;&#x438;&#x441;&#x43a;&#x435;&quot;;
$langStr[&quot;Consultas&quot;] = &quot;&#x417;&#x430;&#x43f;&#x440;&#x43e;&#x441;&#x44b;&quot;;
$langStr[&quot;Impreso&quot;] = &quot;&#x420;&#x430;&#x441;&#x43f;&#x435;&#x447;&#x430;&#x442;&#x430;&#x43d;&#x43e;&quot;;

/resources/lang_se.php

$langStr[&quot;Informe de propiedad&quot;] = &quot;Fastighetsrapport&quot;;
$langStr[&quot;Queremos que tengas toda la informaci&oacute;n sobre c&oacute;mo avanza la venta de tu vivienda.&lt;br&gt;&lt;br&gt;En este informe podr&aacute;s ver cu&aacute;ntas personas han visitado tu anuncio, cu&aacute;ntas se han interesado y c&oacute;mo est&aacute; funcionando la promoci&oacute;n.&quot;] = &quot;Vi vill att du ska ha fullst&auml;ndig information om hur f&ouml;rs&auml;ljningen av din bostad fortskrider.&lt;br&gt;&lt;br&gt;I den h&auml;r rapporten kan du se hur m&aring;nga som har bes&ouml;kt din annons, hur m&aring;nga som har visat intresse och hur marknadsf&ouml;ringen fungerar.&quot;;
$langStr[&quot;Adem&aacute;s, aqu&iacute; puedes ver c&oacute;mo hemos presentado tu casa online&quot;] = &quot;H&auml;r kan du ocks&aring; se hur vi har presenterat din bostad online&quot;;
$langStr[&quot;&iquest;Quieres cambiar algo del contenido o las fotos? Pincha aqu&iacute;&quot;] = &quot;Vill du &auml;ndra n&aring;got i inneh&aring;llet eller bilderna? Klicka h&auml;r&quot;;
$langStr[&quot;Si tienes alguna duda o comentario, haz clic aqu&iacute; para ponerte en contacto con nosotros&quot;] = &quot;Om du har n&aring;gra fr&aring;gor eller kommentarer, klicka h&auml;r f&ouml;r att kontakta oss&quot;;
$langStr[&quot;Seguimos trabajando cada d&iacute;a para encontrar al comprador ideal para tu vivienda. Actualmente, la estamos promocionando activamente en nuestra p&aacute;gina web, a trav&eacute;s de nuestra red de contactos, en redes sociales, en campa&ntilde;as de anuncios online, soportes offline y en los principales portales inmobiliarios.&quot;] = &quot;Vi arbetar varje dag f&ouml;r att hitta den idealiska k&ouml;paren till din bostad. Just nu marknadsf&ouml;r vi den aktivt p&aring; v&aring;r webbplats, genom v&aring;rt kontaktn&auml;tverk, i sociala medier, i onlinekampanjer, tryckt material och p&aring; de st&ouml;rsta bostadsportalerna.&quot;;
$langStr[&quot;Dedicamos todos nuestros recursos para que tu casa encuentre comprador.&quot;] = &quot;Vi anv&auml;nder alla v&aring;ra resurser f&ouml;r att hitta en k&ouml;pare till din bostad.&quot;;
$langStr[&quot;Estos son los datos que tenemos para ponernos en contacto contigo:&quot;] = &quot;Detta &auml;r de kontaktuppgifter vi har f&ouml;r att n&aring; dig:&quot;;
$langStr[&quot;Informe de la propiedad&quot;] = &quot;Bostadsrapport&quot;;
$langStr[&quot;D&iacute;as desde la publicaci&oacute;n del anuncio en nuestra web:&quot;] = &quot;Dagar sedan annonsen publicerades p&aring; v&aring;r webbplats:&quot;;
$langStr[&quot;Visualizaciones&quot;] = &quot;Visningar&quot;;
$langStr[&quot;Seguimiento de la propiedad&quot;] = &quot;Uppf&ouml;ljning av bostaden&quot;;
$langStr[&quot;Agenda de seguimiento&quot;] = &quot;Uppf&ouml;ljningsagenda&quot;;
$langStr[&quot;text_report_1&quot;] = &quot;&#x1f4e9; Vi har skickat flera e-postmeddelanden till potentiella k&ouml;pare via v&aring;r webbplats. Den h&auml;r rapporten visar endast automatiska utskick fr&aring;n CRM-systemet, men det finns m&aring;nga fler.&lt;br&gt;&lt;br&gt;&#x1f4de; Dessutom kontaktar vi kunder via WhatsApp och telefonsamtal &ndash; &aring;tg&auml;rder som inte visas h&auml;r, men som &auml;r en viktig del av v&aring;rt dagliga arbete.&lt;br&gt;&lt;br&gt;&#x1f4ec; Om du vill ha mer information om dessa kontakter, tveka inte att h&ouml;ra av dig till oss.&quot;;
$langStr[&quot;text_report_2&quot;] = &quot;Vi g&ouml;r allt vi kan f&ouml;r att s&auml;lja din bostad: marknadsf&ouml;ring via portaler, sociala medier, n&auml;tverk, annonser... &Auml;nd&aring; kan faktorer som pris, bostadens skick eller efterfr&aring;gan i omr&aring;det p&aring;verka antalet f&ouml;rfr&aring;gningar och hur l&aring;ng tid det tar att s&auml;lja. Om du vill kan vi g&aring; igenom dessa punkter tillsammans och forts&auml;tta f&ouml;rs&auml;ljningsprocessen med ny energi.&quot;;
$langStr[&quot;text_report_3&quot;] = &quot;Tack f&ouml;r att du har valt oss f&ouml;r att s&auml;lja din bostad!&quot;;
$langStr[&quot;Modificado&quot;] = &quot;&Auml;ndrad&quot;;
$langStr[&quot;Listado&quot;] = &quot;Listad&quot;;
$langStr[&quot;Consultas&quot;] = &quot;F&ouml;rfr&aring;gningar&quot;;
$langStr[&quot;Impreso&quot;] = &quot;Utskriven&quot;;

/resources/lang_zh.php

$langStr[&quot;Informe de propiedad&quot;] = &quot;&#x623f;&#x4ea7;&#x62a5;&#x544a;&quot;;
$langStr[&quot;Queremos que tengas toda la informaci&oacute;n sobre c&oacute;mo avanza la venta de tu vivienda.&lt;br&gt;&lt;br&gt;En este informe podr&aacute;s ver cu&aacute;ntas personas han visitado tu anuncio, cu&aacute;ntas se han interesado y c&oacute;mo est&aacute; funcionando la promoci&oacute;n.&quot;] = &quot;&#x6211;&#x4eec;&#x5e0c;&#x671b;&#x60a8;&#x4e86;&#x89e3;&#x623f;&#x4ea7;&#x9500;&#x552e;&#x7684;&#x5168;&#x90e8;&#x8fdb;&#x5c55;&#x60c5;&#x51b5;&#x3002;&lt;br&gt;&lt;br&gt;&#x5728;&#x672c;&#x62a5;&#x544a;&#x4e2d;&#xff0c;&#x60a8;&#x53ef;&#x4ee5;&#x770b;&#x5230;&#x6709;&#x591a;&#x5c11;&#x4eba;&#x67e5;&#x770b;&#x4e86;&#x60a8;&#x7684;&#x5e7f;&#x544a;&#xff0c;&#x6709;&#x591a;&#x5c11;&#x4eba;&#x611f;&#x5174;&#x8da3;&#xff0c;&#x4ee5;&#x53ca;&#x63a8;&#x5e7f;&#x7684;&#x6548;&#x679c;&#x5982;&#x4f55;&#x3002;&quot;;
$langStr[&quot;Adem&aacute;s, aqu&iacute; puedes ver c&oacute;mo hemos presentado tu casa online&quot;] = &quot;&#x6b64;&#x5916;&#xff0c;&#x60a8;&#x8fd8;&#x53ef;&#x4ee5;&#x5728;&#x6b64;&#x67e5;&#x770b;&#x6211;&#x4eec;&#x662f;&#x5982;&#x4f55;&#x5728;&#x7f51;&#x4e0a;&#x5c55;&#x793a;&#x60a8;&#x7684;&#x623f;&#x4ea7;&#x7684;&quot;;
$langStr[&quot;&iquest;Quieres cambiar algo del contenido o las fotos? Pincha aqu&iacute;&quot;] = &quot;&#x60f3;&#x4fee;&#x6539;&#x5185;&#x5bb9;&#x6216;&#x56fe;&#x7247;&#x5417;&#xff1f;&#x70b9;&#x51fb;&#x8fd9;&#x91cc;&quot;;
$langStr[&quot;Si tienes alguna duda o comentario, haz clic aqu&iacute; para ponerte en contacto con nosotros&quot;] = &quot;&#x5982;&#x6709;&#x4efb;&#x4f55;&#x7591;&#x95ee;&#x6216;&#x610f;&#x89c1;&#xff0c;&#x8bf7;&#x70b9;&#x51fb;&#x8fd9;&#x91cc;&#x4e0e;&#x6211;&#x4eec;&#x8054;&#x7cfb;&quot;;
$langStr[&quot;Seguimos trabajando cada d&iacute;a para encontrar al comprador ideal para tu vivienda. Actualmente, la estamos promocionando activamente en nuestra p&aacute;gina web, a trav&eacute;s de nuestra red de contactos, en redes sociales, en campa&ntilde;as de anuncios online, soportes offline y en los principales portales inmobiliarios.&quot;] = &quot;&#x6211;&#x4eec;&#x6bcf;&#x5929;&#x90fd;&#x5728;&#x52aa;&#x529b;&#x4e3a;&#x60a8;&#x7684;&#x623f;&#x4ea7;&#x5bfb;&#x627e;&#x7406;&#x60f3;&#x4e70;&#x5bb6;&#x3002;&#x76ee;&#x524d;&#x6211;&#x4eec;&#x6b63;&#x901a;&#x8fc7;&#x5b98;&#x7f51;&#x3001;&#x8054;&#x7cfb;&#x4eba;&#x7f51;&#x7edc;&#x3001;&#x793e;&#x4ea4;&#x5a92;&#x4f53;&#x3001;&#x7ebf;&#x4e0a;&#x5e7f;&#x544a;&#x3001;&#x7ebf;&#x4e0b;&#x6e20;&#x9053;&#x53ca;&#x4e3b;&#x6d41;&#x623f;&#x5730;&#x4ea7;&#x95e8;&#x6237;&#x7f51;&#x7ad9;&#x79ef;&#x6781;&#x63a8;&#x5e7f;&#x60a8;&#x7684;&#x623f;&#x4ea7;&#x3002;&quot;;
$langStr[&quot;Dedicamos todos nuestros recursos para que tu casa encuentre comprador.&quot;] = &quot;&#x6211;&#x4eec;&#x4f1a;&#x52a8;&#x7528;&#x6240;&#x6709;&#x8d44;&#x6e90;&#x5e2e;&#x52a9;&#x60a8;&#x7684;&#x623f;&#x4ea7;&#x627e;&#x5230;&#x4e70;&#x5bb6;&#x3002;&quot;;
$langStr[&quot;Estos son los datos que tenemos para ponernos en contacto contigo:&quot;] = &quot;&#x4ee5;&#x4e0b;&#x662f;&#x6211;&#x4eec;&#x76ee;&#x524d;&#x638c;&#x63e1;&#x7684;&#x60a8;&#x7684;&#x8054;&#x7cfb;&#x65b9;&#x5f0f;&#xff1a;&quot;;
$langStr[&quot;Informe de la propiedad&quot;] = &quot;&#x623f;&#x4ea7;&#x62a5;&#x544a;&quot;;
$langStr[&quot;D&iacute;as desde la publicaci&oacute;n del anuncio en nuestra web:&quot;] = &quot;&#x5e7f;&#x544a;&#x5728;&#x6211;&#x4eec;&#x7f51;&#x7ad9;&#x4e0a;&#x53d1;&#x5e03;&#x7684;&#x5929;&#x6570;&#xff1a;&quot;;
$langStr[&quot;Visualizaciones&quot;] = &quot;&#x6d4f;&#x89c8;&#x6b21;&#x6570;&quot;;
$langStr[&quot;Seguimiento de la propiedad&quot;] = &quot;&#x623f;&#x4ea7;&#x8ddf;&#x8fdb;&quot;;
$langStr[&quot;Agenda de seguimiento&quot;] = &quot;&#x8ddf;&#x8fdb;&#x65e5;&#x7a0b;&quot;;
$langStr[&quot;text_report_1&quot;] = &quot;&#x1f4e9; &#x6211;&#x4eec;&#x5df2;&#x7ecf;&#x901a;&#x8fc7;&#x7f51;&#x7ad9;&#x5411;&#x6f5c;&#x5728;&#x4e70;&#x5bb6;&#x53d1;&#x9001;&#x4e86;&#x5927;&#x91cf;&#x90ae;&#x4ef6;&#x3002;&#x672c;&#x62a5;&#x544a;&#x4ec5;&#x663e;&#x793a;&#x901a;&#x8fc7; CRM &#x7cfb;&#x7edf;&#x81ea;&#x52a8;&#x53d1;&#x9001;&#x7684;&#x90ae;&#x4ef6;&#xff0c;&#x8fd8;&#x6709;&#x8bb8;&#x591a;&#x672a;&#x5217;&#x51fa;&#x3002;&lt;br&gt;&lt;br&gt;&#x1f4de; &#x6b64;&#x5916;&#xff0c;&#x6211;&#x4eec;&#x8fd8;&#x901a;&#x8fc7; WhatsApp &#x548c;&#x7535;&#x8bdd;&#x8054;&#x7cfb;&#x5ba2;&#x6237;&#xff0c;&#x8fd9;&#x4e9b;&#x64cd;&#x4f5c;&#x867d;&#x672a;&#x8bb0;&#x5f55;&#x5728;&#x672c;&#x62a5;&#x544a;&#x4e2d;&#xff0c;&#x4f46;&#x5374;&#x662f;&#x6211;&#x4eec;&#x65e5;&#x5e38;&#x5de5;&#x4f5c;&#x7684;&#x91cd;&#x8981;&#x7ec4;&#x6210;&#x90e8;&#x5206;&#x3002;&lt;br&gt;&lt;br&gt;&#x1f4ec; &#x5982;&#x9700;&#x4e86;&#x89e3;&#x66f4;&#x591a;&#x4fe1;&#x606f;&#xff0c;&#x8bf7;&#x968f;&#x65f6;&#x4e0e;&#x6211;&#x4eec;&#x8054;&#x7cfb;&#x3002;&quot;;
$langStr[&quot;text_report_2&quot;] = &quot;&#x6211;&#x4eec;&#x6b63;&#x5728;&#x5c3d;&#x6700;&#x5927;&#x52aa;&#x529b;&#x4fc3;&#x6210;&#x60a8;&#x7684;&#x623f;&#x4ea7;&#x51fa;&#x552e;&#xff1a;&#x95e8;&#x6237;&#x7f51;&#x7ad9;&#x3001;&#x793e;&#x4ea4;&#x7f51;&#x7edc;&#x3001;&#x8054;&#x7cfb;&#x4eba;&#x3001;&#x5e7f;&#x544a;&#x63a8;&#x5e7f;&hellip;&hellip;&#x5f53;&#x7136;&#xff0c;&#x623f;&#x4ef7;&#x3001;&#x623f;&#x5c4b;&#x72b6;&#x51b5;&#x53ca;&#x5f53;&#x5730;&#x5e02;&#x573a;&#x9700;&#x6c42;&#x7b49;&#x56e0;&#x7d20;&#x4e5f;&#x4f1a;&#x5f71;&#x54cd;&#x54a8;&#x8be2;&#x91cf;&#x548c;&#x9500;&#x552e;&#x5468;&#x671f;&#x3002;&#x5982;&#x60a8;&#x613f;&#x610f;&#xff0c;&#x6211;&#x4eec;&#x53ef;&#x4ee5;&#x4e00;&#x8d77;&#x8bc4;&#x4f30;&#x8fd9;&#x4e9b;&#x65b9;&#x9762;&#xff0c;&#x4ee5;&#x4fbf;&#x66f4;&#x6709;&#x529b;&#x5730;&#x63a8;&#x52a8;&#x9500;&#x552e;&#x8fdb;&#x7a0b;&#x3002;&quot;;
$langStr[&quot;text_report_3&quot;] = &quot;&#x611f;&#x8c22;&#x60a8;&#x5bf9;&#x6211;&#x4eec;&#x9500;&#x552e;&#x670d;&#x52a1;&#x7684;&#x4fe1;&#x4efb;&#xff01;&quot;;
$langStr[&quot;Modificado&quot;] = &quot;&#x5df2;&#x4fee;&#x6539;&quot;;
$langStr[&quot;Listado&quot;] = &quot;&#x5df2;&#x5217;&#x51fa;&quot;;
$langStr[&quot;Consultas&quot;] = &quot;&#x54a8;&#x8be2;&quot;;
$langStr[&quot;Impreso&quot;] = &quot;&#x5df2;&#x6253;&#x5370;&quot;;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>


<!-- <div class="card mb-4">
    <h6 class="card-header" id="sec17">
        <span class="badge badge-dark">17</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadido archivo LLMS.txt para las ias
    </h6>
    <div class="card-body">
        Ejecutamos las queries:
        <pre>
            <code class="sql">
ALTER TABLE `news` ADD COLUMN `llms_nws` INT(1) NULL DEFAULT 0 AFTER `quick_costa_nws`;
CREATE TABLE `llms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `llms` (`id`, `name`, `description`) VALUES (1, 'Nombre empresa', 'Descripción de la empresa');

            </code>
        </pre>
        <hr>
        Añadir los archivos:
        <pre>
            <code class="makefile">
/Connections/conf/llms.php
/llms.php
/llms.txt
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/inmoconn.php:72
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/Connections/conf/gdpr.php&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/Connections/conf/gdpr.php&#039;);
require_once($_SERVER[&quot;DOCUMENT_ROOT&quot;] . &#039;/Connections/conf/llms.php&#039;);
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/pages/news-form.php:XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
XXXXXXXXXXXXXXXXXXXXX:XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
XXXXXXXXXXXXXXXXXXXXX:XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
XXXXXXXXXXXXXXXXXXXXX:XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
XXXXXXXXXXXXXXXXXXXXX:XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
XXXXXXXXXXXXXXXXXXXXX:XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/.htaccess:22
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
RewriteRule ^google95b9582a26f99026.html$ google95b9582a26f99026.html [L,QSA]
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
RewriteRule ^google95b9582a26f99026.html$ google95b9582a26f99026.html [L,QSA]
RewriteRule ^llms.txt$ llms.txt [L,QSA]
RewriteRule ^llms.php$ llms.php [L,QSA]
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
XXXXXXXXXXXXXXXXXXXXX:XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
XXXXXXXXXXXXXXXXXXXXX:XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
XXXXXXXXXXXXXXXXXXXXX
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div> -->


<div class="card mb-4">
    <h6 class="card-header" id="sec18">
        <span class="badge badge-dark">18</span> <i class="fas fz-fw fa-bug text-danger"></i> Error master valoraciones
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/properties-client-data-cli.php:673
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
(SELECT rate FROM cli_prop_rate WHERE property = id_prop) AS rate,
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
(SELECT rate FROM cli_prop_rate WHERE property = id_prop AND client = &#039;&quot; . $_GET[&#039;id_cli&#039;] . &quot;&#039;   LIMIT 1) AS rate,
(SELECT id FROM cli_prop_rate WHERE property = id_prop AND client = &#039;&quot; . $_GET[&#039;id_cli&#039;] . &quot;&#039;   LIMIT 1) AS rateid,
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>


<div class="card mb-4">
    <h6 class="card-header" id="sec19">
        <span class="badge badge-dark">19</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo en los 3 modals nuevos de Status, Collaborator y Source compradores
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/clients-form.js:59
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;.add-status&#039;).click(function (e) {
    $(&#039;#myModal5&#039;).modal(&#039;show&#039;).on(&#039;hide.bs.modal&#039;, myHandler999);
});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;.add-status&#039;).click(function (e) {
    $(&#039;#myModal5&#039;).modal(&#039;show&#039;);
});

$(&#039;#myModal5 a.btn-success&#039;).click(function (e) {
    e.preventDefault();
    myHandler999();
});
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/clients-form.js:89
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;.add-captado&#039;).click(function (e) {
    $(&#039;#myModal6&#039;).modal(&#039;show&#039;).on(&#039;hide.bs.modal&#039;, myHandler9996);
});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;.add-captado&#039;).click(function (e) {
    $(&#039;#myModal6&#039;).modal(&#039;show&#039;);
});

$(&#039;#myModal6 a.btn-success&#039;).click(function (e) {
    e.preventDefault();
    myHandler9996();
});
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/clients-form.js:119
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$(&#039;.add-source&#039;).click(function (e) {
    $(&#039;#myModalSource&#039;).modal(&#039;show&#039;).on(&#039;hide.bs.modal&#039;, myHandlerSource);
});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$(&#039;.add-source&#039;).click(function (e) {
    $(&#039;#myModalSource&#039;).modal(&#039;show&#039;);
});

$(&#039;#myModalSource a.btn-success&#039;).click(function (e) {
    e.preventDefault();
    myHandlerSource();
});
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>


<div class="card mb-4">
    <h6 class="card-header" id="sec20">
        <span class="badge badge-dark">20</span> <i class="fas fz-fw fa-bug text-danger"></i> Fallo Sources
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-sources.php:53
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;th id=&quot;actions&quot;&gt;&lt;/th&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if($actFerias == 1) { ?&gt;
&lt;th&gt;&lt;?php __(&#039;Ferias&#039;); ?&gt;&lt;/th&gt;
&lt;?php } ?&gt;
&lt;th id=&quot;actions&quot;&gt;&lt;/th&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-sources.php:60
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;td&gt;&lt;input type=&quot;hidden&quot; name=&quot;active_fair_sts&quot; id=&quot;active_fair_sts&quot;&gt;
    &lt;select name=&quot;active_fair_sts_sel&quot; id=&quot;active_fair_sts_sel&quot; class=&quot;form-select form-select-sm&quot;&gt;
        &lt;option value=&quot;&quot;&gt;&lt;?php __(&#039;Todos&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;&lt;?php __(&#039;S&iacute;&#039;); ?&gt;&quot;&gt;&lt;?php __(&#039;S&iacute;&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;&lt;?php __(&#039;No&#039;); ?&gt;&quot;&gt;&lt;?php __(&#039;No&#039;); ?&gt;&lt;/option&gt;
    &lt;/select&gt;
&lt;/td&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if($actFerias == 1) { ?&gt;
&lt;td&gt;
    &lt;input type=&quot;hidden&quot; name=&quot;active_fair_sts&quot; id=&quot;active_fair_sts&quot;&gt;
    &lt;select name=&quot;active_fair_sts_sel&quot; id=&quot;active_fair_sts_sel&quot; class=&quot;form-select form-select-sm&quot;&gt;
        &lt;option value=&quot;&quot;&gt;&lt;?php __(&#039;Todos&#039;); ?&gt;&lt;/option&gt;
        &lt;option value=&quot;&lt;?php __(&#039;S&iacute;&#039;); ?&gt;&quot;&gt;&lt;?php __(&#039;S&iacute;&#039;); ?&gt;&lt;/option&gt;
         &lt;option value=&quot;&lt;?php __(&#039;No&#039;); ?&gt;&quot;&gt;&lt;?php __(&#039;No&#039;); ?&gt;&lt;/option&gt;
    &lt;/select&gt;
&lt;/td&gt;
 &lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-sources.php:89
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;script src=&quot;_js/clients-sources-list.js?id=&lt;?php echo time(); ?&gt;&quot; type=&quot;text/javascript&quot;&gt;&lt;/script&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;script&gt;
   var totalColumns = &lt;?php echo ($actFerias == 1 ? 3 : 2); ?&gt;;
   var non = &#039;&lt;?php echo $lang[&#039;No&#039;] ?&gt;&#039;;
&lt;/script&gt;

&lt;script src=&quot;_js/clients-sources-list.js?id=&lt;?php echo time(); ?&gt;&quot; type=&quot;text/javascript&quot;&gt;&lt;/script&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-sources-form.php:182
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;hr&gt;

&lt;div class=&quot;form-check form-switch form-switch-lg pt-2&quot; dir=&quot;ltr&quot;&gt;
   &lt;input type=&quot;checkbox&quot; name=&quot;active_fair_sts&quot; id=&quot;active_fair_sts&quot; value=&quot;1&quot; class=&quot;form-check-input&quot; &lt;?php if (!(strcmp( KT_escapeAttribute($row_rsproperties_client_sources[&#039;active_fair_sts&#039;]), &quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt;&gt;
    &lt;label class=&quot;form-check-label&quot; for=&quot;active_fair_sts&quot;&gt;
        &lt;?php __(&#039;Active Fair&#039;); ?&gt;
    &lt;/label&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client_sources&quot;, &quot;active_fair_sts&quot;); ?&gt;
&lt;/div&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php if($actFerias == 1) { ?&gt;
&lt;hr&gt;

&lt;div class=&quot;form-check form-switch form-switch-lg pt-2&quot; dir=&quot;ltr&quot;&gt;
    &lt;input type=&quot;checkbox&quot; name=&quot;active_fair_sts&quot; id=&quot;active_fair_sts&quot; value=&quot;1&quot; class=&quot;form-check-input&quot; &lt;?php if (!(strcmp( KT_escapeAttribute($row_rsproperties_client_sources[&#039;active_fair_sts&#039;]), &quot;1&quot;))) {echo &quot;checked&quot;;} ?&gt;&gt;
    &lt;label class=&quot;form-check-label&quot; for=&quot;active_fair_sts&quot;&gt;
        &lt;?php __(&#039;Active Fair&#039;); ?&gt;
    &lt;/label&gt;
    &lt;?php echo $tNGs-&gt;displayFieldError(&quot;properties_client_sources&quot;, &quot;active_fair_sts&quot;); ?&gt;
&lt;/div&gt;
&lt;?php } ?&gt;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-sources-data.php:38
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$aColumns = array(&#039;category_&#039; . $lang_adm . &#039;_sts&#039;, &#039;active_fair_sts&#039;, &#039;id_sts&#039;);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
if($actFerias == 1) {
  $aColumns = array(&#039;category_&#039; . $lang_adm . &#039;_sts&#039;, &#039;active_fair_sts&#039;, &#039;id_sts&#039;);
} else{
  $aColumns = array(&#039;category_&#039; . $lang_adm . &#039;_sts&#039;, &#039;id_sts&#039;);
}
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients-sources-data.php:211
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$sQuery = &quot;
SELECT SQL_CALC_FOUND_ROWS
 category_&quot; . $lang_adm . &quot;_sts,
 id_sts
FROM   $sTable
$sWhere
$sOrder
$sLimit
&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$sQuery = &quot;
SELECT SQL_CALC_FOUND_ROWS
 category_&quot; . $lang_adm . &quot;_sts,
  case active_fair_sts
    when 1 then &#039;&quot;. __(&#039;S&iacute;&#039;, true) . &quot;&#039;
    when 0 then &#039;&quot; . __(&#039;No&#039;, true) . &quot;&#039;
  end as active_fair_sts,
 id_sts
FROM   $sTable
$sWhere
$sOrder
$sLimit
&quot;;

            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/_js/clients-source-list.js:38
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
oTable = $(&#039;#records-tables&#039;).dataTable({
    &quot;sAjaxSource&quot;: &quot;clients-sources-data.php&quot;,
    &quot;bSortCellsTop&quot;: true,
    &quot;fnInitComplete&quot;: function() {
        var oSettings = $(&#039;#records-tables&#039;).dataTable().fnSettings();
        for ( var i=0 ; i&lt;oSettings.aoPreSearchCols.length ; i++ ){
            if(oSettings.aoPreSearchCols[i].sSearch.length&gt;0){
                $(&quot;thead input&quot;)[i].value = oSettings.aoPreSearchCols[i].sSearch;
            }
        }
        toggleScrollBarIcon();
        if ($(&#039;#active_fair_sts&#039;).val() != &#039;&#039;) {
            $(&#039;#active_fair_sts_sel&#039;).val($(&#039;#active_fair_sts&#039;).val() );
        }
    },
    &quot;aoColumns&quot;: [
        null,
        {
            &quot;bSearchable&quot;: false,
            &quot;bSortable&quot;: false,
            &quot;sClass&quot;: &quot;actions&quot;,
            &quot;render&quot;: function ( data, type, row ) {
                    btns = &#039;&lt;div class=&quot;dropdown d-inline-block w-100&quot;&gt;&#039;;
                        btns += &#039;&lt;button class=&quot;btn btn-soft-primary btn-sm dropdown w-100&quot; type=&quot;button&quot; data-bs-toggle=&quot;dropdown&quot; aria-expanded=&quot;false&quot;&gt;&#039;;
                            btns += &#039;&lt;i class=&quot;fa-regular fa-ellipsis align-middle&quot;&gt;&lt;/i&gt;&#039;;
                        btns += &#039;&lt;/button&gt;&#039;;
                        btns += &#039;&lt;ul class=&quot;dropdown-menu dropdown-menu-end&quot;&gt;&#039;;
                            btns += &#039;&lt;li&gt;&lt;a href=&quot;clients-sources-form.php?id_sts=&#039; + data + &#039;&amp;amp;KT_back=1&quot; class=&quot;dropdown-item edit-item-btn&quot;&gt;&lt;i class=&quot;fa-regular fa-pencil align-bottom me-1&quot;&gt;&lt;/i&gt; &#039; + dtEditar + &#039;&lt;/a&gt;&lt;/li&gt;&#039;;
                            if (canDel == 1) {
                                btns += &#039;&lt;li&gt;&lt;hr class=&quot;dropdown-divider&quot;&gt;&lt;/li&gt;&#039;;
                                btns += &#039;&lt;li&gt;&lt;a href=&quot;clients-sources-form.php?id_sts=&#039; + data + &#039;&amp;amp;KT_back=1&amp;amp;KT_Delete1=1&quot; class=&quot;dropdown-item remove-item-btn text-danger delrow&quot;&gt;&lt;i class=&quot;fa-regular fa-trash-can me-1&quot;&gt;&lt;/i&gt; &#039; + dtEliminar + &#039;&lt;/a&gt;&lt;/li&gt;&#039;;
                            }
                        btns += &#039;&lt;/ul&gt;&#039;;
                    btns += &#039;&lt;/div&gt;&#039;;
                    return  btns;
                }
        }
    ]
});
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var aoCols = [];

aoCols.push(null);

if (totalColumns === 3) {
    aoCols.push({
    &quot;bSearchable&quot;: false,
    &quot;bSortable&quot;: false,
    &quot;sClass&quot;: &quot;text-center&quot;,
    &quot;render&quot;: function ( data, type, row ) {
        if (!data || data.trim() === non.trim()) {
            return &#039;&lt;div class=&quot;mt-1&quot;&gt;&lt;i class=&quot;fa-regular fa-xmark text-danger fs-4 fw-bolder&quot;&gt;&lt;/i&gt;&lt;/div&gt;&#039;;
        } else {
            return &#039;&lt;div class=&quot;mt-1&quot;&gt;&lt;i class=&quot;fa-regular fa-check text-success fs-4 fw-bolder&quot;&gt;&lt;/i&gt;&lt;/div&gt;&#039;;
        }
    }
    });
}

aoCols.push({
    &quot;bSearchable&quot;: false,
    &quot;bSortable&quot;: false,
    &quot;sClass&quot;: &quot;actions&quot;,
    &quot;render&quot;: function ( data, type, row ) {
        btns = &#039;&lt;div class=&quot;dropdown d-inline-block w-100&quot;&gt;&#039;;
            btns += &#039;&lt;button class=&quot;btn btn-soft-primary btn-sm dropdown w-100&quot; type=&quot;button&quot; data-bs-toggle=&quot;dropdown&quot; aria-expanded=&quot;false&quot;&gt;&#039;;
                btns += &#039;&lt;i class=&quot;fa-regular fa-ellipsis align-middle&quot;&gt;&lt;/i&gt;&#039;;
            btns += &#039;&lt;/button&gt;&#039;;
            btns += &#039;&lt;ul class=&quot;dropdown-menu dropdown-menu-end&quot;&gt;&#039;;
                btns += &#039;&lt;li&gt;&lt;a href=&quot;clients-sources-form.php?id_sts=&#039; + data + &#039;&amp;amp;KT_back=1&quot; class=&quot;dropdown-item edit-item-btn&quot;&gt;&lt;i class=&quot;fa-regular fa-pencil align-bottom me-1&quot;&gt;&lt;/i&gt; &#039; + dtEditar + &#039;&lt;/a&gt;&lt;/li&gt;&#039;;
                if (canDel == 1) {
                    btns += &#039;&lt;li&gt;&lt;hr class=&quot;dropdown-divider&quot;&gt;&lt;/li&gt;&#039;;
                    btns += &#039;&lt;li&gt;&lt;a href=&quot;clients-sources-form.php?id_sts=&#039; + data + &#039;&amp;amp;KT_back=1&amp;amp;KT_Delete1=1&quot; class=&quot;dropdown-item remove-item-btn text-danger delrow&quot;&gt;&lt;i class=&quot;fa-regular fa-trash-can me-1&quot;&gt;&lt;/i&gt; &#039; + dtEliminar + &#039;&lt;/a&gt;&lt;/li&gt;&#039;;
                }
            btns += &#039;&lt;/ul&gt;&#039;;
        btns += &#039;&lt;/div&gt;&#039;;
        return  btns;
    }
});

oTable = $(&#039;#records-tables&#039;).dataTable({
    &quot;sAjaxSource&quot;: &quot;clients-sources-data.php&quot;,
    &quot;bSortCellsTop&quot;: true,
    &quot;aoColumns&quot;: aoCols,
    &quot;fnInitComplete&quot;: function() {
        var oSettings = $(&#039;#records-tables&#039;).dataTable().fnSettings();
        for ( var i=0 ; i&lt;oSettings.aoPreSearchCols.length ; i++ ){
            if(oSettings.aoPreSearchCols[i].sSearch.length&gt;0){
                $(&quot;thead input&quot;)[i].value = oSettings.aoPreSearchCols[i].sSearch;
            }
        }
        toggleScrollBarIcon();
        if ($(&#039;#active_fair_sts&#039;).val() != &#039;&#039;) {
            $(&#039;#active_fair_sts_sel&#039;).val($(&#039;#active_fair_sts&#039;).val() );
        }
    }
});
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>


<div class="card mb-4">
    <h6 class="card-header" id="sec21">
        <span class="badge badge-dark">21</span> <i class="fas fz-fw fa-bug text-danger"></i> Error al añadir emojis en las metas de las noticias
    </h6>
    <div class="card-body">
        Sustituir el archivo:
        <pre>
            <code class="makefile">
/templates/plugins/modifier.slug.php
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/modules/init.php:318
            </code>
        </pre>
        Cambiar:
        <pre>
        <code class="php">
    // Make sure string is in UTF-8 and strip invalid UTF-8 characters
$str = mb_convert_encoding((string)$str, &#039;UTF-8&#039;, mb_list_encodings());
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$str = preg_replace(&#039;/[\x{1F600}-\x{1F64F}&#039; . // Emoticons
          &#039;\x{1F300}-\x{1F5FF}&#039; . // Symbols &amp; Pictographs
          &#039;\x{1F680}-\x{1F6FF}&#039; . // Transport &amp; Map
          &#039;\x{2600}-\x{26FF}&#039; .   // Misc symbols
          &#039;\x{2700}-\x{27BF}&#039; .   // Dingbats
          &#039;\x{1F900}-\x{1F9FF}&#039; . // Supplemental Symbols
          &#039;\x{1F1E6}-\x{1F1FF}&#039; . // Flags
          &#039;\x{25B7}]/u&#039;, &#039;&#039;, $str); //  White Right-Pointing Triang
  // Make sure string is in UTF-8 and strip invalid UTF-8 characters
$str = mb_convert_encoding((string)$str, &#039;UTF-8&#039;, mb_list_encodings());
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="sec22">
        <span class="badge badge-dark">22</span> <i class="fas fz-fw fa-bug text-danger"></i> Actualización archivos para inmovilla
    </h6>
    <div class="card-body">
        Ejecutamos la query:
        <pre>
            <code class="makefile">
ALTER TABLE `properties_properties` ADD COLUMN `id_inmovilla_prop` INT(11) NULL DEFAULT NULL ;
            </code>
        </pre>
        <hr>
        Sustituir las carpetas:
        <pre>
            <code class="makefile">
/cliente
/ficha
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/xml/importadores/Inmovilla.php:69
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$query = &quot;INSERT INTO properties_properties SET &quot;;
if ($in_database) {
    $query = &quot;UPDATE properties_properties SET &quot;;
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$query = &quot;INSERT INTO properties_properties SET &quot;;
if ($in_database) {
    $query = &quot;UPDATE properties_properties SET &quot;;
}
$query .= &quot;id_inmovilla_prop = &#039;&quot;.mysqli_real_escape_string($inmoconn,trim((int)$property-&gt;id)).&quot;&#039;, &quot;;
            </code>
        </pre>
        <hr>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
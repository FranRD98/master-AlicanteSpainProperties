<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 25-02-2019</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-plus-circle text-success"></i> Añadido consultas de portales a la administración</a></li>
    </ol>
</div>

<div class="card">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-plus-circle text-success"></i> Añadido consultas de portales a la administración
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/includes/inc.header-admin.php:354
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;a href=&quot;/intramedianet/seguimiento/exported.php&quot; &lt;?php if(preg_match(&apos;/\/exported.php/&apos;, $_SERVER[&apos;PHP_SELF&apos;])){ ?&gt;class=&quot;active&quot;&lt;?php } ?&gt;&gt;
    &lt;span class=&quot;fa-stack fa-lg&quot;&gt;
        &lt;i class=&quot;fa fa-circle fa-stack-2x&quot;&gt;&lt;/i&gt;
        &lt;i class=&quot;fa fa-bar-chart fa-stack-1x fa-inverse stats-down&quot;&gt;&lt;/i&gt;
        &lt;i class=&quot;fa fa-cloud-download fa-stack-1x fa-inverse stats&quot;&gt;&lt;/i&gt;
    &lt;/span&gt;
    &lt;?php __(&apos;Propiedades exportadas&apos;); ?&gt;
&lt;/a&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;a href=&quot;/intramedianet/seguimiento/exported.php&quot; &lt;?php if(preg_match(&apos;/\/exported.php/&apos;, $_SERVER[&apos;PHP_SELF&apos;])){ ?&gt;class=&quot;active&quot;&lt;?php } ?&gt;&gt;
    &lt;span class=&quot;fa-stack fa-lg&quot;&gt;
        &lt;i class=&quot;fa fa-circle fa-stack-2x&quot;&gt;&lt;/i&gt;
        &lt;i class=&quot;fa fa-bar-chart fa-stack-1x fa-inverse stats-down&quot;&gt;&lt;/i&gt;
        &lt;i class=&quot;fa fa-cloud-download fa-stack-1x fa-inverse stats&quot;&gt;&lt;/i&gt;
    &lt;/span&gt;
    &lt;?php __(&apos;Propiedades exportadas&apos;); ?&gt;
&lt;/a&gt;

&lt;?php if ($actPortalsEnquiries == 1): ?&gt;

&lt;div class=&quot;hor-divider&quot;&gt;&lt;/div&gt;

&lt;a href=&quot;/intramedianet/email/email.php&quot; &lt;?php if(preg_match(&apos;/\/email/&apos;, $_SERVER[&apos;PHP_SELF&apos;])){ ?&gt;class=&quot;active&quot;&lt;?php } ?&gt;&gt;
    &lt;span class=&quot;fa-stack fa-lg&quot;&gt;
        &lt;i class=&quot;fa fa-circle fa-stack-2x&quot;&gt;&lt;/i&gt;
        &lt;i class=&quot;fa fa-envelope fa-stack-1x fa-inverse&quot;&gt;&lt;/i&gt;
    &lt;/span&gt;
    &lt;?php __(&apos;Portales&apos;); ?&gt;
&lt;/a&gt;

&lt;?php endif ?&gt;
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
$lang[&apos;Seleccione una carpeta&apos;] = &apos;Seleccione una carpeta&apos;;
$lang[&apos;&#xbf;Seguro que desea borrar este mensaje?&apos;] = &apos;&#xbf;Seguro que desea borrar este mensaje?&apos;;
$lang[&apos;Introduzca un email de destino&apos;] = &apos;Introduzca un email de destino&apos;;
$lang[&apos;Introduzca un asunto&apos;] = &apos;Introduzca un asunto&apos;;
$lang[&apos;Introduzca un mensaje&apos;] = &apos;Introduzca un mensaje&apos;;
$lang[&apos;El mensaje se ha enviado correctamente&apos;] = &apos;El mensaje se ha enviado correctamente&apos;;
$lang[&apos;Mensajes del&apos;] = &apos;Mensajes del&apos;;
$lang[&apos;al&apos;] = &apos;al&apos;;
$lang[&apos;de&apos;] = &apos;de&apos;;
$lang[&apos;mensajes&apos;] = &apos;mensajes&apos;;
$lang[&apos;Ver&apos;] = &apos;Ver&apos;;
$lang[&apos;Mover&apos;] = &apos;Mover&apos;;
$lang[&apos;No hay mensajes que mostrar en este momento&apos;] = &apos;No hay mensajes que mostrar en este momento&apos;;
$lang[&apos;Mover mensaje&apos;] = &apos;Mover mensaje&apos;;
$lang[&apos;Mover a la carpeta&apos;] = &apos;Mover a la carpeta&apos;;
$lang[&apos;Entrada&apos;] = &apos;Entrada&apos;;
$lang[&apos;Borradores&apos;] = &apos;Borradores&apos;;
$lang[&apos;Enviados&apos;] = &apos;Enviados&apos;;
$lang[&apos;Papelera&apos;] = &apos;Papelera&apos;;
$lang[&apos;Procesando&apos;] = &apos;Procesando&apos;;
$lang[&apos;Primero&apos;] = &apos;Primero&apos;;
$lang[&apos;&#xda;ltimo&apos;] = &apos;&#xda;ltimo&apos;;
$lang[&apos;Enviar mensaje&apos;] = &apos;Enviar mensaje&apos;;
$lang[&apos;Destinatario&apos;] = &apos;Destinatario&apos;;
$lang[&apos;Asunto&apos;] = &apos;Asunto&apos;;
$lang[&apos;Mensaje&apos;] = &apos;Mensaje&apos;;
$lang[&apos;Este cliente no existe en nuestra base de datos&apos;] = &apos;Este cliente no existe en nuestra base de datos&apos;;
$lang[&apos;Ver cliente&apos;] = &apos;Ver comprador&apos;;
$lang[&apos;A&#xf1;adir consulta al cliente&apos;] = &apos;A&#xf1;adir consulta al comprador&apos;;
$lang[&apos;Convertir en cliente&apos;] = &apos;Convertir en comprador&apos;;
$lang[&apos;Portales&apos;] = &apos;Consultas Portales&apos;;
$lang[&#039;Este cliente ya existe en nuestra base de datos&#039;] = &#039;Este cliente ya existe en nuestra base de datos&#039;;
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
$lang[&apos;Seleccione una carpeta&apos;] = &apos;Select a folder&apos;;
$lang[&apos;&#xbf;Seguro que desea borrar este mensaje?&apos;] = &apos;Are you sure you want to delete this message?&apos;;
$lang[&apos;Introduzca un email de destino&apos;] = &apos;Enter a destination email&apos;;
$lang[&apos;Introduzca un asunto&apos;] = &apos;Enter a subject&apos;;
$lang[&apos;Introduzca un mensaje&apos;] = &apos;Enter a message&apos;;
$lang[&apos;El mensaje se ha enviado correctamente&apos;] = &apos;The message has been sent successfully&apos;;
$lang[&apos;Mensajes del&apos;] = &apos;Messages from&apos;;
$lang[&apos;al&apos;] = &apos;to&apos;;
$lang[&apos;de&apos;] = &apos;of&apos;;
$lang[&apos;Ver&apos;] = &apos;View&apos;;
$lang[&apos;Mover&apos;] = &apos;Move&apos;;
$lang[&apos;No hay mensajes que mostrar en este momento&apos;] = &apos;No messages to display at this time&apos;;
$lang[&apos;Mover mensaje&apos;] = &apos;Move message&apos;;
$lang[&apos;Mover a la carpeta&apos;] = &apos;Move to the folder&apos;;
$lang[&apos;Entrada&apos;] = &apos;Inbox&apos;;
$lang[&apos;Borradores&apos;] = &apos;Drafts&apos;;
$lang[&apos;Enviados&apos;] = &apos;Sent&apos;;
$lang[&apos;Papelera&apos;] = &apos;Trash&apos;;
$lang[&apos;Procesando&apos;] = &apos;Processing&apos;;
$lang[&apos;Primero&apos;] = &apos;First&apos;;
$lang[&apos;&#xda;ltimo&apos;] = &apos;Last&apos;;
$lang[&apos;Enviar mensaje&apos;] = &apos;Send Message&apos;;
$lang[&apos;Destinatario&apos;] = &apos;To&apos;;
$lang[&apos;Asunto&apos;] = &apos;Subject&apos;;
$lang[&apos;Mensaje&apos;] = &apos;Message&apos;;
$lang[&apos;Este cliente no existe en nuestra base de datos&apos;] = &apos;This buyer does not exist in the database&apos;;
$lang[&apos;Ver cliente&apos;] = &apos;See buyer&apos;;
$lang[&apos;A&#xf1;adir consulta al cliente&apos;] = &apos;Add inquiry to buyer&apos;;
$lang[&apos;Convertir en cliente&apos;] = &apos;Convert to buyer&apos;;
$lang[&apos;Portales&apos;] = &apos;Portal Enquiries&apos;;
$lang[&#039;Este cliente ya existe en nuestra base de datos&#039;] = &#039;This client already exists in the database&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/Connections/conf/email.php
            </code>
        </pre>
        Añadir:
        <pre>
            <code class="php">
/*--------------------------------------------------------------------------
/* @group Consultas de portales */
/*--------------------------------------------------------------------------
|
| Activar la consultas de portales
| 0 - Desactivado
| 1 - Activado
|
*/

$actPortalsEnquiries = 0;

/*--------------------------------------------------------------------------
/* @group Id portales de la secci&#xf3;n origenes de clientes:
/intramedianet/properties/clients-sources.php */
/*--------------------------------------------------------------------------
|
| A&#xf1;adir las IDs de los portales que use el cliente
|
*/

$idPortalTodopisosalicante = &apos;&apos;;
$idPortalVivados = &apos;&apos;;
$idPortalMoveagain = &apos;&apos;;
$idPortalVentadepisos = &apos;&apos;;
$idPortalGranmanzana = &apos;&apos;;
$idPortalKyero = &apos;&apos;;
$idPortalRightmove = &#039;&#039;;
$idPortalThinkSpain = &#039;&#039;;

/*--------------------------------------------------------------------------
/* @group Datos email recepci&#xf3;n de portales */
/*--------------------------------------------------------------------------
|
| El email donde se reciben los emails de los portales
|
*/

$mailboxPortales = &apos;&apos;; // server.mediawebs14.com
$usernamePortales = &apos;&apos;;
$passwordPortales = &apos;&apos;;
            </code>
        </pre>
        <hr>
        Subir las carpetas <code>/intramedianet/email</code>,<code>/includes/ImapClient</code> y el archivo <code>/intramedianet/includes/assets/css/app.css</code> de esta versión.
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
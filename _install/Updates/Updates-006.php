<div class="row mb-4">
    <div class="col-md-6">
        <span class="badge badge-dark"><i class="far fa-clock"></i> <span id="proy-time">Tiempo total estimado: 8 min.</span></span>
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 25-05-2018</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Al añadir un cliente uno de los idiomas viene en blanco</a></li>
        <li><a href="#dos"><i class="fas fz-fw fa-plus-circle text-success"></i> Actualizado el master para adaptarlo a la ley de protección de datos (GDPR)</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Al añadir un cliente uno de los idiomas viene en blanco
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/intramedianet/properties/clients.php:162
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
&lt;?php
if ($lang_adm == 'es') {
    $idiomas = array('da' =&gt; 'Danés', 'de' =&gt; 'Alemán', 'el' =&gt; 'Griego', 'en' =&gt; 'Inglés', 'es' =&gt; 'Español', 'fi' =&gt; 'Finlandés', 'fr' =&gt; 'Francés', 'is' =&gt; 'Islandés', 'it' =&gt; 'Italiano', 'nl' =&gt; 'Holandés', 'no' =&gt; 'Noruego', 'pt' =&gt; 'Portugués', 'ru' =&gt; 'Ruso', 'sv' =&gt; 'Sueco', 'zh' =&gt; 'Chino');
} else {
    $idiomas = array('da' =&gt; 'Danish', 'de' =&gt; 'German', 'el' =&gt; 'Greek', 'en' =&gt; 'English', 'es' =&gt; 'Spanish', 'fi' =&gt; 'Finnish', 'fr' =&gt; 'French', 'is' =&gt; 'Icelandic', 'it' =&gt; 'Italian', 'nl' =&gt; 'Dutch', 'no' =&gt; 'Norwegian', 'pt' =&gt; 'Portuguese', 'ru' =&gt; 'Russian', 'sv' =&gt; 'Swedish', 'zh' =&gt; 'Chinese');
}
foreach ($languages as $value) {
    $selected = (!(strcmp($value, $row_rsproperties_client['idioma_cli'])))?&quot; SELECTED&quot;:&quot;&quot;;
    echo '&lt;option value=&quot;'.$value.'&quot;'.$selected.'&gt;'.$idiomas[$value].'&lt;/option&gt;';
}
?&gt;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
&lt;?php
if ($lang_adm == 'es') {
    $idiomas = array('da' =&gt; 'Danés', 'de' =&gt; 'Alemán', 'el' =&gt; 'Griego', 'en' =&gt; 'Inglés', 'es' =&gt; 'Español', 'fi' =&gt; 'Finlandés', 'fr' =&gt; 'Francés', 'is' =&gt; 'Islandés', 'it' =&gt; 'Italiano', 'nl' =&gt; 'Holandés', 'no' =&gt; 'Noruego', 'pt' =&gt; 'Portugués', 'ru' =&gt; 'Ruso', 'se' =&gt; 'Sueco', 'zh' =&gt; 'Chino');
} else {
    $idiomas = array('da' =&gt; 'Danish', 'de' =&gt; 'German', 'el' =&gt; 'Greek', 'en' =&gt; 'English', 'es' =&gt; 'Spanish', 'fi' =&gt; 'Finnish', 'fr' =&gt; 'French', 'is' =&gt; 'Icelandic', 'it' =&gt; 'Italian', 'nl' =&gt; 'Dutch', 'no' =&gt; 'Norwegian', 'pt' =&gt; 'Portuguese', 'ru' =&gt; 'Russian', 'se' =&gt; 'Swedish', 'zh' =&gt; 'Chinese');
}
foreach ($languages as $value) {
    $selected = (!(strcmp($value, $row_rsproperties_client['idioma_cli'])))?&quot; SELECTED&quot;:&quot;&quot;;
    echo '&lt;option value=&quot;'.$value.'&quot;'.$selected.'&gt;'.$idiomas[$value].'&lt;/option&gt;';
}
?&gt;
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 1 min.</small>
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="dos">
        <span class="badge badge-dark">2</span> <i class="fas fa-plus-circle text-success"></i> Actualizado el master para adaptarlo a la ley de protección de datos (GDPR)
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl:257
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var cookieTxt = '{$lng_cookiestext|escape:&quot;quotes&quot;}';
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var cookieTxt = '{$lng_cookiestext|escape:&quot;quotes&quot;}';
var cookiePol = '{$lng_politica_de_cookies|escape:&quot;quotes&quot;}';
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/website.js:1191
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
window.addEventListener(&quot;load&quot;, function(){
    window.cookieconsent.initialise({
        &quot;palette&quot;: {
            &quot;popup&quot;: {
                &quot;background&quot;: &quot;#eee&quot;,
                &quot;text&quot;: &quot;#1C232C&quot;
            },
            &quot;button&quot;: {
                &quot;background&quot;: &quot;#1C232C&quot;
            }
        },
        &quot;content&quot;: {
            &quot;message&quot;: cookieTxt + &quot;.&quot;,
            &quot;dismiss&quot;: cookieTxtBtn,
            &quot;link&quot;: cookieTxtMoreInfo,
            &quot;href&quot;: cookieURL
        }
    })
});
            </code>
        </pre>
        Pop:
        <pre>
            <code class="php">
window.addEventListener(&quot;load&quot;, function(){
    window.cookieconsent.initialise({
        &quot;palette&quot;: {
            &quot;popup&quot;: {
                &quot;background&quot;: &quot;#ccc&quot;,
                &quot;text&quot;: &quot;#1C232C&quot;
            },
            &quot;button&quot;: {
                &quot;background&quot;: &quot;#1C232C&quot;
            }
        },
        &quot;content&quot;: {
            &quot;message&quot;: cookieTxt + &quot;.&quot;,
            &quot;dismiss&quot;: cookieTxtBtn,
            &quot;link&quot;: cookieTxtMoreInfo,
            &quot;href&quot;: cookieURL
        },
        law: {
          regionalLaw: false,
        },
        revokable:true,
        revokeBtn:'&lt;div class=&quot;cc-revoke {{classes}}&quot;&gt;' + cookiePol + '&lt;/div&gt;',
        law: {
          regionalLaw: false,
        },
        location: false,
    })
});
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_da.php:13
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr['Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad'] = 'Markér feltet for at bekræfte, at du har læst og forstået vores %sfortrolighedspolitik%s';
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad&quot;] = &quot;Tjek boksen for at kontakte os og acceptere, at dine oplysninger bliver brugt i henhold til vores% s Fortrolighedspolitik% s, du bliver automatisk tilføjet til vores mailingliste, men du kan til enhver tid fravælge&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_de.php:13
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr['Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad'] = 'Aktivieren Sie das Kontrollkästchen, um zu bestätigen, dass Sie unsere Datenschutzbestimmungen gelesen und %sverstanden haben%s';
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad&quot;] = &quot;Aktivieren Sie das Kontrollkästchen, um mit uns in Kontakt zu treten, und stimmen Sie zu, dass Ihre Daten gemäß unserer %s Datenschutzrichtlinie verwendet werden%s. Sie werden automatisch zu unserer Mailingliste hinzugefügt, Sie können jedoch jederzeit aussteigen&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_en.php:13
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr['Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad'] = 'Check the box to confirm that you have read and understood our %sPrivacy Policy%s';
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad&quot;] = &quot;Check the box to contact us and agree to your information being used according to our %s Privacy Policy %s you will automatically be added to our mailing list, but you can opt out at any time&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_es.php:13
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr[&quot;Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad&quot;] = &quot;Marque la casilla para confirmar que ha leido y entendido nuestra %sPolitica de Privacidad%s&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad&quot;] = &quot;Marque la casilla para contactarnos y acepte que su información se use de acuerdo con nuestra %s Política de privacidad %s que se agregará automáticamente a nuestra lista de correo, pero puede cancelarla en cualquier momento&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_fi.php:13
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr['Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad'] = 'Valitse ruutu vahvistaa, että olet lukenut ja ymmärtänyt %stietosuojakäytännössämme%s';
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad&quot;] = &quot;Valitsemalla ruudun, johon haluat ottaa meihin yhteyttä ja hyväksyä, että tietojasi käytetään: %s  n tietosuojakäytännön mukaisesti %s, ne lisätään automaattisesti postituslistallemme, mutta voit milloin tahansa poistaa ilmoituksen&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_fr.php:13
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr['Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad'] = 'Cochez la case pour confirmer que vous avez lu et compris notre %spolitique de confidentialité%s';
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad&quot;] = &quot;Cochez la case pour nous contacter et acceptez que vos informations soient utilisées conformément à notre %s politique de confidentialité s%  vous serez automatiquement ajouté à notre liste de diffusion, mais vous pouvez vous désinscrire à tout moment&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_is.php:13
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr['Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad'] = 'Hakaðu í reitinn til að staðfesta að þú hafir lesið og %sskilið persónuverndarstefnu okkar%s';
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad&quot;] = &quot;Hakaðu í reitinn til að hafa samband við okkur og samþykkið að upplýsingar þínar séu notaðar í samræmi við %s persónuverndarstefnu okkar %s sem þú verður sjálfkrafa bætt við póstlista okkar, en þú getur afþakkað hvenær sem er&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_nl.php:13
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr['Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad'] = 'Vink het vakje om te bevestigen dat u hebt gelezen en %sbegrepen ons privacybeleid%s';
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad&quot;] = &quot;Vink het vakje aan om contact met ons op te nemen en ga ermee akkoord dat uw informatie wordt gebruikt volgens ons %s Privacybeleid %s u wordt automatisch toegevoegd aan onze mailinglijst, maar u kunt op elk moment afmelden&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_no.php:13
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr[&quot;Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad&quot;] = &quot;Kryss av i boksen for å bekrefte at du har lest og %sforstått våre privatregler%s&quot;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad&quot;] = &quot;Merk av i boksen for å kontakte oss og godta at informasjonen din blir brukt i henhold til vår %s personvernsreglement %s, du blir automatisk lagt til i vår mailingliste, men du kan når som helst melde deg av&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_ru.php:13
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr['Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad'] = 'Установите флажок, чтобы подтвердить, что вы прочитали и поняли нашу %sполитику конфиденциальности%s';
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad&quot;] = &quot;Установите флажок, чтобы связаться с нами и согласиться с вашей информацией, используемой в соответствии с нашей %s Политикой конфиденциальности %s, которую вы автоматически добавите в наш список рассылки, но вы можете отказаться в любое время&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_se.php:13
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr['Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad'] = 'Markera kryssrutan för att bekräfta att du har läst och %sförstått vår sekretesspolicy%s';
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad&quot;] = &quot;Markera rutan för att kontakta oss och godkänna att din information används enligt vår %s Sekretesspolicy %s du kommer automatiskt att läggas till i vår mailinglista, men du kan när som helst välja bort&quot;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/resources/lang_zh.php:13
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$langStr['Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad'] = '%s选中此框以确认您已阅读并了解我们的隐私权政策%s';
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$langStr[&quot;Marque la casilla para confirmar que ha leido y entendido nuestra Politica de Privacidad&quot;] = &quot;选中此框即可与我们联系，并同意根据我们%s的隐私政策%s使用您的信息，您将自动添加到我们的邮件列表中，但您可以随时退出&quot;;
            </code>
        </pre>
        <hr>
    </div>
    <div class="card-footer text-muted">
        <small><i class="far fa-clock"></i> Tiempo estimado: 7 min.</small>
        <a href="#" class="float-right text-secondary"><i class="fas fa-arrow-circle-up"></i></a>
    </div>
</div>
<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 18-03-2025</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#sec1"><i class="fas fz-fw fa-bug text-danger"></i> Falta script JS a valoración de inmueles</a></li>
        <li><a href="#sec2"><i class="fas fz-fw fa-bug text-danger"></i> No aparece el texto legal de los formularios</a></li>
    </ol>
</div>

<div class="card mb-4">
    <h6 class="card-header" id="sec1">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Falta script JS a valoración de inmueles
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/templates/templates/footer.tpl
            </code>
        </pre>
        Añadir antes de la etiqueta <code>&lt;/body&gt;</code>:
        <pre>
            <code class="php">
{if $seccion == &#039;rate&#039;}
&lt;script&gt;
$(&#039;.btn-ratecont&#039;).click(function(e) {
    e.preventDefault();
    var $parent = $(this).parent(&#039;.ratecont&#039;);

    if ($parent.find(&#039;.check-rate&#039;).is(&#039;:checked&#039;)) {} else {
        alert(&#039;{$lng_select_a_rating|escape}&#039;);
        return false;
    }

    $client = &#039;{$smarty.get.id_cli}&#039;;
    $id_prop = $parent.find(&quot;.id_prop_rate&quot;).val();
    $rate = $parent.find(&quot;.check-rate:checked&quot;).val();
    $location = ($parent.find(&quot;.locationchck&quot;).is(&#039;:checked&#039;))?1:0;
    $type = ($parent.find(&quot;.typechck&quot;).is(&#039;:checked&#039;))?1:0;
    $price = ($parent.find(&quot;.pricechck&quot;).is(&#039;:checked&#039;))?1:0;
    $bedrooms = ($parent.find(&quot;.bedroomschck&quot;).is(&#039;:checked&#039;))?1:0;
    $other = ($parent.find(&quot;.otherchck&quot;).is(&#039;:checked&#039;))?1:0;

    $.get(&quot;/modules/mail_partials/ratesave.php?id_cli=&quot; + $client + &quot;&amp;id_prop=&quot; + $id_prop + &quot;&amp;rate=&quot; + $rate + &quot;&amp;location=&quot; + $location + &quot;&amp;type=&quot; + $type + &quot;&amp;price=&quot; + $price + &quot;&amp;bedrooms=&quot; + $bedrooms + &quot;&amp;other=&quot; + $other, function(data) {
      if(data != &#039;&#039;) {
          $parent.parent().html(&#039;&lt;h2&gt;{$lng_thank_you_for_your_review|escape}&lt;/h2&gt;&lt;br&gt;&lt;br&gt;&lt;p&gt;{$lng_we_will_adjust_your_purchase_criteria_to_offer_you_the_best_service|escape}&lt;/p&gt;&#039;);
      }
    });

});
&lt;/script&gt;
{/if}
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

<div class="card">
    <h6 class="card-header" id="sec2">
        <span class="badge badge-dark">2</span> <i class="fas fz-fw fa-bug text-danger"></i> No aparece el texto legal de los formularios
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/index.php:289
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;texto_formularios_GDPR&quot;, $texto_formularios_GDPR);
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
$smarty-&gt;assign(&quot;texto_formularios_GDPR&quot;, $texto_formularios_GDPR[$lang]);
            </code>
        </pre>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>
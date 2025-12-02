<div class="row mb-4">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-md-right">
        <span class="badge badge-secondary"><i class="fas fa-fw fa-calendar"></i> 14-05-2024</span>
    </div>
</div>

<div class="card mb-4">
    <ol class="ver-index">
        <li><a href="#uno"><i class="fas fz-fw fa-bug text-danger"></i> Rediseño popup cookies</a></li>
    </ol>
</div>

<div class="card">
    <h6 class="card-header" id="uno">
        <span class="badge badge-dark">1</span> <i class="fas fz-fw fa-bug text-danger"></i> Rediseño popup cookies
    </h6>
    <div class="card-body">
        En el archivo:
        <pre>
            <code class="makefile">
/js/source/jquery.ihavecookies.js:84
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
var cookieMessage = &#039;&lt;div id=&quot;gdpr-cookie-message&quot;&gt;&lt;h4&gt;&#039; + settings.title + &#039;&lt;/h4&gt;&lt;p&gt;&#039; + settings.message + &#039; &lt;a href=&quot;&#039; + settings.link + &#039;&quot;&gt;&#039; + settings.moreInfoLabel + &#039;&lt;/a&gt;&lt;div id=&quot;gdpr-cookie-types&quot; style=&quot;display:none;&quot;&gt;&lt;h5&gt;&#039; + settings.cookieTypesTitle + &#039;&lt;/h5&gt;&lt;ul&gt;&#039; + cookieTypes + &#039;&lt;/ul&gt;&lt;/div&gt;&lt;p&gt;&lt;button id=&quot;gdpr-cookie-deny&quot; type=&quot;button&quot;&gt;&#039; + settings.denyBtnLabel + &#039;&lt;/button&gt;&lt;button id=&quot;gdpr-cookie-advanced&quot; type=&quot;button&quot;&gt;&#039; + settings.advancedBtnLabel + &#039;&lt;/button&gt;&lt;button id=&quot;gdpr-cookie-accept&quot; type=&quot;button&quot;&gt;&#039; + settings.acceptBtnLabel + &#039;&lt;/button&gt;&lt;/p&gt;&lt;/div&gt;&#039;;
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
var cookieMessage = &#039;&lt;div id=&quot;gdpr-cookie-message&quot;&gt;&lt;h4&gt;&#039; + settings.title + &#039;&lt;/h4&gt;&lt;p&gt;&#039; + settings.message + &#039; &lt;a href=&quot;&#039; + settings.link + &#039;&quot;&gt;&#039; + settings.moreInfoLabel + &#039;&lt;/a&gt;&lt;div id=&quot;gdpr-cookie-types&quot; style=&quot;display:none;&quot;&gt;&lt;h5&gt;&#039; + settings.cookieTypesTitle + &#039;&lt;/h5&gt;&lt;ul&gt;&#039; + cookieTypes + &#039;&lt;/ul&gt;&lt;/div&gt;&lt;p&gt;&lt;button id=&quot;gdpr-cookie-accept&quot; type=&quot;button&quot;&gt;&#039; + settings.acceptBtnLabel + &#039;&lt;/button&gt;&lt;button id=&quot;gdpr-cookie-advanced&quot; type=&quot;button&quot;&gt;&#039; + settings.advancedBtnLabel + &#039;&lt;/button&gt;&lt;button id=&quot;gdpr-cookie-deny&quot; type=&quot;button&quot;&gt;&#039; + settings.denyBtnLabel + &#039;&lt;/button&gt;&lt;/p&gt;&lt;/div&gt;&#039;;
            </code>
        </pre>
        <hr>
        En el archivo:
        <pre>
            <code class="makefile">
/css/source/pages/_miscellaneous.scss:144
            </code>
        </pre>
        Cambiar:
        <pre>
            <code class="php">
@include media-breakpoint-up(md)
{
    button#gdpr-cookie-deny
    {
        background-color: transparent;
        border: 1px solid #a8a8a8;
        margin-top: 6px;
    }
    button#gdpr-cookie-deny, button#gdpr-cookie-advanced
    {
        width: 48%;
        padding: 8px 8px;
        margin-left: 0;
        margin-right: 8px;
        white-space: nowrap;
        display: inline-block;
        margin-top: 6px;
    }
    button#gdpr-cookie-advanced
    {
        margin-left: 0;
        margin-right: 0;
        border: 1px solid #fefefe;
        background-color: #fefefe;
    }
}
            </code>
        </pre>
        Por:
        <pre>
            <code class="php">
@include media-breakpoint-up(md)
{
    button#gdpr-cookie-deny, button#gdpr-cookie-advanced
    {
        background-color: transparent;
        border: 1px solid #a8a8a8;
        width: 100%;
        padding: 8px 8px;
        margin-left: 0;
        margin-right: 8px;
        white-space: nowrap;
        display: inline-block;
        margin-top: 6px;
    }
}
            </code>
        </pre>
        <hr>
        <b>Una vez hechos estos cambios recompilamos css y javascript</b>
    </div>
    <div class="card-footer text-muted">
        <a href="#" class="float-right text-secondary toTop"><i class="fas fz-fw fa-arrow-circle-up"></i></a>
    </div>
</div>

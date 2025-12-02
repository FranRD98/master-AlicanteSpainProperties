{include file="header.tpl"}

<div class="container text-center">
    <div class="row mt-3 mt-lg-5 py-3 py-lg-5">
        <div class="col-md-12">
                 <div class="page-content">
                    {if $aviso == 1}
                    <h2>
                        {$lng_unsubstxt}
                    </h2>
                    <p>
                        <strong>
                        {$lng_unsubstxt2}
                        </strong>
                    </p>
                    {else}
                    <h2 class="main-title">
                        An error ocurred
                    </h2>
                    <p>
                        <strong>
                        Please, try to unsubscribe again
                        </strong>
                    </p>
                    {/if}
                </div>
        </div>
    </div>

</div>

{include file="footer.tpl"}

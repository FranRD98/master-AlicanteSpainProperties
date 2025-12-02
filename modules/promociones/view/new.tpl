{include file="header.tpl"}

{include file="file:modules/promociones/view/partials/titulo.tpl" }

{include file="file:modules/promociones/view/partials/main-img.tpl" }

<div class="property-data bg-light">
    <div class="container pb-4 pb-xl-5">
        <div class="row">
            <div class="col-12">

                {* @group SEC - BOTONES *}
                {include file="file:modules/promociones/view/partials/botonera.tpl" }

                {* @group SEC - NAVIGATION *}
                {include file="file:modules/promociones/view/partials/nav-tabs.tpl" }

                {* @group SEC - NAVIGATION *}
                {include file="file:modules/promociones/view/partials/tabs-panels.tpl" }

            </div>
        </div>
    </div>


</div>

{* @group SEC - CONTACTAR *}
<div class="bg-light pt-5 pt-xl-3 pb-5 property-form">
    <div class="container pt-5 pb-4 mb-xl-4 bg-white position-relative viewed">
        <div class="row justify-content-center mt-xl-5">
            <div class="col-lg-6">
                {include file="file:modules/promociones/view/partials/contactar.tpl" }
            </div>
        </div>
    </div>
</div>

{include file="footer.tpl"}

{if $galeriaModal == 1}
    {include file="file:modules/promociones/view/partials/modal-gallery.tpl" }
{/if}
<script type="text/javascript">
    ! function($) {
        {if $localizacionReferencia != ''}
            {if $property[0].zoom > 0}
                showMapProperty('gmap', [{$localizacionReferencia}], {$zoomReferencia - 3});
            {else}
                showMapProperty('gmap', [{$localizacionReferencia}], 13);
            {/if}
            $(document).on('shown.bs.collapse', function() {
                showMapProperty('gmap', [{$localizacionReferencia}], {$zoomReferencia - 3});
            });
        {else}
            {if $property[0].zoom > 0}
                showMapProperty('gmap', [{$news[0].lat_long_gp_prop}], {$news[0].zoom_gp_prop - 3});
            {else}
                showMapProperty('gmap', [{$news[0].lat_long_gp_prop}], 13);
            {/if}
            $(document).on('shown.bs.collapse', function() {
                showMapProperty('gmap', [{$news[0].lat_long_gp_prop}], {$news[0].zoom_gp_prop - 3});
            });
        {/if}

        $(window).on("scroll", function(e) {
            var fromTop = $(window).scrollTop();

            if (!$('body').hasClass('promociones') && $(window).width() > 1200) {
                $('.main-header').toggleClass("fix-header", (fromTop > 30));
                $('.brand').toggleClass("fix-brand", (fromTop > 15));
            } else {
                let maintopHeight = ($('.main-header').outerHeight() + $('.main-header-top').outerHeight());
                $('.property-title').toggleClass("fix-property-header py-2 py-lg-4", (fromTop > maintopHeight));
                $('#prop-header--placeholder').toggleClass("show-prop-header", (fromTop > maintopHeight));
            }
        });

        $(".toForm2").click(function() {
            $('html, body').animate({
                scrollTop: $(".property-form").offset().top - 100
            }, 700);
        });

        $(".toGallery").click(function() {
            $('html, body').animate({
                scrollTop: $("#pane-photos").offset().top - 120
            }, 700);
        });

        if ($(window).width() > 990) {
            var clickBtn = 250;

            $('.scroll-tabs a[href^="#"]').on('click', function(e) {
                e.preventDefault();

                var target = this.hash;
                var $target = $(target);
                $('html, body').animate({
                    'scrollTop': $target.offset().top - clickBtn
                }, 600, 'swing');
            });

            $('.btn-to_photos').on('click', function(e) {
                e.preventDefault();

                var target = this.hash;
                var $target = $(target);
                $('html, body').animate({
                    'scrollTop': $target.offset().top - clickBtn
                }, 600, 'swing');
            });
        }

    }(window.jQuery);
</script>
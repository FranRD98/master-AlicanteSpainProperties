$(document).ready(function($) 
{

    // TOGGLE MENU PRINCIPAL MOBILE
    $('.open-main-menu').click(function(){
        $('.menu-responsivo').toggleClass("toggled");
        $('.black-bg').toggleClass("toggled");
    });
    $('.black-bg').click(function(){
        $('.menu-responsivo').removeClass("toggled");
        $('.black-bg').removeClass("toggled");
    });



       //  ================================================================
       //  /* @group BTN MENU DESPLEGABLE */
       //  ================================================================

      $('.btn-menu-lateral').click(function(e)
      {
         e.preventDefault();
         $('.mega-menu').fadeToggle();

      });


    //  ================================================================
    //  /* @group R MODAL SEARCH  buscador header */
    //  ================================================================

        $('.btn-top-search').click(function(){
            $('#modal-search').toggleClass('open-modal-search');
        });


    //  ================================================================
    //  /* @group FIX HEADER */
    //  ================================================================

    $(window).on("scroll", function(e) 
    {
        var fromTop = $(window).scrollTop();


        if (!$('body').hasClass('property') && $(window).width() > 1200) 
        {
            $('.main-header').toggleClass("fix-header", (fromTop > 30));
            $('.brand').toggleClass("fix-brand", (fromTop > 30));
        }
        else 
        {
             $('.property-title').toggleClass("fix-property-header", (fromTop > 100));
        }
    });

    //  ================================================================
    //  /* @group FIX BOTTOM BAR */
    //  ================================================================

    $(window).on("scroll", function(e) {
        var fromTop = $(window).scrollTop();
        $('.bottom-bar-new').toggleClass("show", (fromTop > 100));
    });

    //  ================================================================
    //  /* @group BACK TO TOP */
    //  ================================================================

    var offset = 220;
    var duration = 500;

    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > offset) {
            jQuery('.back-to-top').fadeIn(duration);
        } else {
            jQuery('.back-to-top').fadeOut(duration);
        }
    });

    jQuery('.back-to-top, .back-to-top-resp').click(function(event) {
        event.preventDefault();
        jQuery('html, body').animate({scrollTop: 0}, duration);
        return false;
    });

    $('.btnCont').click(function(){
        $('html, body').animate({scrollTop:$('#footer').position().top}, 1000);
        return false;
    });

      $(".toForm").click(function() 
      {
          $('html, body').animate({
              scrollTop: $("#requestInfoForm").offset().top - 100
          }, 700);
      });


    //  ================================================================
    //  /* @group SOCIAL BARRA RESPONSIVA */
    //  ================================================================

    $('a[href="#mobile-bottom-social"]').click(function(){
        $('#mobile-bottom-social').toggle();
        return false;
    });

    //  ================================================================
    //  /* @group HOVER DROPDOWNS */
    //  ================================================================

    if (!("ontouchstart" in document.documentElement)) {
        $('#main-nav [data-bs-toggle="dropdown"]:not(.idiomas-drop), #footer [data-bs-toggle="dropdown"]').bootstrapDropdownHover();
    }

    //  ================================================================
    //  /* @group SCROLL TO FIXED */
    //  ================================================================

    if( $('body').hasClass('property') )
    {
        if($(window).width() > 1199)
        {

            var clickBtn= 80;

            $('.scroll-tabs a[href^="#"]').on('click', function (e) {
                e.preventDefault();

                var target = this.hash;
                var $target = $(target);
                $('html, body').animate({
                    'scrollTop': $target.offset().top - clickBtn
                }, 600, 'swing');
            });
        }

    }

    //  ================================================================
    //  /* @group EVENTOS  */
    //  ================================================================
    
    $(".toEventForm").click(function() 
    {
      $('html, body').animate({
          scrollTop: $("#eventForm").offset().top - 100
      }, 600);
    });


    $('#contactFormEvent').submit(function(e) {

    e.preventDefault();

    if ($(this).valid()) {

        $(this).append('<div class="loading">');

        $.get("/modules/events/send.php?" + $(this).serialize()).done(function(data) {
            if (data == 'ok') {

                $('#contactFormEvent input[type=text], #contactFormEvent textarea').val('');
                $('#contactFormEvent input[type=checkbox]').removeAttr('checked');
                $('#contactFormEvent .loading').remove();
                swal('', okConsult, 'success');
                $('#quotePureModal .close').click();
                gtag('event', 'evento', { 'event_category': 'Contact Form', 'event_action': 'Contact', 'event_label': 'eventos' });

            }

        });
    }
    });

    //  ================================================================
    //  /* @group VALIDACIÓN DE FORMULARIOS */
    //  ================================================================

    $(".validate").each(function() {

        $(this).validate({
            ignore: "",
            rules: {
                hiddenRecaptcha: {
                    required: function () {
                        if (grecaptcha.getResponse() == '') {
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            },
            onkeyup: false,
            errorClass: "help-block error",
            validClass: 'valid',
            highlight: function(element, errorClass, validClas) {
                $(element).parents("div.form-group").addClass("error");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents("div.error").removeClass("error");
            },
            errorPlacement: function(error, element) {
                $(element).closest('div').append(error);
            },
            errorElement: 'div'
        });

    });

    //  ================================================================
    //  /* @group SELECTS PERSONALIZADOS */
    //  ================================================================

        var $cs = $('select:not([multiple])').customSelect();

    //  ================================================================
    //  /* @group SCROLL PROPERTY */
    //  ================================================================

    $('.property-slider .slides').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        mobileFirst: true,
        zIndex: -1,
        arrows: true,
        asNavFor: '.property-gallery-slider .slides',
        fade: true,
        cssEase: 'linear',
        adaptiveHeight: true
    });

    $('.property-gallery-slider .slides').slick({
        dots: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
        mobileFirst: true,
        arrows: true,
        zIndex: -1,
        asNavFor: '.property-slider .slides',
        centerMode: true,
        focusOnSelect: true,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 5
                    }
            },
            {
            breakpoint: 767,
            settings: {
                    slidesToShow: 3
                }
            }
        ]
    });

    $('.property-slider-center .slides').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        // variableWidth: true,
        centerMode: true,
        centerPadding: '0%',
        infinite: true,
        zIndex: 1,
        mobileFirst: true,
        adaptiveHeight: true,
        arrows: true,
        responsive: [
            {
                breakpoint: 1920,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerPadding: '20%',
                }
            },
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerPadding: '15%',
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerPadding: '10%',
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerPadding: '10%',
                }
            },
            {
                breakpoint: 576,
                settings: {
                }
            }
        ]
    });

    //  ================================================================
    //  /* @group SCROLL DESTACADOS, OFERTAS Y SIMILARES */
    //  ================================================================

    $("#featured-properties .slides, #ofertas-properties .slides, #featProms-properties .slides, #similares-properties .slides").slick({
        dots: true,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 5000,
        mobileFirst: true,
        arrows: false,
        zIndex: 1,
        slidesToShow: 1,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
            },
            {
                breakpoint: 992,
                settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
            },
            {
            breakpoint: 767,
            settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }
        ]
    });

    $("#similares-properties-modal .slides, #similares-properties-bajada-modal .slides").slick({
        dots: true,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 5000,
        mobileFirst: true,
        arrows: false,
        zIndex: 1,
        slidesToShow: 1,
        slidesToScroll: 1,
        responsive: [
            {
            breakpoint: 767,
            settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }
        ]
    });

    //  ================================================================
    //  /* @group  SCROLL TESTIMONIALS */
    //  ================================================================

    $("#testimonials-home .slides").slick({
        dots: true,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 5000,
        mobileFirst: true,
        arrows: false,
        adaptiveHeight: true,
        zIndex: 1,
        slidesToShow: 1,
        slidesToScroll: 1,
        responsive: [{
            breakpoint: 991,
            settings: {
                adaptiveHeight: false
            }
        }]
    });

    //  ================================================================
    //  /* @group PROPERTY IMAGE SLIDER */
    //  ================================================================
    $(".porta-img .slides").slick({
        dots: false,
        infinite: true,
        autoplay: false,
        zIndex: 1,
        slidesToShow: 1,
        slidesToScroll: 1,
        adaptiveHeight: false
    });

    // On before slide change
    $(".porta-img .slides").on('beforeChange', function(event, slick, currentSlide, nextSlide){
        $ele = this;
        if ( !$($ele).hasClass("ajax-loaded") ) {
            var $idProp = $($ele).attr("data-id-prop");
            var $alt = $($ele).attr("data-alt");
            var $width = $($ele).attr("data-width");
            var $height = $($ele).attr("data-height");
            var $url = $($ele).attr("data-url");
            $(this).append('<div class="loading"></div>');

            $.get(
              "/modules/properties/slider-images.php?id_prop="+$idProp+"&alt="+$alt+"&width="+$width+"&height="+$height+"&url="+$url
            ).done(function(data) {
                data = $.parseJSON(data);
                $prop = $(".porta-img .slides[data-id-prop="+data.id+"]");
                $prop.slick('slickAdd', data.slides);
                $prop.slick('slickRemove', 1);
                $prop.children('.loading').remove();
            });
        }
    });
    // On after slide change
    $(".porta-img .slides").on('afterChange', function(event, slick, currentSlide, nextSlide){
        $ele = this;
        if ( !$($ele).hasClass("ajax-loaded") ) {
            $($ele).addClass("ajax-loaded");
            $($ele).slick('slickGoTo', 2);
        }
    });

    //  ================================================================
    //  /* @group RESULTADOS BUSCADOR */
    //  ================================================================

    $('#searchHomeForm select').change(function(event) {
        vals = $('#searchHomeForm').serialize();
        $.get("/modules/properties/total.php?" + $('#searchHomeForm').serialize()).done(function(data) {
            if (data != '') {
                $('.result span').text(data);
            }
        });
    }).change();

    $('#rf').keyup(function(event) {
        vals = $('#searchHomeForm').serialize();
        $.get("/modules/properties/total.php?" + $('#searchHomeForm').serialize()).done(function(data) {
            if (data != '') {
                $('.result span').text(data);
            }
        });
    }).change();

    $('#searchHomeForm1 select').change(function(event) {
        vals = $('#searchHomeForm1').serialize();
        $.get("/modules/properties/total.php?" + $('#searchHomeForm1').serialize()).done(function(data) {
            if (data != '') {
                $('.result span').text(data);
            }
        });
    }).change();

    $('#rf1').keyup(function(event) {
        vals = $('#searchHomeForm1').serialize();
        $.get("/modules/properties/total.php?" + $('#searchHomeForm1').serialize()).done(function(data) {
            if (data != '') {
                $('.result span').text(data);
            }
        });
    }).change();

    //  ================================================================
    //  /* @group LOCALIZACIÓN BUSCADOR AVANZADO */
    //  ================================================================

    $('#locun').change(function(event) {
        $.get("/modules/search/provinces.php?locun=" + $(this).val() + "&lang=" + appLang).done(function(data) {
            if (data != '') {
                $('#lopr').html(data);
                $('#lopr').change();
                $('#loct').change();
            }
        });
    });

    $('#lopr').change(function(event) {
        $.get("/modules/search/towns.php?lopr=" + $(this).val() + "&lang=" + appLang).done(function(data) {
            if (data != '') {
                $('#loct').html(data);
                $('#loct').change();
            }
        });
    });

    $('#loct').change(function(event) {
        $.get("/modules/search/areas.php?loct=" + $(this).val() + "&lang=" + appLang).done(function(data) {
            if (data != '') {
                $('#lozn').html(data);
            }
        });
    });

    $('#coast').change(function (event) {
        $.get("/modules/search/coasts.php?coast=" + $(this).val() + "&lang=" + appLang).done(function (data) {
            if (data != '') {
                $('#loct').html(data);
            }
        });
    }).change();

    $('#locun1').change(function(event) {
        $.get("/modules/search/provinces.php?locun=" + $(this).val() + "&lang=" + appLang).done(function(data) {
            if (data != '') {
                $('#lopr1').html(data);
                $('#lopr1').change();
                $('#loct1').change();
            }
        });
    });

    $('#lopr1').change(function(event) {
        $.get("/modules/search/towns.php?lopr=" + $(this).val() + "&lang=" + appLang).done(function(data) {
            if (data != '') {
                $('#loct1').html(data);
                $('#loct1').change();
            }
        });
    });

    $('#loct1').change(function(event) {
        $.get("/modules/search/areas.php?loct=" + $(this).val() + "&lang=" + appLang).done(function(data) {
            if (data != '') {
                $('#lozn1').html(data);
            }
        });
    });

    $('#coast1').change(function (event) {
        $.get("/modules/search/coasts.php?coast=" + $(this).val() + "&lang=" + appLang).done(function (data) {
            if (data != '') {
                $('#loct1').html(data);
            }
        });
    }).change();

    //  ================================================================
    //  /* @group RESETEAR BUSCADOR */
    //  ================================================================

    // $('#searchHomeForm').on('reset',function(){
    //     setTimeout(function() {
    //         $(".select2").val('').trigger('change').trigger('update');
    //     }, 1);
    // });

    // $('#searchHomeForm1').on('reset',function(){
    //     setTimeout(function() {
    //         $(".select2").val('').trigger('change').trigger('update');
    //     }, 1);
    // });

    $('.button-search-reset').click(function(){

       $('.buscador select').val(null).trigger('change');
       $('.buscador input[type=text]').val('');

       $(".buscador input[type=checkbox]").each(function ()
        {
            $(this).removeAttr('checked');
        });
    });
       

    //  ================================================================
    //  /* @group ORDEN PROPIEDADES */
    //  ================================================================

    function changeParamByName(href, paramName, newVal) {
        var tmpRegex = new RegExp("(\&" + paramName + "=)[0-9]+", 'ig');
        return href.replace(tmpRegex, '$1'+newVal);
    }

    $('#o, #o2').change(function() {

        var url = window.location.href;

        var tempArray = url.split("?");
        var tempArray2 = url.split("&o=");

        if(tempArray[1] != null && tempArray[1] != undefined) {
            if(tempArray2[1] != null && tempArray2[1] != undefined) {
                url = changeParamByName(url, 'o', $(this).val());
            } else {
                url = url + '&o=' + $(this).val();
            }
        } else {
            url = url + '?o=' + $(this).val();
        }

        window.location = url;

    });

    //  ================================================================
    //  /* @group NUMERO PROPIEDADES */
    //  ================================================================

    $('#nu, #nu2').change(function() {

        var url = window.location.href;

        var tempArray = url.split("?");
        var tempArray2 = url.split("&nu=");

        if(tempArray[1] != null && tempArray[1] != undefined) {
            if(tempArray2[1] != null && tempArray2[1] != undefined) {
                url = changeParamByName(url, 'nu', $(this).val());
            } else {
                url = url + '&nu=' + $(this).val();
            }
        } else {
            url = url + '?nu=' + $(this).val();
        }

        window.location = url;

    });

    //  ================================================================
    //  /* @group GALERÍA PROPIEDADES */
    //  ================================================================

    $('.moreimg').click(function(e) {

        e.preventDefault();

        $(this).hide();

        $('.lessimg').show();

        $('.img-hidden').addClass('img-show');

    });

    $('.lessimg').click(function(e) {

        e.preventDefault();

        $(this).hide();

        $('.moreimg').show();

        $('.img-hidden').removeClass('img-show');

    });

    //  ================================================================
    //  /* @group CALCULAR HIPOTECA */
    //  ================================================================

    $(document).on('click', '#calc', function(e) {

        var formCalc = $(this).parent().parent().parent();

        var loanamount = formCalc.find('#muamount').val();
        var interest = formCalc.find('#muinterest').val();
        var term = formCalc.find('#muterm').val();
        var I = interest / 12;
        var X = 1 / (1 + I / 100);
        var N = term * 12;

        formCalc.find('#txtrepay').val(formatnumber(loanamount * (X - 1) / (Math.pow(X, N + 1) - X)));
        formCalc.find('#txtinterest').val(formatnumber((loanamount - loanamount * Math.pow(X, N)) * (X - 1) / (Math.pow(X, N + 1) - X)));

        return false;

    });

    //  ================================================================
    //  /* @group CONTACTAR PIE */
    //  ================================================================

    $('#contactFootForm').submit(function(e) {

        e.preventDefault();

        if ($(this).valid()) {

            $(this).append('<div class="loading">');

            $.get("/modules/contact/send-quote.php?" + $(this).serialize()).done(function(data) {
                if (data == 'ok') {

                    $('#contactFootForm input[type=text], #contactFootForm textarea').val('');
                    $('#contactFootForm input[type=checkbox]').removeAttr('checked');
                    $('#contactFootForm .loading').remove();
                    swal('', okConsult, 'success');
                    $('#quotePureModal .close').click();
                    gtag('event', 'evento', {'event_category': 'Contact Form', 'event_action': 'Contact', 'event_label': 'home'});

                }

            });
        }
    });

    //  ================================================================
    //  /* @group SOLICITAR INFORMACIÓN INMUEBLE */
    //  ================================================================

    $('#requestInfoForm').submit(function(e) {

        e.preventDefault();

        if ($(this).valid()) {

            $(this).append('<div class="loading">');

            $.get("/modules/property/enquiry.php?" + $(this).serialize()).done(function(data) {
                if (data == 'ok') {

                    $('#requestInfoForm input[type=text], #requestInfoForm textarea').val('');
                    $('#requestInfoForm input[type=checkbox]').removeAttr('checked');
                    $('#requestInfoForm .loading').remove();
                    if (opcionSimilares == 0) {
                        swal('', okConsult, 'success');
                    } else {
                        $('#similarModal').modal('toggle');
                        $('#similares-properties-modal .slides').resize();
                    }
                    gtag('event', 'evento', {'event_category': 'Contact Form', 'event_action': 'Contact', 'event_label': 'property'});

                }

            });

        }

    });

    //  ================================================================
    //  /* @group SOLICITAR INFORMACIÓN PROMOCIÓN */
    //  ================================================================

    $('#requestInfoForm2').submit(function(e) {

        e.preventDefault();

        if ($(this).valid()) {

            $(this).append('<div class="loading">');

            $.get("/modules/property/enquiry.php?" + $(this).serialize()).done(function(data) {
                if (data == 'ok') {

                    $('#requestInfoForm2 input[type=text], #requestInfoForm2 textarea').val('');
                    $('#requestInfoForm2 input[type=checkbox]').removeAttr('checked');
                    $('#requestInfoForm2 .loading').remove();
                    if (opcionSimilares == 0) {
                        swal('', okConsult, 'success');
                    } else {
                        $('#similarModal').modal('toggle');
                        $('#similares-properties-modal .slides').resize();
                    }
                    gtag('event', 'evento', {'event_category': 'Contact Form', 'event_action': 'Contact', 'event_label': 'property'});

                }

            });

        }

    });


    $('#sendFriendFormTrips').submit(function(e) 
    {
        e.preventDefault();
        if ($(this).valid()) {
            $(this).append('<div class="loading">');
            $.get("/modules/contact/send-visita-virtual.php?" + $(this).serialize()).done(function(data) {
                if (data == 'ok') {
                    $('#sendFriendFormTrips input[type=text], #sendFriendFormTrips textarea').val('');
                    $('#sendFriendFormTrips input[type=checkbox]').removeAttr('checked');
                    $('#sendFriendFormTrips .loading').remove();
                    swal('', okRecomen, 'success');
                    $('#online_viewing_trip').modal('hide');
                    gtag('event', 'evento', {'event_category': 'Online viewing', 'event_action': 'Online viewing', 'event_label': 'rec'});
                }else{
                    alert(data);
                    $('#sendFriendFormTrips .loading').remove();
                }
            });
        }
    });

    //  ================================================================
    //  /* @group ENVIAR A AMIGO */
    //  ================================================================

    $('#sendFriendForm').submit(function(e) {

        e.preventDefault();

        if ($(this).valid()) {

            $(this).append('<div class="loading">');

            $.get("/modules/property/send-friend.php?" + $(this).serialize()).done(function(data) {
                if (data == 'ok') {

                    $('#sendFriendForm input[type=text], #sendFriendForm textarea').val('');
                    $('#requestInfoForm input[type=checkbox]').removeAttr('checked');
                    $('#sendFriendForm .loading').remove();
                    swal('', okRecomen, 'success');
                    $('#friendPureModal').modal('hide');
                    gtag('event', 'evento', {'event_category': 'Contact Form', 'event_action': 'Contact', 'event_label': 'rec'});

                }
            });

        }

    });

    //  ================================================================
    //  /* @group ENVIAR FAVORITOS */
    //  ================================================================

    $('#sendFavoritesForm').submit(function(e) {

        e.preventDefault();

        if ($(this).valid()) {

            $(this).append('<div class="loading">');

            $.get("/modules/favorites/send-favs.php?" + $(this).serialize()).done(function(data) {
                if (data == 'ok') {

                    $('#sendFavoritesForm input[type=text], #sendFavoritesForm textarea').val('');
                    $('#sendFavoritesForm input[type=checkbox]').removeAttr('checked');
                    $('#sendFavoritesForm .loading').remove();
                    swal('', okPropert, 'success');
                    $('#favoritesPureModal').modal('hide');
                    gtag('event', 'evento', {'event_category': 'Contact Form', 'event_action': 'Contact', 'event_label': 'favs'});

                }

            });

        }

    });

    //  ================================================================
    //  /* @group CONTACTAR */
    //  ================================================================

    $('#contactForm2').submit(function(e) {

        e.preventDefault();

        if ($(this).valid()) {

            $(this).append('<div class="loading">');

            $.get("/modules/contact/send-quote.php?" + $(this).serialize()).done(function(data) {
                if (data == 'ok') {

                    $('#contactForm2 input[type=text], #contactForm2 textarea').val('');
                    $('#sendFavoritesForm input[type=checkbox]').removeAttr('checked');
                    $('#contactForm2 .loading').remove();
                    swal('', okConsult, 'success');
                    gtag('event', 'evento', {'event_category': 'Contact Form', 'event_action': 'Contact', 'event_label': 'contact'});

                }

            });

        }

    });

    //  ================================================================
    //  /* @group NEWSLETTER */
    //  ================================================================

    $('#newsletterForm2').submit(function(e) {

        e.preventDefault();

        if ($(this).valid()) {

            $(this).append('<div class="loading">');

            $.get("/modules/acumbamail/newsletter.php?" + $(this).serialize()).done(function(data) {

                if (data == 'ok') {

                    $('#newsletterForm2 input[type=text], #newsletterForm2 textarea').val('');
                    $('#newsletterForm2 input[type=checkbox]').removeAttr('checked');
                    $('#newsletterForm2 .loading').remove();
                    swal('', okNewslet, 'success');

                }

            });

        }

    });

    //  ================================================================
    //  /* @group BAJADA PRECIOS */
    //  ================================================================

    $('#bajadaPrecioForm').submit(function(e) {

        e.preventDefault();

        if ($(this).valid()) {

            $(this).append('<div class="loading">');

            $.get("/modules/property/bajada.php?" + $(this).serialize()).done(function(data) {

                if (data == 'ok') {

                    $('#bajadaPrecioForm input[type=text]').val('');
                    $('#bajadaPrecioForm input[type=checkbox]').removeAttr('checked');
                    $('#bajadaPrecioForm .loading').remove();
                    $('#bajadaModal').modal('toggle');
                    if (opcionSimilares == 0) {
                        swal('', bajPrecio, 'success');
                    } 
                    else 
                    {
                        $('#similarModalBajada').modal('toggle');
                        $('#similares-properties-bajada-modal .slides').resize();
                    }
                    gtag('event', 'evento', {'event_category': 'Contact Form', 'event_action': 'Contact', 'event_label': 'price'});

                }

            });

        }

    });

    //  ================================================================
    //  /* @group CAMBIO DATOS */
    //  ================================================================

    $('#solicitarCambioForm').submit(function(e) {

        e.preventDefault();

        if ($(this).valid()) {

            $(this).append('<div class="loading">');

            $.get("/modules/reporte/send.php?" + $(this).serialize()).done(function(data) {

                if (data == 'ok') {

                    $('#solicitarCambioForm input[type=textarea]').val('');
                    $('#solicitarCambioForm .loading').remove();
                    swal('', okConsult, 'success');
                    $('#solicitarCambio').modal('toggle');

                }

            });

        }

    });

    //  =====================================================================================================
    //  /* @group VENDER */
    //  =====================================================================================================

    $('#contactForm4').submit(function(e) {

        e.preventDefault();

        if ($(this).valid()) {

            $(this).append('<div class="loading">');

            $.get("/modules/vender/send-quote.php?" + $(this).serialize()).done(function(data) {
                if (data == 'ok') {

                    $('#contactForm4 input[type=text], #contactForm4 textarea').val('');
                    $('#contactForm4 select').prop('selectedIndex',0);
                    $('#contactForm4 input[type=checkbox]').removeAttr('checked');
                    $('#contactForm4 .loading').remove();
                    // $('#contactForm4').reset();
                    $('#image-list').html('');
                    swal('', okConsult, 'success');
                    gtag('event', 'evento', {'event_category': 'Contact Form', 'event_action': 'Contact', 'event_label': 'sell'});

                }

            });

        }

    });

    //  ================================================================
    //  /* @group DISPONIBILIDAD */
    //  ================================================================

        if ($("#calendar-disp"). length) {
            $('#calendar-disp').fullCalendar({
                header: {
                    left: 'prevYear prev',
                    center: 'title',
                    right: 'today next nextYear'
                },
                defaultView: 'month',
                yearColumns: 3,
                fixedWeekCount: 9,
                firstDay: 1,
                aspectRatio: 1.1,
                selectable: true,
                selectHelper: true,
                editable: false,
                theme: false,
                events: "/modules/property/disp-json.php?p=" + idprop
            });
        }
    $("a[href='#pane-calendar']").on('shown.bs.tab', function(){
    });

    // $(document).on('shown.bs.collapse', function(){
    //     $('#calendar-disp').fullCalendar({
    //         header: {
    //             left: 'prevYear prev',
    //             center: 'title',
    //             right: 'today next nextYear'
    //         },
    //         defaultView: 'month',
    //         yearColumns: 3,
    //         fixedWeekCount: 9,
    //         firstDay: 1,
    //         aspectRatio: 1.1,
    //         selectable: true,
    //         selectHelper: true,
    //         editable: false,
    //         theme: false,
    //         events: "/modules/property/disp-json.php?p=" + idprop
    //     });
    // });

    $('#pn-content').on('shown.bs.collapse', function(e){
        if (e.target.id == 'collapse-calendar') {
            $('#calendar-disp').fullCalendar({
                header: {
                    left: 'prevYear prev',
                    center: 'title',
                    right: 'today next nextYear'
                },
                defaultView: 'month',
                yearColumns: 3,
                fixedWeekCount: 9,
                firstDay: 1,
                aspectRatio: 1.1,
                selectable: true,
                selectHelper: true,
                editable: false,
                theme: false,
                events: "/modules/property/disp-json.php?p=" + idprop
            });
        }
        id = '#' + e.target.id;
        var aid = $('a[data-target="' + id + '"]').attr("href");
        $('html,body').animate({scrollTop: $(aid).offset().top-60}, 'fast');
    });

    //  ================================================================
    //  /* @group INMUEBLES FAVORITOS */
    //  ================================================================

    function actualizaFavs(totalFavs){
        if(totalFavs>0) {
            $(".favoritosbtn").addClass("fav-strong");
            $(".budget-fav").text("("+totalFavs+")");
            // $("#sidr-id-budget-fav").text("("+totalFavs+")");
        }
        else {
            $(".favoritosbtn").removeClass("fav-strong");
            $(".budget-fav").text("");
            // $("#sidr-id-budget-fav").text("");
        }
    }


    $('.add-fav').click(function(e) {
        e.preventDefault();
        var btn = $(this);
        $.get(btn.data('href'), function(data) {
            btn.addClass('fav-hide');
            btn.parent().find('.rem-fav').removeClass('fav-hide');
            actualizaFavs(data);
        });
        return false;
    });

    $('.rem-fav').click(function(e) {
        e.preventDefault();
        var btn = $(this);
        $.get(btn.data('href'), function(data) {
            btn.addClass('fav-hide');
            btn.parent().find('.add-fav').removeClass('fav-hide');
            actualizaFavs(data);
        });
        // window.setTimeout('location.reload()', 500);
        return false;
    });

    $('.rem-fav2').click(function() {
        var btn = $(this);
        $.get(btn.data('href'), function(data) {
            btn.addClass('hide');
            btn.parent().find('.add-fav').removeClass('hide');
        });
        window.setTimeout('location.reload()', 500);
        return false;
    });

    $('.btn-rem-all-favs').click(function(e) {
        e.preventDefault();
        swal({
            title: '',
            text: delallfavs,
            type: 'warning',
            dangerMode: true,
             buttons: true,
        }).then((willDelete) => {
          if (willDelete) {
            window.location = $('.btn-rem-all-favs').attr('href');
          } else {
            return false;
          }
        });
    });

    $('.add-fav-rs').click(function() {
        var btn = $(this);
        $.get(btn.data('href'), function(data) {
            btn.addClass('fav-hide');
            btn.parent().find('.rem-fav-rs').removeClass('fav-hide');
            actualizaFavs(data);
        });
        return false;
    });

    $('.rem-fav-rs').click(function() {
        var btn = $(this);
        $.get(btn.data('href'), function(data) {
            btn.addClass('fav-hide');
            btn.parent().find('.add-fav-rs').removeClass('fav-hide');
            actualizaFavs(data);
        });
        // window.setTimeout('location.reload()', 500);
        return false;
    });

    //  ================================================================
    //  /* @group PUPUP INMUEBLES */
    //  ================================================================

    if ($('.gallProp').length) 
    {

        $('.gallProp').swipebox( {
            useCSS : true,
            useSVG : true,
            initialIndexOnArray : 0,
            hideCloseButtonOnMobile : false,
            hideBarsDelay : 0,
            videoMaxWidth : 1140,
            afterOpen: null,
            loopAtEnd: true
        });
    }

    //  ================================================================
    //  /* @group PUPUP INMUEBLES PLANOS */
    //  ================================================================

    if ($('.gallPropPlans').length) {
        $('.gallPropPlans').swipebox( {
            useCSS : true,
            useSVG : true,
            initialIndexOnArray : 0,
            hideCloseButtonOnMobile : false,
            hideBarsDelay : 0,
            videoMaxWidth : 1140,
            afterOpen: null,
            loopAtEnd: true
        });
    }

    //  ================================================================
    //  /* @group PUPUP NOTICIAS */
    //  ================================================================

    if ($('.gallNews').length) {
        $('.gallNews').swipebox( {
            useCSS : true,
            useSVG : true,
            initialIndexOnArray : 0,
            hideCloseButtonOnMobile : false,
            hideBarsDelay : 0,
            videoMaxWidth : 1140,
            afterOpen: null,
            loopAtEnd: true
        });
    }

    //  ================================================================
    //  /* @group SELECT2 */
    //  ================================================================

    $(".select2").select2({ width: '100%' });

    //  ================================================================
    //  /* @group MENU RESPONSIVO */
    //  ================================================================

    // $('.responsive-menu-button').sidr({
    //     name: 'sidr-main',
    //     side: 'right',
    //     source: '#main-nav',
    //     displace: false
    // });

    // $('.sidr-class-responsive-menu-button').click(function(event) {
    //     $.sidr('close', 'sidr-main');
    // });

    $('.responsive-search-button').click(function(event) {
        $('.buscador').toggle();
    });



});

//  ================================================================
//  /* @group CHARTS */
//  ================================================================

function showChart(container, title, series) {
    chart = $(container).highcharts('StockChart',{
    chart: {
            defaultSeriesType: 'line',
            borderwidth: 0,
          },
    xAxis: {
         type: 'datetime',
         dateTimeLabelFormats: {
         day: '%e. %b %y',
         month: '%e. %b %y',
         year: '%e. %b %y'
         }
      },
      yAxis: {
          title: {
              text: title
          },
          min: 0,
         plotLines: [{
            value: 0,
            width: 1,
            color: '#8CC899'
         }]
      },
    exporting: {
             enabled: false
    },
    credits: {
          enabled: false
      },

    rangeSelector : {
            buttons : [{
              type : 'day',
              count : 31,
              text : '1M'
            },{
              type : 'day',
              count : 90,
              text : '3M'
            },{
              type : 'day',
              count : 180,
              text : '6M'
            }, {
              type : 'all',
              count : 1,
              text : todotxt
            }],
            selected : 1,
            inputEnabled : false
          },
    series: [series]
    });
}

//  ================================================================
//  /* @group MAPA PROPIEDAD */
//  ================================================================

function showMapProperty(container, latLng, zoom) {
    var map = L.map(container).setView(latLng, zoom);
    map.scrollWheelZoom.disable();
    map.addLayer(new L.TileLayer('https://mt0.google.com/vt/lyrs=m&hl=en&x={x}&y={y}&z={z}', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
            '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, '
    }));
    var customIcon = L.icon({
        iconUrl: 'https://unpkg.com/leaflet@1.4.0/dist/images/marker-icon.png',
        iconSize:     [25, 41],
        iconAnchor:   [28, 41],
        popupAnchor:  [-12, -42]
    });
    var marker = L.marker(latLng, { icon: customIcon }).addTo(map);
}

//  ================================================================
//  /* @group MAPA PROPIEDADES */
//  ================================================================

function showMapProperties(container, locations) {

    var map = L.map(container).setView([38.3847,-0.680823], 8);
    map.scrollWheelZoom.disable();
    map.addLayer(new L.TileLayer('https://mt0.google.com/vt/lyrs=m&hl=en&x={x}&y={y}&z={z}', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
            '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, '
    }));
    var customIcon = L.icon({
        iconUrl: 'https://unpkg.com/leaflet@1.4.0/dist/images/marker-icon.png',
        iconSize:     [25, 41],
        iconAnchor:   [28, 41],
        popupAnchor:  [-12, -42]
    });
    var markers = new L.MarkerClusterGroup({
            showCoverageOnHover: false,
            zoomToBoundsOnClick: true,
            spiderfyOnMaxZoom: true
        });
    var markersList = [];
    for (var i = 0; i <= markersLocations.length -1; i++) {
        var marker = L.marker(markersLocations[i][0], { icon: customIcon });
        marker.bindPopup('<div style="width: 200px; max-width: 200px;"><div class="row"><div class="col-12">'+markersLocations[i][1]+'</div></div><div class="row" style="margin-top: 10px;"><div class="col-12"><h4 style="font-size: 12px !important; margin-bottom: 5px !important;">'+markersLocations[i][2]+'</h4>'+markersLocations[i][3]+'</strong><br/><span class="prices" style="margin: 5px 0 10px; display: block; font-weight: 600; color: var(--primary);">'+markersLocations[i][4]+'</strong></span><a href="'+markersLocations[i][5]+'}" class="btn btn-primary btn-sm btn-block" style="color:#fff">'+markersLocations[i][6]+'</a></div></div></div>');

        markersList.push(marker);
        markers.addLayer(marker);
    }
    map.addLayer(markers);
}

//  ================================================================
//  /* @group MAPAS ZONAS */
//  ================================================================

function showMapZones(container, latLng, zoom) {
    var map = L.map(container).setView(latLng, zoom);
    map.scrollWheelZoom.disable();
    map.addLayer(new L.TileLayer('https://mt0.google.com/vt/lyrs=m&hl=en&x={x}&y={y}&z={z}', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
            '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, '
    }));
}

//  ================================================================
//  /* @group OTROS */
//  ================================================================

function formatnumber(n) {
    return Math.round(n * 100) / 100;
}

//  ================================================================
//  /* @group COOKIES */
//  ================================================================

var options = {
    title: cookieTxt,
    message: cookieTxt2,
    moreInfoLabel: cookieTxt3,
    acceptBtnLabel: cookieTxt4,
    advancedBtnLabel: cookieTxt5,
    cookieTypesTitle: cookieTxt6,
    fixedCookieTypeLabel: cookieTxt7,
    fixedCookieTypeDesc: cookieTxt8,
    denyBtnLabel: cookieTxt9,
    link: '/cookies',
    onAccept: function() {
        if ($.fn.ihavecookies.preference('analytics') === true) {
            // gtag('js', new Date());
            // gtag('config', 'UA-00000-1');
        }
        if ($.fn.ihavecookies.preference('preferences') === true) {
        }
        if ($.fn.ihavecookies.preference('marketing') === true) {
        }
    }
}

$('body').ihavecookies(options);

//  ================================================================
//  /* @group FIX BUG PARALLAX IE 10/11 */
//  ================================================================

if(navigator.userAgent.match(/MSIE 10/i) || navigator.userAgent.match(/Trident\/7\./)) {
    $('body').on("mousewheel", function () {
        event.preventDefault();
        var wd = event.wheelDelta;
        var csp = window.pageYOffset;
        if(typeof event.wheelDelta == "undefined") { wd = event.deltaY; }
        window.scrollTo(0, csp - wd);
    });
}


function getlink()
{
    var aux = document.createElement("input");
    aux.setAttribute("value", window.location.href.split("?")[0].split("#")[0]);
    document.body.appendChild(aux);
    aux.select();
    document.execCommand("copy");
    document.body.removeChild(aux);
    var aviso = document.createElement("div");
    aviso.setAttribute("id", "aviso");
    var contenido = document.createTextNode(copiado);
    aviso.appendChild(contenido);
    document.body.appendChild(aviso);
    window.load = setTimeout("document.body.removeChild(aviso)", 4000);
}

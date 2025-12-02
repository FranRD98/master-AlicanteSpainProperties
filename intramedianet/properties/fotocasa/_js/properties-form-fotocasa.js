$(document).ready(function() {
    //////////////////////
    // Utilidades FOTOCASA
    //////////////////////
    // Si cambia el checkbox de fotocasa muestra el formulario
    $('#export_fotocasa_prop').change(function(e) {
      e.preventDefault();
      if ($(this).is(':checked') == true) {
        $('#basicFotocasa').fadeIn('slow');
        var $val1 = $('#fotocasaPropertyStatusId').val();
        var $val2 = $('#fotocasaTransactionTypeId').val();
        var $val3 = $('#fotocasaTypeId').val();
        if ( $val1 != "" && $val2 != "" && $val3 != "" ) {
          $('#featuresFotocasa').fadeIn('slow');
        }
      } else{
        $('#basicFotocasa, #featuresFotocasa').fadeOut('slow');
      }
    });

    // Si cambia IsPromotion muestra PromotionType
    $('#fotocasa_IsPromotion').change(function(e) {
      e.preventDefault();
      if ($(this).is(':checked') == true) {
        $('#fotocasaPromotionType').fadeIn('slow');
      } else{
        $('#fotocasaPromotionType').fadeOut('slow');
      }
    });

    // Si cambia el Status muestra el Motivo de expiración
    $('#fotocasaPropertyStatusId, #fotocasaTransactionTypeId, #fotocasaTypeId').change(function(e) {
      var $val1 = $('#fotocasaPropertyStatusId').val();
      var $val2 = $('#fotocasaTransactionTypeId').val();
      var $val3 = $('#fotocasaTypeId').val();
      if ( $val1 != "" && $val2 != "" && $val3 != "" ) {
        $('#featuresFotocasa').fadeIn('slow');
      } else{
        $('#featuresFotocasa').fadeOut('slow');
      }
    });

    // Si cambia el Status muestra el Motivo de expiración
    $('#fotocasaPropertyStatusId').change(function(e) {
      e.preventDefault();
      if ($(this).val() != "" && ($(this).val() == 4 ) ) {
        $('#fotocasaExpiracion').fadeIn('slow');
      } else{
        $('#fotocasaExpiracion').fadeOut('slow');
      }
    });

    // Si cambia el select de Tipo de Transacción ocultamos los campos que dependan de esto
    $('#fotocasaTransactionTypeId').on('change.select2',function(e) {
        $typeVal = $(this).val();
        if ($typeVal != "" && ($typeVal != 1 && $typeVal != 4) ) {
          $('#fotocasaPaymentPeriodicityId').fadeIn('slow');
        } else{
          $('#fotocasaPaymentPeriodicityId').fadeOut('slow');
        }
        $.each($('div[data-show]'), function( key, value ) {
            if( $(value).data("show")["TransactionTypeId"] ){
                $(value).fadeOut('slow');
                if( $(value).data("show")["TypeId"] ) {
                    if( $.inArray(parseInt($('#fotocasaTypeId').val()), $(value).data("show")["TypeId"]) < 0 ){
                        return true;
                    }
                }
                if( $.inArray(parseInt($typeVal), $(value).data("show")["TransactionTypeId"]) >= 0) {
                    $(value).fadeIn('slow');
                }
            }
        });
    });

    // Si cambia el select de Tipo de Propiedad, mostrar el subtipo y ocultamos los campos que dependan de esto
    $('#fotocasaTypeId').on('change.select2',function(e) {
        $typeVal = $(this).val();
        if ( $typeVal != "" ) {
          $('#fotocasaSubType').fadeIn('slow');
        } else{
          $('#fotocasaSubType').fadeOut('slow');
        }
        if($('div[data-show]')){
            $.each($('div[data-show]'), function( key, value ) {
                if( $(value).data("show")["TypeId"] ){
                    $(value).fadeOut('slow');
                    if( $.inArray(parseInt($typeVal), $(value).data("show")["TypeId"]) >= 0) {
                        if( $(value).data("show")["TransactionTypeId"] ) {
                            if( $.inArray(parseInt($('#fotocasaTransactionTypeId').val()), $(value).data("show")["TransactionTypeId"]) < 0 ){
                                return true;
                            }
                        }
                        $(value).fadeIn('slow');
                    }
                }
            });
        }

        var $subTypes = fotocasaSubTypes[$typeVal];
        var $el = $("#fotocasaSubTypeId");
            $el.empty();
            $el.append($("<option></option>").attr("value", "").text(selectOne));
        $.each( $subTypes, function( key, value ) {
            $el.append($("<option></option>").attr("value", key).text(value));
        });
    });

});

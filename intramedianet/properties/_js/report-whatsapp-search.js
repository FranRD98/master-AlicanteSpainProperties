$(document).ready(function() {

        var oTable, asInitVals = [];

        function fnResetAllFilters() {
            var oSettings = oTable.fnSettings();
            for(iCol = 0; iCol < oSettings.aoPreSearchCols.length; iCol++) {
                oSettings.aoPreSearchCols[ iCol ].sSearch = '';
            }
            oTable.fnDraw();
        }

        oTable = $('#records-tables').dataTable({
            "sAjaxSource": "whatsapp-data.php",
            "bSortCellsTop": true,
            "bDestroy": true,
             "aaSorting": [[ 5, "DESC" ]],
             "fnInitComplete": function() {
                 toggleScrollBarIcon();
             },
            "aoColumns": [
                null,
                null,
                null,
                null,
                null,
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "sClass": "actions",
                    "mRender": function (data, type, full) {
                            var convertClientText = ConvertClient;
                            var convertPropietarioText = ConvertPropietario;
                            var dataSplit = data.split(',');
                            var idBajClient = dataSplit[0];
                            var nameBajClient = full[0];
                            var langBajClient = full[6];
                            var phoneBajClient = full[1];
                            var dateBajClient = full[4];
                            // var mailBajClient = full[1];
                            var notaBajClient = $(full[2]).text();
                            var existClient = full[7];
                            var existOwner = full[8];
                            var colorBtn = 'text-success';
                            if(existClient > 0){
                                convertClientText = calClientex;
                                colorBtn = 'text-muted';
                            }
                            var colorBtnOwn = 'text-success';
                            if(existOwner > 0){
                                convertClientText = calClientex;
                                colorBtnOwn = 'text-muted';
                            }

                            btns = '<div class="dropdown d-inline-block w-100">';
                                btns += '<button class="btn btn-soft-primary btn-sm dropdown w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
                                    btns += '<i class="fa-regular fa-ellipsis align-middle"></i>';
                                btns += '</button>';
                                btns += '<ul class="dropdown-menu dropdown-menu-end">';

                                if(existClient > 0) {
                                btns += '<li><a href="/intramedianet/properties/clients-form.php?id_cli=' + existClient + '" class="dropdown-item edit-item-btn ' + colorBtn + '"><i class="fa-regular fa-user align-bottom me-1"></i> ' + convertClientText + '</a></li>';
                                } else {
                                    btns += '<li><a href="/intramedianet/properties/add_client_from_consulta.php?c=' + idBajClient + '" class="dropdown-item edit-item-btn ' + colorBtn + '"><i class="fa-regular fa-user-plus align-bottom me-1"></i> ' + convertClientText + '</a></li>';
                                }

                                if(existOwner > 0) {
                                    btns += '<li><a href="/intramedianet/properties/owners-form.php?id_pro=' + existOwner + '" class="dropdown-item edit-item-btn ' + colorBtnOwn + '"><i class="fa-regular fa-user align-bottom me-1"></i> ' + convertPropietarioText + '</a></li>';
                                } else {
                                    btns += '<li><a href="javascript:void(0);" class="dropdown-item edit-item-btn ' + colorBtnOwn + ' btn-modal-convertir-propietario" data-client-id="' + idBajClient + '" data-client-name="' + nameBajClient + '" data-client-lang="' + langBajClient + '" data-client-phone=\'' + phoneBajClient + '\' data-client-nota="' + notaBajClient + '" data-client-date="' + dateBajClient + '"><i class="fa-regular fa-user-plus align-bottom me-1"></i> ' + convertPropietarioText + '</a></li>';
                                }

                                if (canDel == 1) {
                                    btns += '<li><hr class="dropdown-divider"></li>';
                                    btns += '<li><a href="/intramedianet/properties/remove_client_from_whatsapp.php?c=' + full[5] + '" class="dropdown-item remove-item-btn text-danger delrow"><i class="fa-regular fa-trash-can me-1"></i> ' + dtEliminar + '</a></li>';
                                }

                                btns += '</ul>';
                            btns += '</div>';
                            return  btns;
                        }
                }
            ]
        });

    $("#records-tables_length").appendTo(".panel-heading");

$('.btn-reset').click(function() {
    $(".select2").val('').change();
    $('#desde, #hasta').val('').change();
    $(".select2references").val('').keyUp();

    getProps();
});

$(".select2, .select2references").change(function(e) {

    getProps();

});

$('#desde, #hasta, #tipo').change(function(e) {

      getProps();

  });

    });

function getProps() {

  // $('#records-tables').dataTable().fnDraw();
  oTable = $('#records-tables').dataTable();
  oTable.fnReloadAjax("consultas-data.php?"+ $('#filtermails').serialize());

}


$.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource, fnCallback, bStandingRedraw )
{
    if ( sNewSource !== undefined && sNewSource !== null ) {
        oSettings.sAjaxSource = sNewSource;
    }

    // Server-side processing should just call fnDraw
    if ( oSettings.oFeatures.bServerSide ) {
        this.fnDraw();
        return;
    }

    this.oApi._fnProcessingDisplay( oSettings, true );
    var that = this;
    var iStart = oSettings._iDisplayStart;
    var aData = [];

    this.oApi._fnServerParams( oSettings, aData );

    oSettings.fnServerData.call( oSettings.oInstance, oSettings.sAjaxSource, aData, function(json) {
        /* Clear the old information from the table */
        that.oApi._fnClearTable( oSettings );

        /* Got the data - add it to the table */
        var aData =  (oSettings.sAjaxDataProp !== "") ?
            that.oApi._fnGetObjectDataFn( oSettings.sAjaxDataProp )( json ) : json;

        for ( var i=0 ; i<aData.length ; i++ )
        {
            that.oApi._fnAddData( oSettings, aData[i] );
        }

        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();

        that.fnDraw();


        if ( bStandingRedraw === true )
        {
            oSettings._iDisplayStart = iStart;
            that.oApi._fnCalculateEnd( oSettings );
            that.fnDraw( false );
        }

        that.oApi._fnProcessingDisplay( oSettings, false );

        /* Callback user function - for event handlers etc */
        if ( typeof fnCallback == 'function' && fnCallback !== null )
        {
            fnCallback( oSettings );
        }



    }, oSettings );
};

$(document).on('click', '.btn-modal-convertir-propietario', function (e) {
    e.preventDefault();
    tb = $(this);
    $('#myModal .btn-convertir-cliente').attr('href', "/intramedianet/properties/add_client_from_consulta.php?c=" + tb.attr("data-client-id"))
    $('#myModal #nombre_pro').val(tb.attr("data-client-name"));
    $('#myModal #idioma_pro option[value="' + tb.attr("data-client-lang") + '"]').attr('selected', 'selected');
    $('#myModal #telefono_fijo_pro').val(tb.attr("data-client-phone"));
    $('#myModal #email_pro').val(tb.attr("data-client-mail"));

    var notaDate = tb.attr("data-client-date");
    $('#myModal #historial_pro').val("[ " + notaDate + " ] [ " + tb.attr("data-client-name") + " ] → " + tb.attr("data-client-nota") + " \n\n" + $('#historial_pro').val());

    $('#myModal').modal('show');
});

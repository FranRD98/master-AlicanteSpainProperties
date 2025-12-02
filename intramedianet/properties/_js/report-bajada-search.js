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
            "sAjaxSource": "bajada-data.php",
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
                null,
                {
                    "bSearchable": false,
                    "bSortable": false,
                    "sClass": "actions",
                    "mRender": function (data, type, full) {
                            var convertClientText = ConvertClient;
                            var dataSplit = data.split(',');
                            var idBajClient = dataSplit[0];
                            var existClient = dataSplit[1];
                            var colorBtn = 'btn-success';
                            if(existClient == '1'){
                                convertClientText = calClientex;
                                colorBtn = 'btn-info';
                            }

                            btns  = '<a href="/intramedianet/properties/add_client_from_bajada.php?c=' + idBajClient + '" target="_blank" class="btn '+ colorBtn +' btn-sm">'+convertClientText+'</a> ';
                            btns  += '<a href="/intramedianet/properties/del-bajada.php?id=' + data + '" class="btn btn-danger btn-sm del-bajada2"><i class="fa-regular fa-trash-can me-1"></i> '+ dtEliminar +'</a> ';
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
  oTable.fnReloadAjax("bajada-data.php?"+ $('#filtermails').serialize());

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

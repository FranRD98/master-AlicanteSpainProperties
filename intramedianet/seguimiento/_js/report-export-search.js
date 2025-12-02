$(document).ready(function() {

        var oTable, asInitVals = [];

        function fnResetAllFilters() {
            var oSettings = oTable.fnSettings();
            for(iCol = 0; iCol < oSettings.aoPreSearchCols.length; iCol++) {
                oSettings.aoPreSearchCols[ iCol ].sSearch = '';
            }
            oTable.fnDraw();
        }

        columnas = [];

        columnas.push(null);
        columnas.push(null);

        columnas.push({"sName": "activado_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=activado_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=activado_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});

        if (showKyero == 1) {
            columnas.push({"sName": "export_kyero_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=export_kyero_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=export_kyero_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        if (showIdealista == 1) {
            columnas.push({"sName": "idealista_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=idealista_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=idealista_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        if (showRightmove == 1) {
            columnas.push({"sName": "export_rightmove_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=export_rightmove_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=export_rightmove_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        if (showZoopla == 1) {
            columnas.push({"sName": "export_zoopla_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=export_zoopla_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=export_zoopla_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        if (showThinkSpain == 1) {
            columnas.push({"sName": "export_thinkspain_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=export_thinkspain_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=export_thinkspain_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        if (showHemnet == 1) {
            columnas.push({"sName": "export_hemnet_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=export_hemnet_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=export_hemnet_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        if (showUbiflow == 1) {
            columnas.push({"sName": "export_ubiflow_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=export_ubiflow_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=export_ubiflow_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        if (showGreenAcres == 1) {
            columnas.push({"sName": "export_green_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=export_green_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=export_green_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        if (showPrian == 1) {
            columnas.push({"sName": "export_prian_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=export_prian_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=export_prian_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        if (showHabitaclia == 1) {
            columnas.push({"sName": "export_habitaclia_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=export_habitaclia_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=export_habitaclia_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        if (showPisos == 1) {
            columnas.push({"sName": "export_pisos_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=export_pisos_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=export_pisos_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        if (showFacilisimo == 1) {
            columnas.push({"sName": "export_facilisimo_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=export_facilisimo_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=export_facilisimo_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        if (showFotocasa == 1) {
            columnas.push({"sName": "export_fotocasa_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=export_fotocasa_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=export_fotocasa_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        if (showTodoPisoAlicante == 1) {
            columnas.push({"sName": "export_todopisoalicante_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=export_todopisoalicante_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=export_todopisoalicante_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        if (showYaencontre == 1) {
            columnas.push({"sName": "export_yaencontre_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=export_yaencontre_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=export_yaencontre_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        if (showAPITS == 1) {
            columnas.push({"sName": "expport_APITS_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=expport_APITS_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=expport_APITS_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        if (showCostadelHome == 1) {
            columnas.push({"sName": "expport_CostadelHome_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=expport_CostadelHome_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=expport_CostadelHome_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        if (showSpainHouses == 1) {
            columnas.push({"sName": "expport_SpainHomes_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=expport_SpainHomes_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=expport_SpainHomes_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        if (showMimove == 1) {
            columnas.push({"sName": "export_mimove_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=export_mimove_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=export_mimove_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        if (showInmoco == 1) {
            columnas.push({"sName": "export_inmoco_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=export_inmoco_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=export_inmoco_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        if (showMediaelx == 1) {
            columnas.push({"sName": "export_mediaelx_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=export_mediaelx_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=export_mediaelx_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        if (showFacebook == 1) {
            columnas.push({"sName": "export_facebook_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=export_facebook_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=export_facebook_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        if (showMLSMediaelx == 1) {
            columnas.push({"sName": "export_mlsmediaelx_prop","bSearchable": true,"bSortable": true,"sClass": "ticks","render": function ( data, type, row ) {if (data == non) {return '<a href="../properties/properties-change.php?s=export_mlsmediaelx_prop&v=1&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div></a>';} else{return '<a href="../properties/properties-change.php?s=export_mlsmediaelx_prop&v=0&id_prop=' +  row[totalFLDS] + '" class="update-status" data-toggle="tooltip" data-placement="bottom" title="' + titleExtraAction + '"><div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div></a>';}}});
        }

        // alert(columnas.join());

        if (showIdealista == 0 && showRightmove == 0) {}

        if (showIdealista == 1 && showRightmove == 0) {}

        if (showIdealista == 0 && showRightmove == 1) {}

        if (showIdealista == 1 && showRightmove == 1) {}

        oTable = $('#records-tables').dataTable({
            "sAjaxSource": "exported-data.php",
            "bSortCellsTop": true,
            "bDestroy": true,
             "aaSorting": [[ 1, "ASC" ]],
             "fnInitComplete": function() {
                 toggleScrollBarIcon();
                 $('[data-toggle="tooltip"]').tooltip();
             },
             "aoColumns": columnas


        });

    $("#records-tables_length").appendTo(".panel-heading");

$('.btn-reset').click(function() {
    $(".select2").val('').change();
    $('#search-fields select').val('').change();
    $(".select2references").val('').change();

    getProps();
});

$(".select2, .select2references").change(function(e) {

    getProps();

});

$("#search-fields select").change(function() {

    getProps();

});



    });

function getProps() {

  oTable = $('#records-tables').dataTable();
  oTable.fnReloadAjax("exported-data.php?"+ $('#search-fields :input').serialize());

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

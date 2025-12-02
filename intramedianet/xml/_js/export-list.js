$(document).ready(function() {

    var oTable, asInitVals = [];

    $("thead input").keyup( function () {
        oTable.fnFilter( this.value, oTable.oApi._fnVisibleToColumnIndex(
            oTable.fnSettings(), $("thead input").index(this) ) );
    });

    $("thead input").each( function (i) {
        asInitVals[i] = this.value;
    });

    $("thead input").blur( function (i) {
        if ( this.value == "" )
        {
            this.value = asInitVals[$("thead input").index(this)];
        }
    });

    $("thead .search-clear").click( function (i) {
        $("thead input").val('');
        fnResetAllFilters()
    });

    function fnResetAllFilters() {
        var oSettings = oTable.fnSettings();
        for(iCol = 0; iCol < oSettings.aoPreSearchCols.length; iCol++) {
            oSettings.aoPreSearchCols[ iCol ].sSearch = '';
        }
        oTable.fnDraw();
    }

    oTable = $('#records-tables').dataTable({
        "sAjaxSource": "exportar-data.php",
        "bSortCellsTop": true,
        "fnInitComplete": function() {
            var oSettings = $('#records-tables').dataTable().fnSettings();
            for ( var i=0 ; i<oSettings.aoPreSearchCols.length ; i++ ){
                if(oSettings.aoPreSearchCols[i].sSearch.length>0){
                    $("thead input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                }
            }
            toggleScrollBarIcon();
        },
        "aoColumns": [
            {
                "mRender": function (data, type, full) {
                    return '' + data + '<span class="badge text-bg-primary float-end">' + getTotPropsXML(full[2]) + '</span>';
                }
            },
            {
                "mRender": function (data, type, full) {
                    $urlXML = '<span class="badge bg-primary text-bg-primary">kyero: </span> &nbsp;<a href="https://' + httpHost + '/xml/kyero.php?f=' + data + '" class="btn btn-soft-primary btn-sm mb-1" target="_blank">https://' + httpHost + '/xml/kyero.php?f=' + data + '</a><br>';
                    $urlXML += '<span class="badge bg-primary text-bg-primary">kyero: </span> &nbsp;<a href="https://' + httpHost + '/xml/kyero_all_languages.php?f=' + data + '" class="btn btn-soft-primary btn-sm mb-1" target="_blank">https://' + httpHost + '/xml/kyero_all_languages.php?f=' + data + '</a><br>';
                    $urlXML += '<span class="badge bg-primary text-bg-primary">XML-Mediaelx: </span>  &nbsp;<a href="https://' + httpHost + '/xml/xml-mediaelx.php?f=' + data + '" class="btn btn-success btn-sm" target="_blank">https://' + httpHost + '/xml/xml-mediaelx.php?f=' + data + '</a>';
                    return $urlXML;
                }
            },
            {
                "bSearchable": false,
                "bSortable": false,
                "sClass": "actions",
                "mRender": function (data, type, full) {
                        btns = '<div class="dropdown d-inline-block w-100">';
                            btns += '<button class="btn btn-soft-primary btn-sm dropdown w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
                                btns += '<i class="fa-regular fa-ellipsis align-middle"></i>';
                            btns += '</button>';
                            btns += '<ul class="dropdown-menu dropdown-menu-end">';
                                btns += '<li><a href="exportar-form.php?id_exp=' + data + '&amp;KT_back=1" class="dropdown-item edit-item-btn"><i class="fa-regular fa-pencil align-bottom me-1"></i> ' + dtEditar + '</a></li>';
                                if (canDel == 1) {
                                    btns += '<li><hr class="dropdown-divider"></li>';
                                    btns += '<li><a href="exportar-form.php?id_exp=' + data + '&amp;KT_back=1&amp;KT_Delete1=1" class="dropdown-item remove-item-btn text-danger delrow"><i class="fa-regular fa-trash-can me-1"></i> ' + dtEliminar + '</a></li>';
                                }
                            btns += '</ul>';
                        btns += '</div>';
                        return  btns;
                    }
            }
        ]
    });

    $("#records-tables_length").appendTo("th#actions");

});

function getTotPropsXML(value) {
    $.ajax({
      type: "GET",
      url: "/intramedianet/properties/ids-kyero-tot.php?id="+value+'',
      async: false,
      cache: false
    }).done(function( data ) {
        returndata = data;
    });
    return returndata;
}

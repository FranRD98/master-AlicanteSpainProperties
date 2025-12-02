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
        toggleScrollBarIcon();
    }

    oTable = $('#records-tables').dataTable({
        "sAjaxSource": "clients-data.php",
        dom: "lC " +
             // "<'row'<'col-sm-12' f>>" +
             "<'row'<'col-sm-12 table-responsive'tr>>" +
             "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "bSortCellsTop": true,
        "order": [[ 1, 'ASC' ]],
        "oColVis": {
            "aiExclude": [ numCols ],
            "buttonText": "<i class=\"fa fa-table\"></i>",
            "sAlign": "right",
            "fnStateChange": function ( iColumn, bVisible ) {
                toggleScrollBarIcon();
            }
        },
        "fnInitComplete": function() {
            var oSettings = $('#records-tables').dataTable().fnSettings();
            for ( var i=0 ; i<oSettings.aoPreSearchCols.length ; i++ ){
                if(oSettings.aoPreSearchCols[i].sSearch.length>0){
                    $("thead input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                }
            }
            toggleScrollBarIcon();
        },
        "columnDefs": [
            {
                "render": function ( data, type, row ) {
                    btns  = data + '<a href="/intramedianet/properties/clients-form.php?id_cli=' + row[5] + '&amp;KT_back=1" class="btn btn-success btn-sm d-md-none"><i class="fa fa-pencil"></i> ' + dtEditar + '</a> ';
                    if (canDel == 1) {
                    }
                    return  btns;
                },
                "targets": 0
            },
            {
                "render": function ( data, type, row ) {
                    btns  = '<a href="/intramedianet/properties/clients-form.php?id_cli=' + data + '&amp;KT_back=1" class="btn btn-success btn-sm w-100"><i class="fa fa-pencil"></i></a> ';
                    if (canDel == 1) {
                    }
                    return  btns;
                },
                "targets": 5,
                "orderable": false,
                "className": "actions"
            }
        ]
    });

    $("#records-tables_length").appendTo("#col-1");
    // $(".ColVis").appendTo("#col-2");
    // $("#marca").appendTo("#records-tables_filter");

});


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


        $('.popoverbtn').hover(function() {
          $(this).popover('show');
        }, function() {
          $(this).popover('hide');
        });


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

 $(document).ready(function() {

    $('#atendido_cli_sel').change(function(e) {

        $('#atendido_cli').val($(this).val()).trigger('keyup');

    });

      $('.downcsv').click(function() {
          window.open('clients-download-csv.php?'+ $('#form1').serialize(),'Descargar');
      });

      $('.downoutlook').click(function() {
          window.open('clients-download-outlook.php?'+ $('#form1').serialize(),'Descargar');
      });

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
            $('select').prop('selectedIndex',0);
            oTable.fnDraw();
        }

        oTable = $('#records-tables').dataTable({
            "sAjaxSource": "clients-data-adv.php",
            dom: "lC" +
                 "<'row'<'col-sm-12 table-responsive'tr>>" +
                 "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "bSortCellsTop": true,
            "oColVis": {
                "aiExclude": [ numCols ],
                "buttonText": "<i class=\"fa fa-table\"></i>",
                "sAlign": "right",
                "fnStateChange": function ( iColumn, bVisible ) {
                    toggleScrollBarIcon();
                }
            },
             "aaSorting": [[ 3, "DESC" ]],
                "fnInitComplete": function() {
                    var oSettings = $('#records-tables').dataTable().fnSettings();
                    for ( var i=0 ; i<oSettings.aoPreSearchCols.length ; i++ ){
                        if(oSettings.aoPreSearchCols[i].sSearch.length>0){
                            $("thead input")[i].value = oSettings.aoPreSearchCols[i].sSearch;
                        }
                    }
                    toggleScrollBarIcon();
                    if ($('#atendido_cli').val() != '') {

                        $('#atendido_cli_sel').val($('#atendido_cli').val() );

                    }
                },
              "columnDefs": [
                {
                    "render": function ( data, type, row ) {
                        if (data == non) {
                            btns  = '<div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div>';
                        } else{
                            btns  = '<div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div>';
                        }
                        return  btns;
                    },
                    "targets": numColsAtendido
                },
                  {
                      "render": function ( data, type, row ) {
                                        btns = '<div class="dropdown d-inline-block w-100">';
                                            btns += '<button class="btn btn-soft-primary btn-sm dropdown w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
                                                btns += '<i class="fa-regular fa-ellipsis align-middle"></i>';
                                            btns += '</button>';
                                            btns += '<ul class="dropdown-menu dropdown-menu-end">';
                                                btns += '<li><a href="clients-form.php?id_cli=' + data + '&amp;KT_back=1" class="dropdown-item edit-item-btn"><i class="fa-regular fa-pencil align-bottom me-1"></i> ' + dtEditar + '</a></li>';
                                                if (canDel == 1) {
                                                    btns += '<li><hr class="dropdown-divider"></li>';
                                                    btns += '<li><a href="clients-form.php?id_cli=' + data + '&amp;KT_back=1&amp;KT_Delete1=1" class="dropdown-item remove-item-btn text-danger delrow"><i class="fa-regular fa-trash-can me-1"></i> ' + dtEliminar + '</a></li>';
                                                }
                                            btns += '</ul>';
                                        btns += '</div>';
                                      return  btns;
                      },
                      "targets": numCols,
                      "orderable": false,
                      "className": "actions"
                  }
                ]
          });

          $("#records-tables_length").appendTo("#col-1");
          $(".ColVis").appendTo("#col-2");

          $(".select2").change(function(e) {
              getProps();
          });

          $('#puntuacion_cli, #fecha_alta_cli, #status_cli,#b_beds_cli, #b_baths_cli, #b_precio_desde_cli, #b_precio_hasta_cli, #b_orientacion_cli, #captado_por2_cli, #atendido_cli, #idioma_cli, #nacionalidad_cli').change(function(e) {
              getProps();
          });

          $('#form1 input, #b_precio_desde_cli, #b_precio_hasta_cli').keyup(function(e) {
              getProps();
          });

      });

function getProps() {
    oTable = $('#records-tables').dataTable();
    oTable.fnReloadAjax("clients-data-adv.php?"+ $('#form1').serialize());
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

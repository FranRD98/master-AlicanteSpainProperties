 $(document).ready(function() {

      $('.downcsv').click(function() {
          window.open('owners-download-csv.php?'+ $('#form1').serialize(),'Descargar');
      });

      $('.downoutlook').click(function() {
          window.open('owners-download-outlook.php?'+ $('#form1').serialize(),'Descargar');
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
            oTable.fnDraw();
        }

        oTable = $('#records-tables').dataTable({
            "sAjaxSource": "owners-data-adv.php",
            "bSortCellsTop": true,
            dom: "<'row'<'col-sm-12 table-responsive' tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>lB",
            "bSortCellsTop": true,
            buttons: [
                {
                    extend: 'colvis',
                    columns: [0, 1, 2, 3, 4, 5, 6],
                    className: 'btn btn-soft-primary btn-sm w-100',
                    text: '<i class="fa-regular fa-table"></i>',
                    align: "button-right"
                }
            ],
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
                null,
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
                    "render": function ( data, type, row ) {
                            btns = '<div class="dropdown d-inline-block w-100">';
                                btns += '<button class="btn btn-soft-primary btn-sm dropdown w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
                                    btns += '<i class="fa-regular fa-ellipsis align-middle"></i>';
                                btns += '</button>';
                                btns += '<ul class="dropdown-menu dropdown-menu-end">';
                                    btns += '<li><a href="owners-form.php?id_pro=' + data + '&amp;KT_back=1" class="dropdown-item edit-item-btn"><i class="fa-regular fa-pencil align-bottom me-1"></i> ' + dtEditar + '</a></li>';
                                    if (canDel == 1) {
                                        btns += '<li><hr class="dropdown-divider"></li>';
                                        btns += '<li><a href="owners-form.php?id_pro=' + data + '&amp;KT_back=1&amp;KT_Delete1=1" class="dropdown-item remove-item-btn text-danger delrow"><i class="fa-regular fa-trash-can me-1"></i> ' + dtEliminar + '</a></li>';
                                    }
                                btns += '</ul>';
                            btns += '</div>';
                            return  btns;
                        }
                }
            ]
        });

        $("#records-tables_length").appendTo("#col-1");
        $(".buttons-colvis").appendTo("#col-2");


    $(".select2, #idioma_pro, #nacionalidad_pro").change(function(e) {
        getProps();
    });

    $('#puntuacion_pro, #fecha_alta_pro, #fecha_alta_pro_h, #status_pro, input[type="checkbox"], #type_pro').change(function(e) {

          getProps();

      });

    $('#form1 input').keyup(function(e) {

          getProps();

      });

  });


  function getProps() {
    // $('#records-tables').dataTable().fnDraw();
    oTable = $('#records-tables').dataTable();
    oTable.fnReloadAjax("owners-data-adv.php?"+ $('#form1 :input').serialize());

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

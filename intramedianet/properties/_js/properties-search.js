$(document).ready(function() {

      $('.downcsv').click(function() {
          window.open('properties-download-csv.php?'+ $('#formSearch').serialize(),'Descargar');
      });

  var oTable, asInitVals = [];

      $(window).change('.search-inputs select', function(e) {
          var current = $(e.target);
          $(current).prev().val($(current).val()).trigger('keyup');
      });

  $("thead input").keyup( function () {
      oTable.fnFilter( this.value, oTable.oApi._fnVisibleToColumnIndex(
      oTable.fnSettings(), $("thead input").index(this) ) );
  });

  $("thead input").each( function (i) {
      asInitVals[i] = this.value;
  });

  $("thead input").blur( function (i) {
      if ( this.value == "" ) {
          this.value = asInitVals[$("thead input").index(this)];
      }
  });

  $("thead .search-clear").click( function (i) {
      $(".search-inputs thead input").val('');
      $('.search-inputs select').val('');
      fnResetAllFilters()
  });

  function fnResetAllFilters() {
      var oSettings = oTable.fnSettings();
      for(iCol = 0; iCol < oSettings.aoPreSearchCols.length; iCol++) {
          oSettings.aoPreSearchCols[ iCol ].sSearch = '';
      }
      oTable.fnDraw();
  }

var colDef = [
    {
        "targets": 0,
        "sName": "offert_prop",
        "bSearchable": false,
        "bSortable": false,
        "render": function ( data, type, row ) {
            return '<div class="form-check form-switch form-switch-sm text-center pt-2" dir="ltr"><input type="checkbox" name="user" id="user" value="' + data + '" class="form-check-input chklist"></div>';
        }
    },
    {
        "targets": 1,
        "bSearchable": false,
        "bSortable": false,
        "sClass": "imgprop"
    },
    {
        "targets": 8,
        "sName": "activado_prop",
        "bSearchable": true,
        "bSortable": true,
        "sClass": "ticks",
        "render": function ( data, type, row ) {
            if (data == non) {
                return '<div class="text-center mt-1"><i class="fa-regular fa-xmark text-danger fs-4 fw-bolder"></i></div>';
            } else{
                return '<div class="text-center mt-1"><i class="fa-regular fa-check text-success fs-4 fw-bolder"></i></div>';
            }
        }
    },
    {
        "targets": numCols,
        "bSearchable": false,
        "bSortable": false,
        "sClass": "actions",
        "render": function ( data, type, row ) {
            btns = '<a href="properties-form.php?id_prop=' + data + '&amp;KT_back=1" class="btn btn-success btn-sm w-100"><i class="fa-regular fa-pencil"></i></a>';
            return  btns;
        }
    }
  ];

  if(typeof extraColDef !== 'undefined' && extraColDef.length > 0) {
      colDef = colDef.concat(extraColDef);
  }

  if(typeof ocultarCols !== 'undefined' && ocultarCols.length > 0) {
    colDef.push({
        "targets": ocultarCols,
        "visible": false,
    });
  }

  var oTable = $('#records-tables').dataTable({
      "sAjaxSource": "properties-client-data-search.php?"+ $('#search-fields :input').serialize(),
      "bSortCellsTop": true,
      dom: "<'row'<'col-sm-12 table-responsive' tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>lB",
      buttons: [
          {
              extend: 'colvis',
              columns: [1, 2, 3, 4, 5, 6, 7, 8],
              className: 'btn btn-soft-primary btn-sm w-100',
              text: '<i class="fa-regular fa-table"></i>',
              align: "button-right"
          }
      ],
      "fnInitComplete": function() {
          var oSettings = $('#records-tables').dataTable().fnSettings();
          var x= 0;
          for ( var i=0 ; i<oSettings.aoPreSearchCols.length ; i++ ){
              if (oSettings.aoColumns[i].bVisible == false) {
                  x++;
                  continue;
              }
              if(oSettings.aoPreSearchCols[i].sSearch.length>0){
                  $("thead input")[i-x].value = oSettings.aoPreSearchCols[i].sSearch;
              }
          }
          toggleScrollBarIcon();

          $.map( $('.search-inputs select'), function( select, i ) {
              var input = $(select).prev();
              if(input.val() != '') {
                  $(select).val(input.val());
              }
          });

          $(document).delegate('*[data-toggle="lightbox"]', 'click', function(e) {
              e.preventDefault();
              $(this).ekkoLightbox();
          });

      },
      "columnDefs": colDef,
      "fnDrawCallback": function ( oSettings ) {
          $('#records-tables tbody tr').each( function () {
              var iPos = oTable.fnGetPosition( this );
              if (iPos!=null) {
                  var aData = oTable.fnGetData( iPos );
                  if (jQuery.inArray(aData[0], selected)!=-1)
                      $(this).addClass('row_selected');
                  if ( $(this).hasClass('row_selected') ) {
                       $(this).find('input').attr('checked', true);
                  }
              }
              $('.chklist').each( function () {
                  if(jQuery.inArray($(this).val(), selected)!=-1) {
                    $(this).attr('checked', true);
                  }
                });
              $(this).find('input').click( function () {

                  var iPos = oTable.fnGetPosition( this.parentNode.parentNode );
                  var aData = oTable.fnGetData( iPos );
                  var iId = aData[0];

                  is_in_array = jQuery.inArray(iId, selected);
                  if (is_in_array==-1) {
                      selected[selected.length]=iId;
                  }
                  else {
                      selected = jQuery.grep(selected, function(value) {
                          return value != iId;
                      });
                  }
                  if ( $(this).is(':checked') ) {
                       $(this).parents('tr').addClass('row_selected');
                       $(this).attr('checked', true);

                  }
                  else {
                      $(this).parents('tr').removeClass('row_selected');
                      $(this).attr('checked', false);
                  }
                $('.countusers').html(selected.length);
                if (selected.length > 0) {
                  if (selected.length > 1) {
                    $('.countusers2').hide();
                    $('.countusers3').show();
                  } else{
                    $('.countusers3').hide();
                    $('.countusers2').show();
                  }
          $('#sendcont').fadeIn('slow');
                } else {
          $('#sendcont').fadeOut('slow');
                }
              });
          });
      }
  });

  $("#records-tables_length").appendTo("#col-1");
  $(".buttons-colvis").appendTo("#col-2");


  $('.btnsend').click(function(e) {

      e.preventDefault();

      if (!isValidEmailAddress($('#email_cli').val())) {

            alert(cliMailNo);

          return false;

      }

        if (!confirm(cliMailConf)) {
          return false;
        }

        var values = Array();

        var priceRegex = /([0-9]+)/;

        for (var i = 0; i < selected.length; i++) {
            // var match = selected[i].match(priceRegex);
            // values.push(match[1]);
            values.push(selected[i]);
          }

          values = values.join(',');


            $(this).parent().parent().parent().append('<div class="loadingMail">');

                $.ajax({
                  type: "GET",
                  url: "clients-send.php?ids="+values+'&email='+$('#email_cli').val()+'&comment='+$('#comment').val().replace( /\r?\n/g, "<br>" )+'&lang=' + appLang + '',
                    cache: false
                }).done(function( data ) {

                      if(data == 'ok') {
                          alert(mensaSend);
                          $('#form1 .loadingMail').remove();
                      }

                });

  });

  $(".select2").change(function(e) {

      getProps();

  });

  $('#b_beds_cli, #b_baths_cli, #b_precio_desde_cli, #b_precio_hasta_cli, #nw, #ven, #alq, #res, #rp, #cs, #sw, #ep, #po, #rps, #or, #m2ut, #m2pl, #piscina_prop, #parking_prop, #distance_beach_med_prop, #distance_amenities_med_prop, #distance_airport_med_prop, #distance_golf_med_prop').change(function(e) {

        getProps();

    });

  $('#b_precio_desde_cli, #b_precio_hasta_cli, #direccion, #palabras_clave, #distance_beach_prop_from, #distance_beach_prop_to, #distance_amenities_prop_from, #distance_amenities_prop_to, #distance_airport_prop_from, #distance_airport_prop_to, #distance_golf_prop_from, #distance_golf_prop_to').keyup(function(e) {

        getProps();

    });

});


function isValidEmailAddress(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

function getProps() {

  oTable = $('#records-tables').dataTable();
  oTable.fnReloadAjax("properties-client-data-search.php?"+ $('#search-fields :input').serialize());

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

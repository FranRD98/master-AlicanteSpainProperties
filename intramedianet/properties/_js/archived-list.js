$(document).ready(function() {

    $('#atendido_cli_sel').change(function(e) {

        $('#atendido_cli').val($(this).val()).trigger('keyup');

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
        toggleScrollBarIcon();
    }

    oTable = $('#records-tables').dataTable({
        "sAjaxSource": "archived-data.php",
        dom: "<'row'<'col-sm-12 table-responsive' tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>lB",
        "bSortCellsTop": true,
        "order": [[ numCols - 1, 'desc' ]],
        buttons: [
            {
                extend: 'colvis',
                columns: arrayColVis,
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
                }
                if(oSettings.aoPreSearchCols[i].sSearch.length>0){

                    $("thead input")[i-x].value = oSettings.aoPreSearchCols[i].sSearch;
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
                        btns  = '<img src="/intramedianet/includes/assets/img/delete.gif" alt="">';
                    } else{
                        btns  = '<img src="/intramedianet/includes/assets/img/done.gif" alt="">';
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
        ],
        "fnDrawCallback": function ( oSettings ) {
            $('.listdata').each(function(index, el) {
                idClient = $(this).data('id');
                getNew(idClient, $(this));
            });
        }
    });

    $("#records-tables_length").appendTo("#col-1");
    $(".buttons-colvis").appendTo("#col-2");

});

function getNew(id, elm) {
    jQuery.ajax({
        type: "get",
        url: "_count_news2.php?id_cli="+id,
        data: {},
        dataType: 'html'
    }).done(function(data) {
        elm.append('<span class="badge bg-info">'+data+'</span> ');
        getInter(id, elm);
    });
}

function getNoInter(id, elm) {
    jQuery.ajax({
        type: "get",
        url: "_count_news_intno.php?id_cli="+id,
        data: {},
        dataType: 'html'
    }).done(function(data) {
        elm.append('<span class="badge bg-danger">'+data+'</span> ');
    });
}

function getInter(id, elm) {
    jQuery.ajax({
        type: "get",
        url: "_count_news_int.php?id_cli="+id,
        data: {},
        dataType: 'html'
    }).done(function(data) {
        elm.append('<span class="badge bg-success">'+data+'</span> ');
        getNoInter(id, elm);
    });
}

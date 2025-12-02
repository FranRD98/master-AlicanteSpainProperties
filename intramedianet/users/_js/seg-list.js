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
         "sAjaxSource": "seg-data.php",
         "bSortCellsTop": true,
         "aaSorting": [[ 3, "DESC" ]],
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
             {
                 "sType": "date-eu-pre"
             },
             {
                 "sType": "date-eu-pre"
             },
             {
                "bSearchable": false,
                "bSortable": false,
                "sClass": "actions",
                "mRender": function (data, type, full) {
                    btns  = '<a href="seg-user.php?id_usr=' + data + '" data-id="' + data + '" data-row="' + full[5] + '" class="btn btn-soft-info btn-sm w-100 showInfo"><i class="fa fa-info"></i></a> ';
                     return  btns;
                 }
             }
         ]
     });

    $("#records-tables_length").appendTo("th#actions");


    $(document).on('click', '.showInfo', function(e) {
        e.preventDefault();
        tb = $(this);
        $('.loadingfrm').html('<div class="py-5 text-center"><div class="fa-3x"><i class="fa-solid fa-spinner fa-spin-pulse"></i></div></div>');
        $('#myModal').modal('show').on('shown.bs.modal', function () {
            $.get('seg-user.php', { id_usr: tb.attr('data-id'), id_log: tb.attr('data-row') }, function(data) {
                $('.loadingfrm').html(data);
            });
        });
    });

  });

/*! DataTables Bootstrap 3 integration
 * Â©2011-2014 SpryMedia Ltd - datatables.net/license
 */

/**
 * DataTables integration for Bootstrap 3. This requires Bootstrap 3 and
 * DataTables 1.10 or newer.
 *
 * This file sets the defaults and adds options to DataTables to style its
 * controls using Bootstrap. See http://datatables.net/manual/styling/bootstrap
 * for further information.
 */
// (function(window, document, undefined){

// var factory = function( $, DataTable ) {
// "use strict";


// /* Set the defaults for DataTables initialisation */
$.extend( true, DataTable.defaults, {
    // dom:
    //     "l" +
    //     "<'row'<'col-sm-12 table-responsive'tr>>" +
    //     "<'row'<'col-sm-6'i><'col-sm-6'p>>",
    dom: "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>l",
    renderer: 'bootstrap',
    "iDisplayStart": 0,
    "iDisplayLength": 10,
    "bStateSave": true,
    "bProcessing": true,
    "bServerSide": true,
    "oLanguage": {
        "sProcessing":   '<div class="fa-3x"><i class="fa-solid fa-spinner fa-spin-pulse">',
        "sLengthMenu": '<select class="form-select form-select-sm form-control-num-reg"><option value="10">10</option><option value="20">20</option><option value="30">30</option><option value="40">40</option><option value="50">50</option><option value="-1">' + dtTodos + '</option></select>',
        "sEmptyTable":   dtVacio,
        "sZeroRecords":  dtNoreg,
        "sInfo":         dtMostr,
        "sInfoEmpty":    dtMostrVacio,
        "sInfoFiltered": dtFiltr,
        "sInfoPostFix":  "",
        "sSearch":       "",
        "sUrl":          "",
        "oPaginate": {
            "sFirst":    dtPrimero,
            "sPrevious": dtAnterior,
            "sNext":     dtSiguiente,
            "sLast": dtUltimo
        }
      }

});

$.extend( DataTable.ext.classes, {
    sWrapper:      "dataTables_wrapper dt-bootstrap5",
    sFilterInput:  "form-control form-control-sm",
    sLengthSelect: "form-select form-select-sm",
    sProcessing:   "dataTables_processing card",
    sPageButton:   "paginate_button page-item mt-2"
});


// /* Default class modification */
// $.extend( DataTable.ext.classes, {
//     sWrapper:      "dataTables_wrapper form-inline dt-bootstrap",
//     sFilterInput:  "form-control input-sm",
//     sLengthSelect: "form-control input-sm"
// } );


// /* Bootstrap paging button renderer */
// DataTable.ext.renderer.pageButton.bootstrap = function ( settings, host, idx, buttons, page, pages ) {
//     var api     = new DataTable.Api( settings );
//     var classes = settings.oClasses;
//     var lang    = settings.oLanguage.oPaginate;
//     var btnDisplay, btnClass;

//     var attach = function( container, buttons ) {
//         var i, ien, node, button;
//         var clickHandler = function ( e ) {
//             e.preventDefault();
//             if ( !$(e.currentTarget).hasClass('disabled') ) {
//                 api.page( e.data.action ).draw( false );
//             }
//         };

//         for ( i=0, ien=buttons.length ; i<ien ; i++ ) {
//             button = buttons[i];

//             if ( $.isArray( button ) ) {
//                 attach( container, button );
//             }
//             else {
//                 btnDisplay = '';
//                 btnClass = '';

//                 switch ( button ) {
//                     case 'ellipsis':
//                         btnDisplay = '&hellip;';
//                         btnClass = 'disabled';
//                         break;

//                     case 'first':
//                         btnDisplay = lang.sFirst;
//                         btnClass = button + (page > 0 ?
//                             '' : ' disabled');
//                         break;

//                     case 'previous':
//                         btnDisplay = lang.sPrevious;
//                         btnClass = button + (page > 0 ?
//                             '' : ' disabled');
//                         break;

//                     case 'next':
//                         btnDisplay = lang.sNext;
//                         btnClass = button + (page < pages-1 ?
//                             '' : ' disabled');
//                         break;

//                     case 'last':
//                         btnDisplay = lang.sLast;
//                         btnClass = button + (page < pages-1 ?
//                             '' : ' disabled');
//                         break;

//                     default:
//                         btnDisplay = button + 1;
//                         btnClass = page === button ?
//                             'active' : '';
//                         break;
//                 }

//                 if ( btnDisplay ) {
//                     node = $('<li>', {
//                             'class': classes.sPageButton+' '+btnClass,
//                             'aria-controls': settings.sTableId,
//                             'tabindex': settings.iTabIndex,
//                             'id': idx === 0 && typeof button === 'string' ?
//                                 settings.sTableId +'_'+ button :
//                                 null
//                         } )
//                         .append( $('<a>', {
//                                 'href': '#'
//                             } )
//                             .html( btnDisplay )
//                         )
//                         .appendTo( container );

//                     settings.oApi._fnBindAction(
//                         node, {action: button}, clickHandler
//                     );
//                 }
//             }
//         }
//     };

//     attach(
//         $(host).empty().html('<ul class="pagination pagination-sm"/>').children('ul'),
//         buttons
//     );
// };


// /*
//  * TableTools Bootstrap compatibility
//  * Required TableTools 2.1+
//  */
// if ( DataTable.TableTools ) {
//     // Set the classes that TableTools uses to something suitable for Bootstrap
//     $.extend( true, DataTable.TableTools.classes, {
//         "container": "DTTT btn-group",
//         "buttons": {
//             "normal": "btn btn-default",
//             "disabled": "disabled"
//         },
//         "collection": {
//             "container": "DTTT_dropdown dropdown-menu",
//             "buttons": {
//                 "normal": "",
//                 "disabled": "disabled"
//             }
//         },
//         "print": {
//             "info": "DTTT_print_info"
//         },
//         "select": {
//             "row": "active"
//         }
//     } );

//     // Have the collection use a bootstrap compatible drop down
//     $.extend( true, DataTable.TableTools.DEFAULTS.oTags, {
//         "collection": {
//             "container": "ul",
//             "button": "li",
//             "liner": "a"
//         }
//     } );
// }

// }; // /factory


// // Define as an AMD module if possible
// if ( typeof define === 'function' && define.amd ) {
//     define( ['jquery', 'datatables'], factory );
// }
// else if ( typeof exports === 'object' ) {
//     // Node/CommonJS
//     factory( require('jquery'), require('datatables') );
// }
// else if ( jQuery ) {
//     // Otherwise simply initialise as normal, stopping multiple evaluation
//     factory( jQuery, jQuery.fn.dataTable );
// }


// })(window, document);

// jQuery.extend( jQuery.fn.dataTableExt.oSort, {
//   "date-eu-pre": function ( date ) {
//       var date = date.replace(" ", "");

//       if (date.indexOf('.') > 0) {
//           /*date a, format dd.mn.(yyyy) ; (year is optional)*/
//           var eu_date = date.split('.');
//       } else {
//           /*date a, format dd/mn/(yyyy) ; (year is optional)*/
//           var eu_date = date.split('/');
//       }

//       /*year (optional)*/
//       if (eu_date[2]) {
//           var year = eu_date[2];
//       } else {
//           var year = 0;
//       }

//       /*month*/
//       var month = eu_date[1];
//       if (month.length == 1) {
//           month = 0+month;
//       }

//       /*day*/
//       var day = eu_date[0];
//       if (day.length == 1) {
//           day = 0+day;
//       }

//       return (year + month + day) * 1;
//   },

//   "date-eu-asc": function ( a, b ) {
//       return ((a < b) ? -1 : ((a > b) ? 1 : 0));
//   },

//   "date-eu-desc": function ( a, b ) {
//       return ((a < b) ? 1 : ((a > b) ? -1 : 0));
//   }
// });

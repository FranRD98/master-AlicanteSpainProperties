$(document).ready(function() {

    $(document).delegate('*[data-toggle="lightbox"]', 'click', function(e) {
        e.preventDefault();
        $(this).ekkoLightbox();
    });

    $('.add-prop').click( function(e) {
      $('#myModal5').modal('show').on('shown', function () {
      }).on('hide.bs.modal', myModal5Handler);
    });

    $('#referencia_prop').keyup(function() {
        ref = $(this).val();
        if (ref != '') {
            $('.ref_prop').text('Ref: '+ $(this).val());
        } else {
            $('.ref_prop').text('');
        }
    }).keyup();

    function myModal5Handler() {
        // if(!$('#addPropie').valid()) {
        //     return false;
        // }

        var percont = [];
        var num = 0;

        $('#myModal5 textarea[name^="worker"]').each(function() {
            if ($(this).val() != '') {
                percont[num++] = $(this).val();
            }
        });

        var Valkeys = ($('#myModal5 #keyholder_pro').is(':checked') == true)?'1':'0';
        $.post('owners-form-ajax.php', {
          nombre_pro: $('#myModal5 #nombre_pro').val(),
          apellidos_pro: $('#myModal5 #apellidos_pro').val(),
          telefono_fijo_pro: $('#myModal5 #telefono_fijo_pro').val(),
          telefono_movil_pro: $('#myModal5 #telefono_movil_pro').val(),
          nie_pro: $('#myModal5 #nie_pro').val(),
          pasaporte_pro: $('#myModal5 #pasaporte_pro').val(),
          keyholder_pro: ''+Valkeys+'',
          keyholder_name_pro: $('#myModal5 #keyholder_name_pro').val(),
          keyholder_tel_pro: $('#myModal5 #keyholder_tel_pro').val(),
          fecha_alta_pro: $('#myModal5 #fecha_alta_pro').val(),
          email_pro: $('#myModal5 #email_pro').val(),
          skype_pro: $('#myModal5 #skype_pro').val(),
          direccion_pro: $('#myModal5 #direccion_pro').val(),
          como_nos_conocio_pro: $('#myModal5 #como_nos_conocio_pro').val(),
          captado_por_pro: $('#myModal5 #captado_por_pro').val(),
          status_pro: $('#myModal5 #status_pro').val(),
          worker: percont,
          type_pro: $('#myModal5 #type_pro').val(),
          KT_Insert1: '1'
        }, function(data) {
            
          
          const dangerAlertComment = '<!-- Danger Alert -->';
          const index = data.indexOf(dangerAlertComment);
          
          if (index !== -1) {
            // Obtener la parte de la cadena antes del comentario
            const beforeComment = data.substring(0, index).trim();
            // Encontrar el último número antes del comentario
            const numberMatch = beforeComment.match(/\d+$/);
            if (numberMatch) {
              const number = numberMatch[0];
              data = number;
              alert("El propietario ya existe");  
            } 
          } 

          
            $('#myModal5 #nombre_pro').val('');
            $('#myModal5 #apellidos_pro').val('');
            $('#myModal5 #telefono_fijo_pro').val('');
            $('#myModal5 #telefono_movil_pro').val('');
            $('#myModal5 #nie_pro').val('');
            $('#myModal5 #pasaporte_pro').val('');
            $('#myModal5 #keyholder_name_pro').val('');
            $('#myModal5 #keyholder_tel_pro').val('');
            $('#myModal5 #fecha_alta_pro').val('');
            $('#myModal5 #email_pro').val('');
            $('#myModal5 #skype_pro').val('');
            $('#myModal5 #direccion_pro').val('');
            $('#myModal5 #como_nos_conocio_pro').val('');
            $('#myModal5 #captado_por_pro').val('');
            $('#myModal5 #status_pro').val('');
            if(data != '') {
                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: '/intramedianet/properties/properties-owners-select-single.php?q=' + data
                }).then(function (data2) {
                  $.get('owner-data.php', { i: data}, function(data3) {
                      $('#owner-data').addClass('loading');
                      $('#owner-data').removeClass('loading').html(data3);
                  });
                  $(".select2owners").select2('data', { id:data2.id, text: data2.text});
                  $(".select2owners").change();
                });
            }
          
            $('#myModal5').off('hide', myModal5Handler);
        
      });
    }

    $(".multi_files2").pluploadQueue({
        runtimes : 'html5,flash,silverlight,html4',
        url : '/intramedianet/properties/dfiles_upload.php?id_prop=' + idProperty,
        max_file_size : '100mb',
        unique_names : false,
        multiple_queues: true,
        preinit : attachCallbacks21,
        dragdrop: true,
        filters : {
          mime_types: [
            {title : "Files", extensions : "rar,txt,zip,doc,pdf,csv,xls,rtf,sxw,odt,docx,xlsx,ppt,mov,eml"}
          ]
        },
        flash_swf_url : '../includes/assets/swf/Moxie.swf',
        silverlight_xap_url : '../includes/assets/swf/Moxie.xap'
    });


    function attachCallbacks21(uploader) {
        uploader.bind('FileUploaded', function(Up, File, Response) {
            if( (uploader.total.uploaded + 1) == uploader.files.length) {
                $.get("dfiles_list.php?id_prop=" + idProperty, function(data) {
                  if(data != '') {
                      $('#file-list2').html(data);
                  }
                });
            }
        });
    }

    $(".multi_files").pluploadQueue({
        runtimes : 'html5,flash,silverlight,html4',
        url : '/intramedianet/properties/files_upload.php?id_prop=' + idProperty,
        max_file_size : '100mb',
        unique_names : false,
        multiple_queues: true,
        preinit : attachCallbacks2,
        dragdrop: true,
        filters : {
          mime_types: [
            {title : "Files", extensions : "rar,txt,zip,doc,pdf,csv,xls,rtf,sxw,odt,docx,xlsx,ppt,mov,eml"}
          ]
        },
        flash_swf_url : '../includes/assets/swf/Moxie.swf',
        silverlight_xap_url : '../includes/assets/swf/Moxie.xap'
      });


    function attachCallbacks2(uploader) {
        uploader.bind('FileUploaded', function(Up, File, Response) {
            if( (uploader.total.uploaded + 1) == uploader.files.length) {
                $.get("files_list.php?id_prop=" + idProperty, function(data) {
                  if(data != '') {
                      $('#file-list').html(data);
                  }
                });
            }
        });
    }

    $(document).on('click', '.edit-name', function(e) {
      e.preventDefault();
      tb = $(this);
      $('#myModal2').modal('show').on('shown.bs.modal', myModal2ShowHandler).on('hide.bs.modal', myModal2HideHandler);
    });

    function myModal2ShowHandler() {
        $.get('files_names.php', { p: tb.attr('data-id') }, function(data) {
          $('#myModal2 .loadingfrm').html(data);
        });
        $('#myModal2').off('shown.bs.modal', myModal2ShowHandler);
    }

    function myModal2HideHandler() {
        var nameVals = $('#myModal2 :input').serialize();
        $.get('files_names.php?' + nameVals, function(data) {
          $('.loadingfrm').css('background', 'url(../includes/assets/img/loading_big.gif) no-repeat center center').html('');
        });

        $('#myModal2').off('hide.bs.modal', myModal2HideHandler);

    }

    var uploader = $(".multi_images").pluploadQueue({
      runtimes : 'html5,flash,silverlight,html4',
      url : '/intramedianet/properties/images_upload.php?id_prop=' + idProperty,
      max_file_size : '100mb',
      unique_names : true,
      multiple_queues: true,
      preinit : attachCallbacks,

      dragdrop: true,
      filters : {
        mime_types: [
          {title : "Image files", extensions : "jpg,jpeg,gif,png"}
        ]
      },
      resize : {width : 2000, height : 1200, quality : 90},
      flash_swf_url : '../includes/assets/swf/Moxie.swf',
      silverlight_xap_url : '../includes/assets/swf/Moxie.xap'
    });

    function attachCallbacks(uploader) {
        uploader.bind('FileUploaded', function(Up, File, Response) {
        if( (uploader.total.uploaded + 1) == uploader.files.length) {
            $.get("images_list.php?id_prop=" + idProperty, function(data) {
            if(data != '') {
                $('#images-list').html(data);
            }
            });
        }
        });
    }

    var uploader = $(".multi_imagesp").pluploadQueue({
     runtimes : 'html5,flash,silverlight,html4',
     url : '/intramedianet/properties/images_uploadp.php?id_prop=' + idProperty,
     max_file_size : '100mb',
     unique_names : true,
     multiple_queues: true,
     preinit : attachCallbacksPrivimg,

     dragdrop: true,
     filters : {
       mime_types: [
         {title : "Image files", extensions : "jpg,jpeg,gif,png"}
       ]
     },
     resize : {width : 2000, height : 1200, quality : 90},
     flash_swf_url : '../includes/assets/swf/Moxie.swf',
     silverlight_xap_url : '../includes/assets/swf/Moxie.xap'
   });

   function attachCallbacksPrivimg(uploader) {
       uploader.bind('FileUploaded', function(Up, File, Response) {
       if( (uploader.total.uploaded + 1) == uploader.files.length) {
           $.get("images_listp.php?id_prop=" + idProperty, function(data) {
           if(data != '') {
               $('#images-listp').html(data);
           }
           });
       }
       });
   }

    $(document).on('click', '.edit-alt', function(e) {
        e.preventDefault();
        tb = $(this);
        $('#myModal').modal('show').on('shown.bs.modal', myModalShowHandler).on('hide.bs.modal', myModalHideHandler);
      });

      function myModalShowHandler() {
          $.get('images_alts.php', { p: tb.attr('data-id') }, function(data) {
            $('#myModal .loadingfrm').html(data);
          });
          $('#myModal').off('shown.bs.modal', myModalShowHandler);
      }

      function myModalHideHandler() {
          var altsVals = $('#myModal :input').serialize();
          $.post('images_alts.php?' + altsVals, function(data) {
              $('.loadingfrm').css('background', 'url(/intramedianet/includes/assets/img/loading_big.gif) no-repeat center center').html('');
              $.get("images_list.php?id_prop=" + idProperty, function(data) {
                  if(data != '') {
                      $('#images-list').html(data);
                  }
              });
          });

          $('#myModal').off('hide.bs.modal', myModalHideHandler);

      }

      var uploader = $(".multi_planos").pluploadQueue({
        runtimes : 'html5,flash,silverlight,html4',
        url : '/intramedianet/properties/planos_upload.php?id_prop=' + idProperty,
        max_file_size : '100mb',
        unique_names : true,
        multiple_queues: true,
        preinit : attachCallbacksPla,

        dragdrop: true,
        filters : {
          mime_types: [
            {title : "Image files", extensions : "jpg,jpeg,gif,png"}
          ]
        },
        resize : {width : 2000, height : 1200, quality : 90},
        flash_swf_url : '../includes/assets/swf/Moxie.swf',
        silverlight_xap_url : '../includes/assets/swf/Moxie.xap'
      });

      function attachCallbacksPla(uploader) {
          uploader.bind('FileUploaded', function(Up, File, Response) {
          if( (uploader.total.uploaded + 1) == uploader.files.length) {
              $.get("planos_list.php?id_prop=" + idProperty, function(data) {
              if(data != '') {
                  $('#planos-list').html(data);
              }
              });
          }
          });
      }

      $(document).on('click', '.edit-alt-pla', function(e) {
          e.preventDefault();
          tb = $(this);
          $('#myModal').modal('show').on('shown.bs.modal', myModalShowHandlerPla).on('hide.bs.modal', myModalHideHandlerPla);
        });

        function myModalShowHandlerPla() {
            $.get('planos_alts.php', { p: tb.attr('data-id') }, function(data) {
              $('#myModal .loadingfrm').html(data);
            });
            $('#myModal').off('shown.bs.modal', myModalShowHandlerPla);
        }

        function myModalHideHandlerPla() {
            var altsVals = $('#myModal :input').serialize();
            $.post('planos_alts.php?' + altsVals, function(data) {
                $('.loadingfrm').css('background', 'url(/intramedianet/includes/assets/img/loading_big.gif) no-repeat center center').html('');
                $.get("planos_list.php?id_prop=" + idProperty, function(data) {
                    if(data != '') {
                        $('#planos-list').html(data);
                    }
                });
            });

            $('#myModal').off('hide.bs.modal', myModalHideHandlerPla);

        }

      $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        m = g_Map.gmap3('get');
        x = m.getZoom();
          c = m.getCenter();
        google.maps.event.trigger(m, 'resize');
         m.setZoom(x);
          m.setCenter(c);

          mp = g_Mapp.gmap3('get');
          xp = mp.getZoom();
            cp = mp.getCenter();
          google.maps.event.trigger(mp, 'resize');
           mp.setZoom(xp);
            mp.setCenter(cp);
        $('#calendar').fullCalendar('render');

        uploader.splice();


      });

      g_Map = $('#g_map');

      if($('.comp_lat_lng').val()  == '') {
          g_Map.gmap3({
            action: 'init',
            options:{
              center  : [40.463667, -3.749220],
              zoom    : 6
            },
            events: {
              zoom_changed: function(marker){
                $('.zoom_gp_prop').val(g_Map.gmap3('get').getZoom());
              }
            },
            callback: function(){
              $('#search_on_map').click(function(){
                $('.zoom_gp_prop').val(g_Map.gmap3('get').getZoom());
                // $('#gmap_search').val('');
                 drop_marker_search();
                 return false;
              })
            }
          });
      } else {
          var latLng_array = $('.comp_lat_lng').val().split(',');
          var zoomVal = ($('.zoom_gp_prop').val() == '')?16:$('.zoom_gp_prop').val()*1;
          g_Map.gmap3({
            action: 'init',
                options:{
                  center  : latLng_array,
                  zoom    : zoomVal
                },
                events: {
                  zoom_changed: function(marker){
                    $('.zoom_gp_prop').val(g_Map.gmap3('get').getZoom()).focus();
                  }
                }
            },
            {
              action: 'clear',
              name:'marker'
            },
            {
              action: 'addMarker',
              latLng: latLng_array,
              marker: {
                events: {
                dragend: function(marker){
                  marker_callback(marker);
                  g_Map.gmap3('get').panTo(marker.position);
                }
              },
              options: { draggable: true },
              callback: function(){
                $('#search_on_map').click(function(){
                  drop_marker_search();
                  return false;
                  });
                }
              }
            }
          );
      }

      function marker_callback(marker) {
        $('.comp_lat_lng').val(marker.position.lat().toFixed(6)+', '+marker.position.lng().toFixed(6));

        $('.zoom_gp_prop').val(g_Map.gmap3('get').getZoom());
        g_Map.gmap3({
            action: 'getAddress',
            latLng: marker.getPosition(),
            callback: function(results){
                $('.comp_address').val(results[0].formatted_address);
            }
        });

      };

      function drop_marker_search() {
        var search_query = $('#gmap_search').val();
        if(search_query != ''){
          g_Map.gmap3(
            {
              action: 'clear',
              name: 'marker'
            },
            {   action: 'addMarker',
              address: search_query,
              map: {
                center:true,
                zoom: 15
              },
              marker: {
                events: {
                  dragend: function(marker){
                    marker_callback(marker);
                    g_Map.gmap3('get').panTo(marker.position);
                  }
                },
                callback: function(marker){
                  if(marker){
                    $('#msgSM').html('<div class="alert alert-info"><a class="close" data-dismiss="alert" href="#">&times;</a> ' + gmArras + '</div>');
                    marker_callback(marker);
                  } else {
                    $('#msgSM').html('<div class="alert alert-warning"><a class="close" data-dismiss="alert" href="#">&times;</a> ' + gmNoFound + '</div>');

                  }
                },
                options: { draggable: true }
              }
            }
          )
        } else {
          $('#msgSM').html('<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#">&times;</a> ' + gmIntrud + '</div>');
        }
      }

      // ZeroClipboard.config( { swfPath: "/intramedianet/includes/assets/swf/ZeroClipboard.swf" } );
      // var clip = new ZeroClipboard( $("a#copy") );
      // clip.on( 'ready', function(event) {
      //   clip.on( 'copy', function(event) {
      //       event.clipboardData.setData('text/plain', $('#lat_long_gp_prop').val());
      //   });
      //   clip.on( 'aftercopy', function(event) {
      //       alert(textCopy + ": " + event.data['text/plain'] );
      //   });
      // });

      g_Mapp = $('#g_mapp');

      if($('.comp_lat_lngp').val()  == '') {
          g_Mapp.gmap3({
            action: 'init',
            options:{
              center  : [40.463667, -3.749220],
              zoom    : 6
            },
            events: {
              zoom_changed: function(marker){
                $('.zoom_gpp_prop').val(g_Mapp.gmap3('get').getZoom());
              }
            },
            callback: function(){
              $('#search_on_mapp').click(function(){
                $('.zoom_gpp_prop').val(g_Mapp.gmap3('get').getZoom());
                // $('#gmap_searchp').val('');
                 drop_marker_searchp();
                 return false;
              })
            }
          });
      } else {
          var latLng_array = $('.comp_lat_lngp').val().split(',');
          var zoomVal = ($('.zoom_gpp_prop').val() == '')?16:$('.zoom_gpp_prop').val()*1;
          g_Mapp.gmap3({
            action: 'init',
                options:{
                  center  : latLng_array,
                  zoom    : zoomVal
                },
                events: {
                  zoom_changed: function(marker){
                    $('.zoom_gpp_prop').val(g_Mapp.gmap3('get').getZoom()).focus();
                  }
                }
            },
            {
              action: 'clear',
              name:'marker'
            },
            {
              action: 'addMarker',
              latLng: latLng_array,
              marker: {
                events: {
                dragend: function(marker){
                  marker_callbackp(marker);
                  g_Mapp.gmap3('get').panTo(marker.position);
                }
              },
              options: { draggable: true },
              callback: function(){
                $('#search_on_mapp').click(function(){
                  drop_marker_searchp();
                  return false;
                  });
                }
              }
            }
          );
      }

      function marker_callbackp(marker) {
        $('.comp_lat_lngp').val(marker.position.lat().toFixed(6)+', '+marker.position.lng().toFixed(6));

        $('.zoom_gpp_prop').val(g_Mapp.gmap3('get').getZoom());
        g_Mapp.gmap3({
            action: 'getAddress',
            latLng: marker.getPosition(),
            callback: function(results){
                $('.comp_addressp').val(results[0].formatted_address);
            }
        });

      };

      function drop_marker_searchp() {
        var search_query = $('#gmap_searchp').val();
        if(search_query != ''){
          g_Mapp.gmap3(
            {
              action: 'clear',
              name: 'marker'
            },
            {   action: 'addMarker',
              address: search_query,
              map: {
                center:true,
                zoom: 15
              },
              marker: {
                events: {
                  dragend: function(marker){
                    marker_callbackp(marker);
                    g_Mapp.gmap3('get').panTo(marker.position);
                  }
                },
                callback: function(marker){
                  if(marker){
                    $('#msgSMp').html('<div class="alert alert-info"><a class="close" data-dismiss="alert" href="#">&times;</a> ' + gmArras + '</div>');
                    marker_callbackp(marker);
                  } else {
                    $('#msgSMp').html('<div class="alert alert-warning"><a class="close" data-dismiss="alert" href="#">&times;</a> ' + gmNoFound + '</div>');

                  }
                },
                options: { draggable: true }
              }
            }
          )
        } else {
          $('#msgSMp').html('<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#">&times;</a> ' + gmIntrud + '</div>');
        }
      }

      // ZeroClipboard.config( { swfPath: "/intramedianet/includes/assets/swf/ZeroClipboard.swf" } );
      // var clip = new ZeroClipboard( $("a#copyp") );
      // clip.on( 'ready', function(event) {
      //   clip.on( 'copy', function(event) {
      //       event.clipboardData.setData('text/plain', $('#lat_long_gpp_prop').val());
      //   });
      //   clip.on( 'aftercopy', function(event) {
      //       alert(textCopy + ": " + event.data['text/plain'] );
      //   });
      // });

      var calendar = $('#calendar').fullCalendar({
        header: {
          left: 'prev next today',
          center: 'title',
          right: ''
        },
        buttonText: {
          today: today,
          month: month,
          week: week,
          day: day
        },
        monthNames: monthNames,
        dayNamesShort: dayNamesShort,
        dayNames: dayNames,
        allDayText: allDayText,
        firstDay: 1,
        aspectRatio: 1.5,
        selectable: true,
        selectHelper: true,
        editable: false,
        theme: false,
        events: "disp-json.php?p=" + idProperty,
        eventColor: 'rgb(64, 81, 137)',

       eventClick: function(calEvent, jsEvent, view) {
          if (confirm(delRecord)) {
            $.get('disp_del.php', { e: calEvent.id }, function(data) {
              if(data == 'ok') {
                  $('#calendar').fullCalendar('refetchEvents');
              }
            });
          }
        }

      });

      $('#addDisp').click(function (e){
        tb = $(this);
        e.preventDefault();
        if($('#inicio').val() != '' && $('#final').val() != ''){
          if ($('#privado_disp').is(':checked')) {
              checked = 1;
          } else {
              checked = 0;
          }
          $.get('disp_add.php', { p: tb.attr('data-prop'), i: $('#inicio').val(), f: $('#final').val(), privado_disp: checked }, function(data) {
            $('#inicio').val('');
            $('#final').val('');
            $('#privado_disp').removeAttr('checked');
            $('#calendar').fullCalendar('refetchEvents');
          });
        }
      });

      $('#alarm_prop').change(function(e) {

        e.preventDefault();

        if ($(this).is(':checked') == true) {

          $('#alarmatxt').fadeIn('slow');

        } else{

          $('#alarmatxt').fadeOut('slow');

        }

      });

      $('#hipoteca_prop').change(function(e) {

        e.preventDefault();

        if ($(this).is(':checked') == true) {

          $('#hipotxt').fadeIn('slow');

        } else{

          $('#hipotxt').fadeOut('slow');

        }

      });

      $('#llaves_prop').change(function(e) {

        e.preventDefault();

        if ($(this).is(':checked') == true) {

          $('#llavetxt').fadeIn('slow');

        } else{

          $('#llavetxt').fadeOut('slow');

        }

      });

      $('#keyholder_prop').change(function(e) {

        e.preventDefault();

        if ($(this).is(':checked') == true) {

          $('#keytxt').fadeIn('slow');

        } else{

          $('#keytxt').fadeOut('slow');

        }

      });

        $(document).on('click', '.edit-name2', function(e) {
          e.preventDefault();
          tb = $(this);
          $('#myModal4').modal('show').on('shown.bs.modal', function () {
            $.get('dfiles_names.php', { p: tb.attr('data-id') }, function(data) {
              $('#myModal4 .loadingfrm').html(data);
            });
          }).on('hide.bs.modal', function () {
            $.post('dfiles_names.php', { p: tb.attr('data-id'), KT_Custom1: '1' , name_fil: $('#myModal4 #name_fil').val()  }, function(data) {
              // alert(data);
              $.get("dfiles_list.php?id_prop="+ idProperty, function(data) {
                if(data != '') {
                  $('#file-list2').html(data);
                }
              });
              $('.loadingfrm').css('background', 'url(../includes/assets/img/loading_big.gif) no-repeat center center').html('');
            });
          });
        });

      // Borrar archivo
      $(document).on('click', '.del-fil2', function(e) {
      e.preventDefault();

      tb = $(this);
      fil = tb.attr('href');

      if(confirm(delRecord)) {
          $.get(fil, { id: tb.attr('data-id') }, function(data) {
            if(data == 'ok') {
              tb.parent().parent().parent().fadeOut('slow', function() { $(this).remove(); });
            }
          });
      }

      return false;

      });

      $(document).on('click', '.del-imgp', function(e) {
      e.preventDefault();

      tb = $(this);
      fil = tb.attr('href');

      if(confirm(delRecord)) {
          $.get(fil, { id: tb.attr('data-id') }, function(data) {
            if(data == 'ok') {
                $('#' + tb.closest('li').attr('id')).remove();
            }
          });
      }

      return false;

      });

      $('.edit-prop').click( function(e) {

        e.preventDefault();

        $('#myModal6').modal('show').on('shown.bs.modal', function () {
          $.get('owners-form-update-ajax.php', { id_pro: $('#owner_prop').val() }, function(data) {
            $('#myModal6 .loadingfrm').css('background', '#fff').html(data);
            $('#myModal6 #type_pro').change();
          });
        }).on('hide.bs.modal', myHandler2);
      });

      function myHandler2() {

                var Valkeys = ($('#myModal6 #keyholder_pro').is(':checked') == true)?'1':'0';

                var percont = [];
                var num = 0;

                $('#myModal6 textarea[name^="worker"]').each(function() {
                    if ($(this).val() != '') {
                        percont[num++] = $(this).val();
                    }
                });

              $.post('owners-form-ajax.php?id_pro='+$('#owner_prop').val(), {
                nombre_pro: $('#myModal6 #nombre_pro').val(),
                apellidos_pro: $('#myModal6 #apellidos_pro').val(),
                telefono_fijo_pro: $('#myModal6 #telefono_fijo_pro').val(),
                telefono_movil_pro: $('#myModal6 #telefono_movil_pro').val(),
                nie_pro: $('#myModal6 #nie_pro').val(),
                pasaporte_pro: $('#myModal6 #pasaporte_pro').val(),
                keyholder_pro: ''+Valkeys+'',
                keyholder_name_pro: $('#myModal6 #keyholder_name_pro').val(),
                keyholder_tel_pro: $('#myModal6 #keyholder_tel_pro').val(),
                fecha_alta_pro: $('#myModal6 #fecha_alta_pro').val(),
                email_pro: $('#myModal6 #email_pro').val(),
                skype_pro: $('#myModal6 #skype_pro').val(),
                direccion_pro: $('#myModal6 #direccion_pro').val(),
                como_nos_conocio_pro: $('#myModal6 #como_nos_conocio_pro').val(),
                captado_por_pro: $('#myModal6 #captado_por_pro').val(),
                worker: percont,
                type_pro: $('#myModal6 #type_pro').val(),
                status_pro: $('#myModal6 #status_pro').val(),
                KT_Update1: '1'
              }, function(data) {

                $('#myModal6 #nombre_pro').val('');
                $('#myModal6 #apellidos_pro').val('');
                $('#myModal6 #telefono_fijo_pro').val('');
                $('#myModal6 #telefono_movil_pro').val('');
                $('#myModal6 #nie_pro').val('');
                $('#myModal6 #pasaporte_pro').val('');
                $('#myModal6 #keyholder_name_pro').val('');
                $('#myModal6 #keyholder_tel_pro').val('');
                $('#myModal6 #fecha_alta_pro').val('');
                $('#myModal6 #email_pro').val('');
                $('#myModal6 #skype_pro').val('');
                $('#myModal6 #direccion_pro').val('');
                $('#myModal6 #como_nos_conocio_pro').val('');
                $('#myModal6 #captado_por_pro').val('');
                $('#myModal6 #status_pro').val('');

                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: '/intramedianet/properties/properties-owners-select-single.php?q=' + data
                }).then(function (data){
                  console.log(data);
                  $.get('owner-data.php', { i: data}, function(data3) {
                       $('#owner-data').addClass('loading');
                       $('#owner-data').removeClass('loading').html(data3);
                   });
                  $(".select2owners").select2('data', { id:data.id, text: data.text}).change();
                });

                // $.get('owners-get-props.php', { s: data }, function(data2) {
                //     $('#owner_prop').html(data2).change();
                //     $.get('owner-data.php', { i: data}, function(data3) {
                //         $('#owner-data').addClass('loading');
                //         $('#owner-data').removeClass('loading').html(data3);
                //     });
                // });

              });

          $('#myModal6').off('hide.bs.modal', myHandler2);

      }

      $('#owner_prop').change(function() {
        if ($(this).val() != '') {

            $('#owner-data').addClass('loading');

            $.get('owner-data.php', { i: $('#owner_prop').val(), l: appLang }, function(data) {

              $('#owner-data').removeClass('loading').html(data);

            });

        } else{

            $('#owner-data').html('');

        }
      }).change();

      $(document).on('click', '.btn-dupli', function(e) {

            if (confirm(confirmDupli)) {
              return true;
            }

            return false;

      });

      $(document).on('click', '.btnsend', function(e) {

          e.preventDefault();

            if (!confirm(cliMailConf)) {
              return false;
            }
            $(this).append('<div class="loadingMail">');
            $.ajax({
              type: "GET",
              url: 'clients-send.php?ids='+idProperty+'&email='+$(this).data('email')+'&lang='+$(this).data('lang')+'&tipo=4',
                cache: false
            }).done(function( data ) {
                  if(data == 'ok') {
                    alert(mensaSend);
                    $('.loadingMail').remove();
                  }
            });

      });

      $('#interesados-tab').click(function() {

        ref = $('#referencia_prop').val();
        pre = $('#preci_reducidoo_prop').val();
        ope = $('#operacion_prop').val();
        typ = $('#tipo_prop').val();
        hab = $('#habitaciones_prop').val();
        ase = $('#aseos_prop').val();
        loc = $('#localidad_prop').val();

        $('#interesados-content').html('').addClass('loading');

        $.get('interested-clients.php?ref=' + ref + '&pre=' + pre + '&ope=' + ope + '&typ=' + typ + '&hab=' + hab + '&ase=' + ase + '&loc=' + loc + '&idpr=' + idProperty, function(data) {

          $('#interesados-content').removeClass('loading').html(data);

        });

      });

      $('#interesados-tab').click();

      $('#interesados-send-50').click(function(e) {

        e.preventDefault();

        sendit = false;

        porcen = $('#porcen').val();
        ref = $('#referencia_prop').val();
        pre = $('#preci_reducidoo_prop').val();
        ope = $('#operacion_prop').val();
        typ = $('#tipo_prop').val();
        hab = $('#habitaciones_prop').val();
        ase = $('#aseos_prop').val();
        loc = $('#localidad_prop').val();

        if (!confirm(cliMailConf)) {
          return false;
        }
        $.get('interested-clients-50.php?porcen=' + porcen + '&ref=' + ref + '&pre=' + pre + '&ope=' + ope + '&typ=' + typ + '&hab=' + hab + '&ase=' + ase + '&loc=' + loc, function(data) {

          emails = data.split("####");
          total50 = emails.length-1;
          xx= 0;


          for (var i in emails) {
            if (emails[i] != '' ) {
              $('#interesados-content').append('<div class="loadingMail">');
              emailCli = emails[i].split("@@@@");
              $.ajax({
                type: "GET",
                url: 'clients-send.php?ids='+idProperty+'&email='+emailCli[1]+'&cliente='+emailCli[0]+'&lang='+emailCli[2]+'&tipo=4',
                  cache: false
              }).done(function(data) {
                  xx = (xx*1)+1;
                  if (xx == total50) {
                      alert(mensaSend);
                      $('.loadingMail').remove();
                  }
              });
            }
          }
        });
      });


      $('.print-data').click(function (e){

        e.preventDefault();

        window.open('print-data.php?prop='+idProperty+'&propie='+$('#owner_prop').val()+'','print');

      });

      $('.addHist').click(function (e){

        e.preventDefault();

        var currentDate = new Date()
        var day = currentDate.getDate()
        var month = currentDate.getMonth() + 1
        var year = currentDate.getFullYear();
        var hour = currentDate.getHours();
        var minutes = currentDate.getMinutes();

        day = (day > 9)?day:'0'+day;
        month = (month > 9)?month:'0'+month;
        hour = (hour > 9)?hour:'0'+hour;
        minutes = (minutes > 9)?minutes:'0'+minutes;

        $('#notas_prop').val("[ " + day + "-" + month + "-" + year + " " + hour + ":" + minutes + " ] [ " + admiName + " ] → \n\n"+$('#notas_prop').val());

      });

      $('.calcPre').click(function(e){

        e.preventDefault();
        var precio_propietario = parseFloat($('#precio_propie_prop').val());
        var porcentaje_comision = parseFloat($('#comision_prop').val());
        var porcentaje_iva = parseFloat($('#iva_porc_prop').val());

        if (isNaN(precio_propietario)) {
          alert (precProp);
        }

        if (isNaN(porcentaje_comision)) {
          alert (precValor);
        }

        var comision = (precio_propietario*porcentaje_comision/100);

        if ($("#iva_prop").is(':checked')) {

            comision = comision + (comision*porcentaje_iva/100);

        }

        var precio_inmobiliaria = precio_propietario + comision;

        if (!isNaN(precio_inmobiliaria)) {
          $('#precio_venta_prop').val(precio_inmobiliaria);
          if (confirm(precConf)) {

            $('#preci_reducidoo_prop').val(precio_inmobiliaria);

          }
        }

        return false;
      });

      $(document).on('click', '.add-note', function(e) {
        e.preventDefault();
        tb = $(this);
        $('#myModal400').modal('show').on('shown.bs.modal', function () {

        }).on('hide.bs.modal', myHandler333);
      });

      function myHandler333() {

          $.post('owners-add-note.php', { id: ''+$('#owner_prop').val()+'', h: $('#myModal400 #historial_pro2').val()  }, function(data) {
            $.get("owners-add-note-txt.php?id="+$('#owner_prop').val()+"", function(data) {
              if(data != '') {
                $('#note-txt').html(data);
                $('#myModal400 #historial_pro2').val('');
              }
            });
          });


          $('#myModal400').off('hide.bs.modal', myHandler333);
      }

      $('.records-tables-simple').dataTable({
          dom: "<'row'<'col-sm-12 table-responsive'tr>>" +
          "<'row'<'col-sm-6'i><'col-sm-6'p>>",
          "iDisplayStart": 0,
          "iDisplayLength": 20,
          "bProcessing": false,
          "bStateSave": false,
          "bServerSide": false,
          "columnDefs": [
              { "type": "date-euro", targets: 3 }
          ]
      });

      $('.records-tables-simple2').dataTable({
          dom: "<'row'<'col-sm-12 table-responsive' ftr>>" +
          "<'row'<'col-sm-6'i><'col-sm-6'p>>",
          "iDisplayStart": 0,
          "iDisplayLength": 20,
          "bProcessing": false,
          "bStateSave": false,
          "bServerSide": false,
          "columnDefs": [
              { "type": "date-euro", targets: 4 }
          ]
      });

      $('.records-tables-simple3').dataTable({
          dom: "<'row'<'col-sm-12 table-responsive' ftr>>" +
          "<'row'<'col-sm-6'i><'col-sm-6'p>>",
          "iDisplayStart": 0,
          "iDisplayLength": 20,
          "bProcessing": false,
          "bStateSave": false,
          "bServerSide": false,
          "columnDefs": [
              { "type": "date-euro", targets: 2 }
          ]
      });

      $('.records-tables-simple4').dataTable({
          dom: "<'row'<'col-sm-12 table-responsive' ftr>>" +
          "<'row'<'col-sm-6'i><'col-sm-6'p>>",
          "iDisplayStart": 0,
          "iDisplayLength": 20,
          "bProcessing": false,
          "bStateSave": false,
          "bServerSide": false
      });

      $('.records-tables-simple5').dataTable({
          dom: "<'row'<'col-sm-12 table-responsive' ftr>>" +
          "<'row'<'col-sm-6'i><'col-sm-6'p>>",
          "iDisplayStart": 0,
          "iDisplayLength": 20,
          "bProcessing": false,
          "bStateSave": false,
          "bServerSide": false,
          "columnDefs": [
              { "type": "date-euro", targets: 2 },
              { "type": "date-euro", targets: 3 }
          ]
      });

    $(document).on('click', '.edit-lang', function(e) {
      e.preventDefault();
      tb = $(this);
      $('#myModalLang').modal('show').on('shown.bs.modal', myModalLangShowHandler).on('hide.bs.modal', myModalLangHideHandler);
    });

    function myModalLangShowHandler() {
        $.get('files_langs.php', { p: tb.attr('data-id') }, function(data) {
          $('#myModalLang .loadingfrm').css('background', '#fff').html(data);
        });
        $('#myModalLang').off('shown.bs.modal', myModalLangShowHandler);
    }

    function myModalLangHideHandler() {
        var nameVals = $('#myModalLang #langVals').serialize();
        $.get('files_langs.php?' + nameVals, function(data) {
          $.get("files_list.php?id_prop=" + idProperty, function(data) {
            if(data != '') {
                $('#file-list').html(data);
                $('.loadingfrm').css('background', 'url(../includes/assets/img/loading_big.gif) no-repeat center center').html('');
            }
          });
        });

        $('#myModalLang').off('hide.bs.modal', myModalLangHideHandler);

    }

    $('#hipoteca_prop').change(function(e) {
        e.preventDefault();
        if ($(this).is(':checked') == true) {
            $('#hipotxt').fadeIn('slow');
        } else{
            $('#hipotxt').fadeOut('slow');
        }
    });

    $('#llaves_prop').change(function(e) {
        e.preventDefault();
        if ($(this).is(':checked') == true) {
            $('#llavestxt').fadeIn('slow');
        } else{
            $('#llavestxt').fadeOut('slow');
        }
    });

    $('#keyholder_prop').change(function(e) {
        e.preventDefault();
        if ($(this).is(':checked') == true) {
            $('#keytxt').fadeIn('slow');
        } else{
            $('#keytxt').fadeOut('slow');
        }
    });

    $('#alarm_prop').change(function(e) {
        e.preventDefault();
        if ($(this).is(':checked') == true) {
            $('#alarmtxt').fadeIn('slow');
        } else{
            $('#alarmtxt').fadeOut('slow');
        }
    });



});

function reloadPrices() {
    $.get('prec-list.php', { id_prop: idProperty, lang: appLang }, function(data) {
        $('#precios-tbl').html(data);
    });
}

reloadPrices();

$(document).on('click', '#addBtn', function(e) {

    e.preventDefault();

    if($('#from_prc').val() == '') {
        alert(alertFinicio);
        return false;
    }

    if($('#to_prc').val() == '') {
        alert(alertFfinal);
        return false;
    }

    if(new Date($('#from_prc').val()).getTime() > new Date($('#to_prc').val()).getTime()) {
        alert(alertFmenor);
        return false;
    }

    if($('#price_prc').val() == '') {
        alert(alertFprice);
        return false;
    }

    $.get('prec-save.php', { from_prc: $('#from_prc').val(), to_prc: $('#to_prc').val(), price_prc: $('#price_prc').val(), KT_Insert1: '1', id_prop: idProperty, lang: appLang }, function(data) {
        if(data == 'ok') {
              $('#from_prc').val('');
              $('#to_prc').val('');
              $('#price_prc').val('');
              reloadPrices();
        }
    });

});

$(document).on('click', '#updBtn', function(e) {

    e.preventDefault();

    if($('#from_prc').val() == '') {
        alert(alertFinicio);
        return false;
    }

    if($('#to_prc').val() == '') {
        alert(alertFfinal);
        return false;
    }

    if(new Date($('#from_prc').val()).getTime() > new Date($('#to_prc').val()).getTime()) {
        alert(alertFmenor);
        return false;
    }

    if($('#price_prc').val() == '') {
        alert(alertFprice);
        return false;
    }

    $.get('prec-save.php', { id: $('#prcid').val(), from_prc: $('#from_prc').val(), to_prc: $('#to_prc').val(), price_prc: $('#price_prc').val(), KT_Update1: '1', id_prop: idProperty, lang: appLang }, function(data) {
        if(data == 'ok') {
            $('#from_prc').val('');
            $('#to_prc').val('');
            $('#price_prc').val('');
            $('#addBtn').show();
            $('#updBtn').hide();
            reloadPrices();
        }
    });

});

$(document).on('click', '.editprec', function(e) {
    e.preventDefault();
    btn = $(this);
    $.get('prec-get.php', { id: btn.data('id'), id_prop: idProperty, lang: appLang, KT_Delete1: '1' }, function(data) {
        if(data != '') {
        n=data.split("@");
            $('#from_prc').val(n[0]);
            $('#to_prc').val(n[1]);
            $('#price_prc').val(n[2]);
            $('#prcid').val(n[3]);
            $('#addBtn').hide();
            $('#updBtn').show();
            reloadPrices();
        }
    });
});

$(document).on('click', '.delprec', function(e) {
    e.preventDefault();
    btn = $(this);
    if (confirm("¿Seguro que desea borrar este registro?")) {
        $.get('prec-save.php', { id: btn.data('id'), id_prop: idProperty, lang: appLang, KT_Delete1: '1' }, function(data) {
            if(data == 'ok') {
                reloadPrices();
            }
        });
    }
});

var nestedSortablesVideo = [].slice.call(document.querySelectorAll('.nested-sortable-imgPDF'));
if (nestedSortablesVideo) {
    Array.from(nestedSortablesVideo).forEach(function (nestedSortVideo){
        sortablePDF = new Sortable(nestedSortVideo, {
            // handle: '.handle',
            // group: 'nested',
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65,
            onUpdate: function (evt) {
            var order = sortablePDF.toArray();
            $('#mg-order-loadingPDF').css({ width: $('#images-listPDF').outerWidth(), height: $('#images-listPDF').outerHeight() + 5 }).fadeIn();
                $.get("images_order_pdf.php?order="+order, function(data) {
                    $('#img-order-loadingPDF').fadeOut();
                });
            }
        });
    });
}

$(document).on('click', '#imgsPDF', function(e) {
    $.get("images_list_pdf.php?id_prop=" + idProperty, function(data) {
        if(data != '') {
            $('#images-listPDF').html(data);
        }
    });
});

function isData() {
    var plus = document.getElementsByClassName('plus');
    var minus = document.getElementsByClassName('minus');

    if (plus) {
        Array.from(plus).forEach(function (e) {
            e.addEventListener('click', function (event) {
                if (parseInt(e.previousElementSibling.value) < event.target.previousElementSibling.getAttribute('max')) {
                    event.target.previousElementSibling.value++;
                }
            });
        });
    }

    if (minus) {
        Array.from(minus).forEach(function (e) {
            e.addEventListener('click', function (event) {
                if (parseInt(e.nextElementSibling.value) > event.target.nextElementSibling.getAttribute('min')) {
                    event.target.nextElementSibling.value--;
                }
            });
        });
    }
}

isData();


$(document).ready(function() {

  toggleScrollBarIcon();

  var calendar = $('#calendario').fullCalendar({
      header: {
        left: '',
        center: '',
        right: ''
      },
      views: {
        agenda31Days: {
            type: 'list',
            duration: { days: 31 },
            buttonText: next31
        },
        agendaAllDays: {
            type: 'list',
            buttonText: Allevents,
            visibleRange: {
                start: '2010-01-01',
                end: '2050-12-31'
            }
        }
      },
      buttonText: {
      today: today,
      month: month,
      week: week,
      day: day,
      },
      firstDay: 1,
      aspectRatio: 1.5,
      selectable: true,
      selectHelper: true,
      longDateFormat: {
          LT: "H:mm",
          L: "DD/MM/YYYY",
          LL: "D [de] MMMM [del] YYYY",
          LLL: "D [de] MMMM [del] YYYY LT",
          LLLL: "dddd, D [de] MMMM [del] YYYY LT"
      },
      defaultView: "agenda31Days",
      weekHeader: "Sm",
      dateFormat: "dd/mm/yy",
      axisFormat: 'HH:mm',
      timeFormat: 'HH:mm',
      slotDuration: '00:15:00',
      scrollTime: '09:00:00',
      monthNames: monthNames,
      dayNamesShort: dayNamesShort,
      dayNames: dayNames,
      allDayText: allDayText,
      allDaySlot: false,
      editable: false,
      theme: false,
      editable: true,
      events: "/intramedianet/calendar/disp-json-home.php?lang=" + AppLang,
      eventRender: function(event, element) {

      },
     dayClick: function(date, allDay, jsEvent, view) {
        $('.add-cita').click();
        $('#inicio_ct').val(date.format('DD-MM-YYYY') + roundTimeQuarterHour(0));
        $('#final_ct').val(date.format('DD-MM-YYYY') + roundTimeQuarterHour(1));
        $('#titulo_ct').val('');
        $('#lugar_ct').val('');
        $('#notas_ct').val('');
        $('#categoria_ct').val('');
        $('.select2clientes').select2({
            ajax: {
              url: function (params) {
                  return '/intramedianet/properties/properties-buyers-select.php?q=' + params;
              },
              dataType: 'json',
              delay: 250,
              results: function (data, params) {
                  return {
                      results: data.results
                  };
              },
              cache: true,
              },
              placeholder: 'Search buyer by name',
              minimumInputLength: 3,
          });
        $('#users_ct').val('');
        $('.select2references').select2({
            multiple:true,
            ajax: {
              url: function (params) {
                  return '/intramedianet/properties/properties-references-select.php?q=' + params;
              },
              dataType: 'json',
              delay: 250,
              results: function (data, params) {
                  return {
                      results: data.results
                  };
              },
              cache: true,
              },
              placeholder: 'Search buyer by name',
              minimumInputLength: 3,
          });
        $('#property_ct').val('');
     },
     eventDrop: function( event, delta, revertFunc, jsEvent, ui, view ) {
        if (event.end == null) {
            $.get("/intramedianet/calendar/calendario-form-dates.php?inicio_ct="+event.start.format('DD-MM-YYYY HH:mm')+"&final_ct="+event.start.format('DD-MM-YYYY HH:mm')+"&id_ct="+event.id+"", function(data) {
              $('#calendario').fullCalendar('refetchEvents');
            });
        } else {
            $.get("/intramedianet/calendar/calendario-form-dates.php?inicio_ct="+event.start.format('DD-MM-YYYY HH:mm')+"&final_ct="+event.end.format('DD-MM-YYYY HH:mm')+"&id_ct="+event.id+"", function(data) {
              $('#calendario').fullCalendar('refetchEvents');
            });
        }
     },
     eventResize: function( event, jsEvent, ui, view ) {
          $.get("/intramedianet/calendar/calendario-form-dates.php?inicio_ct="+event.start.format('DD-MM-YYYY HH:mm')+"&final_ct="+event.end.format('DD-MM-YYYY HH:mm')+"&id_ct="+event.id+"", function(data) {
            $('#calendario').fullCalendar('refetchEvents');
            // alert(calAddOk);
          });
     },
     eventClick: function(calEvent, jsEvent, view) {

          var content = '';
          content += '<div class="modal-header" style="background: '+calEvent.backgroundColor+' !important;">';
          content += '<h5 class="modal-title text-white pb-3"><b>';
                              content += calEvent.titulo;
                              content += '</b><br>';
                              content += '<small>'+calEvent.category+' // '+calEvent.user+'</small>';
                              content += '</h5>';
          content += '<button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>';
          content += '</div>';
          content += '<div class="modal-body">';
          content += '<ul class="list-unstyled">';
          if (calEvent.inicio != calEvent.final) {
            content += '<li style="margin-top: 5px;"><b><i class="fa-regular fa-calendar-arrow-down"></i> ' + calFechaInicio + ':</b> '+calEvent.inicio+'</li>';
          }
          content += '<li style="margin-top: 5px;"><b><i class="fa-regular fa-calendar-arrow-up"></i> ' + calFechaFinal + ':</b> '+calEvent.final+'</li>';
          if ((calEvent.usern != null && calEvent.usern != '') || (calEvent.usera != null && calEvent.usera != '')) {
            content += '<li style="margin-top: 5px;"><b><i class="fa-regular fa-user"></i> ' + calClientex + ':</b> <a href="/intramedianet/properties/clients-form.php?id_cli='+calEvent.idn+'" target="_blank" class="btn btn-soft-primary btn-sm">';
            if (calEvent.usern != null) {
                content += calEvent.usern + ' ';
            }
            if (calEvent.usera != null) {
                content += calEvent.usera + ' ';
            }
            content += '</a></li>';
          }
          if ((calEvent.userv != null && calEvent.userv != '') || (calEvent.userva != null && calEvent.userva != '')) {
            content += '<li style="margin-top: 5px;"><b><i class="fa-regular fa-user-tie-hair"></i> ' + calPropx + ':</b> <a href="/intramedianet/properties/owners-form.php?id_pro='+calEvent.idv+'" target="_blank" class="btn btn-soft-primary btn-sm">';
            if (calEvent.userv != null) {
                content += calEvent.userv + ' ';
            }
            if (calEvent.userva != null) {
                content += calEvent.userva + ' ';
            }
            content += '</a></li>';
          }
          if (calEvent.property != 'null' && calEvent.property != '') {
            var refsLP = calEvent.property.split(",");
            var idesLP = calEvent.ids.split(",");
            content += '<li style="margin-top: 5px;"><b><i class="fa-regular fa-building"></i> ' + calPropiedad + ':</b> ';
            for (var i = 0; i < refsLP.length; i++) {
                content += '<a href="/intramedianet/properties/properties-form.php?id_prop='+idesLP[i]+'" target="_blank" class="btn btn-soft-primary btn-sm">'+refsLP[i]+'</a> ';
            }
            // +calEvent.ref+' '+calEvent.ids+
            content +='</li>';
          }
          if (calEvent.lugar != null && calEvent.lugar != '') {
            content += '<li style="margin-top: 5px;"><b><i class="fa-regular fa-location-dot"></i> ' + calLugar + ':</b> '+calEvent.lugar+'</li>';
          }
          content += '</ul>';
          if (calEvent.notas != null) {
            content += '<div style="height: 100px; overflow: scroll; margin: 5px;">';
            content += ''+calEvent.notas+'';
            content += '</div>';
          }
          content += '</div>';
          if (calEvent.backgroundColor != $eventBgColor) {
              content += '<div class="modal-footer  bg-soft-primary">';
              content += '<a href="" class="btn btn-success btn-sm edit-event mt-4" data-id="'+calEvent.id+'"><i class="fa-regular fa-pencil "></i> '+dtEditar+'</a>';
              content += '<a href="" class="btn btn-danger btn-sm delete-event mt-4" data-id="'+calEvent.id+'"><i class="fa-regular fa-trash-can "></i> '+dtEliminar+'</a>';
              content += '</div>';
          }

          $('#event-text').html(content);
          $('#myModal3').modal('show');

      }

    });

    $(document).on('click', '.add-cita', function(e) {
      e.preventDefault();
      tb = $(this);
      $('.add-cita').attr('name','KT_Insert1');
      $('#myModal').modal('show').on('shown', function () {

      });//.on('hide', myHandler);
      $('.add-cita').attr('name','KT_Insert1');
      $('#titulo_ct').val('');
      $('#lugar_ct').val('');
      $('#notas_ct').val('');
      $('#categoria_ct').val('');
      $('.select2clientes').select2('destroy').select2({
          ajax: {
            url: function (params) {
                return '/intramedianet/properties/properties-buyers-select.php?q=' + params;
            },
            dataType: 'json',
            delay: 250,
            results: function (data, params) {
                return {
                    results: data.results
                };
            },
            // cache: true,
            },
            placeholder: 'Search buyer by name',
            minimumInputLength: 3,
        });
      $('.select2vendors').select2('destroy').select2({
          ajax: {
            url: function (params) {
                return '/intramedianet/properties/properties-vendors-select.php?q=' + params;
            },
            dataType: 'json',
            delay: 250,
            results: function (data, params) {
                return {
                    results: data.results
                };
            },
            // cache: true,
            },
            placeholder: 'Search buyer by name',
            minimumInputLength: 3,
        });
      $('#users_ct').val('');
      $('#vendedores_ct').val('');
        $('.select2references').select2({
            multiple:true,
            ajax: {
              url: function (params) {
                  return '/intramedianet/properties/properties-references-select.php?q=' + params;
              },
              dataType: 'json',
              delay: 250,
              results: function (data, params) {
                  return {
                      results: data.results
                  };
              },
              cache: true,
              },
              placeholder: 'Search buyer by name',
              minimumInputLength: 3,
          });
      $('#property_ct').val('');
    });

    $(document).on('click', '#btn-close-save', function(e) {
      e.preventDefault();
      tb = $(this);
      var formVals = $("#form1").serialize();
      $.get("/intramedianet/calendar/calendario-form.php?"+formVals+"&KT_Update1=ok", function(data) {
        $('#calendario').fullCalendar('refetchEvents');
        alert(calAddOk);
      });
      $('#myModal').modal('hide');
      $('#myModal3').modal('hide')
    });

    $(document).on('click', '#btn-close', function(e) {
      e.preventDefault();
      tb = $(this);
      clearForm();
      $('#myModal').modal('hide');
      $('#myModal3').modal('hide');
    });

    $(document).on('click', '.edit-event', function(e) {
      e.preventDefault();
      tb = $(this);
        $.get("/intramedianet/calendar/disp-datos.php?lang=" + AppLang + "&id="+tb.data('id'), function(data) {
          $('.add-cita').attr('name','KT_Update1');
          var jsonObject = $.parseJSON(data);
          $('#id_ct').val(jsonObject[0].id_ct);
          $('#categoria_ct').val(jsonObject[0].categoria_ct);
          $('#user_ct').val(jsonObject[0].user_ct);
          $('#users_ct').val(jsonObject[0].users_ct);
          if (jsonObject[0].users_ct != null) {
              $.ajax({
                  type: 'GET',
                  dataType: 'json',
                  url: '/intramedianet/properties/properties-buyers-select-single.php?q=' + jsonObject[0].users_ct
              }).then(function (data) {
                $(".select2clientes").select2('data', { id:data.id, text: data.text});
              });
          }
          if (jsonObject[0].vendedores_ct != null) {
              $.ajax({
                  type: 'GET',
                  dataType: 'json',
                  url: '/intramedianet/properties/properties-owners-select-single.php?q=' + jsonObject[0].vendedores_ct
              }).then(function (data) {
                $(".select2vendors").select2('data', { id:data.id, text: data.text});
              });
          }
          if (jsonObject[0].property_ct != null) {
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: '/intramedianet/properties/properties-references-select-multiple.php?q=' + jsonObject[0].property_ct
            }).done(function (data) {
                $(".select2references").select2('data', data);
            });
          }

          $('#inicio_ct').val(jsonObject[0].inicio_ct);
          $('#final_ct').val(jsonObject[0].final_ct);
          $('#titulo_ct').val(jsonObject[0].titulo_ct);
          $('#lugar_ct').val(jsonObject[0].lugar_ct);
          $('#notas_ct').val(jsonObject[0].notas_ct);
          $('.select2').change();
        });
      $('#myModal').modal('show');
    });

    $(document).on('click', '.delete-event', function(e) {
      e.preventDefault();
      tb = $(this);
      if (confirm(calDel)) {
        $.get("/intramedianet/calendar/calendario-form.php?lang=" + AppLang + "&KT_Delete1=ok&id_ct="+tb.data('id'), function(data) {
          $('#calendario').fullCalendar('refetchEvents');
        });
        $('#myModal3').modal('hide');
      }

    });

    $('.addHist').click(function (e){

        e.preventDefault();

        var currentDate = new Date();
        var day = currentDate.getDate();
        var month = currentDate.getMonth() + 1;
        var year = currentDate.getFullYear();
        var hour = currentDate.getHours();
        var minutes = currentDate.getMinutes();

        day = (day > 9)?day:'0'+day;
        month = (month > 9)?month:'0'+month;
        hour = (hour > 9)?hour:'0'+hour;
        minutes = (minutes > 9)?minutes:'0'+minutes;

        $('#notas_ct').val("[ " + day + "-" + month + "-" + year + " " + hour + ":" + minutes + " ] [ " + admiName + " ] → \n\n"+$('#notas_ct').val());

    });

});

function show_Chart(elm, data) {
  $plot = $.plot(elm, data, {
      series: {
          pie: {
              show: true,
              radius: 0.6,
              label: {
                  show: true,
                  radius: 3/4,
                  formatter: labelFormatter,
                  background: {
                      opacity: 0,
                  }
              }
          }
      },
      legend: {
        show: true
      },
      grid: {
          hoverable: true,
          clickable: true
      }
  });

  $(elm).bind("plotclick", function(event, pos, obj) {
    if (!obj) { return; }
    percent = parseFloat(obj.series.percent).toFixed(2);
    alert(""  + obj.series.label.replace("&nbsp;&nbsp;", "") + ": " + percent + "%");
  });
}

function labelFormatter(label, series) {
  return Math.round(series.percent) + "%";
}

function myHandler() {

  alert('ocultado');

    $('#myModal').off('hide', myHandler);
}

function clearForm() {

  $('#form1 input[type=text], #form1 textarea').val('');
  $('#form1 #categoria_ct, #form1 #users_ct, #form1 #property_ct').val('').trigger('liszt:updated');

}

function roundTimeQuarterHour(plus) {
    var coeff = 1000 * 60 * 15;
    var date = new Date();
    var rounded = new Date(Math.round(date.getTime() / coeff) * coeff);
    time = ' ' + (rounded.getHours() + plus) + ':' + rounded.getMinutes();
    return time;
}

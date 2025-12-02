 $(document).ready(function() {

     // $(".baner-imgest-order").sortable({
     //   placeholder: "sortable-highlight-banner",
     //   update : function () {
     //       var order = $('.baner-imgest-order').sortable('serialize');

     //       $('.loading-ord').fadeIn();

     //       $.get("banner_order.php?"+order, function(data) {
     //         $('.loading-ord').fadeOut();
     //       });
     //   }
     // }).disableSelection();

    var nestedSortablesHandles = [].slice.call(document.querySelectorAll('.nested-sortable-handle'));
    if (nestedSortablesHandles) {
        Array.from(nestedSortablesHandles).forEach(function (nestedSortHandle){
            sortable = new Sortable(nestedSortHandle, {
                // handle: '.handle',
                group: 'nested',
                animation: 150,
                fallbackOnBody: true,
                swapThreshold: 0.65,
                onUpdate: function (evt) {
                    var order = sortable.toArray();
                    $('.loading-ord').html('<i class="fa-solid fa-hourglass-end text-muted fa-flip" style="--fa-flip-x: 1; --fa-flip-y: 0;"></i>');
                    $.get("banner_order.php?order="+order, function(data) {
                        $('.loading-ord').html('<i class="fa-solid fa-check text-success"></i>');
                        setTimeout(function(){$('.loading-ord').html('');}, 5000);
                    });
                }
            });
        });
    }

 });

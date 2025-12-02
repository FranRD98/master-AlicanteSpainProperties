$(document).ready(function($) {

    $(document).on('click', '.showInfo', function(e) {
        e.preventDefault();
        tb = $(this);
        $('#myModal').modal('show');
    });

    $('#sendFriendForm').submit(function (e){
          e.preventDefault();
              $('.modal-body').append('<div class="loadingfrm">');
              $.get("/intramedianet/properties/enquiries-send.php?" + $(this).serialize()).done(function(data) {
                  if (data == 'ok') {
                      $('#sendFriendForm input[type=text], #sendFriendForm textarea').val('');
                      $('.modal-body .loadingfrm').remove();
                      alert(mensaSend);
                      $('#friendPureModal .close-reveal-modal').click();
                      window.location.reload();
                  }
              });
      });

});

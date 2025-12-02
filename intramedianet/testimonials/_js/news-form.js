$(document).ready(function() {

    $(".multi_images").pluploadQueue({
      runtimes : 'html5,flash,silverlight,html4',
      url : '/intramedianet/news/images_upload.php?id_nws=' + idNews,
      max_file_size : '100mb',
      unique_names : true,
      multiple_queues: true,
      // browse_button : 'pickfiles',
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
        $.get("images_list.php?id_nws=" + idNews, function(data) {
          if(data != '') {
            $('#images-list').html(data);
          }
        });

      }
      });
    }

    $(document).on('click', '.edit-alt', function(e) {
      e.preventDefault();
      tb = $(this);
      $('#myModal').modal('show').on('shown.bs.modal', function () {
        $.get('images_alts.php', { p: tb.attr('data-id') }, function(data) {
          $('#myModal .loadingfrm').css('background', '#fff').html(data);
        });
      }).on('hide.bs.modal', function () {
        var altsVals = $('#myModal :input').serialize();
        $.get('images_alts.php?' + altsVals,  function(data) {
          $('.loadingfrm').css('background', 'url(../includes/assets/img/loading_big.gif) no-repeat center center').html('');
          $.get("images_list.php?id_nws=" + idTeams, function(data) {
            if(data != '') {
              $('#images-list').html(data);
            }
          });
        });
      });
    });

});

(function($, window, document, undefined) {
  Drupal.behaviors.general = {
    attach: function (context) {
      $("a.coactor").off("click").on("click", function(e) {
        e.preventDefault();
        var aid = $(this).attr('actor-id');
        var mid = $(this).attr('movie-id');
        console.log(aid);
        console.log(mid);
        console.log(Drupal.url('coactor/' + mid + '/' + aid));
        if (aid) {
          $.ajax({
            // Hitting the url of costar page.
            url: Drupal.url('coactor/' + mid + '/' + aid),
            type:"POST",
            // data: JSON.stringify(data),
            contentType:"application/json; charset=utf-8",
            dataType:"json",
            // If function return JsonResponse suucessfully pop up a dialouge box.
            success: function(response) {
              console.log(response);
              $(".modal-title").html(response.name);
              $(".modal-body img ").attr("src",response.image);
              $(".modal-body p").html(response.role);
              // When clicked on costar name costar pop up will open.
              $('.modal').show();
              // when click on close button hide the pop-up
              $('.close').click(function(){
                $('.modal').hide();
              });
            }
          });
        }
      });
    }
  }
})(jQuery, window, document);

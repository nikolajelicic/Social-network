jQuery(document).ready(function(){
    var button = $('.postLikes')
    $(document).on('click', '.postLikes', function () {
      $('#likes').empty();
        var post_id = $(this).data('post-id');
        $.ajax({
            url: '/showLikes/' + post_id,
            method: 'GET',
            dataType: 'JSON',
            success: function(data){
              console.log(data)
              data.data.forEach(item => {
                $('#likes').append(`<li class="list-group-item">${item.user.name}</li>`)
              });
            },
            error: function(error){
                console.error(error);
            }
        })
    })

    var button = $('.commentLikes')
    $(document).on('click', '.commentLikes', function () {
      $('#likes').empty();
        var comment_id = $(this).data('comment-id');
        $.ajax({
            url: '/commentLikes/' + comment_id ,
            method: 'GET',
            dataType: 'JSON',
            success: function(data){
              console.log(data)
              data.data.forEach(item => {
                $('#likes').append(`<li class="list-group-item">${item.user.name}</li>`)
              });
            },
            error: function(error){
                console.error(error);
            }
        })
    })
})
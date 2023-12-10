jQuery(document).ready(function(){
    $(document).on('click', '.postLikes', function () {
      $('#likes').empty();
        var post_id = $(this).data('post-id');
        $.ajax({
            url: '/showLikes/' + post_id,
            method: 'GET',
            dataType: 'JSON',
            success: function(data){
              //console.log(data)
              data.data.forEach(item => {
                $('#likes').append(`<li class="list-group-item">${item.user.name}</li>`)
              });
            },
            error: function(error){
                //console.error(error);
            }
        })
    })

    $(document).on('click', '.commentLikes', function () {
      $('#likes').empty();
        var comment_id = $(this).data('comment-id');
        $.ajax({
            url: '/commentLikes/' + comment_id ,
            method: 'GET',
            dataType: 'JSON',
            success: function(data){
              //console.log(data)
              data.data.forEach(item => {
                $('#likes').append(`<li class="list-group-item">${item.user.name}</li>`)
              });
            },
            error: function(error){
                //console.error(error);
            }
        })
    })

    $('#searchButton').on('click', function() {
      executeSearch();
    });

    $('#searchInput').on('input', function() {
        executeSearch();
    });

    function executeSearch() {
        let searchTerm = $('#searchInput').val();

        if (searchTerm.length >= 2) {
            $.ajax({
                url: `/search-users?search=${searchTerm}`,
                method: 'GET',
                dataType: 'json',
                success: function(users) {
                    let searchResults = $('#searchResults');
                    searchResults.empty();

                    users.forEach(user => {
                      let listItem = $('<a class="dropdown-item"></a>').attr('href', `/profile/${user.slug}`).text(user.name);
                      searchResults.append(listItem);
                    });
                },
                error: function(error) {
                    //console.error('Error:', error);
                }
            });
        } else {
            $('#searchResults').empty();
        }
    }
})
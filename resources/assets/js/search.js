$('#search-admin-reservations').click( function (e) {
    e.preventDefault();
    var keyword = $('#keyword').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: '/search/adminreservations',
        dataType: "JSON",
        cache: false,
        data: {
            keyword: keyword,
        },
        success: function(response) {
            $.each(response, function() {
                console.log(this);
                
            });
            $("#search-results").html(response);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("error: "+ XMLHttpRequest.responseText);
        }
    });
});

const fetchNotifications = () => {
    const data = {
        [`${$('meta[name="csrf_token_name"]').attr('content')}`]: $('meta[name="X-CSRF-TOKEN"]').attr('content')
    };
    
    $.ajax({
        url: baseUrl + 'dashboard/notifications',
        type: 'POST',
        data: data,
        success: function(response) {
            console.log(response);
            $('#loading-notifications').hide();
            $('#notifications-area').append(response);
        },
        error: function(xhr, status, error) {
            console.error("An error occurred: ", error);
        }
    });
}

$(document).ready(function() {
    fetchNotifications();
});
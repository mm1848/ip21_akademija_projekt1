$(document).ready(function() {
    $('#priceForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'GET',
            url: 'show_price.php',
            data: formData,
            success: function(response) {
                $('#priceResult').html(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});

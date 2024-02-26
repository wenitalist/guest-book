$(document).ready(function(){
    $('#auth-form').submit(function(e){
        e.preventDefault();
        
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(response) {
                alert(1);
                if (response.success && response.action == 'authorization') {
                    window.location.href = '/';
                } else if (response.success && response.action == 'registration') {
                    window.location.href = '/authorization';
                } else {
                    window.location.href = '/authorization';
                    $('#error-message').text(response.message).show();
                }
            },
            error: function() {
                alert(1);
                $('#error-message').text('Ошибка при отправке запроса').show();
            }
        });
    });
});
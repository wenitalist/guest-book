document.addEventListener('DOMContentLoaded', function() { 
    const form = document.getElementById('auth-form');

    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        let errorMessage = document.getElementById('error-message');
        let link = 'http://wenitalist.local:80' + form.getAttribute('action');

        try {
            const response = await fetch(link, {
                method: 'POST',
                body: new FormData(this)
            });
            const data = await response.json();

            if ((data['success'] === false && data['action'] === 'authorization') || (data['success'] === false && data['action'] === 'registration')) {
                errorMessage.innerHTML = data['message'];
                errorMessage.style.cssText = 'color: rgb(222, 1, 1); font-size: 22px;';
            } else {
                window.location.href = data['redirect'];
            }
        } catch (error) {
            errorMessage.innerHTML = 'Ошибка на сервере';
            errorMessage.style.cssText = 'color: rgb(222, 1, 1); font-size: 22px;';
        }
    });
});
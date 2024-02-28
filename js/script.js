document.addEventListener('DOMContentLoaded', function() { 
    const form = document.getElementById('auth-form');

    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        let errorMessage = document.getElementById('error-message');

        try {
            const response = await fetch('http://wenitalist.local:80/auth', {
                method: 'POST',
                body: new FormData(this)
            });
            const data = await response.json();
            
            if (data['success'] === true && data['action'] === 'authorization') {
                window.location.href = "/";
            } else if (data['success'] === false && data['action'] === 'authorization') {
                errorMessage.innerHTML = 'Неправильный логин или пароль';
                errorMessage.style.cssText = 'color: rgb(222, 1, 1); font-size: 22px;';
            }
        } catch (error) {
            errorMessage.innerHTML = 'Ошибка на сервере';
            errorMessage.style.cssText = 'color: rgb(222, 1, 1); font-size: 22px;';
        }
    });
});
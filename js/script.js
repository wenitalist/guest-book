document.addEventListener('DOMContentLoaded', function() { 
    if (window.location.pathname === '/authorization' || window.location.pathname === '/registration') {
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

                if (data['success'] === false) {
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
    }

    if (window.location.pathname === '/' && document.getElementById('del-form')) {
        const form = document.getElementById('del-form');

        form.addEventListener('submit', async function(event) {
            event.preventDefault();
            let message = document.getElementById('del-message');
            let link = 'http://wenitalist.local:80' + form.getAttribute('action');

            try {
                const response = await fetch(link, {
                    method: 'POST',
                    body: new FormData(this)
                });
                const data = await response.json();

                if (data['success'] === true) {
                    window.location.href = data['redirect'];
                } else {
                    message.innerHTML = data['message'];
                    message.style.cssText = 'color: rgb(222, 1, 1)';
                }
            } catch (error) {
                message.innerHTML = 'Ошибка на сервере';
                message.style.cssText = 'color: rgb(222, 1, 1)';
            }
        });
    }
});
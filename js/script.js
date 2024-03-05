document.addEventListener('DOMContentLoaded', function() { 
    if (window.location.pathname === '/authorization' || window.location.pathname === '/registration') {

        const inputName = document.getElementById('inputName');
        const inputMail = document.getElementById('inputMail');
        const inputPassword = document.getElementById('inputPassword');

        const form = document.getElementById('auth-form');

        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            let errorMessage = document.getElementById('error-message');
            let link = 'http://wenitalist.local:80' + form.getAttribute('action');

            let regexForName = /^[A-Za-zА-ЯЁа-яё. ]+/u;
            let regexForMail = /^[A-Za-z0-9_-]+@[A-Za-z.]+$/;
            let regexForPass = /^[A-Za-z0-9!#$%&?*~_-]+/;

            if (inputName && !regexForName.test(inputName.value)) {
                errorMessage.innerHTML = 'Неправильный формат имени';
                errorMessage.style.cssText = 'color: rgb(222, 1, 1); font-size: 22px;';
                return;
            } else if (!regexForMail.test(inputMail.value)) {
                errorMessage.innerHTML = 'Неправильный формат почты';
                errorMessage.style.cssText = 'color: rgb(222, 1, 1); font-size: 22px;';
                return;
            } else if (!regexForPass.test(inputPassword.value)) {
                errorMessage.innerHTML = 'Неправильный формат пароля';
                errorMessage.style.cssText = 'color: rgb(222, 1, 1); font-size: 22px;';
                return;
            };

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

        inputMail.addEventListener('keypress', function(event) {
            let inputChar = event.key;
            let regex = /^[A-Za-z0-9.@_-]+/;

            if (!regex.test(inputChar)) {
                event.preventDefault();
            }
        });

        inputPassword.addEventListener('keypress', function(event) {
            let inputChar = event.key;
            let regex = /^[A-Za-z0-9!#$%&?*~_-]+/;

            if (!regex.test(inputChar)) {
                event.preventDefault();
            }
        });

        if (inputName) {
            inputName.addEventListener('keypress', function(event) {
                let inputChar = event.key;
                let regex = /^[A-Za-zА-ЯЁа-яё. ]+/u;
    
                if (!regex.test(inputChar)) {
                    event.preventDefault();
                }
            });
        }
    }

    if (window.location.pathname === '/') {

        const inputName = document.getElementById('inputName');
        //const inputComment = document.getElementById('inputComment');

        const form = document.getElementById('publish-form');

        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            let message = document.getElementById('publish-form-error-message');
            let link = 'http://wenitalist.local:80' + form.getAttribute('action');

            let regexForName = /^[A-Za-zА-ЯЁа-яё. ]+/u;
            if (!regexForName.test(inputName.value)) {
                message.innerHTML = 'Неправильный формат имени';
                message.style.cssText = 'color: rgb(222, 1, 1); font-size: 22px;';
                return;
            }

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

        if (inputName) {
            inputName.addEventListener('keypress', function(event) {
                let inputChar = event.key;
                let regex = /^[A-Za-zА-ЯЁа-яё. ]+/u;
    
                if (!regex.test(inputChar)) {
                    event.preventDefault();
                }
            });
        }
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

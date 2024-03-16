function openModalWindow(imageName) {
    let modal = document.getElementById('modal-window');
    let image = document.getElementById('modal-image');

    image.setAttribute('src', imageName);

    modal.style.display = 'block';
}

function closeModalWindow() {
    let modal = document.getElementById('modal-window');

    modal.style.display = 'none';
}

function imageClick(event) { // Для того чтобы при нажатии на картинку не закрывалось модальное окно
    event.stopPropagation();
}

function autoGrow(element) { // Автоматическое увеличение высоты textarea
    element.style.height = "127px"; // Минимальная высота текстового поля
    element.style.height = (element.scrollHeight) + "px"; // Получает высоту содержимого в текстовом поле и задаёт высоту для самого текстового поля
}

document.addEventListener('DOMContentLoaded', function() { 

    var errorColor = 'rgb(222, 1, 1);';
    var errorFontSize = '20px;';

    var protocol = window.location.protocol + '//';
    var domain = window.location.host;

    if (window.location.pathname === '/authorization' || window.location.pathname === '/registration') {
        authPage();
    }

    if (window.location.pathname === '/') {
        mainPage();
    }

    if (window.location.pathname === '/' && document.getElementById('del-form')) {
        mainPageAdmin();
    }

    function mainPage() {
        const inputName = document.getElementById('inputName');
        const form = document.getElementById('publish-form');
        const textarea = document.getElementById('inputComment');

        textarea.addEventListener('input', function() {
            const row = this.value;
            if (row.includes('\n')) {
                console.log(true);
            }
        });

        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            let message = document.getElementById('publish-form-error-message');
            let link = protocol + domain + form.getAttribute('action');

            if (inputName && !validateName(inputName.value)) {
                message.textContent = 'Неправильный формат имени';
                message.style.cssText = `color: ${errorColor} font-size: ${errorFontSize}`;
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
                    message.textContent = data['message'];
                    message.style.cssText = `color: ${errorColor} font-size: ${errorFontSize}`;
                }
            } catch (error) {
                message.textContent = 'Ошибка на сервере';
                message.style.cssText = `color: ${errorColor} font-size: ${errorFontSize}`;
            }
        });

        if (inputName) {
            inputName.addEventListener('keypress', function(event) {
                let inputChar = event.key;
                let regex = new RegExp(/^[A-Za-zА-ЯЁа-яё. ]+/u);
    
                if (!regex.test(inputChar)) {
                    event.preventDefault();
                }
            });
        }
    }

    function mainPageAdmin() {
        const form = document.getElementById('del-form');

        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            let message = document.getElementById('del-message');
            let link = protocol + domain + form.getAttribute('action');

            try {
                const response = await fetch(link, {
                    method: 'POST',
                    body: new FormData(this)
                });
                const data = await response.json();

                if (data['success'] === true) {
                    window.location.href = data['redirect'];
                } else {
                    message.textContent = data['message'];
                    message.style.cssText = `color: ${errorColor} font-size: ${errorFontSize}`;
                }
            } catch (error) {
                message.textContent = 'Ошибка на сервере';
                message.style.cssText = `color: ${errorColor} font-size: ${errorFontSize}`;
            }
        });
    }

    function authPage() {
        const inputName = document.getElementById('inputName');
        const inputMail = document.getElementById('inputMail');
        const inputPassword = document.getElementById('inputPassword');

        const form = document.getElementById('auth-form');

        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            let errorMessage = document.getElementById('error-message');
            let link = protocol + domain + form.getAttribute('action');

            if (inputName && !validateName(inputName.value)) {
                errorMessage.textContent = 'Неправильный формат имени';
                errorMessage.style.cssText = `color: ${errorColor} font-size: ${errorFontSize}`;
                return;
            } else if (!validateMail(inputMail.value)) {
                errorMessage.textContent = 'Неправильный формат почты';
                errorMessage.style.cssText = `color: ${errorColor} font-size: ${errorFontSize}`;
                return;
            } else if (!validatePassword(inputPassword.value)) {
                errorMessage.textContent = 'Неправильный формат пароля';
                errorMessage.style.cssText = `color: ${errorColor} font-size: ${errorFontSize}`;
                return;
            };

            try {
                const response = await fetch(link, {
                    method: 'POST',
                    body: new FormData(this)
                });
                const data = await response.json();

                if (data['success'] === false) {
                    errorMessage.textContent = data['message'];
                    errorMessage.style.cssText = `color: ${errorColor} font-size: ${errorFontSize}`;
                } else {
                    window.location.href = data['redirect'];
                }
            } catch (error) {
                errorMessage.textContent = 'Ошибка на сервере';
                errorMessage.style.cssText = `color: ${errorColor} font-size: ${errorFontSize}`;
            }
        });

        inputMail.addEventListener('keypress', function(event) {
            let inputChar = event.key;
            let regex = new RegExp(/^[A-Za-z0-9.@_-]+/);

            if (!regex.test(inputChar)) {
                event.preventDefault();
            }
        });

        inputPassword.addEventListener('keypress', function(event) {
            let inputChar = event.key;
            let regex = new RegExp(/^[A-Za-z0-9!#$%&?*~_-]+/);

            if (!regex.test(inputChar)) {
                event.preventDefault();
            }
        });

        if (inputName) {
            inputName.addEventListener('keypress', function(event) {
                let inputChar = event.key;
                let regex = new RegExp(/^[A-Za-zА-ЯЁа-яё. ]+/u);
    
                if (!regex.test(inputChar)) {
                    event.preventDefault();
                }
            });
        }
    }

    function validatePassword(pass) {
        let regex = new RegExp(/^[A-Za-z0-9!#$%&?*~_-]+/);

        return regex.test(pass);
    }

    function validateName(name) {
        let regex = new RegExp(/^[A-Za-zА-ЯЁа-яё. ]+/u);

        return regex.test(name);
    }

    function validateMail(mail) {
        let regex = new RegExp(/^[A-Za-z0-9_-]+@[A-Za-z.]+$/);

        return regex.test(mail);
    }
});

const registerForm = document.getElementById('register-form');
const loginForm = document.getElementById('login-form');

function clearErrors() {
    document.querySelectorAll('.field-error').forEach((el) => (el.textContent = ''));
    const formError = document.getElementById('form-error');
    if (formError) formError.textContent = '';
}

function showFieldErrors(errors) {
    Object.entries(errors).forEach(([field, messages]) => {
        const el = document.getElementById(`${field}-error`);
        if (el) el.textContent = messages[0];
    });
}

function showFormError(message) {
    const el = document.getElementById('form-error');
    if (el) el.textContent = message;
}

if (registerForm) {
    registerForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearErrors();

        const body = {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            password_confirmation: document.getElementById('password_confirmation').value,
        };

        const response = await fetch('/api/v1/register', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
            body: JSON.stringify(body),
        });

        const data = await response.json();

        if (response.ok) {
            window.location.href = '/login';
        } else if (response.status === 422) {
            showFieldErrors(data.errors ?? {});
        } else {
            showFormError(data.message ?? 'Something went wrong.');
        }
    });
}

if (loginForm) {
    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearErrors();

        const body = {
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
        };

        const response = await fetch('/api/v1/login', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
            body: JSON.stringify(body),
        });

        const data = await response.json();

        if (response.ok) {
            localStorage.setItem('token', data.token);
            window.location.href = '/quotation';
        } else if (response.status === 422) {
            showFieldErrors(data.errors ?? {});
        } else {
            showFormError(data.message ?? 'Invalid credentials.');
        }
    });
}

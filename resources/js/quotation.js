const token = localStorage.getItem('token');

if (! token) {
    window.location.href = '/login';
}

function clearErrors() {
    document.querySelectorAll('.field-error').forEach((el) => (el.textContent = ''));
    document.getElementById('form-error').textContent = '';
}

function showFieldErrors(errors) {
    Object.entries(errors).forEach(([field, messages]) => {
        const el = document.getElementById(`${field}-error`);
        if (el) el.textContent = messages[0];
    });
}

document.getElementById('logout-btn').addEventListener('click', async () => {
    await fetch('/api/v1/logout', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            Authorization: `Bearer ${token}`,
        },
    });

    localStorage.removeItem('token');
    window.location.href = '/login';
});

document.getElementById('quotation-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    clearErrors();

    document.getElementById('quotation-result').hidden = true;

    const body = {
        age: document.getElementById('age').value.split(',').map((a) => parseInt(a.trim(), 10)).filter((n) => !isNaN(n)),
        currency_id: document.getElementById('currency_id').value,
        start_date: document.getElementById('start_date').value,
        end_date: document.getElementById('end_date').value,
    };

    const response = await fetch('/api/v1/quotation', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify(body),
    });

    const data = await response.json();

    if (response.ok) {
        document.getElementById('result-total').textContent = `${data.total} ${data.currency_id}`;
        document.getElementById('result-currency').textContent = data.currency_id;
        document.getElementById('result-id').textContent = data.quotation_id;
        document.getElementById('quotation-result').hidden = false;
    } else if (response.status === 422) {
        showFieldErrors(data.errors ?? {});
        if (data.message && ! data.errors) {
            document.getElementById('form-error').textContent = data.message;
        }
    } else if (response.status === 401) {
        localStorage.removeItem('token');
        window.location.href = '/login';
    } else {
        document.getElementById('form-error').textContent = data.message ?? 'Something went wrong.';
    }
});

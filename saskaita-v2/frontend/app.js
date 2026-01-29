
let currentInvoice = null;

function normalizeInvoice(inv) {
    return {
        ...inv,
        shipping_price: Number(inv.shipping_price ?? inv.shippingPrice ?? 0),
        items: Array.isArray(inv.items) ? inv.items : [],
        company: {
            buyer: inv.company?.buyer || {},
            seller: inv.company?.seller || {}
        }
    };
}

function loadInvoiceFromApi() {
    return fetch('https://in3.dev/inv/')
        .then(res => res.json())
        .then(inv => {
            inv.id = crypto.randomUUID();
            return normalizeInvoice(inv);
        });
}

function showToast(message, type = 'info', duration = 3000) {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerText = message;

    container.appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 10);

    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, duration);
}

document.addEventListener('DOMContentLoaded', () => {

    if (document.body.classList.contains('page-create')) {
        initCreatePage();
    }

    bindGlobalButtons();
});

function initCreatePage() {
    loadInvoiceFromApi()
        .then(inv => {
            currentInvoice = inv;
            saskaita(inv);
        })
        .catch(err => {
            console.error(err);
            showToast('Klaida kraunant sąskaitą', 'error');
        });
}

function bindGlobalButtons() {
    const saveBtn = document.querySelector('#save');
    const refreshBtn = document.querySelector('#refresh');
    const cancelBtn = document.querySelector('#cancel');

    if (saveBtn) {
        saveBtn.addEventListener('click', saveInvoice);
    }

    if (refreshBtn) {
        refreshBtn.addEventListener('click', refreshInvoice);
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', () => {
            window.location.href = 'list.html';
        });
    }
}

function refreshInvoice() {
    loadInvoiceFromApi()
        .then(inv => {
            currentInvoice = inv;
            saskaita(inv);
            showToast('Sąskaita atnaujinta', 'info');
        })
        .catch(err => {

            showToast('Klaida atnaujinant', 'error');
        });
}

function saveInvoice() {
    if (!validateInvoice(currentInvoice)) return;

    fetch('/projects/saskaita-v2/backend/invoice_create.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(currentInvoice)
    })
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                showToast(data.error, 'error');
                return;
            }

            showToast('Sąskaita išsaugota', 'success');
        })
        .catch(err => {

            showToast('Klaida saugant, tokia sąskaita jau egzistuoja', 'error');
        });
}

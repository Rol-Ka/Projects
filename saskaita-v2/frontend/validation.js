

function showToast(message, type = 'info') {

    let container = document.querySelector('#toast-container');

    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.classList.add('toast', type);
    toast.innerText = message;

    container.appendChild(toast);
    requestAnimationFrame(() => {
        toast.classList.add('show');
    });

    setTimeout(() => {
        toast.classList.add('hide');
    }, 2500);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}
function showConfirm(
    message,
    onConfirm,
    options = {}
) {
    const {
        confirmText = 'Patvirtinti',
        cancelText = 'Atšaukti',
        confirmClass = 'btn-confirm'
    } = options;

    let overlay = document.querySelector('#confirm-overlay');

    if (!overlay) {
        overlay = document.createElement('div');
        overlay.id = 'confirm-overlay';
        document.body.appendChild(overlay);
    }

    overlay.innerHTML = `
        <div class="confirm-modal">
            <p>${message}</p>
            <div class="confirm-actions">
                <button class="btn-cancel">${cancelText}</button>
                <button class="${confirmClass}">${confirmText}</button>
            </div>
        </div>
    `;

    overlay.classList.add('show');

    overlay.querySelector('.btn-cancel').onclick = () => {
        overlay.classList.remove('show');
    };

    overlay.querySelector(`.${confirmClass}`).onclick = () => {
        overlay.classList.remove('show');
        onConfirm();
    };
}


function validateInvoice(inv) {
    let firstErrorInput = null;

    document.querySelectorAll('.input-error').forEach(el => {
        el.classList.remove('input-error');
    });

    if (!inv.items || inv.items.length === 0) {
        showToast('Sąskaita turi turėti bent vieną prekę', 'error');
        return false;
    }

    for (let i = 0; i < inv.items.length; i++) {
        const item = inv.items[i];

        if (!item.description || item.description.trim() === '') {
            const input = document.querySelector(
                `input[data-field="description"][data-index="${i}"]`
            );

            if (input) {
                input.classList.add('input-error');
                firstErrorInput ??= input;
            }

            showToast(`Prekės pavadinimas ${i + 1}-oje eilutėje yra tuščias`, 'error');
            break;
        }

        if (item.quantity == null || isNaN(item.quantity) || item.quantity < 1) {
            const input = document.querySelector(
                `input[data-field="quantity"][data-index="${i}"]`
            );

            if (input) {
                input.classList.add('input-error');
                firstErrorInput ??= input;
            }

            showToast(`Prekės kiekis ${i + 1}-oje eilutėje turi būti ≥ 1`, 'error');
            break;
        }

        if (item.price == null || isNaN(item.price) || item.price < 0) {
            const input = document.querySelector(
                `input[data-field="price"][data-index="${i}"]`
            );

            if (input) {
                input.classList.add('input-error');
                firstErrorInput ??= input;
            }

            showToast(`Prekės kaina ${i + 1}-oje eilutėje turi būti įvesta`, 'error');
            break;
        }

        if (item.discount?.type === 'percentage' && item.discount.value > 100) {
            showToast(
                `Procentinė nuolaida ${i + 1}-oje eilutėje negali viršyti 100%`,
                'error'
            );
            return false;
        }
    }

    if (firstErrorInput) {
        firstErrorInput.focus();
        return false;
    }

    return true;
}


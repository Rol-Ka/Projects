function validateInvoice(inv) {
    let firstErrorInput = null;

    document.querySelectorAll('.input-error').forEach(el => {
        el.classList.remove('input-error');
    });

    if (!inv.items || inv.items.length === 0) {
        alert('Sąskaita turi turėti bent vieną prekę.');
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
                if (!firstErrorInput) firstErrorInput = input;
            }

            alert(`Prekės pavadinimas ${i + 1}-oje eilutėje yra tuščias.`);
            break;
        }

        if (item.quantity == null || isNaN(item.quantity) || item.quantity < 1) {
            const input = document.querySelector(
                `input[data-field="quantity"][data-index="${i}"]`
            );

            if (input) {
                input.classList.add('input-error');
                if (!firstErrorInput) firstErrorInput = input;
            }

            alert(`Prekės kiekis ${i + 1}-oje eilutėje turi būti ≥ 1.`);
            break;
        }

        if (item.price == null || isNaN(item.price) || item.price < 0) {
            const input = document.querySelector(
                `input[data-field="price"][data-index="${i}"]`
            );

            if (input) {
                input.classList.add('input-error');
                if (!firstErrorInput) firstErrorInput = input;
            }

            alert(`Prekės kaina ${i + 1}-oje eilutėje turi būti įvesta.`);
            break;
        }

        if (item.discount?.type === 'percentage' && item.discount.value > 100) {
            alert(`Procentinė nuolaida ${i + 1}-oje eilutėje negali viršyti 100%.`);
            return false;
        }
    }

    if (firstErrorInput) {
        firstErrorInput.focus();
        return false;
    }

    return true;
}

function saskaita(inv) {

    inv.company = inv.company || {};
    inv.company.buyer = inv.company.buyer || {};
    inv.company.seller = inv.company.seller || {};

    if (!document.querySelector('#saskaitos-numeris')) {
        return;
    }

    const saskNr = document.querySelector('#saskaitos-numeris');
    const saskData = document.querySelector('#israsymo-data');
    const saskApmokejimas = document.querySelector('#apmoketi-iki');

    const pirkejoAdresas = document.querySelector('#pirkejo-adresas');
    const pirkejoKodas = document.querySelector('#pirkejo-kodas');
    const pirkejoPastas = document.querySelector('#pirkejo-pastas');
    const pirkejoPavadinimas = document.querySelector('#pirkejo-pavadinimas');
    const pirkejoTelefonas = document.querySelector('#pirkejo-telefonas');
    const pirkejoPvm = document.querySelector('#pirkejo-pvm');

    const pardavejoAdresas = document.querySelector('#pardavejo-adresas');
    const pardavejoKodas = document.querySelector('#pardavejo-kodas');
    const pardavejoPastas = document.querySelector('#pardavejo-pastas');
    const pardavejoPavadinimas = document.querySelector('#pardavejo-pavadinimas');
    const pardavejoTelefonas = document.querySelector('#pardavejo-telefonas');
    const pardavejoPvm = document.querySelector('#pardavejo-pvm');

    const container = document.querySelector('#krepselis');

    saskNr.innerText = inv.number;
    saskData.innerText = inv.date;
    saskApmokejimas.innerText = inv.due_date;

    pirkejoAdresas.innerText = inv.company.buyer.address;
    pirkejoKodas.innerText = inv.company.buyer.code;
    pirkejoPastas.innerText = inv.company.buyer.email;
    pirkejoPavadinimas.innerText = inv.company.buyer.name;
    pirkejoTelefonas.innerText = inv.company.buyer.phone;
    pirkejoPvm.innerText = inv.company.buyer.vat;

    pardavejoAdresas.innerText = inv.company.seller.address;
    pardavejoKodas.innerText = inv.company.seller.code;
    pardavejoPastas.innerText = inv.company.seller.email;
    pardavejoPavadinimas.innerText = inv.company.seller.name;
    pardavejoTelefonas.innerText = inv.company.seller.phone;
    pardavejoPvm.innerText = inv.company.seller.vat;

    container.innerHTML = '';

    function selectAllOnFocus(input) {
        input.addEventListener('focus', () => {
            input.select();
        });
    }

    const items = inv.items;

    const table = document.createElement('table');
    table.classList.add('krepselio-lentele');

    const thead = document.createElement('thead');
    const headerRow = document.createElement('tr');

    ['Prekės pavadinimas', 'Kiekis', 'Kaina be PVM', 'Nuolaida', 'Suma'].forEach(text => {
        const th = document.createElement('th');
        th.innerText = text;
        headerRow.appendChild(th);
    });

    if (window.IS_EDIT) {
        const th = document.createElement('th');
        th.innerText = 'Veiksmai';
        headerRow.appendChild(th);
    }

    thead.appendChild(headerRow);
    table.appendChild(thead);

    const tbody = document.createElement('tbody');

    let prekiuViso = 0;

    items.forEach((item, index) => {
        const tr = document.createElement('tr');

        const tdTitle = document.createElement('td');

        if (window.IS_EDIT) {
            const input = document.createElement('input');
            input.type = 'text';
            input.value = item.description || '';
            input.dataset.field = 'description';
            input.dataset.index = index;

            selectAllOnFocus(input);

            input.addEventListener('input', () => {
                input.classList.remove('input-error');
                item.description = input.value;
            });

            tdTitle.appendChild(input);
        } else {
            tdTitle.innerText = item.description || 'Be pavadinimo';
        }

        tr.appendChild(tdTitle);

        const qty = item.quantity;
        const tdQty = document.createElement('td');

        if (window.IS_EDIT) {
            const input = document.createElement('input');
            input.type = 'number';
            input.min = 1;
            input.dataset.field = 'quantity';
            input.dataset.index = index;
            input.value = qty;
            selectAllOnFocus(input);

            input.addEventListener('input', () => {
                input.classList.remove('input-error');
                item.quantity = input.value === '' ? null : Number(input.value);
                updateTotals(inv);
            });

            tdQty.appendChild(input);
        } else {
            tdQty.innerText = qty;
        }

        tr.appendChild(tdQty);

        const tdPrice = document.createElement('td');

        if (window.IS_EDIT) {
            const input = document.createElement('input');
            input.type = 'number';
            input.min = 0;
            input.step = '0.01';
            input.dataset.field = 'price';
            input.dataset.index = index;
            input.value = item.price || 0;
            selectAllOnFocus(input);

            input.addEventListener('input', () => {
                input.classList.remove('input-error');
                item.price = input.value === '' ? null : Number(input.value);
                updateTotals(inv);
            });

            tdPrice.appendChild(input);
        } else {
            tdPrice.innerText = (item.price || 0).toFixed(2) + ' €';
        }

        tr.appendChild(tdPrice);

        let discountAmount = 0;
        let discountText = '-';

        if (item.discount && Object.keys(item.discount).length) {
            if (item.discount.type === 'percentage') {
                discountAmount = ((item.price || 0) * qty) * (item.discount.value / 100);
                discountText = `-${item.discount.value}%\n${discountAmount.toFixed(2)} €`;
            } else if (item.discount.type === 'fixed') {
                discountAmount = item.discount.value;
                discountText = `-${item.discount.value.toFixed(2)} €`;
            }
        }

        const tdDiscount = document.createElement('td');

        if (window.IS_EDIT) {

            const discountType = item.discount?.type || 'fixed';
            const discountValue = item.discount?.value || 0;
            const select = document.createElement('select');
            select.innerHTML = `
        <option value="fixed">€</option>
        <option value="percentage">%</option>
    `;
            select.value = discountType;
            const input = document.createElement('input');
            input.type = 'number';
            input.min = 0;
            input.value = discountValue;
            selectAllOnFocus(input);

            const applyDiscount = () => {
                let value = Number(input.value);

                if (isNaN(value)) value = 0;

                if (value < 0) value = 0;

                if (select.value === 'percentage' && value > 100) {
                    value = 100;
                }

                input.value = value;
                item.discount = {
                    type: select.value,
                    value: value
                };

                updateTotals(inv);
            };

            input.addEventListener('input', applyDiscount);
            select.addEventListener('change', applyDiscount);
            tdDiscount.append(select, input);

        } else {
            tdDiscount.innerText = discountText;
        }

        tr.appendChild(tdDiscount);



        const safeQty = item.quantity ?? 0;
        const safePrice = item.price ?? 0;
        const itemSum = (safePrice * safeQty) - discountAmount;
        const tdSum = document.createElement('td');
        tdSum.dataset.index = index;
        tdSum.classList.add('item-sum');
        tdSum.innerText = itemSum.toFixed(2) + ' €';
        tr.appendChild(tdSum);
        prekiuViso += itemSum;
        tbody.appendChild(tr);

        if (window.IS_EDIT) {
            const tdActions = document.createElement('td');
            const deleteBtn = document.createElement('button');
            deleteBtn.innerText = '🗑️';
            deleteBtn.title = 'Trinti prekę';
            deleteBtn.addEventListener('click', () => {
                if (confirm('Ar tikrai norite ištrinti šią prekę?')) {
                    inv.items.splice(index, 1);
                    saskaita(inv);
                }
            });

            tdActions.appendChild(deleteBtn);
            tr.appendChild(tdActions);
        }
    });

    const shippingRow = document.createElement('tr');
    const tdShippingLabel = document.createElement('td');
    tdShippingLabel.innerText = 'Pristatymas:';
    tdShippingLabel.colSpan = 4;
    shippingRow.appendChild(tdShippingLabel);
    const tdShippingPrice = document.createElement('td');
    tdShippingPrice.innerText = Number(inv.shipping_price || 0).toFixed(2) + ' €';
    shippingRow.appendChild(tdShippingPrice);
    tbody.appendChild(shippingRow);
    const sumaBePvm = prekiuViso + Number(inv.shipping_price || 0);
    const totalRow = document.createElement('tr');

    for (let i = 0; i < 3; i++) {
        const empty = document.createElement('td');
        empty.innerText = '';
        totalRow.appendChild(empty);
    }

    const tdTotalLabel = document.createElement('td');
    tdTotalLabel.innerText = 'Iš viso (be PVM):';
    totalRow.appendChild(tdTotalLabel);

    const tdTotalValue = document.createElement('td');
    tdTotalValue.id = 'suma-be-pvm';
    tdTotalValue.innerText = sumaBePvm.toFixed(2) + ' €';
    totalRow.appendChild(tdTotalValue);
    tbody.appendChild(totalRow);

    const pvm = sumaBePvm * 0.21;
    const pvmRow = document.createElement('tr');
    for (let i = 0; i < 3; i++) {
        const empty = document.createElement('td');
        empty.innerText = '';
        pvmRow.appendChild(empty);
    }

    const tdPvmLabel = document.createElement('td');
    tdPvmLabel.innerText = 'PVM (21%):';
    pvmRow.appendChild(tdPvmLabel);

    const tdPvmValue = document.createElement('td');
    tdPvmValue.id = 'pvm-suma';
    tdPvmValue.innerText = pvm.toFixed(2) + ' €';
    pvmRow.appendChild(tdPvmValue);
    tbody.appendChild(pvmRow);

    const sumaSuPvm = sumaBePvm + pvm;
    const finalRow = document.createElement('tr');
    for (let i = 0; i < 3; i++) {
        const empty = document.createElement('td');
        empty.innerText = '';
        finalRow.appendChild(empty);
    }

    const tdFinalLabel = document.createElement('td');
    tdFinalLabel.innerText = 'Galutinė suma (su PVM):';
    finalRow.appendChild(tdFinalLabel);

    const tdFinalValue = document.createElement('td');
    tdFinalValue.id = 'suma-su-pvm';
    tdFinalValue.innerText = sumaSuPvm.toFixed(2) + ' €';
    finalRow.appendChild(tdFinalValue);
    tbody.appendChild(finalRow);
    table.appendChild(tbody);

    if (window.IS_EDIT) {
        const addBtn = document.createElement('button');
        addBtn.innerText = '+ Pridėti prekę';
        addBtn.style.marginTop = '12px';

        addBtn.addEventListener('click', () => {
            inv.items.push({
                description: '',
                quantity: 1,
                price: 0,
                discount: {
                    type: 'fixed',
                    value: 0
                }
            });
            saskaita(inv);
        });
        addBtn.classList.add('add-item-btn');
        container.appendChild(addBtn);
    }
    container.appendChild(table);
}


// function updateTotals(inv) {
//     let prekiuViso = 0;

//     inv.items.forEach((item, index) => {
//         const qty = Number(item.quantity) || 0;
//         const price = Number(item.price) || 0;
//         let discount = 0;

//         if (item.discount) {
//             if (item.discount.type === 'percentage') {
//                 discount = price * qty * (item.discount.value / 100);
//             } else if (item.discount.type === 'fixed') {
//                 discount = Number(item.discount.value) || 0;
//             }
//         }

//         const itemSum = (price * qty) - discount;
//         prekiuViso += itemSum;

//         const sumCell = document.querySelector(
//             `.item-sum[data-index="${index}"]`
//         );
//         if (sumCell) {
//             sumCell.innerText = itemSum.toFixed(2) + ' €';
//         }
//     });

//     const sumaBePvm = prekiuViso + Number(inv.shipping_price || 0);
//     const pvm = sumaBePvm * 0.21;
//     const sumaSuPvm = sumaBePvm + pvm;

//     const bePvmEl = document.querySelector('#suma-be-pvm');
//     if (bePvmEl) bePvmEl.innerText = sumaBePvm.toFixed(2) + ' €';

//     const pvmEl = document.querySelector('#pvm-suma');
//     if (pvmEl) pvmEl.innerText = pvm.toFixed(2) + ' €';

//     const suPvmEl = document.querySelector('#suma-su-pvm');
//     if (suPvmEl) suPvmEl.innerText = sumaSuPvm.toFixed(2) + ' €';
// }

function updateTotals(inv) {
    let prekiuViso = 0;

    inv.items.forEach((item, index) => {
        const qty = Number(item.quantity) || 0;
        const price = Number(item.price) || 0;
        let discount = 0;

        if (item.discount) {
            if (item.discount.type === 'percentage') {
                discount = price * qty * (Number(item.discount.value) / 100);
            } else if (item.discount.type === 'fixed') {
                discount = Number(item.discount.value) || 0;
            }
        }

        const itemSum = (price * qty) - discount;
        prekiuViso += itemSum;

        const sumCell = document.querySelector(
            `.item-sum[data-index="${index}"]`
        );
        if (sumCell) {
            sumCell.innerText = itemSum.toFixed(2) + ' €';
        }
    });

    const shipping = Number(inv.shipping_price) || 0;
    const sumaBePvm = prekiuViso + shipping;
    const pvm = sumaBePvm * 0.21;
    const sumaSuPvm = sumaBePvm + pvm;

    document.querySelector('#suma-be-pvm').innerText =
        sumaBePvm.toFixed(2) + ' €';
    document.querySelector('#pvm-suma').innerText =
        pvm.toFixed(2) + ' €';
    document.querySelector('#suma-su-pvm').innerText =
        sumaSuPvm.toFixed(2) + ' €';
}
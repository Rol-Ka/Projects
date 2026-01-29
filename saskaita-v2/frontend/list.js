
function calculateTotalWithVat(inv) {
  let total = 0;

  if (!Array.isArray(inv.items)) {
    return 0;
  }

  inv.items.forEach(item => {
    const qty = Number(item.quantity) || 0;
    const price = Number(item.price) || 0;
    let discount = 0;

    if (item.discount) {
      if (item.discount.type === 'percentage') {
        discount = price * qty * (item.discount.value / 100);
      }
      if (item.discount.type === 'fixed') {
        discount = item.discount.value;
      }
    }

    total += (price * qty) - discount;
  });

  total += Number(inv.shipping_price) || 0;
  const vat = total * 0.21;

  return total + vat;
}

const tbody = document.querySelector('#invoice-list tbody');

fetch('../backend/invoices_get.php')
  .then(res => res.json())
  .then(invoices => {

    if (!invoices.length) {
      tbody.innerHTML = '<tr><td colspan="4">Sąskaitų nėra</td></tr>';
      return;
    }

    invoices.forEach(inv => {
      const tr = document.createElement('tr');

      tr.innerHTML = `
        <td>${inv.number}</td>
        <td>${inv.date}</td>
        <td>${calculateTotalWithVat(inv).toFixed(2)} €</td>
        <td>
          <a href="view.html?id=${inv.id}">Žiūrėti</a>
          |
          <a href="edit.html?id=${inv.id}">Redaguoti</a>
          |
          <button class="delete-btn" data-id="${inv.id}">Trinti</button>
        </td>
      `;

      tbody.appendChild(tr);
    });
  })
  .catch(() => {
    tbody.innerHTML =
      '<tr><td colspan="4">Klaida kraunant sąskaitas</td></tr>';
    showToast('Nepavyko užkrauti sąskaitų', 'error');
  });

tbody.addEventListener('click', e => {
  if (!e.target.classList.contains('delete-btn')) return;

  const id = e.target.dataset.id;
  const row = e.target.closest('tr');

  showConfirm(
    'Ar tikrai norite ištrinti šią sąskaitą?',
    () => {
      deleteInvoice(id, row);
    },
    {
      confirmText: 'Taip, trinti',
      cancelText: 'Atšaukti',
      confirmClass: 'btn-danger'
    }
  );
});

function deleteInvoice(id, row) {
  fetch('../backend/invoice_delete.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id })
  })
    .then(res => res.json())
    .then(data => {
      if (data.error) {
        showToast(data.error, 'error');
        return;
      }

      row.remove();
      checkEmptyList();
      showToast('Sąskaita ištrinta', 'success');
    })
    .catch(() => {
      showToast('Klaida trinant sąskaitą', 'error');
    });
}

function checkEmptyList() {
  if (!tbody.querySelector('tr')) {
    tbody.innerHTML =
      '<tr><td colspan="4">Sąskaitų nėra</td></tr>';
  }
}
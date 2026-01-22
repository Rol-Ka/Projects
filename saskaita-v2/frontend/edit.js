// window.IS_EDIT = true;

// document.addEventListener('DOMContentLoaded', () => {

//   function getInvoices() {
//     return JSON.parse(localStorage.getItem('invoices')) || [];
//   }

//   function saveInvoices(invoices) {
//     localStorage.setItem('invoices', JSON.stringify(invoices));
//   }

//   const params = new URLSearchParams(window.location.search);
//   const id = params.get('id');

//   const invoices = getInvoices();
//   const invoice = invoices.find(inv => inv.id === id);

//   if (!invoice) {
//     alert('Sąskaita nerasta');
//     window.location.href = 'list.html';
//     return;
//   }

//   saskaita(invoice);

//   const saveBtn = document.querySelector('#save');
//   saveBtn.addEventListener('click', (e) => {
//     e.preventDefault();

//     if (!validateInvoice(invoice)) return;

//     saveInvoices(invoices);
//     alert('Sąskaita atnaujinta');

//     window.location.href = `edit.html?id=${id}`;
//   });

//   document.querySelector('#back').addEventListener('click', () => {
//     window.location.href = 'list.html';
//   });

// });

const params = new URLSearchParams(window.location.search);
const id = params.get('id');

if (!id) {
  alert('Nėra sąskaitos ID');
  window.location.href = 'list.html';
}

let currentInvoice = null;

fetch(`/projects/saskaita-v2/backend/invoice_get.php?id=${id}`)
  .then(res => res.json())
  .then(inv => {
    if (inv.error) {
      alert('Sąskaita nerasta');
      window.location.href = 'list.html';
      return;
    }

    currentInvoice = inv;
    window.IS_EDIT = true; // 👈 LABAI SVARBU
    saskaita(inv);        // 👈 renderinam su inputais
  })
  .catch(err => {
    console.error(err);
    alert('Klaida kraunant sąskaitą');
    window.location.href = 'list.html';
  });



document.querySelector('#save').addEventListener('click', () => {
  if (!validateInvoice(currentInvoice)) return;

  fetch('/projects/saskaita-v2/backend/invoice_update.php', {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(currentInvoice)
  })
    .then(res => res.json())
    .then(data => {
      if (data.error) {
        alert(data.error);
        return;
      }

      showToast('Sąskaita atnaujinta', 'success');
      // window.location.href = 'list.html';
    })
    .catch(err => {
      console.error(err);
      showToast('Klaida saugant duomenis', 'error');
    });
});

document.querySelector('#back').addEventListener('click', () => {
  window.location.href = 'list.html';
});

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

let isDirty = false;
let isInitializing = true;
const params = new URLSearchParams(window.location.search);
const id = params.get('id');

if (!id) {
  showToast('Nėra sąskaitos ID', 'error');
  window.location.href = 'list.html';
}

let currentInvoice = null;

fetch(`/projects/saskaita-v2/backend/invoice_get.php?id=${id}`)
  .then(res => res.json())
  .then(inv => {
    if (inv.error) {
      showToast('Sąskaita nerasta', 'error');
      window.location.href = 'list.html';
      return;
    }

    currentInvoice = inv;
    window.IS_EDIT = true;
    saskaita(inv);
    isDirty = false;
    isInitializing = false;
  })
  .catch(() => {
    showToast('Klaida kraunant sąskaitą', 'error');
    window.location.href = 'list.html';
  });



document.querySelector('#save').addEventListener('click', () => {

  if (!validateInvoice(currentInvoice)) return;

  fetch('/projects/saskaita-v2/backend/invoice_update.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(currentInvoice)
  })
    .then(async res => {
      const text = await res.text();

      let data = null;
      try {
        data = JSON.parse(text);
      } catch (e) {

      }

      if (data?.error) {
        showToast(data.error, 'error');
        return;
      }

      showToast('Sąskaita atnaujinta', 'success');


      isDirty = false;
      isInitializing = true;


      setTimeout(() => {
        isInitializing = false;
      }, 0);
    })
    .catch(() => {
      showToast('Klaida saugant duomenis', 'error');
    });
});

document.querySelector('#back').addEventListener('click', () => {
  if (!isDirty) {
    window.location.href = 'list.html';
    return;
  }

  showConfirm(
    'Ar tikrai norite grįžti? Neįrašyti pakeitimai bus prarasti.',
    () => {
      window.location.href = 'list.html';
    }
  );
});


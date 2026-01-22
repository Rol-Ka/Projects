const params = new URLSearchParams(window.location.search);
const id = params.get('id');

if (!id) {
  alert('Nėra sąskaitos ID');
  window.location.href = 'list.html';
}

fetch(`/projects/saskaita-v2/backend/invoice_get.php?id=${id}`)
  .then(res => res.json())
  .then(inv => {
    if (inv.error) {
      alert('Sąskaita nerasta');
      window.location.href = 'list.html';
      return;
    }

    saskaita(inv);
  })
// .catch(err => {
//   console.error(err);
//   alert('Klaida kraunant sąskaitą');
//   window.location.href = 'list.html';
// });


const backBtn = document.querySelector('#back');

if (backBtn) {
  backBtn.addEventListener('click', () => {
    window.location.href = 'list.html';
  });
}


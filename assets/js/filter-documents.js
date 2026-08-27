const filterDocs = document.getElementById('uuwg-document-filter');
const filterList = filterDocs.querySelector('.uuwg-documents-filter__list');
const filterItems = filterDocs.querySelectorAll('.uuwg-documents-filter__item');

[...filterItems].forEach(f => {
  f.addEventListener('click', (evt) => {
    evt.preventDefault();
    console.log(f.innerHTML);

  })
})
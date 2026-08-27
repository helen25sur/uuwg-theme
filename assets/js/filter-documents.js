(async () => {
  const pageDocs = document.querySelector('.post-type-archive-document');

  if (pageDocs) {
    const filterDocs = document.getElementById('uuwg-document-filter');
    const filterItems = filterDocs.querySelectorAll('.uuwg-documents-filter__item');

    const documentGrid = pageDocs.querySelector('.uuwg-documents-grid__grid');

    [...filterItems].forEach(f => {
      f.addEventListener('click', async (evt) => {
        evt.preventDefault();

        filterItems.forEach(item => item.classList.remove('is-active'));
        f.classList.add('is-active');

        const year = f.querySelector('a').innerText;
        console.log(year);
        let url;
        const urlSite = new URL(window.location.href);

        if (year === 'All') {
          url = '/wp-json/uuwg/v1/document/';
          urlSite.searchParams.delete('document_year');
          window.history.pushState({}, '', urlSite);
        } else {
          url = `/wp-json/uuwg/v1/document/?document_year=${year}`;
          urlSite.searchParams.set('document_year', year);
          window.history.pushState({}, '', urlSite);
        }

        const response = await fetch(url);
        const data = await response.json();
        documentGrid.innerHTML = data.html;

        filterDocs.removeAttribute('open');

      })
    })
  }
})();
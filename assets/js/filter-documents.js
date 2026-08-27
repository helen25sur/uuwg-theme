(async () => {
  const pageDocs = document.querySelector('.post-type-archive-document');

  if (pageDocs) {
    const filterDocs = document.getElementById('uuwg-document-filter');
    const filterItems = filterDocs.querySelectorAll('.uuwg-documents-filter__item a');

    const documentGrid = pageDocs.querySelector('.uuwg-documents-grid__grid');

    [...filterItems].forEach(f => {
      f.addEventListener('click', async (evt) => {
        evt.preventDefault();

        filterItems.forEach(item => item.classList.remove('is-active'));
        f.classList.add('is-active');

        const urlItem = new URL(f.href);
        const year = urlItem.searchParams.get('document_year');

        const startUrl = '/wp-json/uuwg/v1/document/';
        let url;
        const urlSite = new URL(window.location.href);

        if (year === null) {
          url = startUrl;
          urlSite.searchParams.delete('document_year');
          window.history.pushState({}, '', urlSite);
        } else {
          url = `${startUrl}?document_year=${encodeURIComponent(year)}`;
          urlSite.searchParams.set('document_year', year);
          window.history.pushState({}, '', urlSite);
        }

        try {
          const response = await fetch(url);
          if (!response.ok) {
            throw new Error(`HTTP error: ${response.status}`);
          }
          const data = await response.json();
          documentGrid.innerHTML = data.html;

        } catch (error) {
          console.error(error);
        }

        filterDocs.removeAttribute('open');

      })
    })
  }
})();
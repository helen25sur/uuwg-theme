(async () => {
  const pageDocs = document.querySelector('.post-type-archive-document');

  if (pageDocs) {
    const filterDocs = document.getElementById('uuwg-document-filter');
    const filterItems = filterDocs.querySelectorAll('.uuwg-documents-filter__item a');

    [...filterItems].forEach(f => {
      f.addEventListener('click', (evt) => {
        evt.preventDefault();

        const urlItem = new URL(f.href);
        const year = urlItem.searchParams.get('document_year');

        const urlSite = new URL(window.location.href);

        if (year === null) {
          urlSite.searchParams.delete('document_year');
        } else {
          urlSite.searchParams.set('document_year', year);
        }

        window.history.pushState({}, '', urlSite);

        filterDocs.removeAttribute('open');

        filterItems.forEach(item => item.parentElement.classList.remove('is-active'));
        f.parentElement.classList.add('is-active');

        loadDocuments(year, f.text.trim());

      })
    });

    window.addEventListener("popstate", () => {
      const url = new URL(window.location.href);
      const year = url.searchParams.get('document_year');

      let name = '';

      filterItems.forEach(i => {
        i.parentElement.classList.remove('is-active');
        const itemUrl = new URL(i.href);
        const itemYear = itemUrl.searchParams.get('document_year');

        if (itemYear === year) {
          i.parentElement.classList.add('is-active');
          name = i.text.trim();
        }
      });

      loadDocuments(year, name);

      filterDocs.removeAttribute('open');

    });
  }
})();

async function loadDocuments(year, name) {
  const filterDocs = document.getElementById('uuwg-document-filter');
  const pageDocs = document.querySelector('.post-type-archive-document');
  const documentGrid = pageDocs.querySelector('.uuwg-documents-grid__grid');
  const summaryFilter = filterDocs.querySelector('.uuwg-documents-filter__current');

  const startUrl = '/wp-json/uuwg/v1/document/';
  let url = startUrl;

  if (year) {
    url = `${startUrl}?document_year=${encodeURIComponent(year)}`;
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

  summaryFilter.innerText = name;
}
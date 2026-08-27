(async () => {
  const pageProjects = document.querySelector('.post-type-archive-project');

  if (pageProjects) {
    const filterProjects = document.getElementById('uuwg-project-filter');
    const filterItems = filterProjects.querySelectorAll('.uuwg-projects-filter__item a');

    [...filterItems].forEach(f => {
      f.addEventListener('click', (evt) => {
        evt.preventDefault();

        const urlItem = new URL(f.href);
        const type = urlItem.searchParams.get('project_category');

        const urlSite = new URL(window.location.href);

        if (type === null) {
          urlSite.searchParams.delete('project_category');
        } else {
          urlSite.searchParams.set('project_category', type);
        }

        window.history.pushState({}, '', urlSite);

        filterProjects.removeAttribute('open');

        filterItems.forEach(item => item.parentElement.classList.remove('is-active'));

        f.parentElement.classList.add('is-active');

        loadDocuments(type, f.text.trim());
      })
    });

    window.addEventListener('popstate', () => {
      const url = new URL(window.location.href);
      const type = url.searchParams.get('project_category');

      let name = '';

      filterItems.forEach(i => {
        i.parentElement.classList.remove('is-active');
        const itemUrl = new URL(i.href);
        const itemType = itemUrl.searchParams.get('project_category');

        if (itemType === type) {
          i.parentElement.classList.add('is-active');
          name = i.text.trim();
        }
      });

      loadDocuments(type, name);

      filterProjects.removeAttribute('open');
    })
  }
})();

async function loadDocuments(type, name) {
  const pageProjects = document.querySelector('.post-type-archive-project');
  const filterProjects = document.getElementById('uuwg-project-filter');
  const projectGrid = pageProjects.querySelector('.uuwg-our-projects__grids');
  const summaryFilter = filterProjects.querySelector('.uuwg-projects-filter__current');

  const startUrl = '/wp-json/uuwg/v1/project/';
  let url = `${startUrl}?per_page=100`;

  if (type) {
    url = `${startUrl}?project_category=${encodeURIComponent(type)}&per_page=100`;
  }

  try {
    const response = await fetch(url);
    if (!response.ok) {
      throw new Error(`HTTP error: ${response.status}`);
    }
    const data = await response.json();
    console.log(data);
    projectGrid.innerHTML = data.html;

  } catch (error) {
    console.error(error)
  }

  summaryFilter.innerHTML = name;
}
document.addEventListener('DOMContentLoaded', () => {
  const blockContainers = document.querySelectorAll('.uuwg-our-projects');

  blockContainers.forEach((block) => {
    const grid = block.querySelector('.js-projects-grid');
    const pagination = block.querySelector('.js-projects-pagination');
    const count = block.dataset.count;
    const ajaxUrl = block.dataset.ajaxUrl;

    if (!pagination) return;

    pagination.addEventListener('click', (e) => {
      const btn = e.target.closest('.uuwg-pagination-btn');
      if (!btn || btn.classList.contains('is-active')) return;

      const targetPage = btn.dataset.page;

      // Індикація завантаження
      grid.style.opacity = '0.5';

      const formData = new FormData();
      formData.append('action', 'uuwg_get_projects');
      formData.append('page', targetPage);
      formData.append('count', count);

      fetch(ajaxUrl, {
        method: 'POST',
        body: formData,
      })
        .then((res) => res.json())
        .then((response) => {
          if (response.success) {
            grid.innerHTML = response.data.cards;
            pagination.innerHTML = response.data.pagination;
          }
        })
        .catch((err) => console.error('Projects AJAX Error:', err))
        .finally(() => {
          grid.style.opacity = '1';
        });
    });
  });
});
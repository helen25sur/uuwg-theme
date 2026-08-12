(function () {
  function initNewsPagination() {
    const blockContainers = document.querySelectorAll('.uuwg-news-events');

    if (blockContainers.length === 0) return;

    blockContainers.forEach((block, index) => {
      // Захист від повторного навешування слухача
      if (block.dataset.initialized) return;
      block.dataset.initialized = 'true';

      block.addEventListener('click', (e) => {
        const btn = e.target.closest('.uuwg-pagination-news-btn, .uuwg-pagination-btn');

        if (!btn) return;
        e.preventDefault();

        if (btn.classList.contains('is-active')) return;

        const grid = block.querySelector('.js-news-grid');
        const pagination = block.querySelector('.js-news-pagination');
        const targetPage = btn.dataset.page;
        const count = block.dataset.count || 3;
        const ajaxUrl = block.dataset.ajaxUrl || (window.location.origin + '/wp-admin/admin-ajax.php');

        if (!grid) return;

        grid.style.opacity = '0.4';

        const formData = new FormData();
        formData.append('action', 'uuwg_get_news');
        formData.append('page', targetPage);
        formData.append('count', count);

        fetch(ajaxUrl, {
          method: 'POST',
          body: formData,
        })
          .then((res) => {
            if (!res.ok) throw new Error(`HTTP Error: ${res.status}`);
            return res.json();
          })
          .then((response) => {
            if (response.success) {
              if (response.data.cards && grid) grid.innerHTML = response.data.cards;
              if (response.data.pagination && pagination) pagination.innerHTML = response.data.pagination;
            } else {
              console.error('News AJAX error:', response);
            }
          })
          .catch((err) => console.error('News AJAX Fetch Error:', err))
          .finally(() => {
            grid.style.opacity = '1';
          });
      });
    });
  }

  // Якщо DOM вже завантажений — запускаємо одразу, інакше чекаємо події
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initNewsPagination);
  } else {
    initNewsPagination();
  }
})();
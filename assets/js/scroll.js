document.addEventListener('DOMContentLoaded', () => {
  const carousels = document.querySelectorAll('[data-uuwg-carousel]');

  carousels.forEach(initCarousel);

  function initCarousel(carousel) {
    const showPagination = carousel.dataset.showPagination === 'true';
    const track = carousel.querySelector('.uuwg-carousel__track');

    const items = Array.from(
      carousel.querySelectorAll('.uuwg-carousel__item')
    );

    const pagination = carousel.querySelector(
      '.uuwg-carousel__pagination'
    );

    if (!track || items.length === 0) {
      return;
    }

    /*
     * How much of the way to the next page
     * the user has to scroll before the next
     * pagination dot becomes active.
     *
     * 0.5 = 50%
     * 0.6 = 60%
     * 0.4 = 40%
     */
    const PAGE_CHANGE_THRESHOLD = 0.6;

    /*
     * How many items are visible on each breakpoint.
     */
    function getItemsPerPage() {
      const width = window.innerWidth;

      if (width <= 767) {
        return Number(carousel.dataset.carouselMobile) || 1;
      }

      if (width <= 1125) {
        return Number(carousel.dataset.carouselTablet) || 2;
      }

      return Number(carousel.dataset.carouselDesktop) || 3;
    }


    /*
     * How many pagination dots we need.
     */
    function getPageCount() {
      const itemsPerPage = getItemsPerPage();

      return Math.ceil(items.length / itemsPerPage);
    }


    /*
     * Get the horizontal scroll position of a particular item.
     */
    function getItemScrollPosition(item) {
      const trackRect = track.getBoundingClientRect();
      const itemRect = item.getBoundingClientRect();

      return track.scrollLeft + (itemRect.left - trackRect.left);
    }


    /*
     * Determine the current page based on scroll position.
     *
     * Example:
     *
     * Desktop: 3 items per page
     *
     * page 0 starts at item 1
     * page 1 starts at item 4
     * page 2 starts at item 7
     *
     * When the user has scrolled 50% of the distance
     * from page 0 to page 1, page 1 becomes active.
     */
    function getCurrentPage() {
      const itemsPerPage = getItemsPerPage();
      const pageCount = getPageCount();

      if (pageCount <= 1) {
        return 0;
      }

      const currentScroll = track.scrollLeft;

      let currentPage = 0;

      for (let page = 0; page < pageCount - 1; page++) {
        const currentItemIndex = page * itemsPerPage;
        const nextItemIndex = (page + 1) * itemsPerPage;

        const currentItem = items[currentItemIndex];
        const nextItem = items[nextItemIndex];

        if (!currentItem || !nextItem) {
          break;
        }

        const currentPosition =
          getItemScrollPosition(currentItem);

        const nextPosition =
          getItemScrollPosition(nextItem);

        const distance = nextPosition - currentPosition;

        const thresholdPosition =
          currentPosition +
          distance * PAGE_CHANGE_THRESHOLD;

        if (currentScroll >= thresholdPosition) {
          currentPage = page + 1;
        } else {
          break;
        }
      }

      return Math.min(currentPage, pageCount - 1);
    }


    /*
     * Create pagination buttons.
     */
    function createPagination() {
      if (!pagination) {
        return;
      }

      pagination.innerHTML = '';

      const pageCount = getPageCount();

      /*
       * Pagination disabled in block settings.
       */
      if (!showPagination) {
        pagination.hidden = true;
        return;
      } else {
        pagination.hidden = false;
      }

      /*
       * No pagination if there is only one page.
       */
      // if (pageCount <= 1) {
      //   pagination.hidden = true;
      //   return;
      // }

      pagination.hidden = false;

      for (let i = 0; i < pageCount; i++) {
        const button = document.createElement('button');

        button.type = 'button';

        button.classList.add(
          'uuwg-carousel__dot'
        );

        button.setAttribute(
          'aria-label',
          `Go to slide ${i + 1}`
        );

        button.addEventListener('click', () => {
          goToPage(i);
        });

        pagination.appendChild(button);
      }

      updatePagination();
    }

    /*
     * Scroll to the beginning of a page.
     */
    function goToPage(pageIndex) {
      const itemsPerPage = getItemsPerPage();

      const itemIndex = pageIndex * itemsPerPage;

      const targetItem = items[itemIndex];

      if (!targetItem) {
        return;
      }

      const targetPosition =
        getItemScrollPosition(targetItem);

      track.scrollTo({
        left: targetPosition,
        behavior: 'smooth',
      });
    }


    /*
     * Update active pagination dot.
     */
    function updatePagination() {
      if (!pagination) {
        return;
      }

      const dots = pagination.querySelectorAll(
        '.uuwg-carousel__dot'
      );

      const currentPage = getCurrentPage();

      dots.forEach((dot, index) => {
        dot.classList.toggle(
          'is-active',
          index === currentPage
        );
      });
    }


    /*
     * Update pagination while scrolling.
     *
     * requestAnimationFrame prevents us from
     * running the calculation excessively often.
     */
    let ticking = false;

    track.addEventListener('scroll', () => {
      if (ticking) {
        return;
      }

      ticking = true;

      requestAnimationFrame(() => {
        updatePagination();
        ticking = false;
      });
    });


    /*
     * Rebuild pagination when breakpoint changes.
     */
    let resizeTimeout;

    window.addEventListener('resize', () => {
      clearTimeout(resizeTimeout);

      resizeTimeout = setTimeout(() => {
        createPagination();
        updatePagination();
      }, 150);
    });


    /*
     * Initial setup.
     */
    createPagination();
  }
});
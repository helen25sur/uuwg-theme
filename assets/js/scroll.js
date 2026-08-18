document.addEventListener('DOMContentLoaded', () => {
  const carousels = document.querySelectorAll(
    '[data-uuwg-carousel]'
  );

  carousels.forEach(initCarousel);


  function initCarousel(carousel) {
    const track = carousel.querySelector(
      '.uuwg-carousel__track'
    );

    const pagination = carousel.querySelector(
      '.uuwg-carousel__pagination'
    );

    if (!track) {
      return;
    }


    /*
     * Pagination can be disabled in block settings.
     */
    const showPagination =
      carousel.dataset.showPagination === 'true';


    /*
     * Total number of posts in the database.
     */
    const totalItems =
      Number(carousel.dataset.totalItems) || 0;


    /*
     * Items currently loaded into the DOM.
     */
    let items = Array.from(
      carousel.querySelectorAll(
        '.uuwg-carousel__item'
      )
    );


    /*
     * How many items are visible on each breakpoint.
     */
    function getItemsPerPage() {
      const width = window.innerWidth;

      if (width <= 767) {
        return (
          Number(
            carousel.dataset.carouselMobile
          ) || 1
        );
      }

      if (width <= 1125) {
        return (
          Number(
            carousel.dataset.carouselTablet
          ) || 2
        );
      }

      return (
        Number(
          carousel.dataset.carouselDesktop
        ) || 3
      );
    }


    /*
     * Total number of pagination pages.
     *
     * This is based on ALL posts,
     * not only posts currently loaded.
     */
    function getPageCount() {
      const itemsPerPage =
        getItemsPerPage();

      if (!totalItems) {
        return 0;
      }

      return Math.ceil(
        totalItems / itemsPerPage
      );
    }


    /*
     * Get an item's position relative
     * to the carousel track.
     */
    function getItemScrollPosition(item) {
      const trackRect =
        track.getBoundingClientRect();

      const itemRect =
        item.getBoundingClientRect();

      return (
        track.scrollLeft +
        (itemRect.left - trackRect.left)
      );
    }


    /*
     * Determine the current page from
     * the current scroll position.
     *
     * 50% of the distance to the next page
     * is the threshold.
     */
    function getCurrentPage() {
      const itemsPerPage =
        getItemsPerPage();

      const pageCount =
        getPageCount();

      if (
        pageCount <= 1 ||
        items.length === 0
      ) {
        return 0;
      }


      const currentScroll =
        track.scrollLeft;

      let currentPage = 0;


      for (
        let page = 1;
        page < pageCount;
        page++
      ) {

        const itemIndex =
          page * itemsPerPage;

        const nextPageItem =
          items[itemIndex];


        /*
         * The next page hasn't been loaded yet.
         */
        if (!nextPageItem) {
          break;
        }


        const previousPageIndex =
          (page - 1) * itemsPerPage;

        const previousPageItem =
          items[previousPageIndex];


        if (!previousPageItem) {
          break;
        }


        const previousPosition =
          getItemScrollPosition(
            previousPageItem
          );

        const nextPosition =
          getItemScrollPosition(
            nextPageItem
          );


        const distance =
          nextPosition -
          previousPosition;


        const threshold =
          previousPosition +
          distance * 0.5;


        if (
          currentScroll >= threshold
        ) {
          currentPage = page;
        } else {
          break;
        }
      }


      return Math.min(
        currentPage,
        pageCount - 1
      );
    }


    /*
     * Create pagination dots.
     */
    function createPagination() {

      if (
        !pagination ||
        !showPagination
      ) {
        return;
      }


      pagination.innerHTML = '';


      const pageCount =
        getPageCount();


      if (pageCount <= 1) {
        pagination.hidden = true;
        return;
      }


      pagination.hidden = false;


      for (
        let i = 0;
        i < pageCount;
        i++
      ) {

        const button =
          document.createElement('button');


        button.type = 'button';

        button.classList.add(
          'uuwg-carousel__dot'
        );


        button.setAttribute(
          'aria-label',
          `Go to slide ${i + 1}`
        );


        button.addEventListener(
          'click',
          () => {

            carousel.dispatchEvent(
              new CustomEvent(
                'uuwg:carousel-page-request',
                {
                  detail: {
                    page: i
                  }
                }
              )
            );

          }
        );


        pagination.appendChild(button);
      }


      updatePagination();
    }


    /*
     * Scroll to a specific page.
     */
    function goToPage(pageIndex) {

      const itemsPerPage =
        getItemsPerPage();

      const itemIndex =
        pageIndex * itemsPerPage;

      const targetItem =
        items[itemIndex];

      if (!targetItem) {
        return false;
      }

      const targetPosition =
        getItemScrollPosition(
          targetItem
        );

      track.scrollTo({
        left: targetPosition,
        behavior: 'smooth'
      });


      /*
       * We already know exactly which page
       * the user requested.
       *
       * Wait until the smooth scroll has finished
       * and then explicitly set the active dot.
       */
      setTimeout(() => {

        if (!pagination) {
          return;
        }

        const dots =
          pagination.querySelectorAll(
            '.uuwg-carousel__dot'
          );

        dots.forEach((dot, index) => {
          dot.classList.toggle(
            'is-active',
            index === pageIndex
          );
        });

      }, 400);


      return true;
    }


    /*
     * pagination.js calls this after
     * the required posts have been loaded.
     */
    carousel.addEventListener(
      'uuwg:carousel-go-to-page',
      (event) => {

        const page =
          event.detail.page;


        /*
         * Refresh items because AJAX
         * may have added new cards.
         */
        items = Array.from(
          carousel.querySelectorAll(
            '.uuwg-carousel__item'
          )
        );


        goToPage(page);
      }
    );


    /*
     * AJAX added new cards.
     */
    carousel.addEventListener(
      'uuwg:carousel-items-loaded',
      () => {

        items = Array.from(
          carousel.querySelectorAll(
            '.uuwg-carousel__item'
          )
        );


        /*
         * Do not scroll here.
         * pagination.js will request the page.
         */
        updatePagination();
      }
    );


    /*
     * Update active pagination dot.
     */
    function updatePagination() {

      if (!pagination) {
        return;
      }


      const dots =
        pagination.querySelectorAll(
          '.uuwg-carousel__dot'
        );


      const currentPage =
        getCurrentPage();


      dots.forEach(
        (dot, index) => {

          dot.classList.toggle(
            'is-active',
            index === currentPage
          );

        }
      );
    }


    /*
     * Update active dot while scrolling.
     */
    let ticking = false;


    track.addEventListener(
      'scroll',
      () => {

        if (ticking) {
          return;
        }


        ticking = true;


        requestAnimationFrame(
          () => {

            updatePagination();

            ticking = false;

          }
        );
      }
    );


    /*
     * Rebuild pagination after breakpoint change.
     */
    let resizeTimeout;


    window.addEventListener(
      'resize',
      () => {

        clearTimeout(
          resizeTimeout
        );


        resizeTimeout =
          setTimeout(() => {

            createPagination();

            updatePagination();

          }, 150);
      }
    );


    /*
     * Initial setup.
     */
    createPagination();
  }
});
document.addEventListener('DOMContentLoaded', () => {

  const carousels = document.querySelectorAll(
    '[data-uuwg-pagination]'
  );

  carousels.forEach(initPagination);


  function initPagination(carousel) {

    const track = carousel.querySelector(
      '.uuwg-carousel__track'
    );

    if (!track) {
      return;
    }


    const postType =
      carousel.dataset.postType;


    /*
     * Number of items loaded by one AJAX request.
     */
    const perPage =
      Number(carousel.dataset.perPage) || 6;


    /*
     * Number of posts already loaded.
     *
     * Initially these are rendered by PHP.
     */
    let loadedItems =
      carousel.querySelectorAll(
        '.uuwg-carousel__item'
      ).length;


    let isLoading = false;


    /*
     * How many cards are visible
     * at the current breakpoint.
     */
    function getItemsPerPage() {

      const width =
        window.innerWidth;


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
     * User clicked a carousel pagination dot.
     */
    carousel.addEventListener(
      'uuwg:carousel-page-request',
      async (event) => {

        const carouselPage =
          event.detail.page;


        const itemsPerPage =
          getItemsPerPage();


        /*
         * Which card does this carousel page start with?
         */
        const targetIndex =
          carouselPage * itemsPerPage;


        /*
         * Refresh number of loaded cards.
         */
        loadedItems =
          carousel.querySelectorAll(
            '.uuwg-carousel__item'
          ).length;


        /*
         * IMPORTANT:
         *
         * If the required card is already in DOM,
         * we do NOT make an AJAX request.
         */
        if (
          targetIndex < loadedItems
        ) {

          requestScroll(
            carouselPage
          );

          return;
        }


        /*
         * Required card isn't loaded yet.
         *
         * Load the next data batch.
         */
        if (isLoading) {
          return;
        }


        await loadNextDataPage(
          carouselPage
        );

      }
    );


    async function loadNextDataPage(carouselPage) {

      isLoading = true;

      try {
        // Джерело правди — фактична кількість карток У DOM ЗАРАЗ,
        // а не розрахунок "сторінка × perPage".
        loadedItems = carousel.querySelectorAll(
          '.uuwg-carousel__item'
        ).length;

        const url =
          `/wp-json/uuwg/v1/${postType}` +
          `?offset=${loadedItems}` +
          `&per_page=${perPage}`;

        const response = await fetch(url);

        if (!response.ok) {
          throw new Error(`HTTP error: ${response.status}`);
        }

        const data = await response.json();

        if (data.html) {
          track.insertAdjacentHTML('beforeend', data.html);
        }

        loadedItems = carousel.querySelectorAll(
          '.uuwg-carousel__item'
        ).length;

        carousel.dispatchEvent(
          new CustomEvent('uuwg:carousel-items-loaded')
        );

        requestScroll(carouselPage);

      } catch (error) {
        console.error('Failed to load posts:', error);
      } finally {
        isLoading = false;
      }
    }


    function requestScroll(
      page
    ) {

      carousel.dispatchEvent(
        new CustomEvent(
          'uuwg:carousel-go-to-page',
          {
            detail: {
              page: page
            }
          }
        )
      );

    }

  }

});
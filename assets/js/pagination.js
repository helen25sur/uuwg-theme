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
      Number(carousel.dataset.perPage) || 3;


    /*
     * Total items available in DB (used to stop observer when all loaded).
     */
    const totalItems =
      Number(carousel.dataset.totalItems) || 0;


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
    let observer = null;


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
     * IntersectionObserver for loading next items automatically on swipe/scroll.
     */
    function observeLastCard() {
      if (observer) {
        observer.disconnect();
      }

      const items = carousel.querySelectorAll('.uuwg-carousel__item');
      if (!items.length) return;

      // Якщо завантажено абсолютно всі елементи — зупиняємо спостереження
      if (totalItems > 0 && items.length >= totalItems) {
        return;
      }

      const lastItem = items[items.length - 1];

      observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting && !isLoading) {

          const currentLoaded = carousel.querySelectorAll(
            '.uuwg-carousel__item'
          ).length;

          if (totalItems > 0 && currentLoaded >= totalItems) {
            observer.disconnect();
            return;
          }

          const itemsPerPage = getItemsPerPage();
          const nextPage = Math.floor(currentLoaded / itemsPerPage);

          // loadNextDataPage з прапором shouldScroll = false, 
          // щоб не збивати анімацію свайпу користувача
          loadNextDataPage(nextPage, false);
        }
      }, {
        root: track,
        rootMargin: '0px 200px 0px 0px', // Починає завантажувати за 200px до краю
        threshold: 0.1
      });

      observer.observe(lastItem);
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
          carouselPage,
          true
        );

      }
    );


    async function loadNextDataPage(carouselPage, shouldScroll = true) {

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

        if (data.html && data.html.trim() !== '') {
          track.insertAdjacentHTML('beforeend', data.html);
        } else {
          // Якщо сервер повернув порожні дані — відключаємо обзервер
          if (observer) observer.disconnect();
        }

        loadedItems = carousel.querySelectorAll(
          '.uuwg-carousel__item'
        ).length;

        carousel.dispatchEvent(
          new CustomEvent('uuwg:carousel-items-loaded')
        );

        // При кліку на крапку виконуємо скрол, при свайпі — залишаємо вільний рух
        if (shouldScroll) {
          requestScroll(carouselPage);
        }

        // Перепідключаємо обзервер до нової останньої картки
        observeLastCard();

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


    /*
     * Initial observer setup.
     */
    observeLastCard();

  }

});
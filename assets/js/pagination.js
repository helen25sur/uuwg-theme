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

    const perPage =
      Number(carousel.dataset.perPage) || 3;

    let loadedPage = 1;
    let isLoading = false;


    carousel.addEventListener(
      'uuwg:carousel-page-request',
      async (event) => {

        const page =
          event.detail.page + 1;


        /*
         * First page is already rendered
         * by PHP.
         */
        if (page <= loadedPage) {
          requestScroll(page - 1);
          return;
        }


        if (isLoading) {
          return;
        }


        await loadPage(page);
      }
    );


    async function loadPage(page) {
      isLoading = true;

      try {

        const url =
          `/wp-json/uuwg/v1/${postType}` +
          `?page=${page}` +
          `&per_page=${perPage}`;


        const response =
          await fetch(url);


        if (!response.ok) {
          throw new Error(
            `HTTP error: ${response.status}`
          );
        }


        const data =
          await response.json();


        /*
         * Add new cards to the track.
         */
        if (data.html) {
          track.insertAdjacentHTML(
            'beforeend',
            data.html
          );
        }

        loadedPage = page;


        /*
         * Tell carousel.js to refresh
         * its items array.
         */
        carousel.dispatchEvent(
          new CustomEvent(
            'uuwg:carousel-items-loaded'
          )
        );


        /*
         * Now tell carousel.js to scroll
         * to the requested carousel page.
         */
        requestScroll(page - 1);
        // requestAnimationFrame(() => {
        //   requestAnimationFrame(() => {
        //   });
        // });


      } catch (error) {

        console.error(
          'Failed to load projects:',
          error
        );

      } finally {

        isLoading = false;
      }
    }


    function requestScroll(page) {

      carousel.dispatchEvent(
        new CustomEvent(
          'uuwg:carousel-go-to-page',
          {
            detail: {
              page: page,
            },
          }
        )
      );
    }
  }
});
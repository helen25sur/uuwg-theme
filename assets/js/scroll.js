document.addEventListener('DOMContentLoaded', function () {

  const carousels = document.querySelectorAll('[data-uuwg-carousel]');

  carousels.forEach(function (carousel) {
    initCarousel(carousel);
  });

  function initCarousel(carousel) {
    const track = carousel.querySelector('.uuwg-carousel__track');
    const items = track.querySelectorAll('.uuwg-carousel__item');
    const dotsContainer = carousel.querySelector('.uuwg-carousel__dots');

    if (!track || items.length === 0 || !dotsContainer) {
      return; // немає що ініціалізувати
    }

    // 1. Генеруємо dots — один на кожну картку
    const dots = [];
    items.forEach(function (item, index) {
      const dot = document.createElement('button');
      dot.classList.add('uuwg-carousel__dot');
      dot.setAttribute('type', 'button');
      dot.setAttribute('aria-label', 'Go to slide ' + (index + 1));

      dot.addEventListener('click', function () {
        const item = items[index];

        track.scrollTo({
          left: item.offsetLeft - track.offsetLeft,
          behavior: 'smooth',
        });
      });

      dotsContainer.appendChild(dot);
      dots.push(dot);
    });

    // Перша картка активна за замовчуванням
    dots[0].classList.add('is-active');

    // 2. IntersectionObserver — стежить, яка картка зараз видима,
    //    і підсвічує відповідний dot
    const observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            const index = Array.prototype.indexOf.call(items, entry.target);

            dots.forEach(function (dot) {
              dot.classList.remove('is-active');
            });
            dots[index].classList.add('is-active');
          }
        });
      },
      {
        root: track, // спостерігаємо відносно самого track, не всього вікна
        threshold: 0.6, // картка вважається "активною", коли видно хоча б 60%
      }
    );

    items.forEach(function (item) {
      console.log(item);
      observer.observe(item);
    });
  }

});
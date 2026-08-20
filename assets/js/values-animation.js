document.addEventListener('DOMContentLoaded', function () {
  if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
    return;
  }

  gsap.registerPlugin(ScrollTrigger);

  // Працюємо тільки на екранах <= 1000px
  if (window.innerWidth > 1000) {
    return;
  }

  const gridContainer = document.querySelector('.uuwg-values-circles__list');
  const cards = gsap.utils.toArray('.uuwg-values-circles__card');

  console.log('gridContainer:', gridContainer, 'cards:', cards.length);
  console.log(ScrollTrigger.getAll());

  if (!gridContainer || cards.length < 2) {
    return;
  }

  const cardHeight = cards[0].offsetHeight;
  // Крок зміщення з урахуванням CSS margin-top (-35px)
  const step = cardHeight - 35;

  const timeline = gsap.timeline({
    scrollTrigger: {
      trigger: gridContainer,
      start: 'top top+=100',
      end: '+=1000',
      pin: true,
      pinType: 'fixed',
      scrub: 1,
      anticipatePin: 1,
      invalidateOnRefresh: true
    }
  });

  cards.forEach(function (card, index) {
    if (index === 0) return;

    timeline.to(
      card,
      {
        y: -(step * index),
        duration: 1,
        ease: 'none'
      },
      index - 1
    );
  });

  window.addEventListener('load', function () {
    ScrollTrigger.refresh();
  });

  window.addEventListener('resize', function () {
    ScrollTrigger.refresh();
  });

  // додатково, якщо є веб-шрифти:
  if (document.fonts) {
    document.fonts.ready.then(function () {
      ScrollTrigger.refresh();
    });
  }
});
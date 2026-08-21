document.addEventListener('DOMContentLoaded', function () {
  if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

  gsap.registerPlugin(ScrollTrigger);
  if (window.innerWidth > 1125) return;

  const gridsEl = document.querySelector('.uuwg-values-circles__grids');
  const listEl = document.querySelector('.uuwg-values-circles__list');
  const cards = gsap.utils.toArray('.uuwg-values-circles__card');

  if (!listEl || cards.length < 2) return;

  let currentTimeline;
  const START_OFFSET = 100;               // відповідає 'top top+=100'
  // const EXIT_RUNWAY_RATIO = 0.9;          // запас на "спокійний" вихід із піну

  function setup() {
    if (currentTimeline) {
      currentTimeline.scrollTrigger.kill();
      currentTimeline.kill();
      gsap.set(cards, { clearProps: 'transform' });
      gridsEl.style.minHeight = '';
      listEl.style.minHeight = '';
    }

    const cardHeight = cards[0].offsetHeight;   // реальний розмір ЗАРАЗ для цього брейкпоінта
    const marginOverlap = 35;
    const visibleOffset = 20;
    const step = cardHeight - marginOverlap - visibleOffset;

    const animationDistance = step * (cards.length - 1);
    const exitRunway = 100;
    const scrollNeeded = animationDistance + exitRunway;

    // ключове: висота контейнера = точна дистанція скролу, а не вгадана vh
    const requiredHeight = START_OFFSET + scrollNeeded + (window.innerHeight / 2);
    gridsEl.style.minHeight = requiredHeight + 'px';
    listEl.style.minHeight = requiredHeight + 'px';

    currentTimeline = gsap.timeline({
      scrollTrigger: {
        trigger: listEl,
        start: 'top top+=' + START_OFFSET,
        end: '+=' + scrollNeeded,   // синхронізовано з тим самим step, що й висота
        pin: true,
        scrub: 1,
        anticipatePin: 1,
        invalidateOnRefresh: true,
        marked: true
      }
    });

    cards.forEach(function (card, index) {
      if (index === 0) return;
      currentTimeline.to(
        card,
        { y: -(step * index), duration: 1, ease: 'none' },
        index - 1
      );
    });
  }

  setup();

  let resizeTimer;
  window.addEventListener('resize', function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(setup, 200);
  });

  window.addEventListener('load', function () { ScrollTrigger.refresh(); });
  if (document.fonts) {
    document.fonts.ready.then(function () { ScrollTrigger.refresh(); });
  }
});
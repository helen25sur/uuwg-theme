document.addEventListener('DOMContentLoaded', () => {
  const burgerBtn = document.querySelector('.uuwg-burger-menu-btn');
  const closeBtn = document.querySelector('.uuwg-overlay-close');
  const overlay = document.querySelector('.uuwg-overlay');

  if (!burgerBtn || !overlay) return;

  const openMenu = () => {
    overlay.classList.add('is-active');
    document.body.style.overflow = 'hidden';

    const overlayHeader = document.querySelector('.overlay-menu-header:has(.uuwg-overlay.is-active)');
    overlayHeader.addEventListener('click', (evt) => {
      if (evt.target.contains(overlay)) {
        overlay.classList.remove('is-active');
        document.body.style.overflow = '';
      }
    });

  };

  const closeMenu = () => {
    overlay.classList.remove('is-active');
    document.body.style.overflow = '';
  };

  burgerBtn.addEventListener('click', openMenu);
  if (closeBtn) closeBtn.addEventListener('click', closeMenu);
});

// Закриває перемикач мов при кліку за його межами
document.addEventListener('click', (e) => {
  const switcher = document.querySelector('.uuwg-language-switcher');
  if (switcher && !switcher.contains(e.target)) {
    switcher.removeAttribute('open');
  }
});

// Закриває фільтр проєктів при кліку за його межами
document.addEventListener('click', (e) => {
  const projectFilter = document.querySelector('.uuwg-our-projects__filters');
  if (projectFilter && !projectFilter.contains(e.target)) {
    projectFilter.removeAttribute('open');
  }
});
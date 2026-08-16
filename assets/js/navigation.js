document.addEventListener('DOMContentLoaded', () => {
  const burgerBtn = document.querySelector('.uuwg-burger-btn');
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
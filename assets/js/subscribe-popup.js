document.addEventListener('DOMContentLoaded', function () {
  const popup = document.getElementById('uuwg-subscribe-popup');
  const closeBtn = document.getElementById('uuwg-subscribe-popup-close');
  const form = document.querySelector('#mc4wp-form-1');

  if (!popup || !form) return;

  function openPopup() {
    popup.classList.add('is-open');
    popup.setAttribute('aria-hidden', 'false');
  }

  function closePopup() {
    popup.classList.remove('is-open');
    popup.setAttribute('aria-hidden', 'true');
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', closePopup);
  }

  popup.addEventListener('click', function (e) {
    if (e.target === popup) {
      closePopup();
    }
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && popup.classList.contains('is-open')) {
      closePopup();
    }
  });

  const successMsg = form.querySelector('.mc4wp-success');

  if (successMsg) {
    console.log('Here should open popup');
    openPopup();
    successMsg.style.display = 'none';
  }
});
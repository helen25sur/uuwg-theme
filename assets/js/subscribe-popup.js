document.addEventListener('DOMContentLoaded', function () {
  const popup = document.getElementById('uuwg-subscribe-popup');
  const closeBtn = document.getElementById('uuwg-subscribe-popup-close');
  const form = document.querySelector('#mc4wp-form-1');

  if (!popup || !form) return;

  const popupTitle = popup.querySelector('.uuwg-subscribe-popup__title');
  const popupText = popup.querySelector('.uuwg-subscribe-popup__text');

  const imageSuccess = popup.querySelector('.wp-image-234');
  const imageError = popup.querySelector('.wp-image-235');


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
  const errorMsg = form.querySelector('.mc4wp-error');

  if (successMsg) {
    successMsg.style.display = 'none';
    successMsg.remove();
    console.log('Here should open popup');
    openPopup();
  } else if (errorMsg) {
    errorMsg.remove();
    imageSuccess.hidden = true;
    imageError.hidden = false;
    popupTitle.textContent = 'Something went wrong';
    popupText.textContent = 'We couldn’t complete your request.\nPlease try again in a moment.';
    if (!popup.querySelector('.uuwg-subscribe-popup__button')) {
      const btn = document.createElement('a');
      btn.classList.add('uuwg-subscribe-popup__button');
      btn.innerText = 'Try again';
      btn.href = window.location.pathname + '#mc4wp-form-1';
      btn.addEventListener('click', closePopup);
      popup.querySelector('.uuwg-subscribe-popup').appendChild(btn);
      form.reset();
    }
    openPopup();
  }
});
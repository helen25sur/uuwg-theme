document.addEventListener('DOMContentLoaded', function () {
  const popup = document.getElementById('uuwg-subscribe-popup');
  const closeBtn = document.getElementById('uuwg-subscribe-popup-close');
  const form = document.querySelector('#mc4wp-form-1');

  if (!popup || !form) return;

  const popupTitle = popup.querySelector('.uuwg-subscribe-popup__title');
  const popupText = popup.querySelector('.uuwg-subscribe-popup__text');

  const imageSuccess = popup.querySelector('.wp-image-252');
  const imageError = popup.querySelector('.wp-image-253');

  const returnUrlInput = document.getElementById('uuwg-return-url');

  if (returnUrlInput) {
    returnUrlInput.value = window.location.href;
  }

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

  const params = new URLSearchParams(window.location.search);
  const subscriptionStatus = params.get('subscription');

  if (subscriptionStatus === 'success') {

    if (successMsg) {
      successMsg.remove();
    }

    console.log('Here should open success popup');
    openPopup();

    const url = new URL(window.location.href);
    url.searchParams.delete('subscription');
    window.history.replaceState({}, '', url);

  } else if (errorMsg) {
    errorMsg.remove();
    imageSuccess.hidden = true;
    imageError.hidden = false;
    popupTitle.textContent = 'Something went wrong';
    popupText.innerHTML = `We couldn’t complete your request. <br/>Please try again in a moment.`;
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
  } else if (subscriptionStatus === 'confirmed') {
    imageSuccess.hidden = true;
    imageError.hidden = true;
    popupTitle.textContent = 'You\'re subscribed!';
    popupText.innerHTML = `Thank you for joining our newsletter. <br/> We\'ll keep you updated on our work, events, and impact.`;
    if (!popup.querySelector('.chat_button__link')) {
      const btn = document.createElement('a');
      const chatLink = document.querySelector('footer a.uuwg-social-link--telegram');
      btn.classList.add('chat_button__link');
      btn.innerText = 'Join our chat';
      btn.href = chatLink ? chatLink.href : '/';
      btn.target = '_blank';
      btn.rel = 'noopener noreferrer';

      popup.querySelector('.uuwg-subscribe-popup').appendChild(btn);
    }
    openPopup();

    const url = new URL(window.location.href);
    url.searchParams.delete('subscription');
    window.history.replaceState({}, '', url);
  }
});
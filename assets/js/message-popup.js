document.addEventListener('DOMContentLoaded', function () {
  const popup = document.getElementById('uuwg-thankyou-popup');
  const closeBtn = document.getElementById('uuwg-popup-close');

  if (!popup) return;

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

  document.addEventListener('fluentform_submission_success', function (event) {
    openPopup();

    const successMsg = document.querySelector('.ff-message-success');
    if (successMsg) {
      successMsg.style.display = 'none';
    }
  });
});
const socialsList = document.querySelector('.uuwg-socials-share__list');

if (socialsList) {
  const socialsButtons = socialsList.querySelectorAll('.uuwg-socials-share__button');

  const copyNotification = document.querySelector('.uuwg-copy-notification');

  socialsButtons.forEach((btn, idx) => {
    btn.addEventListener('click', (evt) => {
      console.log(evt.target);

      const social = btn.dataset.social;
      console.log(social);
      const url = encodeURIComponent(window.location.href);

      switch (social) {
        case 'facebook':
          // Facebook sharing
          window.open(
            `https://www.facebook.com/sharer/sharer.php?u=${url}`,
            '_blank',
            'width=600,height=500'
          );
          break;

        case 'linkedin':
          // LinkedIn sharing
          window.open(
            `https://www.linkedin.com/sharing/share-offsite/?url=${url}`,
            '_blank',
            'width=600,height=500'
          );
          break;

        case 'telegram':
          // Telegram sharing
          const text = encodeURIComponent(document.title);

          window.open(
            `https://t.me/share/url?url=${url}&text=${text}`,
            '_blank'
          );
          break;

        case 'copy':
          // Clipboard API
          copyLink();
          break;

        case 'instagram':
        case 'youtube':
          if (navigator.share) {
            navigator.share({
              title: document.title,
              url: window.location.href,
            }).catch((error) => {
              if (error.name !== 'AbortError') {
                console.error('Failed to share:', error);
              }
            });
          } else {
            copyLink();
          }
          break;
      }

    })


  });

  async function copyLink() {
    const url = window.location.href;

    try {
      if (navigator.clipboard) {
        await navigator.clipboard.writeText(url);
      } else {
        const textarea = document.createElement('textarea');

        textarea.value = url;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';

        document.body.appendChild(textarea);
        textarea.select();

        document.execCommand('copy');
        textarea.remove();
      }

      console.log('Link copied');
      showCopyNotification();
    } catch (error) {
      console.error('Failed to copy link:', error);
    }
  }

  function showCopyNotification() {
    copyNotification.classList.add('is-visible');

    setTimeout(() => {
      copyNotification.classList.remove('is-visible');
    }, 2000);
  }

}
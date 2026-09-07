const activePages = {
  'page-template-page-about': '/about/',
  'post-type-archive-project': '/projects/',
  'single-project': '/projects/',
  'post-type-archive-news_event': '/news/',
  'single-news_event': '/news/',
  'post-type-archive-document': '/documents',
  'single-document': '/documents/',
};

const navLinks = document.querySelectorAll('.wp-block-navigation-item a');

const bodyClasses = document.body.className;

const entries = Object.entries(activePages);

navLinks.forEach((link) => {
  const found = entries.find((entry) => {
    const className = entry[0];
    return bodyClasses.includes(className);
  });

  let activePath;
  if (found) {
    activePath = found[1];
  }
  console.log('activePath:', activePath, 'link.pathname:', link.pathname, 'link.hash:', link.hash, 'window.location.hash:', window.location.hash);
  if (activePath && link.pathname === activePath) {
    link.parentElement.classList.add('is-active');
  }

  const isHomePage = window.location.pathname === '/';
  if (isHomePage && link.hash === window.location.hash && link.hash !== '') {
    link.parentElement.classList.add('is-active');
  }
}
);

function updateActiveAnchor() {
  const isHomePage = window.location.pathname === '/';

  document.querySelectorAll('.wp-block-navigation-item a').forEach((link) => {
    link.parentElement.classList.remove('is-active');

    if (isHomePage && link.hash === window.location.hash) {
      link.parentElement.classList.add('is-active');
    }
  });
}
window.addEventListener('hashchange', updateActiveAnchor);
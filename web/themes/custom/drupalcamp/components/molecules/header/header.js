document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.querySelector('.header__toggle');
    const container = document.querySelector('.header__container');
    if (toggleBtn && container) {
        const closeBtn = container.querySelector('.header__close');
        toggleBtn.addEventListener('click', () => {
            container.classList.toggle('header__container--open');
            toggleBtn.classList.toggle('header__toggle--open');
        });
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                container.classList.remove('header__container--open');
                toggleBtn.classList.remove('header__toggle--open');
            });
        }
    }
});

document.addEventListener('keydown', (e) => {
  const toggleBtn = document.querySelector('.header__toggle');
  const container = document.querySelector('.header__container');
  if (e.key === 'Escape' && container && container.classList.contains('header__container--open')) {
    container.classList.remove('header__container--open');
    toggleBtn.classList.remove('header__toggle--open');
  }
});

document.addEventListener('click', (e) => {
  const toggleBtn = document.querySelector('.header__toggle');
  const container = document.querySelector('.header__container');
  if (container && container.classList.contains('header__container--open') &&
    !container.contains(e.target) && e.target !== toggleBtn) {
    container.classList.remove('header__container--open');
    toggleBtn.classList.remove('header__toggle--open');
  }
});

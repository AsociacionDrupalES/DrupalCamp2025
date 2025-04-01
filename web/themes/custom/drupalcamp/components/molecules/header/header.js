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

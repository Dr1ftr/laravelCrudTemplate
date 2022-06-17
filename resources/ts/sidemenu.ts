const sidemenu = document.querySelector('.sidemenu');
const hamburger = document.querySelector('.sidemenu-button');

hamburger.addEventListener('click', () => {
    sidemenu.classList.toggle('open');
});

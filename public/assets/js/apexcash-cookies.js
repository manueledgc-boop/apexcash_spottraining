document.addEventListener('DOMContentLoaded', () => {
    const banner = document.getElementById('apexcash-cookie-banner');
    const button = document.getElementById('accept-cookies');

    if (!banner || !button) return;

    const accepted = localStorage.getItem('apexcash_cookies_accepted');

    if (!accepted) {
        banner.classList.add('is-visible');
    }

    button.addEventListener('click', () => {
        localStorage.setItem('apexcash_cookies_accepted', 'yes');
        banner.classList.remove('is-visible');
    });
});
(() => {
    const CONSENT_KEY = 'apexcash_cookie_consent';
    const banner = document.getElementById('apexcash-cookie-banner');
    const acceptBtn = document.getElementById('cookies-accept');
    const essentialBtn = document.getElementById('cookies-essential');

    if (!banner) return;

    const existingConsent = localStorage.getItem(CONSENT_KEY);

    if (!existingConsent) {
        banner.hidden = false;
        banner.style.display = 'flex';
    }

    function saveConsent(type) {
        localStorage.setItem(CONSENT_KEY, JSON.stringify({
            type,
            accepted_at: new Date().toISOString(),
            version: '1.0',
        }));

        banner.style.display = 'none';
        banner.hidden = true;
    }

    acceptBtn?.addEventListener('click', () => {
        saveConsent('all');
    });

    essentialBtn?.addEventListener('click', () => {
        saveConsent('essential');
    });
})();
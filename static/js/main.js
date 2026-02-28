/* Entenbach Tiger - Interaktionen */

document.addEventListener('DOMContentLoaded', () => {
    initNavigation();
    initScrollAnimationen();
    initLightbox();
    initFlashMessages();
});

/* --- Navigation --- */
function initNavigation() {
    const header = document.getElementById('site-header');
    const toggle = document.getElementById('nav-toggle');
    const menu = document.getElementById('nav-menu');

    if (!header) return;

    // Scroll-Effekt fuer Header
    let letzterScroll = 0;
    window.addEventListener('scroll', () => {
        const scrollY = window.scrollY;
        if (scrollY > 60) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
        letzterScroll = scrollY;
    }, { passive: true });

    // Mobile Menu Toggle
    if (toggle && menu) {
        toggle.addEventListener('click', () => {
            toggle.classList.toggle('aktiv');
            menu.classList.toggle('offen');
            document.body.style.overflow = menu.classList.contains('offen') ? 'hidden' : '';
        });

        // Menue schliessen bei Klick auf Link
        menu.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                toggle.classList.remove('aktiv');
                menu.classList.remove('offen');
                document.body.style.overflow = '';
            });
        });

        // Menue schliessen bei Klick ausserhalb
        document.addEventListener('click', (e) => {
            if (!menu.contains(e.target) && !toggle.contains(e.target) && menu.classList.contains('offen')) {
                toggle.classList.remove('aktiv');
                menu.classList.remove('offen');
                document.body.style.overflow = '';
            }
        });
    }
}

/* --- Scroll-Animationen --- */
function initScrollAnimationen() {
    const elemente = document.querySelectorAll('.aufdecken');
    if (!elemente.length) return;

    const observer = new IntersectionObserver((eintraege) => {
        eintraege.forEach((eintrag, index) => {
            if (eintrag.isIntersecting) {
                // Gestaffelte Animation
                const verzug = Math.min(index * 80, 400);
                setTimeout(() => {
                    eintrag.target.classList.add('sichtbar');
                }, verzug);
                observer.unobserve(eintrag.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -40px 0px'
    });

    elemente.forEach(el => observer.observe(el));
}

/* --- Lightbox --- */
function initLightbox() {
    const lightbox = document.getElementById('lightbox');
    const lightboxBild = document.getElementById('lightbox-bild');
    const schliessen = document.querySelector('.lightbox-schliessen');

    if (!lightbox) return;

    // Galerie-Items
    document.querySelectorAll('.galerie-item').forEach(item => {
        item.addEventListener('click', () => {
            const src = item.dataset.vollbild;
            if (src && lightboxBild) {
                lightboxBild.src = src;
                lightboxBild.alt = item.querySelector('img')?.alt || '';
                lightbox.classList.add('sichtbar');
                document.body.style.overflow = 'hidden';
            }
        });
    });

    // Schliessen
    function lightboxSchliessen() {
        lightbox.classList.remove('sichtbar');
        document.body.style.overflow = '';
    }

    if (schliessen) {
        schliessen.addEventListener('click', lightboxSchliessen);
    }

    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) lightboxSchliessen();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && lightbox.classList.contains('sichtbar')) {
            lightboxSchliessen();
        }
    });
}

/* --- Flash Messages automatisch ausblenden --- */
function initFlashMessages() {
    document.querySelectorAll('.flash').forEach(flash => {
        setTimeout(() => {
            flash.style.opacity = '0';
            flash.style.transform = 'translateX(40px)';
            setTimeout(() => flash.remove(), 400);
        }, 4000);
    });
}

class HeaderMenu {
    constructor() {
        this.burger = document.querySelector('.burger');
        this.navMenu = document.querySelector('.nav-menu');
        this.init();
    }

    init() {
        if (this.burger && this.navMenu) {
            this.setupEventListeners();
        }
    }

    setupEventListeners() {
        // Клик по бургеру
        this.burger.addEventListener('click', (e) => {
            e.stopPropagation();
            this.toggleMenu();
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.mobile-nav') && !e.target.closest('.nav-menu')) {
                this.closeMenu();
            }
        });

        this.navMenu.addEventListener('click', (e) => {
            if (e.target.tagName === 'A') {
                this.closeMenu();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeMenu();
            }
        });
    }

    toggleMenu() {
        this.navMenu.classList.toggle('active');
        this.updateAriaAttributes();
    }

    closeMenu() {
        this.navMenu.classList.remove('active');
        this.updateAriaAttributes();
    }

    updateAriaAttributes() {
        const isExpanded = this.navMenu.classList.contains('active');
        this.burger.setAttribute('aria-expanded', isExpanded);
        this.navMenu.setAttribute('aria-hidden', !isExpanded);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new HeaderMenu();
});

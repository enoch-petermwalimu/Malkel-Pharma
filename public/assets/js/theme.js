/**
 * -------------------------------------------------------------
 * Theme Manager
 * -------------------------------------------------------------
 * Gestion dark / light mode
 * -------------------------------------------------------------
 */

class ThemeManager {
    constructor() {
        this.theme = localStorage.getItem('theme') || 'light';

        this.applyTheme();

        this.bindEvents();
    }

    /**
     * Application thème
     */
    applyTheme() {
        document.body.setAttribute('data-theme', this.theme);
    }

    /**
     * Switch thème
     */
    toggleTheme() {
        this.theme =
            this.theme === 'light'
                ? 'dark'
                : 'light';

        localStorage.setItem('theme', this.theme);

        this.applyTheme();
    }

    /**
     * Events
     */
    bindEvents() {
        const button = document.getElementById('themeToggle');

        if (!button) return;

        button.addEventListener('click', () => {
            this.toggleTheme();
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new ThemeManager();
});
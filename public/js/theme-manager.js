/**
 * Theme Manager - Comprehensive Dark/Light Mode System
 * Handles theme switching, persistence, and system preference detection
 */

class ThemeManager {
    constructor() {
        this.storageKey = 'transcript-theme';
        this.themes = {
            LIGHT: 'light',
            DARK: 'dark',
            SYSTEM: 'system'
        };

        this.init();
    }

    init() {
        // Initialize theme on page load
        this.applyTheme(this.getStoredTheme());

        // Listen for system theme changes
        this.watchSystemTheme();

        // Expose global functions for Alpine.js
        window.themeManager = this;
        window.toggleTheme = () => this.toggle();
        window.setTheme = (theme) => this.setTheme(theme);
        window.getCurrentTheme = () => this.getCurrentTheme();
    }

    getStoredTheme() {
        try {
            const stored = localStorage.getItem(this.storageKey);
            if (stored && Object.values(this.themes).includes(stored)) {
                return stored;
            }
        } catch (e) {
            console.warn('Failed to read theme from localStorage:', e);
        }
        return this.themes.SYSTEM;
    }

    getSystemTheme() {
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return this.themes.DARK;
        }
        return this.themes.LIGHT;
    }

    getCurrentTheme() {
        const stored = this.getStoredTheme();
        if (stored === this.themes.SYSTEM) {
            return this.getSystemTheme();
        }
        return stored;
    }

    setTheme(theme) {
        if (!Object.values(this.themes).includes(theme)) {
            console.warn('Invalid theme:', theme);
            return;
        }

        try {
            localStorage.setItem(this.storageKey, theme);
        } catch (e) {
            console.warn('Failed to save theme to localStorage:', e);
        }

        this.applyTheme(theme);
        this.dispatchThemeChange(theme);
    }

    applyTheme(theme) {
        const html = document.documentElement;
        const body = document.body;

        // Remove existing theme classes (we only use 'dark')
        html.classList.remove('dark');
        body.classList.remove('dark');

        // Determine actual theme to apply
        const actualTheme = theme === this.themes.SYSTEM ? this.getSystemTheme() : theme;

        // Apply theme classes: only toggle 'dark'
        if (actualTheme === this.themes.DARK) {
            html.classList.add('dark');
        } else {
            // In light mode, no special class is needed
        }

        // Update meta theme-color for mobile browsers
        this.updateMetaThemeColor(actualTheme);

        // Update CSS custom properties
        this.updateCSSVariables(actualTheme);
    }

    updateMetaThemeColor(theme) {
        let metaThemeColor = document.querySelector('meta[name="theme-color"]');
        if (!metaThemeColor) {
            metaThemeColor = document.createElement('meta');
            metaThemeColor.name = 'theme-color';
            document.head.appendChild(metaThemeColor);
        }

        metaThemeColor.content = theme === this.themes.DARK ? '#111827' : '#ffffff';
    }

    updateCSSVariables(theme) {
        const root = document.documentElement;

        if (theme === this.themes.DARK) {
            // Dark theme variables
            root.style.setProperty('--bg-primary', '#111827');
            root.style.setProperty('--bg-secondary', '#1f2937');
            root.style.setProperty('--bg-tertiary', '#374151');
            root.style.setProperty('--text-primary', '#f9fafb');
            root.style.setProperty('--text-secondary', '#d1d5db');
            root.style.setProperty('--text-tertiary', '#9ca3af');
            root.style.setProperty('--border-primary', '#374151');
            root.style.setProperty('--border-secondary', '#4b5563');
            root.style.setProperty('--accent-primary', '#22c55e');
            root.style.setProperty('--accent-secondary', '#16a34a');
        } else {
            // Light theme variables
            root.style.setProperty('--bg-primary', '#ffffff');
            root.style.setProperty('--bg-secondary', '#f9fafb');
            root.style.setProperty('--bg-tertiary', '#f3f4f6');
            root.style.setProperty('--text-primary', '#111827');
            root.style.setProperty('--text-secondary', '#374151');
            root.style.setProperty('--text-tertiary', '#6b7280');
            root.style.setProperty('--border-primary', '#e5e7eb');
            root.style.setProperty('--border-secondary', '#d1d5db');
            root.style.setProperty('--accent-primary', '#22c55e');
            root.style.setProperty('--accent-secondary', '#16a34a');
        }
    }

    toggle() {
        const current = this.getCurrentTheme();
        const newTheme = current === this.themes.DARK ? this.themes.LIGHT : this.themes.DARK;
        this.setTheme(newTheme);
    }

    watchSystemTheme() {
        if (window.matchMedia) {
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            mediaQuery.addEventListener('change', () => {
                if (this.getStoredTheme() === this.themes.SYSTEM) {
                    this.applyTheme(this.themes.SYSTEM);
                    this.dispatchThemeChange(this.themes.SYSTEM);
                }
            });
        }
    }

    dispatchThemeChange(theme) {
        // Dispatch custom event for other components to listen to
        const event = new CustomEvent('themeChanged', {
            detail: {
                theme: theme,
                actualTheme: theme === this.themes.SYSTEM ? this.getSystemTheme() : theme
            }
        });
        window.dispatchEvent(event);
    }

    // Utility methods for checking current theme
    isDark() {
        return this.getCurrentTheme() === this.themes.DARK;
    }

    isLight() {
        return this.getCurrentTheme() === this.themes.LIGHT;
    }

    isSystem() {
        return this.getStoredTheme() === this.themes.SYSTEM;
    }
}

// Initialize theme manager when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new ThemeManager();
    });
} else {
    new ThemeManager();
}

// Alpine.js data for theme management
window.themeData = function() {
    return {
        darkMode: false,

        init() {
            // Initialize from theme manager
            this.updateFromThemeManager();

            // Listen for theme changes
            window.addEventListener('themeChanged', () => {
                this.updateFromThemeManager();
            });
        },

        updateFromThemeManager() {
            if (window.themeManager) {
                this.darkMode = window.themeManager.isDark();
            }
        },

        toggleTheme() {
            if (window.themeManager) {
                window.themeManager.toggle();
            }
        }
    }
};

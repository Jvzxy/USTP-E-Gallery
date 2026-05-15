/**
 * admin.js
 * Shared utilities for all admin pages.
 * Handles sidebar toggling and global theme application.
 * Include this on every admin page BEFORE page-specific scripts.
 */

function toggleSidebar() {
    if (window.innerWidth > 768) {
        document.body.classList.toggle('sidebar-collapsed');
        localStorage.setItem(
            'sidebarState',
            document.body.classList.contains('sidebar-collapsed') ? 'collapsed' : 'expanded'
        );
    } else {
        document.getElementById('sidebar').classList.toggle('mobile-open');
    }
}

function applyGlobalTheme(mode) {
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isDark      = mode === 'dark' || (mode === 'system' && prefersDark);
    document.documentElement.setAttribute('data-bs-theme', isDark ? 'dark' : 'light');
}
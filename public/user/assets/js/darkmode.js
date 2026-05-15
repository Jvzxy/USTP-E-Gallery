/**
 * darkmode.js
 * Shared dark/light mode toggle for Community Hub pages.
 * Reads and writes to localStorage('darkMode') and listens
 * for OS-level preference changes in real time.
 */

const darkModeToggle = document.getElementById('darkModeToggle');

function applyDarkMode(isDark) {
    document.body.classList.toggle('dark-mode',  isDark);
    document.body.classList.toggle('light-mode', !isDark);
    darkModeToggle.innerHTML = isDark
        ? '<i class="bi bi-sun-fill"></i>'
        : '<i class="bi bi-moon-fill"></i>';
}

function initDarkMode() {
    const saved = localStorage.getItem('darkMode');
    if (saved !== null) {
        applyDarkMode(saved === 'true');
    } else {
        applyDarkMode(window.matchMedia('(prefers-color-scheme: dark)').matches);
    }
}

darkModeToggle.addEventListener('click', function () {
    const isDark = !document.body.classList.contains('dark-mode');
    applyDarkMode(isDark);
    localStorage.setItem('darkMode', String(isDark));
});

// Live OS theme change — only if user has not manually overridden
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (e) {
    if (localStorage.getItem('darkMode') === null) {
        applyDarkMode(e.matches);
    }
});

initDarkMode();
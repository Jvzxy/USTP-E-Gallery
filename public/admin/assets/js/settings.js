// Settings Modal Functions

let pendingTheme = localStorage.getItem('themeMode') || 'light';
let pendingLogoFile = null;

// --- SETTINGS REOPEN LOGIC ---
document.addEventListener("DOMContentLoaded", function() {
    if (sessionStorage.getItem('reopenSettings')) {
        let tabToOpen = sessionStorage.getItem('reopenSettings');
        sessionStorage.removeItem('reopenSettings');

        let modalEl = document.getElementById('settingsModal');
        if (modalEl) {
            let modal = new bootstrap.Modal(modalEl);
            modal.show();
            setTimeout(() => {
                let tabBtn = document.getElementById('nav-btn-' + tabToOpen);
                if (tabBtn) tabBtn.click();
            }, 300);
        }
    }
});

// --- NEW: ONLY PREVIEWS THE LOGO ON SELECTION ---
function previewSchoolLogo(event) {
    const file = event.target.files[0];
    if (!file) return;

    pendingLogoFile = file; // Holds the file securely until "Apply" is clicked

    const preview = document.getElementById('logoPreview');
    const icon = document.getElementById('logoIconPlaceholder');
    if (icon) icon.style.display = 'none';
    preview.src = URL.createObjectURL(file);
    preview.style.display = 'inline-block';
}

// --- NEW: APPLIES THE THEME AND UPLOADS LOGO SIMULTANEOUSLY ---
function applySelectedTheme() {
    // 1. Instantly save and apply the Theme
    localStorage.setItem('themeMode', pendingTheme);
    if (typeof applyGlobalTheme === 'function') {
        applyGlobalTheme(pendingTheme);
    }

    // 2. Check if an image is waiting to be uploaded
    if (pendingLogoFile) {
        let formData = new FormData();
        formData.append('logo', pendingLogoFile);

        Swal.fire({
            title: 'Applying Changes...',
            text: 'Uploading logo and updating theme.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch('../../app/controllers/uploadLogoController.php', {
                method: 'POST',
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Changes Applied!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        sessionStorage.setItem('reopenSettings', 'theme');
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            }).catch(err => {
                Swal.fire('Error', 'Failed to upload logo.', 'error');
            });
    } else {
        // No image was selected, just show Theme applied message
        Swal.fire({
            icon: 'success',
            title: 'Theme Applied!',
            showConfirmButton: false,
            timer: 1500
        });
    }
}

// --- DATABASE SETTINGS AJAX LOGIC ---
function saveGeneralSettings() {
    const sysName = document.getElementById('systemNameInput').value.trim();
    const maintenance = document.getElementById('maintenanceSwitch').checked ? '1' : '0';

    let formData = new FormData();
    formData.append('system_name', sysName);
    formData.append('maintenance_mode', maintenance);

    fetch('../../app/controllers/updateSettingsController.php', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                        icon: 'success',
                        title: 'Settings Saved!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    .then(() => {
                        sessionStorage.setItem('reopenSettings', 'general');
                        location.reload();
                    });
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(err => {
            Swal.fire('Error', 'Failed to save settings. Check connection.', 'error');
        });
}

function selectThemeMode(element, mode) {
    pendingTheme = mode;
    const allItems = document.querySelectorAll('.theme-list-group .list-group-item');
    const allChecks = document.querySelectorAll('.theme-list-group .theme-check');

    allItems.forEach(item => item.classList.remove('active-theme'));
    allChecks.forEach(check => check.classList.add('d-none'));

    element.classList.add('active-theme');
    element.querySelector('.theme-check').classList.remove('d-none');
}

function exportStudentData() {
    const selectedYear = document.getElementById('exportClassYear').value;

    Swal.fire({
        icon: 'success',
        title: 'Export Started',
        text: 'Your CSV file is downloading...',
        showConfirmButton: false,
        timer: 1500
    });

    window.location.href = `../../app/controllers/exportCsvController.php?year=${selectedYear}`;
}

function downloadDatabaseBackup() {
    Swal.fire({
        icon: 'info',
        title: 'Generating Backup',
        text: 'Bundling your database into an SQL file...',
        showConfirmButton: false,
        timer: 2000
    });

    window.location.href = '../../app/controllers/backupDatabaseController.php';
}

// --- CUSTOM STACKED MODAL CONTROLLERS ---
function openStackedModal(modalId) {
    let modalEl = document.getElementById(modalId);
    if (modalEl) {
        let modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    }
}

function closeStackedModal(modalId) {
    let modalEl = document.getElementById(modalId);
    if (modalEl) {
        let modalObj = bootstrap.Modal.getInstance(modalEl);
        if (modalObj) {
            modalObj.hide();
        }
    }
}

// --- DATA MANAGEMENT AJAX LOGIC ---
function submitDepartment() {
    const name = document.getElementById('ui-dept-name').value.trim();
    const abbr = document.getElementById('ui-dept-abbr').value.trim();

    if (!name || !abbr) {
        Swal.fire('Error', 'Both fields are required', 'error');
        return;
    }

    let formData = new FormData();
    formData.append('type', 'department');
    formData.append('name', name);
    formData.append('abbreviation', abbr);

    fetch('../../app/controllers/addDataController.php', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(response => {
            if (response.status === 'success') {
                closeStackedModal('addDeptModal');
                Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    .then(() => {
                        sessionStorage.setItem('reopenSettings', 'data');
                        location.reload();
                    });
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        });
}

function submitProgram() {
    const dept_id = document.getElementById('ui-prog-dept').value;
    const name = document.getElementById('ui-prog-name').value.trim();
    const abbr = document.getElementById('ui-prog-abbr').value.trim();

    if (!dept_id || !name || !abbr) {
        Swal.fire('Error', 'All fields are required', 'error');
        return;
    }

    let formData = new FormData();
    formData.append('type', 'program');
    formData.append('department_id', dept_id);
    formData.append('name', name);
    formData.append('abbreviation', abbr);

    fetch('../../app/controllers/addDataController.php', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(response => {
            if (response.status === 'success') {
                closeStackedModal('addProgModal');
                Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    .then(() => {
                        sessionStorage.setItem('reopenSettings', 'data');
                        location.reload();
                    });
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        });
}

function submitClassYear() {
    const year = document.getElementById('ui-year-name').value.trim();

    if (!year) {
        Swal.fire('Error', 'Year is required', 'error');
        return;
    }

    let formData = new FormData();
    formData.append('type', 'class_year');
    formData.append('year', year);

    fetch('../../app/controllers/addDataController.php', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(response => {
            if (response.status === 'success') {
                closeStackedModal('addClassYearModal');
                Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    .then(() => {
                        sessionStorage.setItem('reopenSettings', 'data');
                        location.reload();
                    });
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        });
}

function deleteItem(type, id, itemName) {
    Swal.fire({
        title: `Delete ${itemName}?`,
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            let formData = new FormData();
            formData.append('type', type);
            formData.append('id', id);
            formData.append('name', itemName);

            fetch('../../app/controllers/deleteDataController.php', {
                    method: 'POST',
                    body: formData
                })
                .then(r => r.json())
                .then(response => {
                    if (response.status === 'success') {
                        sessionStorage.setItem('reopenSettings', 'data');
                        location.reload();
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                });
        }
    });
}

// --- SAVE PROFILE SETTINGS AJAX ---
function saveProfileSettings() {
    const username = document.getElementById('profileUsername').value.trim();
    const email = document.getElementById('profileEmail').value.trim();
    const password = document.getElementById('profilePassword').value;
    const confirmPassword = document.getElementById('profileConfirmPassword').value;
    const twoFactor = document.getElementById('twoFactorSwitch').checked ? '1' : '0';

    if (password !== confirmPassword) {
        Swal.fire('Error', 'Passwords do not match!', 'error');
        return;
    }

    if (twoFactor === '1' && !email) {
        Swal.fire('Warning', 'You must provide a recovery email to enable 2FA.', 'warning');
        return;
    }

    let formData = new FormData();
    formData.append('username', username);
    formData.append('recovery_email', email);
    formData.append('password', password);
    formData.append('two_factor_enabled', twoFactor);

    fetch('../../app/controllers/updateProfileController.php', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Profile Updated!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    sessionStorage.setItem('reopenSettings', 'profile');
                    location.reload();
                });
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(err => Swal.fire('Error', 'Failed to update profile.', 'error'));
}

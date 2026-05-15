<?php
// --- FETCH DYNAMIC DATA FROM DB FOR SETTINGS & UPLOADS ---
$allDepartments = [];
$allPrograms    = [];
$allYears       = [];
$sysSettings = [
    'system_name' => 'USTP E-Gallery',
    'maintenance_mode' => '0',
    'school_logo' => '' 
];

if (isset($conn)) {
    // Fetch Departments
    $deptRes = $conn->query("SELECT * FROM departments ORDER BY name ASC");
    if ($deptRes && $deptRes->num_rows > 0) {
        while ($row = $deptRes->fetch_assoc()) {
            $allDepartments[] = $row;
        }
    }

    // Fetch Programs 
    $progRes = $conn->query("SELECT p.*, COALESCE(d.abbreviation, 'UNKNOWN') as dept_abbr FROM programs p LEFT JOIN departments d ON p.department_id = d.id ORDER BY p.name ASC");
    if ($progRes && $progRes->num_rows > 0) {
        while ($row = $progRes->fetch_assoc()) {
            $allPrograms[] = $row;
        }
    }

    // Fetch Class Years (Kept for Data Management and Export tabs)
    $yearRes = $conn->query("SELECT * FROM class_years ORDER BY year DESC");
    if ($yearRes && $yearRes->num_rows > 0) {
        while ($row = $yearRes->fetch_assoc()) {
            $allYears[] = $row;
        }
    }

    // Fetch Global Settings
    $setRes = $conn->query("SELECT setting_key, setting_value FROM system_settings");
    if ($setRes && $setRes->num_rows > 0) {
        while ($row = $setRes->fetch_assoc()) {
            $sysSettings[$row['setting_key']] = $row['setting_value'];
        }
    }

    // --- REAL SERVER STORAGE (works on localhost AND live servers) ---
    $diskTotal   = disk_total_space('.');          // bytes — '.' = current drive
    $diskFree    = disk_free_space('.');
    $diskUsed    = $diskTotal - $diskFree;
    $diskPct     = ($diskTotal > 0) ? round(($diskUsed / $diskTotal) * 100, 1) : 0;

    // Human-readable helper
    function formatBytes($bytes, $decimals = 1) {
        if ($bytes <= 0) return '0 B';
        $units = ['B','KB','MB','GB','TB'];
        $i = (int) floor(log($bytes, 1024));
        return round($bytes / pow(1024, $i), $decimals) . ' ' . $units[$i];
    }

    $diskUsedStr  = formatBytes($diskUsed);
    $diskTotalStr = formatBytes($diskTotal);

    // --- REAL DATABASE SIZE from information_schema ---
    $dbName   = $conn->query("SELECT DATABASE()")->fetch_row()[0];
    $dbSizeRes = $conn->query(
        "SELECT SUM(data_length + index_length) AS size
         FROM information_schema.TABLES
         WHERE table_schema = '" . $conn->real_escape_string($dbName) . "'"
    );
    $dbSizeBytes = ($dbSizeRes && $row = $dbSizeRes->fetch_assoc()) ? (int)$row['size'] : 0;
    $dbSizeStr   = formatBytes($dbSizeBytes);

    // --- UPLOADS FOLDER SIZE (scans the public uploads directory) ---
    $uploadsPath = realpath(__DIR__ . '/../../public/uploads');   // adjust if your path differs
    $uploadsSizeBytes = 0;
    if ($uploadsPath && is_dir($uploadsPath)) {
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($uploadsPath, FilesystemIterator::SKIP_DOTS)) as $f) {
            $uploadsSizeBytes += $f->getSize();
        }
    }
    $uploadsSizeStr = formatBytes($uploadsSizeBytes);

    // --- FETCH LOGGED IN ADMIN PROFILE ---
    $adminProfile = [
        'username' => '',
        'recovery_email' => '',
        'two_factor_enabled' => 0
    ];
    if (isset($_SESSION['user_id'])) {
        $profileStmt = $conn->prepare("SELECT username, recovery_email, two_factor_enabled FROM user WHERE id = ?");
        $profileStmt->bind_param("i", $_SESSION['user_id']);
        $profileStmt->execute();
        $profileResult = $profileStmt->get_result();
        if ($profileResult && $profileResult->num_rows > 0) {
            $adminProfile = $profileResult->fetch_assoc();
        }
        $profileStmt->close();
    }
}
?>



<div class="modal fade" id="settingsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content border-0 shadow">
            <div class="d-flex h-100 w-100">

                <div class="settings-sidebar">
                    <h4 class="fw-bold mb-4 ms-2">Settings</h4>

                    <div class="nav flex-column settings-nav" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-profile" type="button"><i class="bi bi-person-fill"></i> <span class="nav-label">Profile</span></button>
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-theme" type="button"><i class="bi bi-circle-half"></i> <span class="nav-label">Theme</span></button>
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-activity" type="button"><i class="bi bi-clock-history"></i> <span class="nav-label">Activity</span></button>
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-general" type="button"><i class="bi bi-gear-fill"></i> <span class="nav-label">General</span></button>
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-data" type="button" id="nav-btn-data"><i class="bi bi-database-fill"></i> <span class="nav-label">Data</span></button>
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-storage" type="button"><i class="bi bi-hdd-fill"></i> <span class="nav-label">Storage</span></button>
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-export" type="button"><i class="bi bi-file-earmark-spreadsheet-fill"></i> <span class="nav-label">Export</span></button>
                    </div>
                </div>

                <div class="settings-main flex-grow-1">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal"></button>

                    <div class="tab-content mt-5 pt-2" id="v-pills-tabContent">

                        <div class="tab-pane fade show active" id="tab-profile">
                            <h4 class="fw-bold mb-4">Profile Security</h4>
                            <div class="row g-4 max-w-75">
                                <div class="col-md-6">
                                    <label class="form-label">Admin Username</label>
                                    <input type="text" class="form-control" id="profileUsername" value="<?php echo htmlspecialchars($adminProfile['username']); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Recovery Email</label>
                                    <input type="email" class="form-control" id="profileEmail" placeholder="admin@ustp.edu.ph" value="<?php echo htmlspecialchars($adminProfile['recovery_email'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="profilePassword" placeholder="Leave blank to keep current">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="profileConfirmPassword" placeholder="••••••••">
                                </div>
                                <div class="col-12 mt-4">
                                    <div class="form-check form-switch settings-switch d-flex align-items-center gap-3">
                                        <input class="form-check-input m-0" type="checkbox" id="twoFactorSwitch" <?php echo ($adminProfile['two_factor_enabled'] == 1) ? 'checked' : ''; ?>>
                                        <label class="form-check-label m-0" for="twoFactorSwitch">Enable Two-Factor Authentication (2FA)</label>
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <button class="btn btn-navy fw-bold" onclick="saveProfileSettings()">Save Profile</button>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-theme">
                            <h4 class="fw-bold mb-4">Appearance & Branding</h4>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label mb-3">System Mode</label>
                                    <div class="list-group theme-list-group shadow-sm border rounded-3 p-1">
                                        <div class="list-group-item d-flex justify-content-between align-items-center" onclick="selectThemeMode(this, 'system')">
                                            System Default <i class="bi bi-check-circle-fill text-navy theme-check d-none"></i>
                                        </div>
                                        <div class="list-group-item active-theme d-flex justify-content-between align-items-center" onclick="selectThemeMode(this, 'light')">
                                            Light Mode <i class="bi bi-check-circle-fill text-navy theme-check"></i>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center" onclick="selectThemeMode(this, 'dark')">
                                            Dark Mode <i class="bi bi-check-circle-fill text-navy theme-check d-none"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label mb-3">School Logo</label>
                                    <div class="border rounded-3 p-3 text-center bg-body-secondary" style="border-style: dashed !important;">
                                        <?php
                                        $currentLogo = $sysSettings['school_logo'] ?? '';
                                        if (!empty($currentLogo)):
                                        ?>
                                            <img id="logoPreview" src="../<?php echo htmlspecialchars($currentLogo); ?>" style="max-width: 100%; height: 80px; object-fit: contain; margin-bottom: 10px;">
                                            <i class="bi bi-image fs-1 text-muted" id="logoIconPlaceholder" style="display: none;"></i>
                                        <?php else: ?>
                                            <img id="logoPreview" src="" style="display: none; max-width: 100%; height: 80px; object-fit: contain; margin-bottom: 10px;">
                                            <i class="bi bi-image fs-1 text-muted" id="logoIconPlaceholder"></i>
                                        <?php endif; ?>
                                        <p class="text-muted small mt-2 mb-2">Upload a new logo to replace the E-Gallery text.</p>
                                        <button class="btn btn-outline-secondary btn-sm fw-bold px-4" onclick="document.getElementById('logoUpload').click()">Browse Files</button>
                                        <input type="file" id="logoUpload" hidden accept="image/png, image/jpeg, image/webp" onchange="previewSchoolLogo(event)">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="theme-apply-container d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="fw-bold m-0">Ready to update?</h6>
                                            <small class="text-muted">Changes will apply across the entire dashboard.</small>
                                        </div>
                                        <button class="btn btn-navy fw-bold" onclick="applySelectedTheme()">Apply Theme</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-activity">
                            <div class="d-flex justify-content-between align-items-center mb-4 pe-2">
                                <h4 class="fw-bold m-0">Activity Logs</h4>
                                <button class="btn btn-outline-danger btn-sm fw-bold">Clear Logs</button>
                            </div>
                            <div class="table-responsive border rounded-3" style="max-height: 400px; overflow-y: auto;">
                                <table class="table table-hover align-middle m-0">
                                    <thead class="table-group-divider sticky-top" style="background-color: var(--bs-body-bg);">
                                        <tr>
                                            <th>Admin</th>
                                            <th>Action</th>
                                            <th>Timestamp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($conn)) {
                                            $logQuery = "SELECT u.username, a.action, a.created_at 
                                                         FROM activity_logs a 
                                                         JOIN user u ON a.admin_id = u.id 
                                                         ORDER BY a.created_at DESC LIMIT 15";
                                            $logResult = $conn->query($logQuery);

                                            if ($logResult && $logResult->num_rows > 0) {
                                                while ($log = $logResult->fetch_assoc()) {
                                                    $time = date("M j, Y, g:i A", strtotime($log['created_at']));
                                                    $actionClass = strpos(strtolower($log['action']), 'delete') !== false || strpos(strtolower($log['action']), 'deleted') !== false ? 'text-danger' : 'text-body';

                                                    echo "<tr>";
                                                    echo "<td class='fw-bold'>" . htmlspecialchars($log['username']) . "</td>";
                                                    echo "<td class='$actionClass'>" . htmlspecialchars($log['action']) . "</td>";
                                                    echo "<td class='text-muted small'>" . $time . "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='3' class='text-center text-muted small py-4'>No recent activity found.</td></tr>";
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-general">
                            <h4 class="fw-bold mb-4">General Settings</h4>
                            <div class="row g-4">
                                <div class="col-12">
                                    <label class="form-label">System Name</label>
                                    <input type="text" class="form-control" id="systemNameInput" value="<?php echo htmlspecialchars($sysSettings['system_name']); ?>">
                                </div>

                                <div class="col-12 mt-5 p-4 border rounded-3 bg-body-secondary">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="fw-bold m-0 text-danger">Maintenance Mode</h6>
                                            <small class="text-muted">Takes the user-facing site offline for updates.</small>
                                        </div>
                                        <div class="form-check form-switch settings-switch m-0">
                                            <input class="form-check-input" type="checkbox" id="maintenanceSwitch" <?php echo ($sysSettings['maintenance_mode'] == '1') ? 'checked' : ''; ?>>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <button class="btn btn-navy fw-bold" onclick="saveGeneralSettings()">Save Changes</button>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-data">
                            <h4 class="fw-bold mb-4">Data Management</h4>
                            <p class="text-muted mb-4">Manage the standard lists used in the upload forms.</p>

                            <div class="row g-4 align-items-start">
                                <div class="col-md-6 d-flex flex-column gap-4">

                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <h6 class="fw-bold mb-3 d-flex justify-content-between">Departments <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2" onclick="openStackedModal('addDeptModal')">+</button></h6>
                                            <ul class="list-group list-group-flush border-top" style="max-height: 250px; overflow-y: auto;">
                                                <?php if (!empty($allDepartments)): ?>
                                                    <?php foreach ($allDepartments as $dept): ?>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 small">
                                                            <?php echo htmlspecialchars($dept['abbreviation'] . ' - ' . $dept['name']); ?>
                                                            <i class="bi bi-x-circle text-danger cursor-pointer" style="cursor: pointer;" onclick="deleteItem('department', <?php echo $dept['id']; ?>, '<?php echo addslashes($dept['name']); ?>')"></i>
                                                        </li>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <li class="list-group-item px-0 py-2 small text-muted">No departments found.</li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <h6 class="fw-bold mb-3 d-flex justify-content-between">Class Years <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2" onclick="openStackedModal('addClassYearModal')">+</button></h6>
                                            <ul class="list-group list-group-flush border-top" style="max-height: 250px; overflow-y: auto;">
                                                <?php if (!empty($allYears)): ?>
                                                    <?php foreach ($allYears as $y): ?>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 small">
                                                            <?php echo htmlspecialchars($y['year']); ?>
                                                            <i class="bi bi-x-circle text-danger cursor-pointer" style="cursor: pointer;" onclick="deleteItem('class_year', <?php echo $y['id']; ?>, '<?php echo addslashes($y['year']); ?>')"></i>
                                                        </li>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <li class="list-group-item px-0 py-2 small text-muted">No class years found.</li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <h6 class="fw-bold mb-3 d-flex justify-content-between">Programs <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2" onclick="openStackedModal('addProgModal')">+</button></h6>
                                            <ul class="list-group list-group-flush border-top" style="max-height: 250px; overflow-y: auto;">
                                                <?php if (!empty($allPrograms)): ?>
                                                    <?php foreach ($allPrograms as $prog): ?>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 small">
                                                            <div>
                                                                <?php echo htmlspecialchars($prog['name']); ?><br>
                                                                <small class="text-muted" style="font-size: 0.7rem;"><?php echo htmlspecialchars($prog['dept_abbr']); ?></small>
                                                            </div>
                                                            <i class="bi bi-x-circle text-danger cursor-pointer" style="cursor: pointer;" onclick="deleteItem('program', <?php echo $prog['id']; ?>, '<?php echo addslashes($prog['name']); ?>')"></i>
                                                        </li>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <li class="list-group-item px-0 py-2 small text-muted">No programs found.</li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-storage">
                            <h4 class="fw-bold mb-4">Storage & Backups</h4>

                            <?php
                            // Colour the bar: green < 60%, yellow < 85%, red >= 85%
                            $barColor = '#1A1851';
                            if ($diskPct >= 85) $barColor = '#dc3545';
                            elseif ($diskPct >= 60) $barColor = '#fd7e14';
                            ?>

                            <!-- Disk Storage -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-bold fs-6">Disk Storage</span>
                                    <span class="fw-bold text-muted fs-6">
                                        <?php echo $diskUsedStr; ?> used / <?php echo $diskTotalStr; ?> total
                                    </span>
                                </div>
                                <div class="progress mb-1" style="height: 12px; border-radius: 10px;">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: <?php echo $diskPct; ?>%; background-color: <?php echo $barColor; ?>;"
                                         aria-valuenow="<?php echo $diskPct; ?>" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <small class="text-muted"><?php echo $diskPct; ?>% used</small>
                            </div>

                            <!-- Quick stats row -->
                            <div class="row g-3 mb-5">
                                <div class="col-6 col-md-4">
                                    <div class="border rounded-3 p-3 bg-body-secondary text-center">
                                        <i class="bi bi-database fs-4 text-primary d-block mb-1"></i>
                                        <div class="fw-bold small"><?php echo $dbSizeStr; ?></div>
                                        <div class="text-muted" style="font-size:0.75rem;">Database Size</div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="border rounded-3 p-3 bg-body-secondary text-center">
                                        <i class="bi bi-images fs-4 text-success d-block mb-1"></i>
                                        <div class="fw-bold small"><?php echo $uploadsSizeStr; ?></div>
                                        <div class="text-muted" style="font-size:0.75rem;">Uploads Folder</div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="border rounded-3 p-3 bg-body-secondary text-center">
                                        <i class="bi bi-hdd fs-4 text-warning d-block mb-1"></i>
                                        <div class="fw-bold small"><?php echo formatBytes($diskFree); ?></div>
                                        <div class="text-muted" style="font-size:0.75rem;">Free Space Left</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-4 text-center h-100 bg-body-tertiary">
                                        <i class="bi bi-database-down fs-1 text-primary mb-2 d-block"></i>
                                        <h6 class="fw-bold">Database Backup</h6>
                                        <p class="text-muted small mb-3">Create a safe copy of the MySQL database.</p>
                                        <button class="btn btn-outline-primary fw-bold px-4" onclick="downloadDatabaseBackup()">Generate SQL</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-export">
                            <h4 class="fw-bold mb-4">Export Data</h4>
                            <p class="text-muted mb-4">Download your system data for offline use or reporting.</p>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-4 text-center h-100 bg-body-tertiary d-flex flex-column align-items-center justify-content-center">
                                        <i class="bi bi-file-earmark-spreadsheet fs-1 text-success mb-2 d-block"></i>
                                        <h6 class="fw-bold">Export Students CSV</h6>
                                        <p class="text-muted small mb-3">Select a specific class year or download all records.</p>

                                        <div class="w-100 mb-4 text-start" style="max-width: 250px;">
                                            <label class="form-label small fw-bold">Select Class Year</label>
                                            <select class="form-select form-select-sm shadow-sm" id="exportClassYear">
                                                <option value="all" selected>All Years</option>
                                                <?php if (!empty($allYears)): ?>
                                                    <?php foreach ($allYears as $y): ?>
                                                        <option value="<?php echo htmlspecialchars($y['year']); ?>"><?php echo htmlspecialchars($y['year']); ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>

                                        <button class="btn btn-outline-success fw-bold px-4" onclick="exportStudentData()">Download CSV</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade custom-input-modal" id="addDeptModal" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content p-4 p-md-5">
            <h4 class="m-0 mb-4 fw-bold">Departments</h4>
            <div class="mb-3">
                <label class="form-label">Department <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="ui-dept-name" placeholder="Full Department Name (e.g. Engineer)">
            </div>
            <div class="mb-4">
                <label class="form-label">Abbreviation <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="ui-dept-abbr" placeholder="Abbreviation (e.g. CEA)">
            </div>
            <div class="d-flex gap-3 mt-2">
                <button type="button" class="btn btn-navy flex-grow-1 py-2 fw-bold" onclick="submitDepartment()">Add Department</button>
                <button type="button" class="btn btn-outline-navy flex-grow-1 fw-bold py-2" onclick="closeStackedModal('addDeptModal')">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade custom-input-modal" id="addProgModal" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content p-4 p-md-5">
            <h4 class="m-0 mb-4 fw-bold">Programs</h4>
            <div class="mb-3">
                <label class="form-label">Department <span class="text-danger">*</span></label>
                <select class="form-select" id="ui-prog-dept">
                    <option value="" disabled selected>Select Department</option>
                    <?php
                    if (!empty($allDepartments)) {
                        foreach ($allDepartments as $dept) {
                            echo '<option value="' . $dept['id'] . '">' . htmlspecialchars($dept['abbreviation'] . ' - ' . $dept['name']) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Program <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="ui-prog-name" placeholder="Full Program Name (e.g. Information Technology)">
            </div>
            <div class="mb-4">
                <label class="form-label">Abbreviation <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="ui-prog-abbr" placeholder="Abbreviation (e.g. IT)">
            </div>
            <div class="d-flex gap-3 mt-2">
                <button type="button" class="btn btn-navy flex-grow-1 py-2 fw-bold" onclick="submitProgram()">Add Program</button>
                <button type="button" class="btn btn-outline-navy flex-grow-1 fw-bold py-2" onclick="closeStackedModal('addProgModal')">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade custom-input-modal" id="addClassYearModal" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content p-4 p-md-5">
            <h4 class="m-0 mb-4 fw-bold">Class Year</h4>
            <div class="mb-4">
                <label class="form-label">Year <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="ui-year-name" placeholder="e.g. 2032" min="2000" max="2100">
            </div>
            <div class="d-flex gap-3 mt-2">
                <button type="button" class="btn btn-navy flex-grow-1 py-2 fw-bold" onclick="submitClassYear()">Add Year</button>
                <button type="button" class="btn btn-outline-navy flex-grow-1 fw-bold py-2" onclick="closeStackedModal('addClassYearModal')">Cancel</button>
            </div>
        </div>
    </div>
</div>
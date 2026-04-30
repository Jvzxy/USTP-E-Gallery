<?php
include_once("../../app/middleware/admin.php");
include_once("../../app/config/config.php");

// Fetch ALL Sections so JavaScript can use them
$allSections = [];
if (isset($conn)) {
    $secRes = $conn->query("SELECT * FROM sections ORDER BY name ASC");
    if ($secRes && $secRes->num_rows > 0) {
        while($row = $secRes->fetch_assoc()) {
            $allSections[] = $row;
        }
    }
}

$allYears = [];
$yearRes = $conn->query("SELECT * FROM class_years ORDER BY year DESC");
if ($yearRes && $yearRes->num_rows > 0) {
    while($row = $yearRes->fetch_assoc()) {
        $allYears[] = $row;
    }
}

// Fetch the default year from settings
$defaultYear = '2029'; // Fallback
$setRes = $conn->query("SELECT setting_value FROM system_settings WHERE setting_key = 'default_class_year'");
if ($setRes && $setRes->num_rows > 0) {
    $defaultYear = $setRes->fetch_assoc()['setting_value'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Upload - E-Gallery</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="assets/css/upload.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/upload_photo.css?v=<?php echo time(); ?>">

</head>

<body>
    <script>
        function applyGlobalTheme(mode) {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isDark = mode === 'dark' || (mode === 'system' && prefersDark);
            document.documentElement.setAttribute('data-bs-theme', isDark ? 'dark' : 'light');
        }
        const savedTheme = localStorage.getItem('themeMode') || 'light';
        applyGlobalTheme(savedTheme);

        if (localStorage.getItem('sidebarState') === 'collapsed') {
            document.body.classList.add('sidebar-collapsed');
        }
    </script>

    <div class="d-flex">
        <?php include('includes/sidebar.php'); ?>

        <main class="content-area p-5" id="content-area">
            
            <div class="d-flex align-items-center mb-4 d-md-none">
                <button class="mobile-toggle-btn shadow-sm me-3" onclick="toggleSidebar()">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <h3 class="fw-bold m-0 text-dark">Upload Management</h3>
            </div>

            <?php include('includes/upload_photo.php'); ?>

        </main>
    </div> 

    <?php include('includes/upload_user.php'); ?>
    <?php include('includes/upload_section.php'); ?>
    <?php include('includes/settings_modal.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function toggleSidebar() {
            if (window.innerWidth > 768) {
                document.body.classList.toggle('sidebar-collapsed');
                localStorage.setItem('sidebarState', document.body.classList.contains('sidebar-collapsed') ? 'collapsed' : 'expanded');
            } else {
                document.getElementById('sidebar').classList.toggle('mobile-open');
            }
        }

        // ========================================================
        // --- DYNAMIC JAVASCRIPT DIRECT FROM DATABASE ---
        // ========================================================
        const dbDepartments = <?php echo json_encode($allDepartments ?? []); ?>;
        const dbPrograms = <?php echo json_encode($allPrograms ?? []); ?>;
        const dbSections = <?php echo json_encode($allSections ?? []); ?>; // NEW: Fetch Sections from DB

        const programsData = {};
        const programAbbreviations = {};

        dbPrograms.forEach(p => {
            if (!programsData[p.department_id]) {
                programsData[p.department_id] = [];
            }
            programsData[p.department_id].push({id: p.id, name: p.name});
            programAbbreviations[p.id] = p.abbreviation;
        });

        document.addEventListener('DOMContentLoaded', () => {
            const deptSelects = [
                document.getElementById('photoDeptSelect'), 
                document.getElementById('modalDeptSelect')
            ];
            
            deptSelects.forEach(select => {
                if (select) {
                    select.innerHTML = '<option value="" selected>Select Department</option>';
                    dbDepartments.forEach(d => {
                        let opt = document.createElement('option');
                        opt.value = d.id; 
                        opt.textContent = d.name;
                        select.appendChild(opt);
                    });
                }
            });
        });

        function updatePrograms(deptSelectId, programSelectId) {
            const deptSelect = document.getElementById(deptSelectId);
            const programSelect = document.getElementById(programSelectId);
            const selectedDeptId = deptSelect.value;
            
            programSelect.innerHTML = '<option value="" selected>Select Program</option>';
            
            if (selectedDeptId && programsData[selectedDeptId]) {
                programsData[selectedDeptId].forEach(prog => {
                    let option = document.createElement("option");
                    option.text = prog.name; 
                    option.value = prog.id; // Passing ID instead of text
                    programSelect.add(option);
                });
            }
        }

        function updatePhotoSections() {
            const programSelect = document.getElementById("photoProgramSelect");
            const sectionSelect = document.getElementById("photoSectionSelect");
            const selectedProgramId = programSelect.value;
            
            sectionSelect.innerHTML = '<option value="" selected>Select Section</option>';
            
            if (selectedProgramId) {
                // Filter sections based on selected program ID
                const filteredSections = dbSections.filter(s => s.program_id == selectedProgramId);
                
                if (filteredSections.length > 0) {
                    filteredSections.forEach(sec => {
                        let option = document.createElement("option");
                        option.text = sec.name; 
                        option.value = sec.id; // Pass ID instead of text
                        sectionSelect.add(option);
                    });
                } else {
                    sectionSelect.innerHTML = '<option value="" selected>No sections added yet</option>';
                }
            } else {
                sectionSelect.innerHTML = '<option value="" selected>Select Program first</option>';
            }
        }

        // ========================================================
        // --- ADD SECTION TO DB LOGIC ---
        // ========================================================
        function addNewSection() {
            const dept = document.getElementById("modalDeptSelect").value;
            const progId = document.getElementById("modalProgramSelect").value;
            const secInput = document.getElementById("modalSectionInput").value.trim();

            if(!dept || !progId || !secInput) {
                Swal.fire({ icon: 'warning', title: 'Missing Info', text: 'Please select a Department, Program, and type a Section name.' });
                return;
            }

            let abbr = programAbbreviations[progId] ? programAbbreviations[progId] : "SEC";
            let finalSectionName = abbr + " - " + secInput;

            let formData = new FormData();
            formData.append('program_id', progId);
            formData.append('name', finalSectionName);

            fetch('../../app/controllers/addSectionController.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    Swal.fire({ icon: 'success', title: 'Section Added!', text: finalSectionName + ' is now available.', showConfirmButton: false, timer: 1500 })
                    .then(() => {
                        location.reload(); // Reload to refresh arrays
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire('Error', 'Network Error', 'error');
            });
        }
    </script>
</body>
</html>
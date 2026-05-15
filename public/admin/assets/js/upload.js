// ========================================================
// --- DYNAMIC JAVASCRIPT DIRECT FROM DATABASE ---
// ========================================================
const dbDepartments = window.dbDepartments || [];
const dbPrograms = window.dbPrograms || [];
const dbSections = window.dbSections || [];

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
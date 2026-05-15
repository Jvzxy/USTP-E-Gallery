// Upload Photo Functions
function previewSelectedPhoto(event) {
    const file = event.target.files[0];
    if (file) {
        document.getElementById('uploadPlaceholder').style.display = 'none';
        const previewImg = document.getElementById('photoPreview');
        previewImg.src = URL.createObjectURL(file);
        previewImg.style.display = 'block';
    }
}

function simulateUpload() {
    const name = document.getElementById('inputName').value.trim();
    const deptId = document.getElementById('photoDeptSelect').value;
    const progId = document.getElementById('photoProgramSelect').value;
    const sectionId = document.getElementById('photoSectionSelect').value;
    const latin = document.getElementById('inputLatin').value;
    const year = document.getElementById('inputYear').value.trim();
    const quote = document.getElementById('inputQuote').value.trim();
    const photoInput = document.getElementById('studentPhotoInput');

    // CHECK 1: Ensure all text fields and dropdowns have valid selections
    if (!name || !deptId || !progId || !sectionId || !quote || !year) {
        Swal.fire({
            icon: 'warning',
            title: 'Missing Info',
            text: 'Please fill in all fields. Make sure a Department, Program, and Section are actively selected!'
        });
        return;
    }

    // CHECK 2: Ensure a photo is actually uploaded
    if (photoInput.files.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Missing Photo',
            text: 'Please select a photo to upload.'
        });
        return;
    }

    let formData = new FormData();
    formData.append('photo', photoInput.files[0]);
    formData.append('name', name);
    formData.append('department_id', deptId);
    formData.append('program_id', progId);
    formData.append('section', sectionId);
    formData.append('latin_honor', latin);
    formData.append('class_year', year);
    formData.append('quote', quote);

    Swal.fire({
        title: 'Uploading...',
        text: 'Saving student profile to database.',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Send to PHP engine
    fetch('../../app/controllers/uploadPhotoController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                        icon: 'success',
                        title: 'Uploaded Successfully',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    .then(() => {
                        location.reload();
                    });
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => {
            console.error("Error:", error);
            Swal.fire('Error', 'Critical network error occurred.', 'error');
        });
}

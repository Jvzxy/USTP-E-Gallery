// --- 3 DOTS ACTIONS LOGIC ---

function openEditStudentModal(id, name, latinHonor) {
    // Populate the modal fields
    document.getElementById('editStudentId').value = id;
    document.getElementById('editStudentName').value = name;
    
    // Set the dropdown value (default to 'None' if blank)
    let latinSelect = document.getElementById('editStudentLatin');
    latinSelect.value = (latinHonor && latinHonor !== '') ? latinHonor : 'None';
    
    // Show the modal
    let editModal = new bootstrap.Modal(document.getElementById('editStudentModal'));
    editModal.show();
}

function saveStudentEdit() {
    const id = document.getElementById('editStudentId').value;
    const name = document.getElementById('editStudentName').value.trim();
    const latin = document.getElementById('editStudentLatin').value;

    if (!name) {
        Swal.fire('Error', 'Full Name cannot be empty.', 'error');
        return;
    }

    // Pack the data to send to PHP
    let formData = new FormData();
    formData.append('id', id);
    formData.append('full_name', name);
    formData.append('latin_honor', latin);

    // Send to our new backend controller
    fetch('../../app/controllers/editStudentController.php', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Saved!',
                    text: data.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => location.reload()); // Refresh to show new data
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        }).catch(err => {
            Swal.fire('Error', 'Failed to connect to server.', 'error');
        });
}

function deleteStudentPhoto(id, name) {
    Swal.fire({
        title: `Delete ${name}?`,
        text: "This will permanently remove the student profile.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            let formData = new FormData();
            formData.append('type', 'student'); // Ensure your deleteDataController.php catches 'student'
            formData.append('id', id);
            formData.append('name', name);

            fetch('../../app/controllers/deleteDataController.php', {
                    method: 'POST',
                    body: formData
                })
                .then(r => r.json())
                .then(response => {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => location.reload());
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                }).catch(err => {
                    Swal.fire('Error', 'Failed to connect to server.', 'error');
                });
        }
    });
}

// --- LIVE CHART.JS LOGIC ---
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('visitsChart').getContext('2d');
    const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
    
    // Initialize Chart
    window.visitsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Visits',
                data: [],
                backgroundColor: isDark ? '#82aaff' : '#1A1851',
                borderRadius: 4,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { display: false },
                    ticks: { color: isDark ? '#a0a0c0' : '#6c757d' }
                },
                x: { 
                    grid: { display: false },
                    ticks: { color: isDark ? '#a0a0c0' : '#6c757d' }
                }
            }
        }
    });

    // Load default (Monthly)
    updateChart('monthly', document.querySelector('.chart-filter-btn.active'));
});

// Function to fetch data and update chart
function updateChart(filterType, element) {
    if (element) {
        document.querySelectorAll('.chart-filter-btn').forEach(btn => btn.classList.remove('active'));
        element.classList.add('active');
        document.getElementById('chartFilterLabel').innerText = filterType.charAt(0).toUpperCase() + filterType.slice(1);
    }

    fetch(`../../app/controllers/getVisitsData.php?filter=${filterType}`)
        .then(response => response.json())
        .then(data => {
            window.visitsChart.data.labels = data.labels;
            window.visitsChart.data.datasets[0].data = data.data;
            window.visitsChart.update();
        })
        .catch(error => console.error("Error fetching chart data:", error));
}

// Function to fetch live student count
function updateYearCount(year) {
    fetch(`../../app/controllers/getStudentYearCount.php?year=${year}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('liveClassYearCount').innerText = parseInt(data.count).toLocaleString();
            }
        })
        .catch(error => console.error("Error fetching year count:", error));
}
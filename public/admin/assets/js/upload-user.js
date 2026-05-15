// Upload User Functions
let pendingUsersArray = [];

function stageUserForUpload() {
    const idInput = document.getElementById('newUserId');
    const roleInput = document.getElementById('newUserRole');
    const passInput = document.getElementById('newUserPass');
    const tbody = document.getElementById('adminUserTableBody');

    const newId = idInput.value.trim();
    const newRole = roleInput.value;
    const newPass = passInput.value.trim();
    
    // Visual text for the badge
    const displayRole = newRole === 'admin' ? 'Admin' : 'Student';
    const badgeColor = newRole === 'admin' ? 'bg-danger' : 'bg-primary';

    if (!newId || !newPass) {
        Swal.fire({
            icon: 'warning',
            title: 'Missing Information',
            text: 'Please enter both an ID Number and Password.'
        });
        return;
    }

    // Prevent adding duplicates to the visual box
    if(pendingUsersArray.some(u => u.username === newId)) {
        Swal.fire({ icon: 'warning', title: 'Already added', text: 'This user is already in your pending list.'});
        return;
    }

    // Add to memory array
    pendingUsersArray.push({ username: newId, password: newPass, role: newRole });

    // Add to the UI box
    const newRow = document.createElement('tr');
    newRow.className = 'fade-in-up'; 
    newRow.id = 'pending-row-' + newId;
    newRow.innerHTML = `
        <td class="text-dark">${newId}</td>
        <td class="text-dark"><span class="badge ${badgeColor}">${displayRole}</span></td>
        <td class="text-dark">••••••••</td>
        <td class="text-end">
            <span class="action-delete ms-2" onclick="removePendingUser('${newId}')">Delete</span>
        </td>
    `;

    tbody.insertBefore(newRow, tbody.firstChild);

    // Clear inputs for the next one
    idInput.value = '';
    passInput.value = '';
}

function removePendingUser(username) {
    // Remove from memory
    pendingUsersArray = pendingUsersArray.filter(u => u.username !== username);
    // Remove from UI
    document.getElementById('pending-row-' + username).remove();
}

async function uploadAllPendingUsers() {
    if (pendingUsersArray.length === 0) {
        Swal.fire({ icon: 'info', text: 'There are no users in the box to upload.' });
        return;
    }

    // Show a loading spinner
    Swal.fire({
        title: 'Uploading Users...',
        text: 'Please wait while we save them to the database.',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });

    let successCount = 0;
    let errorMessages = [];

    // Send them to the backend
    for (let i = 0; i < pendingUsersArray.length; i++) {
        let user = pendingUsersArray[i];
        let formData = new FormData();
        formData.append('username', user.username);
        formData.append('password', user.password);
        formData.append('role', user.role); // Passing the role to PHP

        try {
            let response = await fetch('../../app/controllers/addUserController.php', {
                method: 'POST',
                body: formData
            });
            
            let data = await response.json();
            
            if (data.status === 'success') {
                successCount++;
                document.getElementById('pending-row-' + user.username).remove();
            } else {
                errorMessages.push(`<b>${user.username}:</b> ${data.message}`);
            }
        } catch (error) {
            errorMessages.push(`<b>${user.username}:</b> Network connection error.`);
        }
    }

    // Clean up array
    pendingUsersArray = pendingUsersArray.filter(u => document.getElementById('pending-row-' + u.username) !== null);

    if (errorMessages.length === 0) {
        Swal.fire({
            icon: 'success',
            title: 'All Uploaded!',
            text: `${successCount} user(s) successfully added.`,
            showConfirmButton: false,
            timer: 2000
        });
    } else {
        Swal.fire({
            icon: 'warning',
            title: `Upload Complete (${successCount} successful)`,
            html: `Some users failed to upload:<br><br><div class="text-start" style="font-size: 0.85rem;">${errorMessages.join('<br>')}</div>`
        });
    }
}

<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-body p-4">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold m-0">Add Users</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="row">
                    <div class="col-md-7 mb-4 mb-md-0">
                        <div class="user-table-wrapper">
                            <div class="table-scroll-area">
                                <table class="table table-borderless user-table" id="adminUserTable">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>Role</th>
                                            <th>Password</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="adminUserTableBody">
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-navy fw-bold position-absolute bottom-0 end-0 m-3 px-4" onclick="uploadAllPendingUsers()">Upload</button>
                        </div>
                    </div>
                    
                    <div class="col-md-4 offset-md-1">
                        <div class="mb-3">
                            <label class="form-label">ID Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="newUserId" placeholder="ID Number">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select" id="newUserRole">
                                <option value="user" selected>Student / Normal User</option>
                                <option value="admin">System Admin</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="newUserPass" placeholder="Password">
                        </div>
                        <button type="button" class="btn btn-navy w-100 py-2 fw-bold" onclick="stageUserForUpload()">Submit to Box</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<nav class="navbar navbar-expand-lg navbar-dark dashboard-nav px-4 position-relative">
    <div class="container-fluid d-flex justify-content-center">
        <a class="navbar-brand fw-bold position-absolute start-0 ms-4" href="#">E-Gallery</a>

        <div class="navbar-nav bg-navy-pill p-1">
            <a class="nav-link active px-4" href="#" onclick="showSection('home', this)">Home</a>
            <a class="nav-link px-4" href="#" onclick="showSection('latin-honor', this)">Latin Honor</a>
            <a class="nav-link px-4" href="#" onclick="showSection('departments', this)">Department</a>
            <a class="nav-link px-4 text-danger fw-bold" href="#" onclick="confirmUserLogout(event)">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>
</nav>
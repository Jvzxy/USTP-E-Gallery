<div id="photoTab">
    <h5 class="fw-bold mb-4">Upload Student Year Book</h5>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="photo-upload-card text-center shadow-sm">
                <img id="photoPreview" class="preview-img" src="" alt="Student Preview" title="Click to change photo" onclick="document.getElementById('studentPhotoInput').click()">

                <div id="uploadPlaceholder" onclick="document.getElementById('studentPhotoInput').click()">
                    <div class="upload-icon-wrapper mx-auto">
                        <i class="bi bi-cloud-arrow-up-fill"></i>
                    </div>
                    <h6 class="fw-bold mb-2 upload-title">Select Photo to Upload</h6>
                    <p class="text-muted small mb-3" style="font-size: 0.75rem;">Supported Format: PNG, JPG<br>(15mb each)</p>
                </div>

                <input type="file" id="studentPhotoInput" accept="image/png, image/jpeg" style="display: none;" onchange="previewSelectedPhoto(event)">
                
                </div>
        </div>

        <div class="col-lg-7">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="inputName" placeholder="e.g. Durain, Jussy Jay G.">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Department <span class="text-danger">*</span></label>
                    <select class="form-select" id="photoDeptSelect" onchange="updatePrograms('photoDeptSelect', 'photoProgramSelect'); updatePhotoSections();">
                        <option value="" selected>Select Department</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Program <span class="text-danger">*</span></label>
                    <select class="form-select" id="photoProgramSelect" onchange="updatePhotoSections()">
                        <option value="" selected>Select Department first</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Section <span class="text-danger">*</span></label>
                    <select class="form-select" id="photoSectionSelect">
                        <option value="" selected>Select Program first</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Latin Honor <span class="text-danger">*</span></label>
                    <select class="form-select" id="inputLatin">
                        <option value="None" selected>None</option>
                        <option value="Magna Cum Laude">Magna Cum Laude</option>
                        <option value="Summa Cum Laude">Summa Cum Laude</option>
                        <option value="Cum Laude">Cum Laude</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Class Year <span class="text-danger">*</span></label>
                    <select class="form-select" id="inputYear">
                        <?php if (!empty($allYears)): ?>
                            <?php foreach ($allYears as $y): ?>
                                <option value="<?php echo htmlspecialchars($y['year']); ?>" <?php echo ($defaultYear == $y['year']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($y['year']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="<?php echo htmlspecialchars($defaultYear); ?>" selected><?php echo htmlspecialchars($defaultYear); ?></option>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Quote <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="inputQuote" rows="4" placeholder="Enter text here..."></textarea>
                </div>

                <div class="col-12 mt-3">
                    <button type="button" class="btn btn-navy w-100 py-2 fw-bold" onclick="simulateUpload()">Upload</button>
                </div>
            </div>
        </div>
    </div>
</div>
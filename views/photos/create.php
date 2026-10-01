<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="row justify-content-center my-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="card-title fw-bold mb-4">Upload Photo</h3>

                <?php if (!empty($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($_SESSION['error']); ?>
                        <?php unset($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="/Alzikrayat/public/photos/create" method="POST" enctype="multipart/form-data" id="uploadForm" onsubmit="return validateUpload()">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Photo Title *</label>
                        <input type="text" name="title" id="photoTitle" class="form-control" required maxlength="200">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Select Image File *</label>
                        <input type="file" name="photo" id="photoFile" class="form-control" accept="image/*" required>
                        <div class="form-text">Allowed formats: JPG, JPEG, PNG, GIF, WEBP.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Tell the story behind this photo..."></textarea>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="/Alzikrayat/public/" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success px-4">Upload Photo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function validateUpload() {
    const fileInput = document.getElementById('photoFile');
    const title = document.getElementById('photoTitle').value.trim();

    if (title === '') {
        alert('Please enter a photo title.');
        return false;
    }

    if (fileInput.files.length === 0) {
        alert('Please select an image file to upload.');
        return false;
    }

    const fileName = fileInput.files[0].name;
    const ext = fileName.split('.').pop().toLowerCase();
    const allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!allowed.includes(ext)) {
        alert('Invalid file format. Please upload a JPG, JPEG, PNG, GIF, or WEBP image.');
        return false;
    }

    return true;
}
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
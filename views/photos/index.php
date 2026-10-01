
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Photo Gallery</h2>
    <a href="/alzikrayat/public/photos/create" class="btn btn-success">+ Upload Photo</a>
</div>

<div class="row row-cols-1 row-cols-md-3 g-4">
    <?php if (empty($photos)): ?>
        <div class="col-12">
            <div class="alert alert-info">No photos uploaded yet. Be the first to share one!</div>
        </div>
    <?php else: ?>
        <?php foreach ($photos as $photo): ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    <?php 
                        $imageSrc = '/alzikrayat/public' . '/' . ltrim($photo['file_path'] ?? '', '/');
                    ?>
                    <img src="<?= htmlspecialchars($imageSrc); ?>" class="card-img-top photo-card-img" alt="<?= htmlspecialchars($photo['title'] ?? 'Photo'); ?>" style="height: 220px; object-fit: cover;">
                    
                    <div class="card-body">
                        <h5 class="card-title fw-bold"><?= htmlspecialchars($photo['title'] ?? 'Untitled'); ?></h5>
                        
                        <p class="card-text text-muted small mb-2">
                            By <?= htmlspecialchars(trim(($photo['first_name'] ?? '') . ' ' . ($photo['last_name'] ?? '')) ?: ($photo['username'] ?? 'User')); ?>
                        </p>
                        
                        <p class="card-text text-muted small mb-3">
                            <?= !empty($photo['date_time']) ? date('M d, Y - h:i A', strtotime($photo['date_time'])) : (!empty($photo['created_at']) ? date('M d, Y - h:i A', strtotime($photo['created_at'])) : ''); ?>
                        </p>

                        <?php if (!empty($photo['description'])): ?>
                            <p class="card-text text-secondary"><?= htmlspecialchars(mb_strimwidth($photo['description'], 0, 90, '...')); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="card-footer bg-white border-0 d-flex justify-content-between pb-3">
                        <a href="/alzikrayat/public/photos/show/<?= $photo['id']; ?>" class="btn btn-outline-primary btn-sm">View Details</a>
                        
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $photo['user_id']): ?>
                            <a href="/alzikrayat/public/photos/delete/<?= $photo['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this photo?')">Delete</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


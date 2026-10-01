<?php


if (empty($photo)) {
    header("Location: /alzikrayat/public/photos");
    exit;
}

require __DIR__ . '/../layout/header.php'; 
?>

<div class="row g-4">
    <div class="col-lg-8">
        <a href="/alzikrayat/public/photos" class="btn btn-outline-secondary btn-sm mb-3">&larr; Back to Gallery</a>
        
        <div class="card shadow-sm border-0">
            <?php 
                $rawPath = $photo['file_path'] ?? $photo['file_name'] ?? '';
                if (strpos($rawPath, '/alzikrayat/public') === 0) {
                    $imageSrc = $rawPath;
                } else {
                    $imageSrc = '/alzikrayat/public/' . ltrim($rawPath, '/');
                }
            ?>
            <img src="<?= htmlspecialchars($imageSrc) ?>" 
                 class="img-fluid rounded-top" 
                 alt="<?= htmlspecialchars($photo['title'] ?? 'Photo') ?>"
                 style="max-height: 500px; width: 100%; object-fit: contain; background-color: #212529;">
            
            <div class="card-body p-4">
                <h2 class="fw-bold mb-2"><?= htmlspecialchars($photo['title'] ?? 'Untitled') ?></h2>
                
                <p class="text-muted small">
                    Uploaded by <strong>
                        <?= htmlspecialchars(trim(($photo['first_name'] ?? '') . ' ' . ($photo['last_name'] ?? '')) ?: ($photo['username'] ?? 'User')) ?>
                    </strong> 
                    on 
                    <?= !empty($photo['date_time']) ? date('F j, Y \a\t g:i A', strtotime($photo['date_time'])) : (!empty($photo['created_at']) ? date('F j, Y \a\t g:i A', strtotime($photo['created_at'])) : 'N/A') ?>
                </p>
                <hr>
                <p class="fs-6 text-secondary"><?= nl2br(htmlspecialchars($photo['description'] ?? 'No description provided.')) ?></p>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100 d-flex flex-column mt-lg-5">
            <div class="card-header bg-white fw-bold py-3 border-bottom">
                💬 Comments (<?= count($comments ?? []) ?>)
            </div>
            
            <div class="card-body overflow-auto flex-grow-1" style="max-height: 400px;">
                <?php if (empty($comments)): ?>
                    <p class="text-muted small text-center my-4">No comments yet. Start the conversation!</p>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="border-bottom pb-2 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <strong class="small">
                                    <?= htmlspecialchars(trim(($comment['first_name'] ?? '') . ' ' . ($comment['last_name'] ?? '')) ?: ($comment['username'] ?? 'User')) ?>
                                </strong>
                                <span class="text-muted text-nowrap" style="font-size: 0.75rem;">
                                    <?= !empty($comment['date_time']) ? date('M d, H:i', strtotime($comment['date_time'])) : (!empty($comment['created_at']) ? date('M d, H:i', strtotime($comment['created_at'])) : '') ?>
                                </span>
                            </div>
                            <p class="mb-0 small text-secondary"><?= htmlspecialchars($comment['comment'] ?? '') ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="card-footer bg-white p-3 border-top">
    <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Update action path to include subfolder prefix -->
        <form action="/alzikrayat/public/comment/store" method="POST">
            <input type="hidden" name="photo_id" value="<?= htmlspecialchars($photo['id'] ?? 0) ?>">
            <div class="mb-2">
                <textarea name="comment" class="form-control form-control-sm" rows="2" placeholder="Write a comment..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-sm w-100">Submit Comment</button>
        </form>
    <?php else: ?>
        <p class="small text-muted mb-0 text-center">
            <a href="/alzikrayat/public/login">Log in</a> to leave a comment.
        </p>
    <?php endif; ?>
</div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
<?php

require_once __DIR__ . '/../models/Photo.php';
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../core/Controller.php';

// Manages photo upload, view, comments history

class PhotoController extends Controller {

    private Photo $photoModel;
    private Comment $commentModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->photoModel = new Photo();
        $this->commentModel = new Comment();
    }

    public function index(): void {
        $photos = $this->photoModel->getAll();
        $this->render('photos/index', ['photos' => $photos]);
    }

    public function show(int $id): void {
        $photo = $this->photoModel->findById($id);
        if (!$photo) {
            http_response_code(404);
            echo "Photo not found.";
            return;
        }
        $comments = $this->commentModel->getByPhotoId($id);
        $this->render('photos/show', ['photo' => $photo, 'comments' => $comments]);
    }

    /**
     * displaying the upload form and processing submission 
     */
    public function create(): void {
        // Auth check: must be logged in
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/Alzikrayat/public/login');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->render('photos/create');
            return;
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error'] = "Photo upload failed. Please choose a valid file.";
            $this->redirect('/Alzikrayat/public/photos/create');
            return;
        }

        $file = $_FILES['photo'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array($ext, $allowedExts)) {
            $_SESSION['error'] = "Invalid file type. Allowed: JPG, JPEG, PNG, GIF, WEBP.";
            $this->redirect('/Alzikrayat/public/photos/create');
            return;
        }

        $uploadDir = __DIR__ . '/../public/images/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $newFileName = 'photo_' . time() . '_' . uniqid() . '.' . $ext;
        $targetPath = $uploadDir . $newFileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $this->photoModel->create([
                'user_id'     => $_SESSION['user_id'],
                'title'       => $title,
                'description' => $description,
                'file_path'   => '/images/uploads/' . $newFileName
            ]);
            $_SESSION['success'] = "Photo uploaded successfully!";
            $this->redirect('/Alzikrayat/public/');
        } else {
            $_SESSION['error'] = "Failed to save uploaded file on server.";
            $this->redirect('/Alzikrayat/public/photos/create');
        }
    }

    // Photo deleting process
    public function delete(int $id): void {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/Alzikrayat/public/login');
            return;
        }
        
        $photo = $this->photoModel->findById($id);

        if ($photo) {
            $deleted = $this->photoModel->delete($id, $_SESSION['user_id']);

            if ($deleted) {
                $filePath = __DIR__ . '/../public' . ($photo['file_path'] ?? '');
                if (!empty($photo['file_path']) && file_exists($filePath)) {
                    unlink($filePath);
                }
                $_SESSION['success'] = "Photo deleted.";
            } else {
                $_SESSION['error'] = "You cannot delete someone else's photo.";
            }
        }
        $this->redirect('/Alzikrayat/public/');
    }
}
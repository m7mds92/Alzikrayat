<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Comment.php';

class CommentController extends Controller {

    public function store(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $photoId = filter_input(INPUT_POST, 'photo_id', FILTER_VALIDATE_INT);
            $commentText = trim($_POST['comment'] ?? '');

            if ($photoId && !empty($commentText)) {
                $commentModel = new Comment();
                $commentModel->create([
                    'photo_id' => $photoId,
                    'user_id'  => $_SESSION['user_id'],
                    'comment'  => $commentText
                ]);
            }

            $this->redirect("/photos/show/{$photoId}");
        }
    }
}
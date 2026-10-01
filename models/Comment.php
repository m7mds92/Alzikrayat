<?php

require_once __DIR__ . '/../core/Model.php';

class Comment extends Model {

    public function create(array $data): bool {
        $sql = "INSERT INTO comments (photo_id, user_id, comment, created_at) 
                VALUES (:photo_id, :user_id, :comment, NOW())";

        $stmt = $this->query($sql, [
            'photo_id' => $data['photo_id'],
            'user_id'  => $data['user_id'],
            'comment'  => $data['comment']
        ]);

        return $stmt ? true : false;
    }

    public function getByPhotoId(int $photoId): array {
        $sql = "SELECT comments.*, users.username 
                FROM comments 
                JOIN users ON comments.user_id = users.id 
                WHERE comments.photo_id = :photo_id 
                ORDER BY comments.id ASC";
        return $this->query($sql, ['photo_id' => $photoId])->fetchAll();
    }
}
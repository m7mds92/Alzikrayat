<?php

require_once __DIR__ . '/../core/Model.php';

class Photo extends Model {

    public function create(array $data): bool {
        $sql = "INSERT INTO photos (user_id, title, description, file_path) 
                VALUES (:user_id, :title, :description, :file_path)";

        $stmt = $this->query($sql, [
            'user_id'     => $data['user_id'],
            'title'       => $data['title'],
            'description' => $data['description'],
            'file_path'   => $data['file_path']
        ]);

        return $stmt ? true : false;
    }

    public function getAll(): array {
        $sql = "SELECT photos.*, 
                       users.username AS first_name, 
                       '' AS last_name, 
                       photos.created_at AS date_time 
                FROM photos 
                JOIN users ON photos.user_id = users.id 
                ORDER BY photos.id DESC";
        return $this->query($sql)->fetchAll();
    }

    public function findById(int $id) {
        $sql = "SELECT photos.*, 
                       users.username AS first_name, 
                       '' AS last_name, 
                       photos.created_at AS date_time 
                FROM photos 
                JOIN users ON photos.user_id = users.id 
                WHERE photos.id = :id 
                LIMIT 1";
        return $this->query($sql, ['id' => $id])->fetch();
    }

    public function delete(int $id, int $userId): bool {
        $sql = "DELETE FROM photos WHERE id = :id AND user_id = :user_id";
        $stmt = $this->query($sql, ['id' => $id, 'user_id' => $userId]);
        return $stmt->rowCount() > 0;
    }
}
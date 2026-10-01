<?php

require_once __DIR__ . '/../core/Model.php';

// manages user registration, authentication, and database transactions

class User extends Model{
    //create new user to database
    public function create(array $data): bool {
        $sql = "INSERT INTO users (first_name,last_name,username,email,password) 
                VALUES (:first_name,:last_name,:username,:email,:password)";

        $params = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password']
        ];

        return $this->query($sql, $params)->rowCount() > 0;
    }


    public function findByEmail(string $email) {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $stmt = $this->query($sql, ['email' => $email]);
    return $stmt->fetch();
    }
    public function findById(int $id) {
        $sql = "SELECT id , first_name, last_name, email, username
                FROM users WHERE id = :id LIMIT 1";
        return $this->query($sql, ['id'=> $id])-> fetch();
    }

}
?>
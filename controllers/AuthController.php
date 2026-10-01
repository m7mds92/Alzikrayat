<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';

// Manages registration of users, credentials validation, and session status

class AuthController extends Controller {

    private User $userModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = new User();
    }

    /**
     * Display the combined Login / Register view
     */
    public function showLogin(): void {
        $lastLoginCookie = $_COOKIE['last_login'] ?? null;
        $this->render('auth/login', ['lastLogin' => $lastLoginCookie]);
    }

    
    public function showRegister(): void {
        $this->showLogin();
    }

    
    public function register(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/Alzikrayat/public/login');
        }

        $firstName = trim($_POST['first_name'] ?? '');
        $lastName  = trim($_POST['last_name'] ?? '');
        $username  = trim($_POST['username'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $password  = $_POST['password'] ?? '';

        if (empty($firstName) || empty($lastName) || empty($username) || empty($email) || empty($password)) {
            $_SESSION['error'] = "All fields are required.";
            $this->redirect('/Alzikrayat/public/login');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Invalid email format.";
            $this->redirect('/Alzikrayat/public/login');
        }

        if ($this->userModel->findByEmail($email)) {
            $_SESSION['error'] = "Email already exists.";
            $this->redirect('/Alzikrayat/public/login');
        }

        $created = $this->userModel->create([
            'first_name' => $firstName,
            'last_name'  => $lastName,
            'username'   => $username,
            'email'      => $email,
            'password'   => password_hash($password, PASSWORD_DEFAULT)
        ]);

        if ($created) {
            $_SESSION['success'] = "Registration successful. Please log in.";
            $this->redirect('/Alzikrayat/public/login');
        } else {
            $_SESSION['error'] = "Registration failed. Please try again.";
            $this->redirect('/Alzikrayat/public/login');
        }
    }

    
    public function login(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/Alzikrayat/public/login');
        }

        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $user     = $this->userModel->findByEmail($email);
        

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']    = $user['id'];
            $_SESSION['username']   = $user['username'];
            $_SESSION['first_name'] = $user['first_name'];

            $timestamp = date('Y-m-d H:i:s');
            setcookie('last_login', $timestamp, time() + (7 * 86400), "/");

            $this->redirect('/Alzikrayat/public/');
        } else {
            $_SESSION['error'] = "Invalid email or password.";
            $this->redirect('/Alzikrayat/public/login');
        }
    }

    /**
     * Log user out and destroy session
     */
    public function logout(): void {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        $this->redirect('/Alzikrayat/public/login');
    }
}
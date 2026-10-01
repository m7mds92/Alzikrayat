<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (file_exists(__DIR__ . '/../core/Database.php')) {
    require_once __DIR__ . '/../core/Database.php';
}
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Router.php';

require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/PhotoController.php';
require_once __DIR__ . '/../controllers/CommentController.php';

$router = new Router();

// Auth Routes
$router->add('GET', '/login', ['AuthController', 'showLogin']);
$router->add('POST', '/login', ['AuthController', 'login']);
$router->add('GET', '/register', ['AuthController', 'showRegister']);
$router->add('POST', '/register', ['AuthController', 'register']);
$router->add('GET', '/logout', ['AuthController', 'logout']);

// Photo Routes
$router->add('GET', '/', ['PhotoController', 'index']);
$router->add('GET', '/photos', ['PhotoController', 'index']);
$router->add('GET', '/photos/create', ['PhotoController', 'create']);
$router->add('POST', '/photos/create', ['PhotoController', 'create']);
$router->add('GET', '/photos/show/{id}', ['PhotoController', 'show']);
$router->add('GET', '/photos/delete/{id}', ['PhotoController', 'delete']);

// Comment Route
$router->add('POST', '/comment/store', ['CommentController', 'store']);

$router->dispatch();
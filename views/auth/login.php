<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Register - Alzikrayat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['error']); ?>
                    <?php unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['success']); ?>
                    <?php unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <ul class="nav nav-pills nav-justified mb-4" id="authTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-panel" type="button" role="tab">Login</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="register-tab" data-bs-toggle="tab" data-bs-target="#register-panel" type="button" role="tab">Register</button>
                </li>
            </ul>

            <div class="tab-content" id="authTabsContent">
                
                <div class="tab-pane fade show active" id="login-panel" role="tabpanel">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body p-4">
                            <h3 class="card-title text-center mb-4 fw-bold">Welcome Back</h3>
                            <form action="/Alzikrayat/public/login" method="POST">
                                <div class="mb-3">
                                    <label for="login_email" class="form-label">Email Address</label>
                                    <input type="email" name="email" id="login_email" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="login_password" class="form-label">Password</label>
                                    <input type="password" name="password" id="login_password" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-2 mt-2">Login</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="register-panel" role="tabpanel">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body p-4">
                            <h3 class="card-title text-center mb-4 fw-bold">Create Account</h3>
                            <form action="/Alzikrayat/public/register" method="POST">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label for="reg_first_name" class="form-label">First Name</label>
                                        <input type="text" name="first_name" id="reg_first_name" class="form-control" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="reg_last_name" class="form-label">Last Name</label>
                                        <input type="text" name="last_name" id="reg_last_name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="reg_username" class="form-label">Username</label>
                                    <input type="text" name="username" id="reg_username" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="reg_email" class="form-label">Email Address</label>
                                    <input type="email" name="email" id="reg_email" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="reg_password" class="form-label">Password</label>
                                    <input type="password" name="password" id="reg_password" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-success w-100 py-2 mt-2">Register</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
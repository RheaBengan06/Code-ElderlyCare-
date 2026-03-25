<?php
session_start(); 

include('conn.php');

if (isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id'])) {
    header("Location: /elderlycare/templates/admin/AdminDashboard.php");
    exit();
} elseif (isset($_SESSION['relative_id']) && !empty($_SESSION['relative_id'])) {
    header("Location: /elderlycare/templates/relatives/relatives_dashboard.php");
    exit();
} elseif (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    header("Location: /elderlycare/templates/caregiver/CaregiverDashboard.php");
    exit();
}

// Handle session message
$message = '';
if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>FilSha - Login</title>

  <!-- Favicons -->
  <link href="/elderlycare/assets/img/logo.png" rel="icon">

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Nunito:300,400,600,700|Poppins:300,400,500,600,700" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/loginstyle.css">
</head>
<style>
  /* Hide image and add margin-top on mobile */
  @media (max-width: 576px) {
    .row.g-0 > .col-12.col-md-6:first-child {
      display: none;
    }

    .container.py-4 {
      margin-top: 70px; /* adjust the value as needed */
    }
  }
</style>


<body>
  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-12 col-xxl-10">
        <div class="card border-light-subtle shadow-sm">
          <div class="row g-0 flex-column flex-md-row">
            <!-- Left Image -->
            <div class="col-12 col-md-6">
              <img class="img-fluid w-100 h-100 object-fit-cover" loading="lazy" src="./assets/img/logofinal.jpg" alt="Welcome back!">
            </div>

            <!-- Right Form -->
            <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
              <div class="col-12 col-lg-11 col-xl-10">
                <div class="card-body p-3 p-md-4 p-xl-5">
                  
                  <div class="text-center mb-4">
                    <a href="index.php">
                      <img src="./assets/img/loginlogo3.jpg" alt="BootstrapBrain Logo" width="175" height="150">
                    </a>
                  </div>
                  <h4 class="text-center mb-4">Welcome back, dear caregiver! We're so glad you're here.</h4>

                  <!-- Session Message -->
                  <?php if (!empty($message)): ?>
                    <div class="alert alert-info text-center" role="alert">
                      <?= htmlspecialchars($message) ?>
                    </div>
                  <?php endif; ?>

                  <!-- Login Form -->
                  <form action="process.php" method="POST">
                    <div class="row gy-3">
                      <div class="col-12">
                        <div class="form-floating">
                          <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                          <label for="email">Email</label>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-floating position-relative">
                          <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                          <label for="password">Password</label>
                          <span class="position-absolute top-50 end-0 translate-middle-y me-3" id="toggle-password" style="cursor:pointer;">
                            <i class="bi bi-eye" id="eye-icon"></i>
                          </span>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" name="remember_me" id="remember_me">
                          <label class="form-check-label text-secondary" for="remember_me">
                            Keep me logged in
                          </label>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="d-grid">
                          <button class="btn btn-primary w-100" type="submit" name="submit">Log in now</button>
                        </div>
                      </div>
                    </div>
                  </form>

                  <!-- Bottom Links -->
                  <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-2 gap-md-3 text-center text-md-start mt-4 flex-wrap">
                    <a href="forgot_password.php" class="text-decoration-none text-secondary">Forgot Password</a>
                    <span class="text-muted d-none d-md-inline">|</span>
                    <a href="create_new_caregiver.php" class="text-decoration-none text-secondary">Create New Account</a>
                    <span class="text-muted d-none d-md-inline">|</span>
                    <a href="templates/relatives/relatives_login.php" class="text-decoration-none text-secondary">Log in as Relative</a>
                    <span class="text-muted d-none d-md-inline">|</span>
                    <a href="templates/admin/adminLogin.php" class="text-decoration-none text-secondary">Log in as Admin</a>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Password Toggle Script -->
  <script>
    const togglePassword = document.querySelector("#toggle-password");
    const passwordField = document.querySelector("#password");
    const eyeIcon = document.querySelector("#eye-icon");

    togglePassword.addEventListener("click", function() {
      const type = passwordField.type === "password" ? "text" : "password";
      passwordField.type = type;
      eyeIcon.classList.toggle("bi-eye");
      eyeIcon.classList.toggle("bi-eye-slash");
    });
  </script>



</body>
</html>

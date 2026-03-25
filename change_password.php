<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>ElderlyCare - Change Password</title>

  <!-- Favicons -->
  <link href="/elderlycare/assets/img/logo.png" rel="icon">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Nunito:300,400,600,700|Poppins:300,400,500,600,700" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/logins/login-4/assets/css/login-4.css">
  <link rel="stylesheet" href="assets/css/loginstyle.css">
</head>
<style>
  .btn, .btn-secondary {
      border-radius: 5px;
      padding: 12px 20px;
      transition: all 0.3s ease;
    }

     .btn:hover {
      background-color: #0056b3;
      border-color: #0056b3;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      color: black;
    }

    .btn-secondary {
      background-color: #6c757d;
      border-color: #6c757d;
    }

    .btn-secondary:hover {
      background-color: #5a6268;
      border-color: #545b62;
      color: black;
    }
</style>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-xxl-10">
        <div class="card border-light-subtle shadow-sm">
          <div class="row g-0">
            <div class="col-12 col-md-6">
              <img class="img-fluid rounded-start w-100 h-100 object-fit-cover" loading="lazy" src="./assets/img/logofinal.jpg" alt="Change Password">
            </div>
            <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
              <div class="col-12 col-lg-11 col-xl-10">
                <div class="card-body p-3 p-md-4 p-xl-5">
                  <div class="text-center mb-4">
                    <a href="#!">
                      <img src="./assets/img/loginlogo3.jpg" alt="FilSha Logo" width="175" height="100">
                    </a>
                  </div>

                  <h4 class="text-center mb-4">Set a New Password</h4>
                  <p class="text-center text-muted mb-4">Enter your new password below.</p>
                  <form method="POST" action="reset_pass_process.php">
                    <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">

                    <!-- New Password -->

                    <div class="form-floating mb-3 position-relative">
                    <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password" required>
                    <label for="new_password">New Password</label>
                    <i id="toggle-new-password" class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;"></i>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-floating mb-3 position-relative">
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                    <label for="confirm_password">Confirm Password</label>
                    <i id="toggle-confirm-password" class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;"></i>
                    </div>
                    <div class="d-flex justify-content-center gap-2 mt-4">
                      <button type="submit" name="submitPass" class="btn btn-primary fw px-4 py-2">
                        Change Password
                      </button>
                      <a href="forgot_password.php" class="btn btn-secondary fw px-4 py-2 d-flex align-items-center justify-content-center">
                        Back to Reset
                      </a>
                    </div>

                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> 
    </div>
  </div>
<script>
  const toggleNewPassword = document.querySelector("#toggle-new-password");
  const newPasswordField = document.querySelector("#new_password");

  toggleNewPassword.addEventListener("click", function () {
    const type = newPasswordField.type === "password" ? "text" : "password";
    newPasswordField.type = type;

    this.classList.toggle("bi-eye");
    this.classList.toggle("bi-eye-slash");
  });

  const toggleConfirmPassword = document.querySelector("#toggle-confirm-password");
  const confirmPasswordField = document.querySelector("#confirm_password");

  toggleConfirmPassword.addEventListener("click", function () {
    const type = confirmPasswordField.type === "password" ? "text" : "password";
    confirmPasswordField.type = type;

    this.classList.toggle("bi-eye");
    this.classList.toggle("bi-eye-slash");
  });
</script>




<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>

<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>ElderlyCare - Forgot Password</title>
 
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
      padding: 12px 50px;
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
              <img class="img-fluid rounded-start w-100 h-100 object-fit-cover" loading="lazy" src="./assets/img/logofinal.jpg" alt="Forgot Password">
            </div>
            <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
              <div class="col-12 col-lg-11 col-xl-10">
                <div class="card-body p-3 p-md-4 p-xl-5">
                  <div class="text-center mb-4">
                    <a href="#!">
                      <img src="./assets/img/loginlogo3.jpg" alt="FilSha Logo" width="175" height="100">
                    </a>
                  </div>
                  <h4 class="text-center mb-4">Forgot your password?</h4>
                  <p class="text-center text-muted mb-4">Enter your email below to receive a 6-digit reset code.</p>



                  <form action="reset_pass_process.php" method="POST">
                    <div class="form-floating mb-3">
                      <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required>
                      <label for="email">Email address</label>
                    </div>
                    <div class="d-flex justify-content-center gap-2 mt-4">
                      <button class="btn btn-primary px-4 " name="sendCode" type="submit">
                        Send Reset Code
                      </button>
                      <a href="index.php" class="btn btn-secondary px-4 d-flex align-items-center justify-content-center">
                        Back to Login
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
</body>
</html>

<?php
include 'conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>FilSha - Create Account</title>
  <link href="/elderlycare/assets/img/logo.png" rel="icon">
  <link href="/elderlycare/assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Nunito:300,400,600,700|Poppins:300,400,500,600,700" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/logins/login-4/assets/css/login-4.css">
  <link rel="stylesheet" href="assets/css/loginstyle.css">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f7fc;
    }

    .container {
      margin-top: 40px;
    }

    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .card-body {
      padding: 2.5rem 3.5rem;
    }

    .form-floating label {
      font-size: 1rem;
      font-weight: 600;
    }

    .form-check-label {
      font-size: 0.9rem;
    }

    h3 {
      font-size: 1.35rem;
      margin-top: 2rem;
      color: #333;
      font-weight: bold;
    }
    .btn {
      margin-top: 15px;
    }
    .btn-primary, .btn-secondary {
      border-radius: 50px;
      padding: 10px 20px;
      transition: all 0.3s ease;
    }


    
    .btn-primary:hover {
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
    }

    .text-center img {
      max-width: 180px;
      height: auto;
    }

    .form-step {
      display: none;
    }

    .form-step.active {
      display: block;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-control {
      border-radius: 8px;
      padding: 15px;
      font-size: 1rem;
      border: 1px solid #ddd;
    }

    .form-select {
      border-radius: 8px;
      padding: 15px;
      font-size: 1rem;
      border: 1px solid #ddd;
    }

    .form-check-input {
      border-radius: 5px;
    }

    .form-check-label {
      margin-left: 10px;
    }

    .prev-step {
      background-color: #f8f9fa;
      color: #495057;
      border: 1px solid #ddd;
    }

    .prev-step:hover {
      background-color: #e2e6ea;
    }
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
</head>

<body>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-xxl-10">
        <div class="card border-light-subtle shadow-sm">
          <div class="row g-0">
            <div class="col-12 col-md-6">
              <img class="img-fluid rounded-start w-100 h-100 object-fit-cover" loading="lazy" src="./assets/img/logofinal.jpg" alt="Welcome to FilSha, Create Your Account!">
            </div>
            <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
              <div class="col-12 col-lg-11 col-xl-10">
                <div class="card-body p-3 p-md-4 p-xl-5">
                  <div class="row">
                    <div class="col-12">
                      <div class="mb-5">
                        <div class="text-center mb-4">
                          <a href="#!">
                            <img src="./assets/img/loginlogo3.jpg" alt="FilSha Logo" width="175" height="100">
                          </a>
                        </div>
                        <h4 class="text-center">Create Your Account</h4>
                      </div>
                    </div>
                  </div>
                  
                  <form action="process.php" method="POST" id="registration-form">

                    
                    <div class="form-step active">
                      <h3>Personal Information</h3>
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="full_name" id="full_name" required>
                        <label for="full_name">Full Name:</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="date" class="form-control" name="dob" id="dob" required>
                        <label for="dob">Date of Birth:</label>
                      </div>

                      <div class="form-floating mb-3">
                        <select name="gender" id="gender" class="form-select">
                          <option value="male">Male</option>
                          <option value="female">Female</option>
                          <option value="other">Other</option>
                        </select>
                        <label for="gender">Gender:</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="int" class="form-control" name="contact_phone" id="contact_phone" required>
                        <label for="contact_phone">Phone Number:</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="address" id="address" required>
                        <label for="address">Home Address:</label>
                      </div>
                      
                      <button type="button" class="btn btn-primary next-step">Next</button>
                    </div>

                    
                    <div class="form-step">
                      <h3>Professional Information</h3>
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="certification_number" id="certification_number">
                        <label for="certification_number">Caregiver Certification Number:</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="experience" id="experience" required>
                        <label for="experience">Years of Experience:</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="specialized_skills" id="specialized_skills">
                        <label for="specialized_skills">Specialized Skills (e.g. Alzheimer's care):</label>
                      </div>

                      <button type="button" class="btn btn-secondary prev-step">Previous</button>
                      <button type="button" class="btn btn-primary next-step">Next</button>
                    </div>

                    
                    <div class="form-step">
                      <h3>Employment Availability</h3>
                      <div class="form-floating mb-3">
                        <select name="availability" id="availability" class="form-select">
                          <option value="full-time">Full-time</option>
                          <option value="part-time">Part-time</option>
                        </select>
                        <label for="availability">Availability:</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="preferred_hours" id="preferred_hours" >
                        <label for="preferred_hours">Preferred Work Hours:</label>
                      </div>

                      <button type="button" class="btn btn-secondary prev-step">Previous</button>
                      <button type="button" class="btn btn-primary next-step">Next</button>
                    </div>

                    
                    <div class="form-step">
                      <h3>Emergency Contact Information</h3>
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="emergency_contact_name" id="emergency_contact_name" required>
                        <label for="emergency_contact_name">Emergency Contact Name:</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input type="tel" class="form-control" name="emergency_contact_phone" id="emergency_contact_phone" required>
                        <label for="emergency_contact_phone">Emergency Contact Phone Number:</label>
                      </div>

                      <button type="button" class="btn btn-secondary prev-step">Previous</button>
                      <button type="button" class="btn btn-primary next-step">Next</button>
                    </div>

                    

                    <div class="form-step">
                      <h3>Background Check & Documentation</h3>

                      <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" name="background_check" id="background_check" required>
                        <label class="form-check-label" for="background_check">I confirm I have completed a background check.</label>
                      </div>

                      <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" name="health_check" id="health_check" required>
                        <label class="form-check-label" for="health_check">I confirm I have completed a recent health check.</label>
                      </div>

                      <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" name="consent_terms" id="consent_terms" required>
                        <label class="form-check-label" for="consent_terms">I agree to the terms and conditions of FilSha.</label>
                      </div>


                    <div class="form-check mb-3">
                      <button type="button" class="btn btn-secondary prev-step">Previous</button>
                      <button type="button" class="btn btn-primary next-step">Next</button>
                    </div>
                  </div>
                    <div class="form-step">
                        <div class="col-12">
                          <div class="form-floating mb-3">
                            <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                            <label for="email" class="form-label">Email</label>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="form-floating mb-3 position-relative">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                            <label for="password" class="form-label">Password</label>
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3" id="toggle-password">
                              <i class="bi bi-eye" id="eye-icon" style="cursor: pointer;"></i>
                            </span>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="form-floating mb-3 position-relative">
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3" id="toggle-confirm-password">
                              <i class="bi bi-eye" id="eye-icon-confirm" style="cursor: pointer;"></i>
                            </span>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="d-grid">
                            <button type="button" class="btn btn-secondary prev-step">Previous</button>
                            <button class="btn" type="submit" name="create" >Create Account</button>
                          </div>
                        </div>
                      </div>

                        
                    <div id="pending-approval-message" style="display: none;">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-center mt-5">
                                    <p class="text-warning">Your account is pending approval. You will be notified once your account has been approved or rejected.</p>
                                    <a href="/elderlycare/templates/caregiver/userLogin.php" class="link-secondary text-decoration-none">Already have an account? Log in</a>
                                </div>
                            </div>
                        </div>
                    </div>
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
document.addEventListener("DOMContentLoaded", function() {
  const steps = document.querySelectorAll(".form-step");
  const nextBtns = document.querySelectorAll(".next-step");
  const prevBtns = document.querySelectorAll(".prev-step");
  const submitBtn = document.getElementById("submit-btn");
  let currentStep = 0;

  function showStep() {
    steps.forEach((step, i) => step.classList.toggle("active", i === currentStep));
  }

  function validateCurrentStep() {
    const inputs = steps[currentStep].querySelectorAll("input, select, textarea");
    for (let input of inputs) {
      if (input.required && (input.type === "checkbox" ? !input.checked : !input.value.trim())) {
        return false;
      }
    }
    return true;
  }

  nextBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      if (!validateCurrentStep()) {
        return alert("Please fill in all required fields before proceeding.");
      }
      currentStep++;
      showStep();
    });
  });

  prevBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      if (currentStep > 0) {
        currentStep--;
        showStep();
      }
    });
  });

  n
  submitBtn.addEventListener("click", e => {
    e.preventDefault();
    if (!validateCurrentStep()) {
      return alert("Please fill in all required fields before proceeding.");
    }
    
    document.getElementById("registration-form").submit();
  });

  showStep();
});



const togglePassword = document.querySelector("#eye-icon");
const passwordField = document.querySelector("#password");

togglePassword.addEventListener("click", function() {
  const type = passwordField.type === "password" ? "text" : "password";
  passwordField.type = type;
  togglePassword.classList.toggle("bi-eye");
  togglePassword.classList.toggle("bi-eye-slash");
});


const toggleConfirmPassword = document.querySelector("#eye-icon-confirm");
const confirmPasswordField = document.querySelector("#confirm_password");

toggleConfirmPassword.addEventListener("click", function() {
  const type = confirmPasswordField.type === "password" ? "text" : "password";
  confirmPasswordField.type = type;
  toggleConfirmPassword.classList.toggle("bi-eye");
  toggleConfirmPassword.classList.toggle("bi-eye-slash");
});

</script>




</body>
</html>

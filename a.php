<?php

session_start();
include 'conn.php';

if (!isset($_SESSION['admin_id'])) {
    echo "<script>
        alert('Please log in first');
        window.location.href = '/index.php';
    </script>";
    exit();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$notif_sql = "SELECT id, message, is_read, type, reference_id, created_at 
              FROM admin_notifications 
              WHERE type != 'medicine' AND user_type = 'caregiver'
              ORDER BY created_at DESC 
              LIMIT 7";

$notif_result = mysqli_query($conn, $notif_sql);
$notifications = mysqli_fetch_all($notif_result, MYSQLI_ASSOC);

$unread_count = 0;
foreach ($notifications as $n) {
    if ($n['is_read'] == 0) $unread_count++;
}

if (isset($_POST['markAllRead'])) {
    $sql = "UPDATE admin_notifications 
            SET is_read = 1 
            WHERE user_type = 'caregiver'";
    mysqli_query($conn, $sql);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_GET['notif_id'])) {
    $notif_id = intval($_GET['notif_id']);

    // Mark as read only if created by caregiver
    mysqli_query($conn, "UPDATE admin_notifications 
                         SET is_read = 1 
                         WHERE id = $notif_id AND user_type = 'caregiver'");

    $notif_info = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT type, reference_id 
                             FROM admin_notifications 
                             WHERE id = $notif_id AND user_type = 'caregiver'")
    );

    if ($notif_info) {
        if ($notif_info['type'] === 'new_caregiver') {
            header("Location: caregiver_account_request.php?id=" . $notif_info['reference_id']);
        } elseif ($notif_info['type'] === 'deleted_patient') {
            header("Location: managepatient.php");
        } else {
            header("Location: patients_request.php?id=" . $notif_info['reference_id']);
        }
    }
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>ElderlyCare - User's Queries</title>
  <meta content="" name="description">
  <meta content="" name="keywords">


<!-- Favicons -->
<link href="/assets/img/logo.png" rel="icon">

<!-- Google Fonts -->
<link href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
<link href="/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
<link href="/assets/vendor/quill/quill.snow.css" rel="stylesheet">
<link href="/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
<link href="/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
<link href="/assets/vendor/simple-datatables/style.css" rel="stylesheet">

<!-- Template Main CSS File -->
<link href="/assets/css/style.css" rel="stylesheet">

</head>
<style>
  
 
  .notification-item.unread {
    background-color: #f0f8ff;
  }
  .notification-item.unread p {
    font-weight: bold;
  }
 
.dropdown-menu.notifications {
  max-height: 300px;      
  overflow-y: auto;
  padding-right: 0;      
}


.dropdown-menu.notifications::-webkit-scrollbar {
  width: 6px;
}
.dropdown-menu.notifications::-webkit-scrollbar-track {
  background: transparent;
}
.dropdown-menu.notifications::-webkit-scrollbar-thumb {
  background-color: rgba(0,0,0,0.2);
  border-radius: 3px;
}
@media (max-width: 576px), (max-width: 780px) {
  .dropdown-menu.profile {
    position: fixed !important;
    top: 60px;
    left: 0 !important;
    right: 0 !important;
    border-radius: 0;
    z-index: 1050;
  }
}
.dropdown-menu.notifications {
  max-height: 400px;
  overflow-y: auto;
}

@media (max-width: 576px) {
  .dropdown-menu.notifications {
    position: fixed !important;
    top: 60px;
    left: 0 !important;
    right: 0 !important;
    width: 100vw !important;
    max-width: none !important;
    border-radius: 0;
    z-index: 1050;
  }
}
</style>

<body>
<header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
  <a href="AdminDashboard.php" class="logo d-flex align-items-center">
  <img src="/assets/img/logo.png" alt="Logo">
    <span class="d-none d-lg-block">ElderlyCare</span>
  </a>
  <i class="bi bi-list toggle-sidebar-btn"></i>
</div>

<nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">

  
 <!-- Notifications -->
<li class="nav-item dropdown">
  <a id="notificationBell" class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
    <i class="bi bi-bell"></i>
    <?php if ($unread_count > 0): ?>
      <span class="badge bg-primary badge-number"><?= $unread_count ?></span>
    <?php endif; ?>
  </a>

 <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications"
    style="max-width: 350px; word-wrap: break-word;">
  <li class="dropdown-header">
    <span>
      You have <?= $unread_count ?> new notification<?= $unread_count !== 1 ? 's' : ''; ?>
    </span>
    <?php if ($unread_count > 0): ?>
      <div class="mt-1">
        <form method="POST" style="display:inline;">
          <button type="submit" name="markAllRead" class="btn" style="font-size: 13px; height: 35px;">
            Mark all as read
          </button>
        </form>
      </div>
    <?php endif; ?>
  </li>
  <li><hr class="dropdown-divider"></li>

  <?php foreach ($notifications as $notif):
    $url = "?notif_id=" . $notif['id'];
    $liClass = $notif['is_read'] == 0 ? 'notification-item unread' : 'notification-item';
  ?>
    <li class="<?= $liClass ?>">
      <a href="<?= $url ?>" class="d-flex align-items-start text-decoration-none">
        <i class="bi bi-info-circle text-info me-2"></i>
        <div>
          <p class="mb-1"><?= htmlspecialchars($notif['message']) ?></p>
          <small class="text-muted">
            <?= date("M d, Y h:i A", strtotime($notif['created_at'])) ?>
          </small>
        </div>
      </a>
    </li>
    <li><hr class="dropdown-divider"></li>
  <?php endforeach; ?>
</ul>

</li>
<!-- End Notifications -->

      <?php
  include('conn.php');

  $query = "SELECT fullname, position, admin_picture FROM admins WHERE id = 1";
  $stmt = $conn->prepare($query);
  $stmt->execute();
  $stmt->bind_result($fullname, $position, $adminPicture);
  $stmt->fetch();
  $stmt->close();
?>
<li class="nav-item dropdown pe-3">
  <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
    <?php if (!empty($adminPicture)): ?>
      <img src="uploads/admin/<?= htmlspecialchars($adminPicture) ?>"
           alt="Profile"
           class="rounded-circle"
           style="object-fit: cover; width: 40px; height: 40px;" />
    <?php else: ?>
      <div class="rounded-circle bg-secondary d-flex justify-content-center align-items-center"
           style="width: 40px; height: 40px;">
        <i class="bi bi-person text-white fs-5"></i>
      </div>
    <?php endif; ?>
    <span class="dropdown-toggle d-none d-md-inline-block text-truncate" style="max-width: 120px;">
      <?= htmlspecialchars($fullname) ?>
    </span>
  </a>

  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile w-100" style="max-width: none; word-wrap: break-word;">
    <li class="dropdown-header">
      <h6><?= htmlspecialchars($fullname) ?></h6>
      <span><?= htmlspecialchars($position) ?></span>
    </li>

    <li><hr class="dropdown-divider"></li>

    <li>
      <a class="dropdown-item d-flex align-items-center" href="admin_profile.php">
        <i class="bi bi-person"></i>
        <span>My Profile</span>
      </a>
    </li>

    <li><hr class="dropdown-divider"></li>

    <li>
      <a class="dropdown-item d-flex align-items-center" href="/logout.php">
        <i class="bi bi-box-arrow-right"></i>
        <span>Sign Out</span>
      </a>
    </li>
  </ul>
</li>

  </nav>
    </header>


  <aside id="admin-sidebar" class="sidebar">
    <h3 class="text-white text-center space-below">Admin Dashboard</h3>
    <ul class="sidebar-nav" id="admin-sidebar-nav">
      <li class="nav-item">
        <a class="nav-link collapsed" href="AdminDashboard.php">
          <i class="bi bi-house-door"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="manage_rooms.php">
          <i class="bi bi-door-open"></i>
          <span>Manage Patient Rooms </span>
        </a>
    </li>
      <li class="nav-item">
        <a class="nav-link " href="caregiver_account_request.php">
          <i class="bi bi-check-circle"></i>
          <span>Caregiver Approvals </span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="patients_request.php">
          <i class="bi bi-person-check"></i>
          <span>Patient's Approvals </span>
        </a>
    </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="manage_patients.php">
          <i class="bi bi-file-earmark-person"></i>
          <span>Manage Patients</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="manage_caregivers.php">
          <i class="bi bi-person-bounding-box"></i>
          <span>Manage Caregivers</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="view_reports.php">
          <i class="bi bi-file-earmark-text"></i>
          <span>View Reports</span>
        </a>
      </li>
    </ul>
  </aside>

<main id="main" class="main">
  <div class="pagetitle">
    <h2>Manage Caregivers</h2>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="AdminDashboard.php">Home</a></li>
        <li class="breadcrumb-item">Caregivers</li>
        <li class="breadcrumb-item active">Management</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Manage Caregiver Account Requests</h5>

            <?php
            include 'conn.php'; 

            $query = "SELECT 
                c.id,
                c.email,
                c.created_at,
                c.status,
                ci.full_name
              FROM caregivers c
              LEFT JOIN caregivers_info ci ON c.id = ci.caregiver_id
              WHERE c.status = 'pending';";

            $result = mysqli_query($conn, $query);

            if (!$result) {
                die("Error: " . mysqli_error($conn));
            }
            ?>

            <!-- ✅ Responsive wrapper added -->
            <div class="table-responsive">
              <table class="table table-bordered" id="accountRequestsTable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while ($row = mysqli_fetch_assoc($result)) {
                      $requestId = $row['id'];
                      $full_name = $row['full_name']; 
                      $email = $row['email'];
                      $status = $row['status'];
                      $createdAt = $row['created_at'];
                  ?>
                  <tr id="request-<?php echo $requestId; ?>">
                    <td><?php echo $requestId; ?></td>
                    <td><?php echo $full_name; ?></td>
                    <td><?php echo $email; ?></td>
                    <td><span id="status-<?php echo $requestId; ?>"><?php echo ucfirst($status); ?></span></td>
                    <td><?php echo date("F j, Y ( g:i a)", strtotime($createdAt)); ?></td>
                    <td>
                      <div style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
                        <form method="POST" action="process.php">
                          <input type="hidden" name="request_id" value="<?php echo $requestId; ?>">
                          <input type="hidden" name="action" value="approve">
                          <button type="submit" class="btn" style="height: 40px;">Approve</button>
                        </form>

                        <form method="POST" action="process.php">
                          <input type="hidden" name="request_id" value="<?php echo $requestId; ?>">
                          <input type="hidden" name="action" value="reject">
                          <button type="submit" class="btn" style="height: 40px;">Reject</button>
                        </form>
                      </div>
                    </td>

                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- ✅ End responsive wrapper -->

            <?php mysqli_close($conn); ?>

            <!-- Confirm Modal -->
            <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirm Account Request</h5>
                  </div>
                  <div class="modal-body">
                    <p id="confirmMessage"></p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn" id="confirmActionButton">Confirm</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Modal -->

          </div>
        </div>
      </div>
    </div>
  </section>
</main>


  <script>
  function showConfirmModal(requestId, action) {
    var modal = new bootstrap.Modal(document.getElementById('confirmModal'));
    var message = '';

  
    if (action === 'approve') {
      message = 'Are you sure you want to approve this caregiver request?';
    } else if (action === 'reject') {
      message = 'Are you sure you want to reject this caregiver request?';
    }

  
    document.getElementById('confirmMessage').textContent = message;

   
    document.getElementById('confirmActionButton').onclick = function () {
      
      if (action === 'approve') {
        approveRequest(requestId);
      } else if (action === 'reject') {
        rejectRequest(requestId);
      }
    };

  
    modal.show();
  }

 
  function approveRequest(requestId) {
    
    alert('Approved request: ' + requestId); 
  
    var modal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
    modal.hide();
  }


  function rejectRequest(requestId) {
    
    alert('Rejected request: ' + requestId);
   
    var modal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
    modal.hide();
  }
</script>

<footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>ElderlyCare</span></strong>. All Rights Reserved
    </div>
  </footer>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


<script src="/assets/js/main.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

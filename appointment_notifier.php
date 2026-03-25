<?php
include 'caregiver_dbconnection.php';

$today = date('Y-m-d');
$target_date = date('Y-m-d', strtotime('+2 days'));


$query = "SELECT a.*, c.email, p.first_name, p.last_name 
          FROM appointments a
          JOIN caregivers_info c ON a.caregiver_id = c.id
          JOIN patients_info p ON a.patient_id = p.id
          WHERE appointment_date = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $target_date);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    
    $message = "Reminder: You have an upcoming appointment with patient " . $row['first_name'] . " " . $row['last_name'] . " on " . $row['appointment_date'] . " at " . $row['appointment_time'] . " for " . $row['purpose'] . ".";
    
    
    $notif_stmt = $conn->prepare("INSERT INTO caregiver_notifications (caregiver_id, message, is_read) VALUES (?, ?, 0)");
    $notif_stmt->bind_param("is", $row['caregiver_id'], $message);
    $notif_stmt->execute();
}
?>

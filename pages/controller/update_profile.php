<?php
session_start();
require_once '../config/connection.php';

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id_user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Anda harus login terlebih dahulu']);
    exit();
}

$user_id = $_SESSION['user']['id_user']; // Get user ID from session

$username = $_POST['username'];
$email = $_POST['email'];
$fullname = $_POST['fullname'];
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

if (!empty($password) && $password === $confirm_password) {
    // Update with new password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $query = $conn->prepare("UPDATE users SET username = ?, email = ?, nama = ?, password = ? WHERE id_user = ? AND role = 1");
    $query->bind_param("ssssi", $username, $email, $fullname, $hashed_password, $user_id);
} else {
    // Update without password
    $query = $conn->prepare("UPDATE users SET username = ?, email = ?, nama = ? WHERE id_user = ? AND role = 1");
    $query->bind_param("sssi", $username, $email, $fullname, $user_id);
}

if ($query->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update profile']);
}

$query->close();
$conn->close();

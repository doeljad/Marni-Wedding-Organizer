<?php
session_start();
require_once '../config/connection.php';

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id_user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Anda harus login terlebih dahulu']);
    exit();
}

$user_id = $_SESSION['user']['id_user']; // Get user ID from session

$query = $conn->prepare("SELECT * FROM users WHERE id_user = ? AND role = 1");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

if ($user) {
    echo json_encode(['status' => 'success', 'data' => $user]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'User not found or not authorized']);
}

$query->close();
$conn->close();

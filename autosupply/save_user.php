<?php
include 'db_connect.php';

$full_name = $_POST['full_name'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encrypt it!
$role = $_POST['role'];

$stmt = $conn->prepare("INSERT INTO users (full_name, username, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $full_name, $username, $password, $role);

if($stmt->execute()) {
    header("Location: users.php");
} else {
    echo "Error: " . $conn->error;
}
?>
<?php
include '../db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['registerUsername'];
    $email = $_POST['registerEmail'];
    $password = password_hash($_POST['registerPassword'], PASSWORD_DEFAULT); // Hash password
    $usertype = 'user'; // Default type user

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, usertype) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $usertype);

    if ($stmt->execute()) {
        echo "Pendaftaran berhasil. <a href='login.php'>Login di sini</a>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>

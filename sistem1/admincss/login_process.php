<?php
session_start();
include '../db_connection.php';

// Validasi input dari form login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['loginUsername'] ?? '';
    $password = $_POST['loginPassword'] ?? '';

    if (empty($username) || empty($password)) {
        echo "Username atau password tidak boleh kosong.";
        exit;
    }

    // Query untuk memeriksa pengguna
    $stmt = $conn->prepare("SELECT * FROM users WHERE name = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Simpan data pengguna di sesi
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['name'];
        $_SESSION['usertype'] = $user['usertype'];

        // Redirect sesuai usertype
        if ($user['usertype'] === 'admin') {
            header("Location: index.php");
        } else {
            header("Location: ../dashboard.php");
        }
        exit;
    } else {
        echo "Username atau password salah.";
    }
}
?>

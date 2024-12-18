<?php
session_start();
include '../db_connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['loginUsername'] ?? '';
    $password = $_POST['loginPassword'] ?? '';

    if (empty($username) || empty($password)) {
        echo "Username atau password tidak boleh kosong.";
        exit;
    }

    // Query rentan terhadap SQL Injection
    $query = "SELECT * FROM users WHERE name = '$username'";
    echo "Query SQL: $query<br>";
    $result = $conn->query($query);

    if ($result) {
        if ($result->num_rows > 0) {
            echo "Query berhasil. Data ditemukan.<br>";
            $user = $result->fetch_assoc();
            print_r($user); // Debugging output

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['name'];
            $_SESSION['usertype'] = $user['usertype'];

            // Redirect sesuai usertype
            if ($user['usertype'] === 'admin') {
                header("Location: index.php"); // Halaman admin
            } else {
                header("Location: ../dashboard.php"); // Halaman user biasa
            }
            exit;

        } else {
            echo "Query berhasil, tetapi tidak ada data ditemukan.";
        }
    } else {
        echo "Query gagal: " . $conn->error; // Debugging error
    }
    
}
?>

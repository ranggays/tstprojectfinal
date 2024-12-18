<?php
$servername = "localhost";  // server database
$username = "root";         // username MySQL
$password = "";             // password MySQL (kosong untuk root default di XAMPP)
$dbname = "sistem1_db";     // nama database

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname, 3306);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";  // Jika koneksi berhasil
?>

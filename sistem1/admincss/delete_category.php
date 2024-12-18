<?php
    include '../db_connection.php';

    $id = $_GET['id'] ?? null;
    if (!$id) {
        die("Invalid ID");
    }

    // Hapus kategori
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: category.php"); // Kembali ke halaman kategori
    exit();

?>
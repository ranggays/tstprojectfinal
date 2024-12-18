<?php
require_once __DIR__ . '/servers/Database.php';

$db = new Database();
$conn = $db->getConnection();

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Invalid ID");
}

// Ambil data dari database
try {
    $stmt = $conn->prepare("SELECT * FROM resi WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        die("ID tidak valid atau tidak ditemukan.");
    }

    // Proses Update jika form disubmit
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
        $status = $_POST['status'];
        
        $update_stmt = $conn->prepare("UPDATE resi SET status = ? WHERE id = ?");
        $update_stmt->execute([$status, $id]);

        header("Location: http://localhost/sistem2/update.php?id=$id");
        exit();
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Tracking Status</title>
</head>
<body>
    <h1>Update Status</h1>
    <form method="POST" action="">
        <label for="status">Status:</label>
        <input type="text" id="status" name="status" value="<?php echo htmlspecialchars($data['status'] ?? ''); ?>" required>
        <br><br>
        <input type="submit" name="update_status" value="Update Status">
    </form>
</body>
</html>

<?php
include('db_connection.php');  // Menyertakan file koneksi database

// Membaca data JSON dari body request
$data = json_decode(file_get_contents('php://input'), true);

// Validasi apakah data yang diterima lengkap
$count1 = isset($data['count1']) ? intval($data['count1']) : 0; 
$count2 = isset($data['count2']) ? intval($data['count2']) : 0; 
$count3 = isset($data['count3']) ? intval($data['count3']) : 0; 
$shippingMethod = isset($data['shippingMethod']) ? $data['shippingMethod'] : "Unknown";
$subtotal = isset($data['subtotal']) ? floatval($data['subtotal']) : 0;
$total = isset($data['total']) ? floatval($data['total']) : 0;
$name = isset($data['name']) ? $data['name'] : "";
$number = isset($data['number']) ? $data['number'] : "";
$address = isset($data['address']) ? $data['address'] : "";

if (empty($name) || empty($number) || empty($address)) {
    echo json_encode(["status" => "error", "message" => "Field 'name', 'number', dan 'address' harus diisi!"]);
    $conn->close();
    exit();
}
// Menyimpan data ke tabel checkouts
$sql_checkout = "INSERT INTO checkouts (count1, count2, count3, shippingMethod, subtotal, total, name, number, address)
                 VALUES ('$count1', '$count2', '$count3', '$shippingMethod', '$subtotal', '$total', '$name', '$number', '$address')";

if ($conn->query($sql_checkout) === TRUE) {
    // Reset auto-increment untuk memastikan ID berurutan
    $result = $conn->query("SELECT MAX(id) AS max_id FROM checkouts");
    $row = $result->fetch_assoc();
    $last_id = $row['max_id'] ?? 0;
    
    // Atur ulang auto-increment ke nilai terakhir + 1
    $new_auto_increment = $last_id + 1;
    $conn->query("ALTER TABLE checkouts AUTO_INCREMENT = $new_auto_increment");

    // Berikan respon sukses
    echo json_encode(["status" => "success", "message" => $last_id, "id" => $last_id]);
} else {
    // Berikan respon jika terjadi kesalahan pada query
    echo json_encode(["status" => "error", "message" => "Error saving checkout: " . $conn->error]);
}

$conn->close();  // Menutup koneksi database
?>

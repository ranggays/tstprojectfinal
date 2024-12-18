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
$name = isset($data['name']) ? trim($data['name']) : "";
$number = isset($data['number']) ? trim($data['number']) : "";
$address = isset($data['address']) ? trim($data['address']) : "";
// $product_name = isset($data['product_name']) ? trim($data['product_name']) : "";
// $product_description = isset($data['product_description']) ? trim($data['product_description']) : "";

$product_names = [];
$product_descriptions = [];

// Loop melalui data untuk mengambil semua nama dan deskripsi produk
foreach ($data as $key => $value) {
    if (strpos($key, 'product_name') === 0) { // Cek apakah kunci diawali dengan 'productName'
        $product_names[] = trim($value);
    }
    if (strpos($key, 'product_description') === 0) { // Cek apakah kunci diawali dengan 'productDescription'
        $product_descriptions[] = trim($value);
    }
}

// Gabungkan nama dan deskripsi menjadi string
$product_name = implode(", ", $product_names);
$product_description = implode(". ", $product_descriptions);

// Validasi: Cek apakah field penting kosong
if (empty($name) || empty($number) || empty($address) || empty($product_name) || empty($product_description)) {
    echo json_encode(["status" => "error", "message" => "Data tidak valid atau tidak lengkap!"]);
    $conn->close();
    exit();
}

// Menyimpan data ke tabel checkouts
$sql_checkout = "INSERT INTO checkouts_revision (count1, count2, count3, shippingMethod, subtotal, total, name, number, address, product_name, product_description)
                 VALUES ('$count1', '$count2', '$count3', '$shippingMethod', '$subtotal', '$total', '$name', '$number', '$address', '$product_name', '$product_description')";

if ($conn->query($sql_checkout) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Data berhasil disimpan!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error saving checkout: " . $conn->error]);
}

$conn->close();
?>

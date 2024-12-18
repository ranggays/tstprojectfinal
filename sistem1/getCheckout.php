<?php
include('db_connection.php');  // Menyertakan file koneksi database

// Membaca data JSON dari body request
$data = json_decode(file_get_contents('php://input'), true);

// Pastikan data yang diterima lengkap
if (isset($data['count1'], $data['count2'], $data['count3'], $data['shippingMethod'], $data['subtotal'], $data['total'], $data['name'], $data['number'], $data['address'])) {
    // Ambil data dari JSON
    $count1 = $data['count1'];
    $count2 = $data['count2'];
    $count3 = $data['count3'];
    $shippingMethod = $data['shippingMethod'];
    $subtotal = $data['subtotal'];
    $total = $data['total'];
    $name = $data['name'];
    $number = $data['number'];
    $address = $data['address'];

    // Menyimpan data ke tabel checkouts
    $sql_checkout = "INSERT INTO checkouts (count1, count2, count3, shippingMethod, subtotal, total, name, number, address)
                     VALUES ('$count1', '$count2', '$count3', '$shippingMethod', '$subtotal', '$total', '$name', '$number', '$address')";

    if ($conn->query($sql_checkout) === TRUE) {
        $checkout_id = $conn->insert_id;  // Mendapatkan ID checkout yang baru disimpan

        // Jika ada data cart_items yang diterima, simpan ke tabel cart_items
        // Pastikan Anda mengirimkan data cart_items yang diperlukan dari JavaScript sebelumnya
        // $cart_items = $data['cart_items'];  // Pastikan data cart_items dikirim dari JavaScript

        // Menyimpan data ke tabel cart_items
        if (isset($data['cart_items'])) {
            $cart_items = $data['cart_items'];  // Format: array('product_id' => 1, 'quantity' => 2, 'total_price' => 20.00)
            
            foreach ($cart_items as $item) {
                $product_id = $item['product_id'];
                $quantity = $item['quantity'];
                $total_price = $item['total_price'];

                // Menyimpan data ke tabel cart_items
                $sql_cart_item = "INSERT INTO cart_items (checkout_id, product_id, quantity, total_price)
                                  VALUES ('$checkout_id', '$product_id', '$quantity', '$total_price')";
                
                if (!$conn->query($sql_cart_item)) {
                    echo json_encode(["status" => "error", "message" => "Error saving cart item: " . $conn->error]);
                    exit;
                }
            }
        }

        // Berikan respon sukses
        echo json_encode(["status" => "success", "message" => "Data berhasil disimpan!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error saving checkout: " . $conn->error]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Missing data in the request."]);
}

$conn->close();  // Menutup koneksi database
?>

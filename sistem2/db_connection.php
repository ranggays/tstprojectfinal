<?php
// Koneksi ke database sistem1_db
$servername = "localhost";
$username = "root"; // Ganti dengan username Anda
$password = ""; // Ganti dengan password Anda
$dbname = "sistem1_db"; // Ganti dengan nama database Anda

// Koneksi ke sistem1_db
$conn1 = new mysqli($servername, $username, $password, $dbname, 3306);

// Cek koneksi ke sistem1_db
if ($conn1->connect_error) {
    die("Koneksi gagal ke sistem1_db: " . $conn1->connect_error);
}

// Koneksi ke database sistem2_db
$dbname2 = "sistem2_db"; // Ganti dengan nama database sistem2_db
$conn2 = new mysqli($servername, $username, $password, $dbname2, 3306);

// Cek koneksi ke sistem2_db
if ($conn2->connect_error) {
    die("Koneksi gagal ke sistem2_db: " . $conn2->connect_error);
}

// Fungsi untuk generate nomor resi menggunakan layanan SOAP
function generateResi($checkoutId) {
    // URL WSDL
    $wsdl = 'http://localhost/sistem2/servers/server.php?wsdl';

    // Membuat client SOAP
    $client = new SoapClient($wsdl, array('trace' => 1));

    // Membuat parameter untuk request SOAP
    $params = array('checkoutId' => $checkoutId);

    try {
        // Memanggil method SOAP
        $response = $client->__soapCall('generateResi', array($params));

        // Menampilkan nomor resi yang diterima
        if (is_string($response)) {
            return $response; // Jika respons adalah string
        } elseif (is_object($response) && isset($response->return)) {
            return $response->return; // Jika respons adalah objek dan ada properti 'return'
        } else {
            return "Error: Respons tidak sesuai format.";
        }
    } catch (SoapFault $fault) {
        return "Error: " . $fault->getMessage();
    }
}

// Query untuk mengambil semua data dari tabel checkouts di sistem1_db
$sql1 = "SELECT id, count1, count2, count3, shippingMethod, subtotal, total, name, number, address FROM checkouts";
$result1 = $conn1->query($sql1);

if ($result1->num_rows > 0) {
    // Persiapkan statement untuk insert ke sistem2_db
    $sql2 = "INSERT INTO resi (id, count1, count2, count3, shippingMethod, subtotal, total, name, number, address, no_resi) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt2 = $conn2->prepare($sql2);

    if ($stmt2 === false) {
        die("Error preparing statement: " . $conn2->error);
    }

    // Loop untuk setiap data checkout dan proses insert ke sistem2_db
    while ($row = $result1->fetch_assoc()) {
        // Ambil data dari tabel checkouts di sistem1_db
        $id = $row['id'];
        $count1 = $row['count1'];
        $count2 = $row['count2'];
        $count3 = $row['count3'];
        $shippingMethod = $row['shippingMethod'];
        $subtotal = $row['subtotal'];
        $total = $row['total'];
        $name = $row['name'];
        $number = $row['number'];
        $address = $row['address'];

        // Periksa apakah id valid (bukan NULL atau kosong)
        if ($id === NULL || $id === '') {
            echo "ID invalid untuk checkout dengan count1: $count1. Melewati data ini.<br>";
            continue; // Lewati baris ini jika id tidak valid
        }

        // Generate nomor resi
        $resi = generateResi($id);

        // Bind parameter (pastikan tipe data dan jumlahnya sesuai dengan kolom tabel di sistem2_db)
        $stmt2->bind_param(
            'iiiisddssss', // Format tipe data yang sesuai dengan parameter
            $id,            // ID checkout (bigint)
            $count1,        // count1 (int)
            $count2,        // count2 (int)
            $count3,        // count3 (int)
            $shippingMethod, // shippingMethod (varchar)
            $subtotal,      // subtotal (decimal)
            $total,         // total (decimal)
            $name,          // name (varchar)
            $number,        // number (varchar)
            $address,       // address (text)
            $resi           // no_resi (varchar)
        );

        // Menjalankan statement
        if (!$stmt2->execute()) {
            echo "Error: " . $stmt2->error . "<br>";
        } else {
            echo "Data berhasil dimasukkan untuk checkout ID: $id - Resi: $resi<br>";
        }
    }

    // Menutup statement setelah loop selesai
    $stmt2->close();
} else {
    echo "Tidak ada data checkout yang ditemukan.<br>";
}

// Menutup koneksi ke database
$conn1->close();
$conn2->close();
?>

<?php
// Koneksi ke database sistem1_db
$servername = "localhost";
$username = "root"; // Ganti dengan username Anda
$password = ""; // Ganti dengan password Anda
$dbname = "sistem1_db"; // Ganti dengan nama database Anda

// Koneksi ke sistem1_db
$conn1 = new mysqli($servername, $username, $password, $dbname, 3308);

// Cek koneksi ke sistem1_db
if ($conn1->connect_error) {
    die("Koneksi gagal ke sistem1_db: " . $conn1->connect_error);
}

// Koneksi ke database sistem2_db
$dbname2 = "sistem2_db"; // Ganti dengan nama database sistem2_db
$conn2 = new mysqli($servername, $username, $password, $dbname2, 3308);

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission
    $id = $_POST['id'];
    $action = $_POST['action'];

    // Ambil data dari sistem1_db berdasarkan id yang dimasukkan
    $sql1 = "SELECT id, count1, count2, count3, shippingMethod, subtotal, total, name, number, address FROM checkouts WHERE id = ?";
    $stmt1 = $conn1->prepare($sql1);
    $stmt1->bind_param('i', $id);
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    if ($result1->num_rows > 0) {
        $row = $result1->fetch_assoc();

        // Ambil data checkout
        $count1 = $row['count1'];
        $count2 = $row['count2'];
        $count3 = $row['count3'];
        $shippingMethod = $row['shippingMethod'];
        $subtotal = $row['subtotal'];
        $total = $row['total'];
        $name = $row['name'];
        $number = $row['number'];
        $address = $row['address'];

        // Generate nomor resi
        $resi = generateResi($id);

        if ($action == 'save') {
            // Simpan data ke sistem2_db
            $sql2 = "INSERT INTO resi (id, count1, count2, count3, shippingMethod, subtotal, total, name, number, address, no_resi) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt2 = $conn2->prepare($sql2);
            $stmt2->bind_param(
                'iiiisddssss', // Format tipe data yang sesuai dengan parameter
                $id, $count1, $count2, $count3, $shippingMethod, $subtotal, $total, $name, $number, $address, $resi
            );
            if ($stmt2->execute()) {
                echo "Data berhasil disimpan dengan nomor resi: $resi";
            } else {
                echo "Error: " . $stmt2->error;
            }
        } elseif ($action == 'random') {
            // Acak nomor resi dan tampilkan
            $randomResi = 'RESI' . strtoupper(bin2hex(random_bytes(6))); // Menghasilkan nomor acak
            echo "Nomor resi acak: $randomResi";
        }
    } else {
        echo "ID tidak ditemukan di database.";
    }

    $stmt1->close();
}

// Menutup koneksi ke database
$conn1->close();
$conn2->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Nomor Resi</title>
</head>
<body>
    <h2>Generate Nomor Resi</h2>
    <form method="POST">
        <label for="id">Masukkan ID Checkout:</label>
        <input type="number" id="id" name="id" required>
        <br><br>
        
        <button type="submit">Generate Nomor Resi</button>
        
        <br><br>
        
        <!-- Jika nomor resi telah di-generate, beri pilihan simpan atau acak -->
        <?php if (isset($resi) || isset($randomResi)): ?>
            <p>Nomor Resi: <?php echo isset($resi) ? $resi : $randomResi; ?></p>
            <label for="action">Pilih aksi:</label>
            <select name="action" id="action">
                <option value="save">Simpan</option>
                <option value="random">Acak</option>
            </select>
            <br><br>
            <button type="submit">Pilih</button>
        <?php endif; ?>
    </form>
</body>
</html>

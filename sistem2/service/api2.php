<?php

require_once __DIR__ . '/../servers/TrackingService.php';

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$path = str_replace('/sistem2/service/api2.php', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$path = trim($path, '/');

// Memecah path untuk mendukung parameter tambahan
$pathParts = explode('/', $path);

// Debugging: Cek endpoint yang tidak valid
if (!in_array($pathParts[0], ['tracking'])) {
    echo json_encode(["debug_method" => $method, "debug_path" => $path]);
    exit;
}

$trackingService = new TrackingService();

// POST: Mengecek status tracking berdasarkan orderId atau no_resi
if ($method === 'POST' && $pathParts[0] === 'tracking' && $pathParts[1] === 'check') {
    // Periksa apakah data dikirim melalui form
    $identifier = $_POST['id'] ?? null;

    if ($identifier) {
        $trackingStatus = $trackingService->getTrackingStatus($identifier);
        // Tampilkan hasil untuk browser dalam format JSON
        echo json_encode($trackingStatus, JSON_PRETTY_PRINT);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "ID Checkout is required"]);
    }
}


// GET: Mengambil semua data tracking atau data berdasarkan no_resi
elseif ($method === 'GET' && $pathParts[0] === 'tracking' && $pathParts[1] === 'list') {
    if (isset($pathParts[2])) {
        // Mendapatkan data berdasarkan no_resi
        $noResi = $pathParts[2];
        $trackingStatus = $trackingService->getTrackingStatus($noResi);
        echo json_encode($trackingStatus);
    } else {
        // Mendapatkan semua data
        $allTracking = $trackingService->getAllTracking();
        echo json_encode($allTracking);
    }
}

// PUT: Memperbarui status tracking berdasarkan orderId dari URL atau body
elseif ($method === 'PUT' && $pathParts[0] === 'tracking' && $pathParts[1] === 'update') {
    $identifier = $pathParts[2] ?? null; // ID dari URL jika tersedia

    if ($identifier) {
        $input = json_decode(file_get_contents("php://input"), true);
        $data = $input['data'] ?? null;

        if ($data) {
            $updated = $trackingService->updateTrackingStatus($identifier, $data);
            if ($updated) {
                echo json_encode(["success" => true, "message" => "Order updated successfully"]);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Order ID or Resi Number not found"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Invalid data"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Order ID or Resi Number is required"]);
    }
}

// Endpoint tidak ditemukan
else {
    http_response_code(404);
    echo json_encode(["error" => "Endpoint not found"]);
}

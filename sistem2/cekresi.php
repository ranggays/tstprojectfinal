<?php
try {
    require __DIR__ . '/service/ResiService.php';

    if (!class_exists('ResiService')) {
        throw new Exception('Class ResiService tidak ditemukan!');
    }

    $service = new ResiService();
    echo $service->generateResi("asd");
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

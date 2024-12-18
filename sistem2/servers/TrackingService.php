<?php

require_once('Database.php');

class TrackingService {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getTrackingStatus($identifier) {
        $query = "SELECT id AS orderId, no_resi, shippingMethod, status 
                  FROM resi 
                  WHERE id = :identifier OR no_resi = :identifier";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':identifier' , $identifier);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (isset($result['orderId'])) {

                // if (empty($result['status'])) {
                    //     $result['status'] = $this->generateRandomStatus();
                    //     $this->updateTrackingStatus($result['orderId'], ['status' => $result['status']]);
                    // }
                    // $randomStatus = $this->generateRandomStatus();
                    // $this->updateTrackingStatus($result['orderId'], $randomStatus);
                    // $result['status'] = $randomStatus;
                    $result['location'] = $this->generateRandomCity();
                    $result['estimated_delivery'] = $this->generateRandomDate();
                    return $result;
            } else {
                return [
                    "error" => "no valid ID Found in the result"
                ];
            }
        } else {
            return [
                "error" => "Data not found"
            ];
        }
    }

    // public function updateTrackingStatus($identifier, $data) {
    //     $query = "UPDATE resi
    //               SET status = :status
    //               WHERE id = :identifier OR no_resi = :identifier";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bindParam(':status', $data);
    //     $stmt->bindParam(':identifier', $identifier);

    //     return $stmt->execute();
    // }

    public function updateTrackingStatus($identifier, $data) {
        // Pastikan data adalah string
        if (is_array($data)) {
            $data = $data['status'] ?? 'Unknown Status'; // Ambil nilai 'status' dari array atau gunakan default
        }
    
        $query = "UPDATE resi
                  SET status = :status
                  WHERE id = :identifier OR no_resi = :identifier";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $data, PDO::PARAM_STR);
        $stmt->bindParam(':identifier', $identifier);
    
        return $stmt->execute();
    }
    

    private function generateRandomCity() {
        $cities = ["Jakarta", "Surabaya", "Bandung", "Yogyakarta", "Medan", "Makassar", "Malang", "Semarang", "Denpasar", "Balikpapan"];
        return $cities[array_rand($cities)];
    }

    private function generateRandomStatus() {
        $statuses = ["In Transit", "Delivered", "Processing"];
        
        if(is_array($statuses) && !empty($statuses)){
            return $statuses[array_rand($statuses)];
        }

        return "Unknown Status";

    }

    private function generateRandomDate() {
        // Menghasilkan tanggal acak di bulan Desember 2024
        $day = rand(1, 31); // Menghasilkan angka acak antara 1 dan 31
        return "2024-12-" . str_pad($day, 2, "0", STR_PAD_LEFT); // Formatkan menjadi YYYY-MM-DD
    }

    public function getAllTracking() {
        $query = "SELECT id AS orderId, no_resi, shippingMethod, status FROM resi";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($results as &$result) {
            $result['location'] = $this->generateRandomCity(); // Tambahkan lokasi secara dinamis
            $result['location'] = $this->generateRandomCity(); // Tambahkan lokasi secara dinamis
        }
    
        return $results;
    }
    
    
    
    
}

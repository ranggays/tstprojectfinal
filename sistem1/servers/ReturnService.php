<?php

require_once('Database.php');

class ReturnService{
    private $conn;

    public function __construct(){
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getResiDetails($identifier){
        $query = "SELECT id AS orderId, no_resi, shippingMethod, status
                 FROM resi
                 WHERE id = :identifier OR no_resi = :identifier";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':identifier', $identifier);
        $stmt->execute();

        if ($stmt->rowCount() > 0){
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } else {
            return [
                "error" => "Data Not Found" 
            ];
        }
    }

    public function createReturnRequest($orderId = null, $noResi = null) {
        $query = "SELECT * FROM resi WHERE id = :orderId OR no_resi = :noResi";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':orderId', $orderId);
        $stmt->bindParam(':noResi', $noResi);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Simulate return processing
            return ["success" => true, "message" => "Return request is being processed"];
        } else {
            return ["error" => "No matching records found for return request"];
        }
    }
}
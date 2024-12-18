<?php
class ResiService {

    protected $resiNumber = null;

    /**
     * Generate nomor resi berdasarkan checkout ID.
     * @param int $checkoutId
     * @return string
     */
    public function generateResi($checkoutId) {
        if (!is_numeric($checkoutId)) {
            return "ID checkout tidak valid.";
        }

        // Generate nomor resi unik
        $resiNumber = "RESI" . str_pad($checkoutId, 6, "0", STR_PAD_LEFT) . strtoupper(bin2hex(random_bytes(3)));
        return $resiNumber;
    }
}
?>

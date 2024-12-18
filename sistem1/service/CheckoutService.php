<?php
class CheckoutService {
    
    protected $shippingMethod = null;

    /**
     * Mengatur metode pengiriman untuk checkout.
     * @param string $shippingMethod
     * @return string
     */
    public function setShippingMethod($shippingMethod) {
        $allowedMethods = ['Same-Day', 'Express', 'Longer'];
        if (!in_array($shippingMethod, $allowedMethods)) {
            return "Metode pengiriman tidak valid.";
        }
        $this->shippingMethod = $shippingMethod;
        return "Metode pengiriman telah diatur ke " . $shippingMethod;
    }

}?>

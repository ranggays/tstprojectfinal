<?php

require __DIR__ . '/../service/CheckoutService.php';

$wsdlPath = __DIR__ . '/../service/checkoutservice.wsdl';
$server = new SoapServer($wsdlPath);
$server ->setClass('CheckoutService');
$server ->handle();

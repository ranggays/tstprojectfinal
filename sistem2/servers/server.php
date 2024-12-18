<?php

require __DIR__ . '/../service/ResiService.php';

$wsdlPath = __DIR__ . '/../service/resiservice.wsdl';
$server = new SoapServer($wsdlPath);
$server ->setClass('ResiService');
$server ->handle();

<?php

require __DIR__ . '/../vendor/autoload.php';

require "CheckoutService.php";

$gen = new \PHP2WSDL\PHPClass2WSDL("CheckoutService",
    "http://localhost/sistem1/servers/server.php");

$gen->generateWSDL();
file_put_contents("checkoutservice.wsdl", $gen->dump());
echo "Done!";
<?php

require __DIR__ . '/../vendor/autoload.php';

require "ResiService.php";

$gen = new \PHP2WSDL\PHPClass2WSDL("ResiService",
    "http://localhost/sistem2/servers/server.php");

$gen->generateWSDL();
file_put_contents("resiservice.wsdl", $gen->dump());
echo "Done!";
<?php

$identifier = $_POST['identifier'];
$action = $_POST['action'];

$apiUrl = "http://localhost/sistem1/service/api.php/returns/";

if ($action === "check") {
    $url = $apiUrl . "check/" . $identifier;
    $response = file_get_contents($url);
    echo "<pre>Response from API (Check): " . htmlspecialchars($response) . "</pre>";
} elseif ($action === "create") {
    $url = $apiUrl . "create";
    $data = json_encode(["orderId" => $identifier]); // Use "no_resi" instead if needed
    $options = [
        "http" => [
            "header" => "Content-Type: application/json",
            "method" => "POST",
            "content" => $data,
        ],
    ];
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    echo "<pre>Response from API (Create): " . htmlspecialchars($response) . "</pre>";
}

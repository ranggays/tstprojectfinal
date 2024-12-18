<?php

require_once __DIR__ . '/../servers/ReturnService.php';

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$path = str_replace('/sistem1/service/api.php', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$path = trim($path, '/');

$pathParts = explode('/', $path);

if (!in_array($pathParts[0], ['tracking', 'returns'])) {
    echo json_encode(["debug_method" => $method, "debug_path" => $path]);
    exit;
}

$returnService = new ReturnService();

if ($method === 'GET' && $pathParts[0] === 'returns' && $pathParts[1] === 'check') {
    $identifier = $pathParts[2] ?? null;
    if ($identifier) {
        $data = $returnService->getResiDetails($identifier);
        echo json_encode($data);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Identifier (Order ID or Resi Number) is required"]);
    }
}

// POST: Create return request
elseif ($method === 'POST' && $pathParts[0] === 'returns' && $pathParts[1] === 'create') {
    $input = json_decode(file_get_contents("php://input"), true);
    $orderId = $input['orderId'] ?? null;
    $noResi = $input['no_resi'] ?? null;

    if (!$orderId && !$noResi) {
        http_response_code(400);
        echo json_encode(["error" => "Either Order ID or Resi Number is required"]);
        exit;
    }

    $result = $returnService->createReturnRequest($orderId, $noResi);
    echo json_encode($result);
}

// Endpoint not found
else {
    http_response_code(404);
    echo json_encode(["error" => "Endpoint not found"]);
}
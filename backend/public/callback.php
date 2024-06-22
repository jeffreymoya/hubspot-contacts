<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../common/bootstrap.php';

use App\Config;
use App\HubspotClient;
use App\ResponseHandler;
use App\ServiceProvider;

$service = ServiceProvider::getInstance();
$response = $service->get(ResponseHandler::class);
$config = $service->get(Config::class);
$client = $service->get(HubspotClient::class);
$session = $service->get(\App\SessionHandler::class);
$code_regex = "/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$/";


$code = $_GET['code'] ?? null;

if (!isset($code) || !preg_match($code_regex, $code)) {
    $response->sendErrorResponse('No code provided');
}

$tokenData = $client->getAccessToken($code);

try {

    $session->createSession($tokenData);

    $response->sendRedirect($config->getFrontendUrl());
} catch (Exception $e) {
    $response->sendErrorResponse($e->getMessage());
}


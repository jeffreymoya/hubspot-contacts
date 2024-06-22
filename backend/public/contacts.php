<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../common/bootstrap.php';

use App\DbHandler;
use App\ResponseHandler;
use App\ServiceProvider;

$provider = ServiceProvider::getInstance();
$response = $provider->get(ResponseHandler::class);

$provider->get(\App\SessionHandler::class)->validateSession();

$page = $_GET['pageNumber'] ?? 1;
$minDate = $_GET['minDate'] ?? null;
$maxDate = $_GET['maxDate'] ?? null;

$page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 1;
$minDate = isset($_GET['startDate']) ? htmlspecialchars($_GET['startDate']) : null;
$maxDate = isset($_GET['endDate']) ? htmlspecialchars($_GET['endDate']) : null;

$data = $provider->get(DbHandler::class)->getContacts($page, $minDate, $maxDate);
$response->sendJsonResponse($data);

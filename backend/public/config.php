<?php

use App\Config;
use App\DbHandler;
use App\ResponseHandler;
use App\ServiceProvider;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../common/bootstrap.php';

$provider = ServiceProvider::getInstance();
$config = $provider->get(Config::class);
$db = $provider->get(DbHandler::class);

$clientId = $config->getHubspotClientId();
$redirectUrl = $config->getHubspotRedirectUri();
$authUrl = $config->getHubspotAuthUrl();
$scope = $config->getTokenScope();

$hubspotAppUrl = "{$authUrl}?client_id={$clientId}&redirect_uri={$redirectUrl}&scope={$scope}";

$dbstats = $db->getStatsFromDatabase();

$provider->get(ResponseHandler::class)->sendJsonResponse(['hubspotAppUrl' => $hubspotAppUrl, 'contacts' => $dbstats]);

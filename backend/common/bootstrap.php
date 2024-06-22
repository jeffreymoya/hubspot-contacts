<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Config;
use App\CorsHandler;
use App\DbHandler;
use App\HubspotClient;
use App\ResponseHandler;
use App\ServiceProvider;
use App\SessionHandler;
use GuzzleHttp\Client;

$provider = ServiceProvider::getInstance();

$provider->set(Client::class, fn($c) => new Client(['verify' => false]));
$provider->set(Config::class, fn($c) => new Config());
$provider->set(HubspotClient::class, fn($c) => new HubspotClient($provider->get(Client::class), $provider->get(Config::class)));
$provider->set(ResponseHandler::class, fn($c) => new ResponseHandler());
$provider->set(SessionHandler::class, fn($c) => new SessionHandler(ServiceProvider::getInstance()->get(ResponseHandler::class)));
$provider->set(CorsHandler::class, fn($c) => new CorsHandler());
$provider->set(DbHandler::class, fn($c) => new DbHandler($provider->get(Config::class)->getSqliteDb()));

<?php
namespace App;
use App\ServiceProvider;

class CorsHandler {
    private \App\ServiceProvider $provider;
    private array $allowedOrigins;

    public function __construct() {
        $this->provider = ServiceProvider::getInstance();
        $this->allowedOrigins = [$this->provider->get(Config::class)->getFrontendUrl()];
    }

    public function handleCors(): void {
        if (!isset($_SERVER['HTTP_ORIGIN']) || !in_array($_SERVER['HTTP_ORIGIN'], $this->allowedOrigins)) {
            header('HTTP/1.1 403 Forbidden');
            exit;
        }

        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit(0);
        }
    }
}
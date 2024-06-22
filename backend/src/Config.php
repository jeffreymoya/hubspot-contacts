<?php
namespace App;
use Dotenv\Dotenv;

/**
 * Class Config
 *
 * This class is responsible for managing the configuration of the application.
 * It uses the Dotenv package to load environment variables from a .env file.
 */
class Config {

    private array $envVars;

    /**
     * @throws ConfigException
     */
    public function __construct() {
        $this->loadEnvVars();
        $this->validateEnvVars();
    }

    private function loadEnvVars(): void {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $this->envVars = $dotenv->load();
    }

    private function validateEnvVars(): void {
        $reflection = new \ReflectionClass(EnvVars::class);
        $envVars = $reflection->getConstants();

        foreach ($envVars as $envVar) {
            if (!isset($this->envVars[$envVar])) {
                throw new ConfigException("Environment variable {$envVar} is not set.");
            }
        }
    }

    public function getHubspotClientId(): string {
        return $this->envVars[EnvVars::HUBSPOT_CLIENT_ID];
    }

    public function getHubspotClientSecret(): string {
        return $this->envVars[EnvVars::HUBSPOT_CLIENT_SECRET];
    }

    public function getHubspotRedirectUri(): string {
        return $this->envVars[EnvVars::HUBSPOT_REDIRECT_URI];
    }

    public function getHubspotAuthUrl(): string {
        return $this->envVars[EnvVars::HUBSPOT_AUTH_URL];
    }

    public function getHubspotTokenUrl(): string {
        return $this->envVars[EnvVars::HUBSPOT_TOKEN_URL];
    }

    public function getHubspotContactsUrl(): string {
        return $this->envVars[EnvVars::HUBSPOT_CONTACTS_URL];
    }

    public function getFrontendUrl(): string {
        return $this->envVars[EnvVars::FRONTEND_URL];
    }

    public function getTokenScope(): string {
        return $this->envVars[EnvVars::HUBSPOT_TOKEN_SCOPE];
    }

    public function getSqliteDb(): string {
        return $this->envVars[EnvVars::SQLITE_DB];
    }

    public function getPageSize(): string {
        return $this->envVars[EnvVars::PAGE_SIZE];
    }
}

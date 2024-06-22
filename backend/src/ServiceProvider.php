<?php
namespace App;

use InvalidArgumentException;

/**
 * Class ServiceProvider
 *
 * This class is a service provider that manages services in the application.
 * It follows the singleton pattern to ensure only one instance of the service provider exists.
 * It provides methods to set, get, and check the existence of services.
 */
class ServiceProvider {
    private static ?ServiceProvider $instance = null;
    private array $definitions = [];
    private array $instances = [];

    private function __construct() {
        // Private constructor to prevent direct instantiation
    }

    public static function getInstance(): ServiceProvider {
        if (self::$instance === null) {
            self::$instance = new ServiceProvider();
        }
        return self::$instance;
    }

    /**
     * Sets a service definition.
     *
     * @param string $name The name of the service.
     * @param callable $definition The callable that defines how to create the service.
     */
    public function set(string $name, callable $definition): void {
        $this->definitions[$name] = $definition;
    }

    /**
     * Gets a service.
     *
     * If the service has been instantiated before, it returns the existing instance.
     * Otherwise, it creates a new instance of the service using the definition, stores it, and returns it.
     *
     * @param string $name The name of the service.
     * @return mixed The service instance.
     * @throws InvalidArgumentException If the service is not defined.
     */
    public function get(string $name) {
        if (isset($this->instances[$name])) {
            return $this->instances[$name];
        }

        if (!isset($this->definitions[$name])) {
            throw new InvalidArgumentException("Service {$name} not found.");
        }

        $this->instances[$name] = $this->definitions[$name]($this);
        return $this->instances[$name];
    }

    public function has(string $name): bool {
        return isset($this->definitions[$name]);
    }
}

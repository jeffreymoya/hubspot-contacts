<?php
namespace App;

/**
 * Class ResponseHandler
 *
 * This class is responsible for handling HTTP responses.
 * It provides methods to send JSON responses, error responses, and redirects.
 */
class ResponseHandler {
    /**
     * Sends a JSON response.
     *
     * @param mixed $data The data to send in the response.
     * @param int $statusCode The HTTP status code. Defaults to 200.
     */
    public function sendJsonResponse($data, $statusCode = 200): void {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        error_log(json_encode($data));
        echo json_encode($data);
        exit;
    }

    /**
     * Sends an error response.
     *
     * @param string $error The error message to send in the response.
     * @param int $statusCode The HTTP status code. Defaults to 400.
     */
    public function sendErrorResponse($error, $statusCode = 400): void {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        error_log($error);
        echo json_encode(['error' => $error]);
        exit;
    }

    /**
     * Sends a redirect response.
     *
     * @param string $url The URL to redirect to.
     */
    public function sendRedirect($url): void {
        header("Location: $url");
        exit;
    }
}

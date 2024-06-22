<?php
namespace App;

use Random\RandomException;

/**
 * Class SessionHandler
 *
 * This class is responsible for handling session operations.
 */
class SessionHandler
{
    const SESSION_TOKENS_JSON = '../session_tokens.json';
    const TOKENS_JSON = '../tokens.json';
    const SESSION_TOKEN = 'session_token';
    private \App\ResponseHandler $response;

    public function __construct(ResponseHandler $response)
    {
        $this->response = $response;
    }

    /**
     * Validates the session.
     *
     * If the session token is not set or is invalid, it sends an error response.
     */
    public function validateSession()
    {
        if (!isset($_COOKIE[self::SESSION_TOKEN])) {
            $this->response->sendErrorResponse('No session token available', 401);
        }

        $sessionToken = $_COOKIE[self::SESSION_TOKEN];
        $storedTokens = $this->getStoredTokens();

        if (!isset($storedTokens[$sessionToken])) {
            $this->response->sendErrorResponse('Invalid session token', 401);
        }
    }

    /**
     * Retrieves the stored tokens.
     *
     * @param string $tokensFile The path to the tokens file. Defaults to the session tokens JSON file.
     * @return array The stored tokens.
     */
    private function getStoredTokens($tokensFile = self::SESSION_TOKENS_JSON)
    {
        if (!file_exists($tokensFile) || !is_readable($tokensFile)) {
            $this->response->sendErrorResponse('Unable to read session tokens', 500);
        }

        return json_decode(file_get_contents($tokensFile), true);
    }

    /**
     * Creates a session.
     *
     * @param array $tokens The tokens to store in the session.
     * @throws RandomException
     */
    public function createSession(array $tokens): void {
        // file_put_contents(self::TOKENS_JSON, json_encode($tokens));

        $sessionToken = bin2hex(random_bytes(32));
        file_put_contents(self::SESSION_TOKENS_JSON, json_encode([$sessionToken => $tokens]), LOCK_EX);

        setcookie(self::SESSION_TOKEN, $sessionToken, [
            'expires' => time() + 900, // 5 minutes
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict',
        ]);
    }
}

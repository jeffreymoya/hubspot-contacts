<?php
namespace App;
use GuzzleHttp\Client;

/**
 * @deprecated This file is deprecated by hubspot_sync job
 */
class HubspotClient {
    public function __construct(
        private readonly Client $client,
        private readonly Config $config
    ) {}

    public function getAuthUrl(): string {
        return $this->config->getHubspotAuthUrl() . '?' . http_build_query([
                'client_id' => $this->config->getHubspotClientId(),
                'redirect_uri' => $this->config->getHubspotRedirectUri(),
                'scope' => 'contacts',
                'response_type' => 'code'
            ]);
    }

    public function getAccessToken(string $code): array {
        $response = $this->client->post($this->config->getHubspotTokenUrl(), [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => $this->config->getHubspotClientId(),
                'client_secret' => $this->config->getHubspotClientSecret(),
                'redirect_uri' => $this->config->getHubspotRedirectUri(),
                'code' => $code,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function fetchContacts(string $accessToken, int $limit): array {
        $url = $this->config->getHubspotContactsUrl() . '?' . http_build_query(['limit' => $limit]);

        $response = $this->client->get($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ],
        ]);
        $body = json_decode($response->getBody(), true);
        $contacts = [];

        foreach ($body['results'] as $contactData) {
            $contacts[] = Contact::fromResponse($contactData);
        }

        return $contacts;
    }
}

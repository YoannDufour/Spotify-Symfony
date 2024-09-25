<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AuthSpotifyService
{
    private string $clientId;
    private string $clientSecret;
    private HttpClientInterface $httpClient;
    private RequestStack $requestStack;

    public function __construct(HttpClientInterface $httpClient, RequestStack $requestStack, string $clientId, string $clientSecret)
    {
        $this->httpClient = $httpClient;
        $this->requestStack = $requestStack;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public function auth(): string
    {
        $newTokenNeeded = false;
        $session = $this->requestStack->getSession();
        if (!$session->has('token') || $session->get('expire') <= time()) {
            $newTokenNeeded = true;
        }

        if ($newTokenNeeded) {
            $response = $this->httpClient->request('POST', 'https://accounts.spotify.com/api/token', [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret),
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'body' => [
                    'grant_type' => 'client_credentials',
                ],
            ]);

            $data = $response->toArray();


            $session->set('token', $data['access_token']);
            $session->set('expire', time() + 3600);
            return $data['access_token'];
        } else {
            return $session->get('token');
        }
    }
}

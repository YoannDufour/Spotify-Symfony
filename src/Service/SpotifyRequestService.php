<?php

namespace App\Service;

use App\Entity\Track;
use App\Factory\TrackFactory;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Repository\TrackRepository;


readonly class SpotifyRequestService
{

    public function __construct(private readonly HttpClientInterface $httpClient,
                                private readonly TrackFactory        $trackFactory,)
    {}

    public function searchTracks(string $track, string $token): array
    {
        $response = $this->httpClient->request('GET', 'https://api.spotify.com/v1/search?query=' . $track . '&type=track&locale=fr-FR', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);
        return $this->trackFactory->createMultipleFromSpotifyData($response->toArray()['tracks']['items']);
    }

    public function getTrack(string $spotifyId,string $token): Track
    {
        $response = $this->httpClient->request('GET', 'https://api.spotify.com/v1/tracks/' . $spotifyId, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);
        return $this->trackFactory->createFromSpotifyData($response->toArray());
    }

    public function getRecommendations(string $spotifyId, string $token): array
    {
        $response = $this->httpClient->request('GET', 'https://api.spotify.com/v1/recommendations?seed_tracks=' . $spotifyId, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);
        return $this->trackFactory->createMultipleFromSpotifyData($response->toArray()['tracks']);

    }
}
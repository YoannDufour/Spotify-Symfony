<?php

namespace App\Controller;

use App\Factory\TrackFactory;
use App\Service\AuthSpotifyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TrackController extends AbstractController
{

    private string $token;


    public function __construct(private readonly AuthSpotifyService  $authSpotifyService,
                                private readonly HttpClientInterface $httpClient,
//                                private readonly TrackFactory         $trackFactory
    )
    {
        $this->token = $this->authSpotifyService->auth();
    }

    #[Route('/track', name: 'app_track_index')]
    public function index(): Response
    {
        // Make the GET request to the Spotify API with kazzey as the query and the token as the Authorization header
        $response = $this->httpClient->request('GET', 'https://api.spotify.com/v1/search?query=kazzey&type=track&locale=fr-FR', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
            ],
        ]);
// Examples of how you could do this
//        $tracks = $this->trackFactory->createMultipleFromSpotifyData($response->toArray()['tracks']['items']);

        return $this->render('track/index.html.twig', [
            'tracks' => $tracks,
        ]);
    }
}

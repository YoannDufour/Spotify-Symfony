<?php

namespace App\Controller;

use App\Entity\Track;
use App\Factory\TrackFactory;
use App\Repository\TrackRepository;
use App\Service\AuthSpotifyService;
use App\Service\SpotifyRequestService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TrackController extends AbstractController
{

    private string $token;


    public function __construct(private readonly AuthSpotifyService     $authSpotifyService,
                                private readonly HttpClientInterface    $httpClient,
                                private readonly EntityManagerInterface $entityManager,
                                private readonly SpotifyRequestService  $spotifyRequestService,
                                private readonly TrackRepository        $trackRepository,
    )
    {
        $this->token = $this->authSpotifyService->auth();
    }

    #[Route('/', name: 'app_track_index')]
    public function index(Request $request): Response
    {
        $search = (
            $request->query->all('search') === null ||
            $request->query->all('search') == []
        )
            ? "kazzey"
            : $request->query->all('search')['query'];

        return $this->render('track/index.html.twig', [
            'tracks' => $this->spotifyRequestService->searchTracks($search, $this->token),
            'search' => $search,
        ]);
    }

    #[Route('/track/favorite', name: 'app_track_favorite')]
    #[IsGranted('ROLE_USER')]
    public function favorite(): Response
    {
        return $this->render('track/favorite.html.twig', [
            'tracks' => $this->getUser()->getTracks(),
        ]);
    }

    #[Route('/track/{id}', name: 'app_track_show')]
    public function show(string $id): Response
    {
        return $this->render('track/show.html.twig', [
            'track' => $this->spotifyRequestService->getTrack($id, $this->token),
            'recommendations' => $this->spotifyRequestService->getRecommendations($id, $this->token),
        ]);
    }

    //include liked
    #[Route('/track/{id}/liked', name: 'app_track_liked')]
    public function like(string $id): Response
    {
        return $this->render('track/components/_like_listing.html.twig', [
            'track' => $this->trackRepository->findByUser($this->getUser())]);
    }

    //like
    #[Route('/track/{id}/like', name: 'app_track_like')]
    #[IsGranted('ROLE_USER')]
    public function likeTrack(string $id): Response
    {
        $track = $this->trackRepository->findOneBy(['spotifyId' => $id]);
        if ($track === null) {
            $track = $this->spotifyRequestService->getTrack($id, $this->token);
            $this->entityManager->persist($track);
            $this->entityManager->flush();
        } else {
            $this->entityManager->remove($track);
            $this->entityManager->flush();
            $track = null;
        }
        return $this->render('track/components/_like_listing.html.twig', [
            'track' => $track]);
    }
}

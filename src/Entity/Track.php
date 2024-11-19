<?php

namespace App\Entity;

use App\Repository\TrackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrackRepository::class)]
class Track
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $discNumber = null;

    #[ORM\Column(nullable: true)]
    private ?int $durationMs = null;

    #[ORM\Column(nullable: true)]
    private ?bool $explicit = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $isrc = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $spotifyUrl = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $href = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $spotifyId = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isLocal = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $popularity = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $previewUrl = null;

    #[ORM\Column(nullable: true)]
    private ?int $trackNumber = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $uri = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $pictureLink = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'tracks')]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiscNumber(): ?int
    {
        return $this->discNumber;
    }

    public function setDiscNumber(?int $discNumber): static
    {
        $this->discNumber = $discNumber;

        return $this;
    }

    public function getDurationMs(): ?int
    {
        return $this->durationMs;
    }

    public function setDurationMs(?int $durationMs): static
    {
        $this->durationMs = $durationMs;

        return $this;
    }

    public function isExplicit(): ?bool
    {
        return $this->explicit;
    }

    public function setExplicit(?bool $explicit): static
    {
        $this->explicit = $explicit;

        return $this;
    }

    public function getIsrc(): ?string
    {
        return $this->isrc;
    }

    public function setIsrc(?string $isrc): static
    {
        $this->isrc = $isrc;

        return $this;
    }

    public function getSpotifyUrl(): ?string
    {
        return $this->spotifyUrl;
    }

    public function setSpotifyUrl(string $spotifyUrl): static
    {
        $this->spotifyUrl = $spotifyUrl;

        return $this;
    }

    public function getHref(): ?string
    {
        return $this->href;
    }

    public function setHref(?string $href): static
    {
        $this->href = $href;

        return $this;
    }

    public function getSpotifyId(): ?string
    {
        return $this->spotifyId;
    }

    public function setSpotifyId(?string $spotifyId): static
    {
        $this->spotifyId = $spotifyId;

        return $this;
    }

    public function isLocal(): ?bool
    {
        return $this->isLocal;
    }

    public function setLocal(?bool $isLocal): static
    {
        $this->isLocal = $isLocal;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPopularity(): ?int
    {
        return $this->popularity;
    }

    public function setPopularity(?int $popularity): static
    {
        $this->popularity = $popularity;

        return $this;
    }

    public function getPreviewUrl(): ?string
    {
        return $this->previewUrl;
    }

    public function setPreviewUrl(?string $previewUrl): static
    {
        $this->previewUrl = $previewUrl;

        return $this;
    }

    public function getTrackNumber(): ?int
    {
        return $this->trackNumber;
    }

    public function setTrackNumber(?int $trackNumber): static
    {
        $this->trackNumber = $trackNumber;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getUri(): ?string
    {
        return $this->uri;
    }

    public function setUri(?string $uri): static
    {
        $this->uri = $uri;

        return $this;
    }

    public function getPictureLink(): ?string
    {
        return $this->pictureLink;
    }

    public function setPictureLink(?string $pictureLink): static
    {
        $this->pictureLink = $pictureLink;

        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->users->removeElement($user);

        return $this;
    }
}

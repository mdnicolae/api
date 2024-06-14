<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity]
#[ApiResource]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private string $name;

    #[ApiProperty(identifier: true)]
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Gedmo\Slug(fields: ['name'], unique: true)]
    private string $slug;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private string $description;

    #[ORM\Column(type: 'integer')]
    #[Assert\GreaterThan(0)]
    private int $price;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private string $city;

    #[ORM\ManyToOne(targetEntity: Provider::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Provider $provider;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: ServiceImage::class, cascade: ['persist', 'remove'])]
    #[Assert\Count(max: 3)]
    private iterable $images = [];

    #[ORM\Column(type: 'integer')]
    #[Assert\GreaterThan(0)]
    private int $durationMinutes;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Service
     */
    public function setId(int $id): Service
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Service
     */
    public function setName(string $name): Service
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Service
     */
    public function setCity(string $city): Service
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Service
     */
    public function setDescription(string $description): Service
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return Service
     */
    public function setPrice(int $price): Service
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int
     */
    public function getDurationMinutes(): int
    {
        return $this->durationMinutes;
    }

    /**
     * @param int $durationMinutes
     * @return Service
     */
    public function setDurationMinutes(int $durationMinutes): Service
    {
        $this->durationMinutes = $durationMinutes;
        return $this;
    }

    /**
     * @return Provider
     */
    public function getProvider(): Provider
    {
        return $this->provider;
    }

    /**
     * @param Provider $provider
     * @return Service
     */
    public function setProvider(Provider $provider): Service
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Service
     */
    public function setSlug(string $slug): Service
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return iterable
     */
    public function getImages(): iterable
    {
        return $this->images;
    }

    /**
     * @param iterable $images
     * @return Service
     */
    public function setImages(iterable $images): Service
    {
        $this->images = $images;
        return $this;
    }
}

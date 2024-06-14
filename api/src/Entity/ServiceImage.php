<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ApiResource]
class ServiceImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private string $url;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private string $alt;

    #[ORM\ManyToOne(targetEntity: Service::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Service $service;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ServiceImage
     */
    public function setId(int $id): ServiceImage
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return ServiceImage
     */
    public function setUrl(string $url): ServiceImage
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlt(): string
    {
        return $this->alt;
    }

    /**
     * @param string $alt
     * @return ServiceImage
     */
    public function setAlt(string $alt): ServiceImage
    {
        $this->alt = $alt;
        return $this;
    }

    /**
     * @return Service
     */
    public function getService(): Service
    {
        return $this->service;
    }

    /**
     * @param Service $service
     * @return ServiceImage
     */
    public function setService(Service $service): ServiceImage
    {
        $this->service = $service;
        return $this;
    }
}

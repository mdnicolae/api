<?php

namespace App\Entity;


use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\State\UserPasswordHasher;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;


#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(validationContext: ['groups' => ['Default', 'user:create']], processor: UserPasswordHasher::class),
        new Get(),
        new Put(processor: UserPasswordHasher::class),
        new Patch(processor: UserPasswordHasher::class),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:create', 'user:update']],
)]

#[ORM\Entity]
#[UniqueEntity('email')]
class Provider implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Groups(['user:read', 'user:create', 'user:update'])]
    private string $name;

    #[ApiProperty(identifier: true)]
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Gedmo\Slug(fields: ['name'], unique: true)]
    #[Groups(['user:read', 'user:update'])]
    private string $slug;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[Assert\Email]
    private string $email;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Groups(['user:create'])]
    private string $password;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Groups(['user:read', 'user:create', 'user:update'])]
    private string $phone;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\Iban]
    #[Groups(['user:read', 'user:create', 'user:update'])]
    private string $iban;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Groups(['user:read', 'user:create', 'user:update'])]
    private string $city;

    #[ORM\Column(type: 'string', length: 255, unique: true, nullable: true, options: ['default' => null])]
    #[Assert\NotBlank]
    #[Groups(['user:read', 'user:create', 'user:update'])]
    private ?string $cif = null;

    #[ORM\OneToMany(mappedBy: 'provider', targetEntity: Service::class, cascade: ['persist', 'remove'])]
    #[Groups(['user:read', 'user:create', 'user:update'])]
    public iterable $services;

    #[ORM\Column(type: 'json')]
    #[Groups(['user:read'])]
    private array $roles;

    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    #[Assert\GreaterThanOrEqual(0)]
    #[Groups(['user:read'])]
    private int $servicesCount = 0;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    #[Groups(['user:read', 'user:update'])]
    private bool $approved = false;

    public function __construct()
    {
        $this->services = new ArrayCollection();
        $this->roles = ['ROLE_USER'];
    }

    public function addService(Service $service): void
    {
        $service->setProvider($this);
        $this->services->add($service);
    }

    public function removeService(Service $service): void
    {
        $this->services->removeElement($service);
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
     * @return Provider
     */
    public function setId(int $id): Provider
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
     * @return Provider
     */
    public function setName(string $name): Provider
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Provider
     */
    public function setEmail(string $email): Provider
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return Provider
     */
    public function setPhone(string $phone): Provider
    {
        $this->phone = $phone;
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
     * @return Provider
     */
    public function setCity(string $city): Provider
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getIban(): string
    {
        return $this->iban;
    }

    /**
     * @param string $iban
     * @return Provider
     */
    public function setIban(string $iban): Provider
    {
        $this->iban = $iban;
        return $this;
    }

    /**
     * @return iterable
     */
    public function getServices(): iterable
    {
        return $this->services;
    }

    /**
     * @param iterable $services
     * @return Provider
     */
    public function setServices(iterable $services): Provider
    {
        $this->services = $services;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCif(): ?string
    {
        return $this->cif;
    }

    /**
     * @param string|null $cif
     * @return Provider
     */
    public function setCif(?string $cif): Provider
    {
        $this->cif = $cif;
        return $this;
    }

    /**
     * @return int
     */
    public function getServicesCount(): int
    {
        return $this->servicesCount;
    }

    /**
     * @param int $servicesCount
     * @return Provider
     */
    public function setServicesCount(int $servicesCount): Provider
    {
        $this->servicesCount = $servicesCount;
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
     * @return Provider
     */
    public function setSlug(string $slug): Provider
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }
}

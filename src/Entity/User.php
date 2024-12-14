<?php

namespace App\Entity;

use App\Entity\Trait\SluggableTrait;
use App\Entity\Trait\TimestampableTrait;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Scheb\TwoFactorBundle\Model\Email\TwoFactorInterface;
use Scheb\TwoFactorBundle\Model\TrustedDeviceInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\PasswordStrength;

#[ORM\Table(name: '`user`')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface, TwoFactorInterface, TrustedDeviceInterface
{
    use TimestampableTrait;
    use SluggableTrait;

    public const ADMIN_ID = 1;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER, unique: true)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Assert\NotBlank(message: 'Le prénom est obligatoire.')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le prénom ne peut pas dépasser 255 caractères.',
    )]
    #[Assert\NoSuspiciousCharacters]
    private string $firstname;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Assert\NotBlank(message: 'Le nom est obligatoire.')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le nom ne peut pas dépasser 255 caractères.',
    )]
    #[Assert\NoSuspiciousCharacters]
    private string $lastname;

    #[ORM\Column(type: Types::STRING, length: 180, unique: true)]
    #[Assert\NotBlank(message: 'Une adresse email est obligatoire.')]
    #[Assert\Length(
        max: 180,
        maxMessage: "L'email ne peut pas dépasser 180 caractères.",
    )]
    #[Assert\Email(message: "Cette adresse email n'est pas au bon format.")]
    private string $email;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $authCode;

    #[ORM\Column(type: Types::INTEGER)]
    private int $trustedVersion = 0;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $password = null;

    #[PasswordStrength([
        'minScore' => PasswordStrength::STRENGTH_MEDIUM,
        'message' => 'Le mot de passe est trop simple. Veuillez saisir un mot de passe plus sécurisé.',
    ])]
    protected ?string $rawPassword = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $googleAuthId = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column(type: Types::JSON)]
    private array $roles = [];

    private string $roleAsString = 'Utilisateur';

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Assert\NoSuspiciousCharacters]
    private ?string $address1 = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Assert\NoSuspiciousCharacters]
    private ?string $address2 = null;

    #[ORM\ManyToOne(targetEntity: City::class)]
    #[ORM\JoinColumn(name: 'city_id', referencedColumnName: 'id')]
    private ?City $city = null;

    #[ORM\ManyToOne(targetEntity: Country::class)]
    #[ORM\JoinColumn(name: 'country_id', referencedColumnName: 'id')]
    private ?Country $country = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastConnectionAt = null;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false)]
    private bool $enabled = false;

    private bool $admin = false;

    // Todo : Ajouter date de connexion pour RGPD

    /**
     * @var Collection<int, Recipe>
     */
    #[ORM\OneToMany(targetEntity: Recipe::class, mappedBy: 'user')]
    private Collection $recipes;

    public function __construct()
    {
        $this->recipes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return "$this->firstname $this->lastname";
    }

    protected function getSlugSource(): string
    {
        return "$this->firstname $this->lastname";
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = !empty($roles) ? $roles : ['ROLE_USER'];

        return $this;
    }

    public function setRoleAsString(string $roleAsString): static
    {
        $this->roleAsString = $roleAsString;

        return $this;
    }

    public function getRoleAsString(): ?string
    {
        return in_array('ROLE_SONATA_ADMIN', $this->roles) ? 'Administrateur' : $this->roleAsString;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getGoogleAuthId(): ?string
    {
        return $this->googleAuthId;
    }

    public function setGoogleAuthId(?string $googleAuthId): static
    {
        $this->googleAuthId = $googleAuthId;

        return $this;
    }

    public function getRawPassword(): ?string
    {
        return $this->rawPassword;
    }

    public function setRawPassword(?string $rawPassword): static
    {
        $this->rawPassword = $rawPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    public function setAddress1(?string $address1): static
    {
        $this->address1 = $address1;

        return $this;
    }

    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    public function setAddress2(?string $address2): static
    {
        $this->address2 = $address2;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function isAdmin(): bool
    {
        return in_array('ROLE_SONATA_ADMIN', $this->roles);
    }

    public function setAdmin(bool $admin): static
    {
        $this->admin = $admin;

        $admin ? $this->setRoles(['ROLE_SONATA_ADMIN', 'ROLE_ADMIN', 'ROLE_USER']) : $this->setRoles(['ROLE_USER']);

        return $this;
    }

    public function isEmailAuthEnabled(): bool
    {
        return true;
    }

    public function getEmailAuthRecipient(): string
    {
        return $this->email;
    }

    public function getEmailAuthCode(): ?string
    {
        if (null === $this->authCode) {
            throw new \LogicException('The email authentication code was not set');
        }

        return $this->authCode;
    }

    public function setEmailAuthCode(string $authCode): void
    {
        $this->authCode = $authCode;
    }

    public function getTrustedVersion(): int
    {
        return $this->trustedVersion;
    }

    public function setTrustedVersion(int $trustedVersion): void
    {
        $this->trustedVersion = $trustedVersion;
    }

    public function getTrustedTokenVersion(): int
    {
        return $this->trustedVersion;
    }

    /**
     * @return Collection<int, Recipe>
     */
    public function getRecipes(): Collection
    {
        return $this->recipes;
    }

    public function addRecipe(Recipe $recipe): static
    {
        if (!$this->recipes->contains($recipe)) {
            $this->recipes->add($recipe);
            $recipe->setUser($this);
        }

        return $this;
    }

    public function removeRecipe(Recipe $recipe): static
    {
        if ($this->recipes->removeElement($recipe)) {
            // set the owning side to null (unless already changed)
            if ($recipe->getUser() === $this) {
                $recipe->setUser(null);
            }
        }

        return $this;
    }

    public function getLastConnectionAt(): ?\DateTimeInterface
    {
        return $this->lastConnectionAt;
    }

    public function setLastConnectionAt(?\DateTimeInterface $lastConnectionAt): static
    {
        $this->lastConnectionAt = $lastConnectionAt;

        return $this;
    }
}

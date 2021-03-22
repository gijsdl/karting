<?php

namespace App\Entity;

use App\Repository\AppUsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AppUsersRepository::class)
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class AppUsers implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="vul gebruikersnaam in")
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     *
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\Email(
     *    message = "The email '{{ value }}' is geen geldig email adres")
     * @Assert\NotBlank(message="vul emailadres in")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank(message="vul voorletters in")
     */
    private $voorletters;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $tussenvoegsel;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank(message="vul achternaam in")
     */
    private $achternaam;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank(message="vul adres in")
     */
    private $adres;

    /**
     * @ORM\Column(type="string", length=7)
     * @Assert\NotBlank(message="vul postcode in")
     */
    private $postcode;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank(message="vul woonplaats in")
     */
    private $woonplaats;

    /**
     * @ORM\Column(type="string", length=15)
     * @Assert\NotBlank(message="vul telfoonnummer in")
     */
    private $telefoon;

    /**
     * @ORM\ManyToMany(targetEntity=Activiteiten::class, inversedBy="users")
     */
    private $activiteiten;

    public function __construct()
    {
        $this->activiteiten = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getVoorletters(): ?string
    {
        return $this->voorletters;
    }

    public function setVoorletters(string $voorletters): self
    {
        $this->voorletters = $voorletters;

        return $this;
    }

    public function getTussenvoegsel(): ?string
    {
        return $this->tussenvoegsel;
    }

    public function setTussenvoegsel(?string $tussenvoegsel): self
    {
        $this->tussenvoegsel = $tussenvoegsel;

        return $this;
    }

    public function getAchternaam(): ?string
    {
        return $this->achternaam;
    }

    public function setAchternaam(string $achternaam): self
    {
        $this->achternaam = $achternaam;

        return $this;
    }

    function getNaam()
    {
        return $this->voorletters . " " . $this->tussenvoegsel . " " . $this->achternaam;
    }

    public function getAdres(): ?string
    {
        return $this->adres;
    }

    public function setAdres(string $adres): self
    {
        $this->adres = $adres;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getWoonplaats(): ?string
    {
        return $this->woonplaats;
    }

    public function setWoonplaats(string $woonplaats): self
    {
        $this->woonplaats = $woonplaats;

        return $this;
    }

    public function getTelefoon(): ?string
    {
        return $this->telefoon;
    }

    public function setTelefoon(string $telefoon): self
    {
        $this->telefoon = $telefoon;

        return $this;
    }

    /**
     * @return Collection|Activiteiten[]
     */
    public function getActiviteiten(): Collection
    {
        return $this->activiteiten;
    }

    public function addActiviteiten(Activiteiten $activiteiten): self
    {
        if (!$this->activiteiten->contains($activiteiten)) {
            $this->activiteiten[] = $activiteiten;
        }

        return $this;
    }

    public function removeActiviteiten(Activiteiten $activiteiten): self
    {
        $this->activiteiten->removeElement($activiteiten);

        return $this;
    }
}

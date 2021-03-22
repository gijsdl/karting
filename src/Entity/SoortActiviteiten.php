<?php

namespace App\Entity;

use App\Repository\SoortActiviteitenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SoortActiviteitenRepository::class)
 */
class SoortActiviteiten
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="vul naam in")
     */
    private $naam;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="vul minimale leeftijd in")
     */
    private $minLeeftijd;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="vul tijdsduur in")
     */
    private $tijdsduur;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     * @Assert\NotBlank(message="vul prijs in")
     */
    private $prijs;

    /**
     * @ORM\OneToMany(targetEntity=Activiteiten::class, mappedBy="soort", orphanRemoval=true)
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

    public function getNaam(): ?string
    {
        return $this->naam;
    }

    public function setNaam(string $naam): self
    {
        $this->naam = $naam;

        return $this;
    }

    public function getMinLeeftijd(): ?int
    {
        return $this->minLeeftijd;
    }

    public function setMinLeeftijd(int $minLeeftijd): self
    {
        $this->minLeeftijd = $minLeeftijd;

        return $this;
    }

    public function getTijdsduur(): ?int
    {
        return $this->tijdsduur;
    }

    public function setTijdsduur(int $tijdsduur): self
    {
        $this->tijdsduur = $tijdsduur;

        return $this;
    }

    public function getPrijs(): ?string
    {
        return $this->prijs;
    }

    public function setPrijs(string $prijs): self
    {
        $this->prijs = $prijs;

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
            $activiteiten->setSoort($this);
        }

        return $this;
    }

    public function removeActiviteiten(Activiteiten $activiteiten): self
    {
        if ($this->activiteiten->removeElement($activiteiten)) {
            // set the owning side to null (unless already changed)
            if ($activiteiten->getSoort() === $this) {
                $activiteiten->setSoort(null);
            }
        }

        return $this;
    }
}

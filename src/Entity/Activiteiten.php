<?php

namespace App\Entity;

use App\Repository\ActiviteitenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActiviteitenRepository::class)
 */
class Activiteiten
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $datum;

    /**
     * @ORM\Column(type="time")
     */
    private $tijd;

    /**
     * @ORM\ManyToOne(targetEntity=SoortActiviteiten::class, inversedBy="activiteiten")
     * @ORM\JoinColumn(nullable=false)
     */
    private $soort;

    /**
     * @ORM\ManyToMany(targetEntity=AppUsers::class, mappedBy="activiteiten")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatum(): ?\DateTimeInterface
    {
        return $this->datum;
    }

    public function setDatum(\DateTimeInterface $datum): self
    {
        $this->datum = $datum;

        return $this;
    }

    public function getTijd(): ?\DateTimeInterface
    {
        return $this->tijd;
    }

    public function setTijd(\DateTimeInterface $tijd): self
    {
        $this->tijd = $tijd;

        return $this;
    }

    public function getSoort(): ?SoortActiviteiten
    {
        return $this->soort;
    }

    public function setSoort(?SoortActiviteiten $soort): self
    {
        $this->soort = $soort;

        return $this;
    }

    /**
     * @return Collection|AppUsers[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(AppUsers $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addActiviteiten($this);
        }

        return $this;
    }

    public function removeUser(AppUsers $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeActiviteiten($this);
        }

        return $this;
    }
}

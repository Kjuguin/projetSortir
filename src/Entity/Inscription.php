<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InscriptionRepository")
 */
class Inscription
{

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInscription;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sortie", inversedBy="noInscriptions")
     * @ORM\Id()
     */
    private $noSortie;

    /**
     * @Groups("group1")
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="noInscriptions")
     */
    private $noUser;

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getNoSortie(): ?Sortie
    {
        return $this->noSortie;
    }

    public function setNoSortie(?Sortie $noSortie): self
    {
        $this->noSortie = $noSortie;

        return $this;
    }

    public function getNoUser(): ?User
    {
        return $this->noUser;
    }

    public function setNoUser(?User $noUser): self
    {
        $this->noUser = $noUser;

        return $this;
    }

    public function getFiltre()
    {
        return $this->dateInscription;
    }
}
<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\SiteRepository")
 */
class Site
{
    /**
     * @Groups("groupe3")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sortie", mappedBy="noSite")
     */
    private $noSorties;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="noSite")
     */
    private $noUsers;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $etat;

    /**
     * @Groups("groupe3")
     * @Assert\Length(
     *     min="3",
     *     max="30",
     *     minMessage="Le nom du site doit être supérieur à 3 caractères",
     *     maxMessage="Le nom du site doit être inférieur à 30 caractères")
     * @ORM\Column(type="string", length=30)
     */
    private $nomSite;

    public function __construct()
    {
        $this->noSorties = new ArrayCollection();
        $this->noUsers = new ArrayCollection();
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }
    public function setEtat(string $etat): self
    {
        $this->etat = $etat;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSite(): ?string
    {
        return $this->nomSite;
    }

    public function setNomSite(string $nomSite): self
    {
        $this->nomSite = $nomSite;

        return $this;
    }
    public function __toString()
    {
        return $this->nomSite;
    }

    /**
     * @return Collection|Sortie[]
     */
    public function getNoSorties(): Collection
    {
        return $this->noSorties;
    }

    public function addNoSorty(Sortie $noSorty): self
    {
        if (!$this->noSorties->contains($noSorty)) {
            $this->noSorties[] = $noSorty;
            $noSorty->setNoSite($this);
        }

        return $this;
    }

    public function removeNoSorty(Sortie $noSorty): self
    {
        if ($this->noSorties->contains($noSorty)) {
            $this->noSorties->removeElement($noSorty);
            // set the owning side to null (unless already changed)
            if ($noSorty->getNoSite() === $this) {
                $noSorty->setNoSite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getNoUsers(): Collection
    {
        return $this->noUsers;
    }

    public function addNoUser(User $noUser): self
    {
        if (!$this->noUsers->contains($noUser)) {
            $this->noUsers[] = $noUser;
            $noUser->setNoSite($this);
        }

        return $this;
    }

    public function removeNoUser(User $noUser): self
    {
        if ($this->noUsers->contains($noUser)) {
            $this->noUsers->removeElement($noUser);
            // set the owning side to null (unless already changed)
            if ($noUser->getNoSite() === $this) {
                $noUser->setNoSite(null);
            }
        }

        return $this;
    }

    
}

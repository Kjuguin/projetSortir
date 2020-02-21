<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\VilleRepository")
 */
class Ville
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Lieu", mappedBy="noVille")
     */
    private $noLieux;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Lieu", mappedBy="ville")
     */
    private $Lieux;

    /**
     * @Groups("groupe2")
     * @Assert\Length(
     *     min="3",
     *     max="30",
     *     minMessage="Le nom de la ville doit être supérieur à 3 caractères",
     *     maxMessage="Le nom de la ville doit être inférieur à 30 caractères")
     * @ORM\Column(type="string", length=30)
     */
    private $nomVille;

    /**
     * @Groups("groupe2")
     * @Assert\Regex(pattern="/^[0-9]{5}$/",
     *     message="Le code postal est de 5 chiffres")
     * @ORM\Column(type="string", length=5)
     */
    private $codePostal;

    public function __construct()
    {
        $this->noLieux = new ArrayCollection();
        $this->Lieux = new ArrayCollection();
    }

    public function __toString()
    {
        return (String) $this->nomVille;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomVille(): ?string
    {
        return $this->nomVille;
    }

    public function setNomVille(string $nomVille): self
    {
        $this->nomVille = $nomVille;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * @return Collection|Lieu[]
     */
    public function getNoLieux(): Collection
    {
        return $this->noLieux;
    }

    /**
     * @return Collection|Lieu[]
     */
    public function getLieux(): Collection
    {
        return $this->Lieux;
    }


    public function addNoLieux(Lieu $noLieux): self
    {
        if (!$this->noLieux->contains($noLieux)) {
            $this->noLieux[] = $noLieux;
            $noLieux->setNoVille($this);
        }

        return $this;
    }

    public function removeNoLieux(Lieu $noLieux): self
    {
        if ($this->noLieux->contains($noLieux)) {
            $this->noLieux->removeElement($noLieux);
            // set the owning side to null (unless already changed)
            if ($noLieux->getNoVille() === $this) {
                $noLieux->setNoVille(null);
            }
        }

        return $this;
    }

    public function addLieux(Lieu $Lieux): self
    {
        if (!$this->Lieux->contains($Lieux)) {
            $this->Lieux[] = $Lieux;
            $Lieux->setVille($this);
        }

        return $this;
    }

    public function removeLieux(Lieu $Lieux): self
    {
        if ($this->Lieux->contains($Lieux)) {
            $this->Lieux->removeElement($Lieux);
            // set the owning side to null (unless already changed)
            if ($Lieux->getVille() === $this) {
                $Lieux->setVille(null);
            }
        }

        return $this;
    }
}
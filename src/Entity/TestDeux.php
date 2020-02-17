<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TestDeuxRepository")
 */
class TestDeux
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("group1")
     * @ORM\Column(type="integer")
     */
    private $numero;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TestUn", mappedBy="deux")
     */
    private $un;

    public function __construct()
    {
        $this->un = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->numero;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return Collection|TestUn[]
     */
    public function getUn(): Collection
    {
        return $this->un;
    }

    public function addUn(TestUn $un): self
    {
        if (!$this->un->contains($un)) {
            $this->un[] = $un;
            $un->setDeux($this);
        }

        return $this;
    }

    public function removeUn(TestUn $un): self
    {
        if ($this->un->contains($un)) {
            $this->un->removeElement($un);
            // set the owning side to null (unless already changed)
            if ($un->getDeux() === $this) {
                $un->setDeux(null);
            }
        }

        return $this;
    }

    public function toJson()
    {
        // ecrire un json

        return $json;
    }
}

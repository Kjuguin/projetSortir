<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TestUnRepository")
 */
class TestUn
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("group1")
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @Groups("group1")
     * @ORM\ManyToOne(targetEntity="App\Entity\TestDeux", inversedBy="un")
     */
    private $deux;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDeux(): ?TestDeux
    {
        return $this->deux;
    }

    public function setDeux(?TestDeux $deux): self
    {
        $this->deux = $deux;

        return $this;
    }
}

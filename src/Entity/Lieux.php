<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LieuxRepository")
 */
class Lieux
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $no_lieu;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom_lieu;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $rue;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longitude;

    /**
     * @ORM\Column(type="integer")
     */
    private $villes_no_ville;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoLieu(): ?int
    {
        return $this->no_lieu;
    }

    public function setNoLieu(int $no_lieu): self
    {
        $this->no_lieu = $no_lieu;

        return $this;
    }

    public function getNomLieu(): ?string
    {
        return $this->nom_lieu;
    }

    public function setNomLieu(string $nom_lieu): self
    {
        $this->nom_lieu = $nom_lieu;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(?string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getVillesNoVille(): ?int
    {
        return $this->villes_no_ville;
    }

    public function setVillesNoVille(int $villes_no_ville): self
    {
        $this->villes_no_ville = $villes_no_ville;

        return $this;
    }
}

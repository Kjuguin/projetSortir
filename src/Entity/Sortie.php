<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\SortieRepository")
 */
class Sortie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inscription", mappedBy="noSortie")
     */
    private $noInscriptions;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duree;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCloture;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbInscriptionMax;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionInfos;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $urlPhoto;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="noSorties")
     */
    private $noOrganisateur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lieu", inversedBy="noSorties")
     */
    private $noLieu;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Etat", inversedBy="noSorties")
     */
    private $noEtat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Site", inversedBy="noSorties")
     */
    private $noSite;

    public function __construct()
    {
        $this->noInscriptions = new ArrayCollection();
    }

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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateCloture(): ?\DateTimeInterface
    {
        return $this->dateCloture;
    }

    public function setDateCloture(\DateTimeInterface $dateCloture): self
    {
        $this->dateCloture = $dateCloture;

        return $this;
    }

    public function getNbInscriptionMax(): ?int
    {
        return $this->nbInscriptionMax;
    }

    public function setNbInscriptionMax(int $nbInscriptionMax): self
    {
        $this->nbInscriptionMax = $nbInscriptionMax;

        return $this;
    }

    public function getDescriptionInfos(): ?string
    {
        return $this->descriptionInfos;
    }

    public function setDescriptionInfos(?string $descriptionInfos): self
    {
        $this->descriptionInfos = $descriptionInfos;

        return $this;
    }

    public function getEtatSortie(): ?int
    {
        return $this->etatSortie;
    }

    public function setEtatSortie(?int $etatSortie): self
    {
        $this->etatSortie = $etatSortie;

        return $this;
    }

    public function getUrlPhoto(): ?string
    {
        return $this->urlPhoto;
    }

    public function setUrlPhoto(?string $urlPhoto): self
    {
        $this->urlPhoto = $urlPhoto;

        return $this;
    }

    /**
     * @return Collection|Inscription[]
     */
    public function getNoInscriptions(): Collection
    {
        return $this->noInscriptions;
    }

    public function addNoInscription(Inscription $noInscription): self
    {
        if (!$this->noInscriptions->contains($noInscription)) {
            $this->noInscriptions[] = $noInscription;
            $noInscription->setNoSortie($this);
        }

        return $this;
    }

    public function removeNoInscription(Inscription $noInscription): self
    {
        if ($this->noInscriptions->contains($noInscription)) {
            $this->noInscriptions->removeElement($noInscription);
            // set the owning side to null (unless already changed)
            if ($noInscription->getNoSortie() === $this) {
                $noInscription->setNoSortie(null);
            }
        }

        return $this;
    }

    public function getNoOrganisateur(): ?User
    {
        return $this->noOrganisateur;
    }

    public function setNoOrganisateur(?User $noOrganisateur): self
    {
        $this->noOrganisateur = $noOrganisateur;

        return $this;
    }

    public function getNoLieu(): ?Lieu
    {
        return $this->noLieu;
    }

    public function setNoLieu(?Lieu $noLieu): self
    {
        $this->noLieu = $noLieu;

        return $this;
    }

    public function getNoEtat(): ?Etat
    {
        return $this->noEtat;
    }

    public function setNoEtat(?Etat $noEtat): self
    {
        $this->noEtat = $noEtat;

        return $this;
    }

    public function getNoSite(): ?Site
    {
        return $this->noSite;
    }

    public function setNoSite(?Site $noSite): self
    {
        $this->noSite = $noSite;

        return $this;
    }

    

}

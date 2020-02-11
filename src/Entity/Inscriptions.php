<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\InscriptionsRepository")
 */
class Inscriptions
{

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_inscription;

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $sorties_no_sortie;

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $participants_no_participant;

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->date_inscription;
    }

    public function setDateInscription(?\DateTimeInterface $date_inscription): self
    {
        $this->date_inscription = $date_inscription;

        return $this;
    }

    public function getSortiesNoSortie(): ?int
    {
        return $this->sorties_no_sortie;
    }

    public function setSortiesNoSortie(?int $sorties_no_sortie): self
    {
        $this->sorties_no_sortie = $sorties_no_sortie;

        return $this;
    }

    public function getParticipantsNoParticipant(): ?int
    {
        return $this->participants_no_participant;
    }

    public function setParticipantsNoParticipant(int $participants_no_participant): self
    {
        $this->participants_no_participant = $participants_no_participant;

        return $this;
    }
}

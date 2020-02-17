<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Site", inversedBy="noUsers")
     */
    private $noSite;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inscription", mappedBy="noUser")
     */
    private $noInscriptions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sortie", mappedBy="noOrganisateur")
     */
    private $noSorties;

    /**
     * @Assert\Email(message="L'email n'est pas valide")
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $email;

//TODO :

    /**
     * @Groups("group1")
     * @Assert\NotBlank(message="Il ne doit pas y avoir d'espace dans votre pseudo")
     * @Assert\Length(
     *     min="3",
     *     max="30",
     *     minMessage="Le nom de la ville doit être supérieur à 3 caractères",
     *     maxMessage="Le nom de la ville doit être inférieur à 30 caractères")
     * @ORM\Column(type="string", length=30, unique=true)
     */
    private $pseudo;

    /**
* @ORM\Column(type="json")
     */
    private $roles = [];


//* @Assert\Regex(
//* pattern = "/^(?=.*\d)(?=.*[A-Z])(?=.*[@#$%])(?!.*(.)\1{2}).*[a-z]/m",
//* match=true,
//* message="Votre mot de passe doit comporter au moins huit caractères, dont des lettres majuscules et minuscules, un chiffre et un symbole.")

    /**
     * @Assert\Regex(
     *      pattern = "/^(?=.*[A-Z]).*[a-z]/m",
     *      match=true,
     *      message="Votre mot de passe doit comporter au moins une lettre majuscule.")
     * @Assert\Regex(
     *      pattern = "/^(?=.*[a-z]).*[a-z]/m",
     *      match=true,
     *      message="Votre mot de passe doit comporter au moins une lettre minuscule.")
     * @Assert\Regex(
     *      pattern = "/^(?=.*[0-9]).*[a-z]/m",
     *      match=true,
     *      message="Votre mot de passe doit comporter au moins un chiffre.")
     * @Assert\Regex(
     *      pattern = "/^(?=.*[@#$%]).*[a-z]/m",
     *      match=true,
     *      message="Votre mot de passe doit comporter au moins un caractère spécial : @ # $ %.")
     * @Assert\Regex(
     *      pattern = "/^.{8,15}/m",
     *      match=true,
     *      message="Votre mot de passe doit comporter entre 8 et 15 caractères.")
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\Length(
     *     min="3",
     *     max="30",
     *     minMessage="Le prénom doit être supérieur à 3 caractères",
     *     maxMessage="Le prénom doit être inférieur à 30 caractères")
     * @ORM\Column(type="string", length=30)
     */
    private $prenom;

    /**
     * @Assert\Length(
     *     min="3",
     *     max="30",
     *     minMessage="Le nom doit être supérieur à 3 caractères",
     *     maxMessage="Le nom doit être inférieur à 30 caractères")
     * @ORM\Column(type="string", length=30)
     */
    private $nom;

    /**
     * @Assert\Regex(pattern="/^0[1|2|6|7][0-9]{8}$/", message="Votre numéro de téléphone doit être composer de 10 chiffres commencant par 01/02/06/07")
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $telephone;

  
    public function __construct()
    {
        $this->noInscription = new ArrayCollection();
        $this->noSortie = new ArrayCollection();
        $this->noInscriptions = new ArrayCollection();
        $this->noSorties = new ArrayCollection();
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @see UserInterface
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }


    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

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
            $noInscription->setNoUser($this);
        }

        return $this;
    }

    public function removeNoInscription(Inscription $noInscription): self
    {
        if ($this->noInscriptions->contains($noInscription)) {
            $this->noInscriptions->removeElement($noInscription);
            // set the owning side to null (unless already changed)
            if ($noInscription->getNoUser() === $this) {
                $noInscription->setNoUser(null);
            }
        }

        return $this;
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
            $noSorty->setNoOrganisateur($this);
        }

        return $this;
    }

    public function removeNoSorty(Sortie $noSorty): self
    {
        if ($this->noSorties->contains($noSorty)) {
            $this->noSorties->removeElement($noSorty);
            // set the owning side to null (unless already changed)
            if ($noSorty->getNoOrganisateur() === $this) {
                $noSorty->setNoOrganisateur(null);
            }
        }

        return $this;
    }

    public function getFiltre()
    {
        return $this->pseudo;
    }

}

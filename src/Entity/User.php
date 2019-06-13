<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields = {"username"}, message="Ce nom d'utilisateur existe déjà")
 * @UniqueEntity(fields = {"email"}, message="Cet email existe déjà")
 * @Vich\Uploadable
 */
class User implements UserInterface
{

    public function __construct(){
        $this->createdAt= new \DateTime();
        $this->bestLaps = new ArrayCollection();
    }
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
       @Assert\Email(message="votre adresse email doit être une adresse email valide !")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire minimum 8 caractères !")
     */
    private $password;

    /**
     * @ORM\Column(name="roles", type="array")
     */
    private $roles = array();
    

     /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $country;

   

    /**
     * @Assert\EqualTo(propertyPath="password", message="2 Passwords must match together !")
     */
    public $confirm_password;

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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles() {
        if (empty($this->roles)) {
            return ['ROLE_USER'];
        }
        return $this->roles;
    }

    function addRole($role) {
        $this->roles[] = $role;
    }

    public function eraseCredentials(){}

    public function getSalt(){}

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }


    /**
     * @var string le token qui servira lors de l'oubli de mot de passe
     * @ORM\Column(type="string", length=255, nullable=true)
    */
    protected $resetToken;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BestLap", mappedBy="player", orphanRemoval=true)
     */
    private $bestLaps;   

    /**
     * @return string
    */
    public function getResetToken(): string
    {
        return $this->resetToken;
    }

    /**
     * @param string $resetToken
    */
    public function setResetToken(?string $resetToken): void
    {
        $this->resetToken = $resetToken;
    }

    /**
     * @return Collection|BestLap[]
     */
    public function getBestLaps(): Collection
    {
        return $this->bestLaps;
    }

    public function addBestLap(BestLap $bestLap): self
    {
        if (!$this->bestLaps->contains($bestLap)) {
            $this->bestLaps[] = $bestLap;
            $bestLap->setPlayer($this);
        }

        return $this;
    }

    public function removeBestLap(BestLap $bestLap): self
    {
        if ($this->bestLaps->contains($bestLap)) {
            $this->bestLaps->removeElement($bestLap);
            // set the owning side to null (unless already changed)
            if ($bestLap->getPlayer() === $this) {
                $bestLap->setPlayer(null);
            }
        }

        return $this;
    }

}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RacerRepository")
 * @Vich\Uploadable
 */
class Racer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="racers_image", fileNameProperty="image")
     * 
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BestLap", mappedBy="racer")
     */
    private $bestLaps;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Top", mappedBy="racer")
     */
    private $tops;

    public function __construct(){
        $this->updatedAt= new \DateTime();
        $this->bestLaps = new ArrayCollection();
        $this->tops = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImageFile(?File $image = null): void
    {
        $this->imageFile = $image;

        if (null !== $image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getImage(): ?string
    {
        return $this->image;
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
            $bestLap->setRacer($this);
        }

        return $this;
    }

    public function removeBestLap(BestLap $bestLap): self
    {
        if ($this->bestLaps->contains($bestLap)) {
            $this->bestLaps->removeElement($bestLap);
            // set the owning side to null (unless already changed)
            if ($bestLap->getRacer() === $this) {
                $bestLap->setRacer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Top[]
     */
    public function getTops(): Collection
    {
        return $this->tops;
    }

    public function addTop(Top $top): self
    {
        if (!$this->tops->contains($top)) {
            $this->tops[] = $top;
            $top->setRacer($this);
        }

        return $this;
    }

    public function removeTop(Top $top): self
    {
        if ($this->tops->contains($top)) {
            $this->tops->removeElement($top);
            // set the owning side to null (unless already changed)
            if ($top->getRacer() === $this) {
                $top->setRacer(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RaceRepository")
 */
class Race
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
     * @ORM\OneToMany(targetEntity="App\Entity\BestLap", mappedBy="race")
     */
    private $bestLaps;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Top", mappedBy="race")
     */
    private $tops;

    public function __construct()
    {
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
            $bestLap->setRace($this);
        }

        return $this;
    }

    public function removeBestLap(BestLap $bestLap): self
    {
        if ($this->bestLaps->contains($bestLap)) {
            $this->bestLaps->removeElement($bestLap);
            // set the owning side to null (unless already changed)
            if ($bestLap->getRace() === $this) {
                $bestLap->setRace(null);
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
            $top->setRace($this);
        }

        return $this;
    }

    public function removeTop(Top $top): self
    {
        if ($this->tops->contains($top)) {
            $this->tops->removeElement($top);
            // set the owning side to null (unless already changed)
            if ($top->getRace() === $this) {
                $top->setRace(null);
            }
        }

        return $this;
    }
}

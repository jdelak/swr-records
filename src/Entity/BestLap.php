<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BestLapRepository")
 */
class BestLap
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\Regex(
     *     pattern = "/\d+\d+[:]+\d+\d+[:]+\d+\d/",
     *     message = "The time format is min:sec:milisec, if laps is less than 1 min, put 00 instead"
     * )
     */
    private $time;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     *     pattern = "/http(?:s?):\/\/www\.youtu(?:be\.com\/embed\/)([\w\-\_]*){1,11}/",
     *     message = "Invalid youtube format !"
     * )
     */
    private $video;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $crash;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Race", inversedBy="bestLaps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $race;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Racer", inversedBy="bestLaps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $racer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="bestLaps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getCrash(): ?int
    {
        return $this->crash;
    }

    public function setCrash(?int $crash): self
    {
        $this->crash = $crash;

        return $this;
    }

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): self
    {
        $this->race = $race;

        return $this;
    }

    public function getRacer(): ?Racer
    {
        return $this->racer;
    }

    public function setRacer(?Racer $racer): self
    {
        $this->racer = $racer;

        return $this;
    }

    public function getPlayer(): ?User
    {
        return $this->player;
    }

    public function setPlayer(?User $player): self
    {
        $this->player = $player;

        return $this;
    }
}

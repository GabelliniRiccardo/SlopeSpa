<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="treatments")
 * @ORM\Entity(repositoryClass="App\Repository\TreatmentRepository")
 */
class Treatment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $duration;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $VAT;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Operator", inversedBy="treatments")
     * @var Operator
     */
    private $operator;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Room", mappedBy="treatment")
     * @var Collection|Room[]
     */
    private $rooms;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="treatment")
     */
    private $reservations;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SPA", inversedBy="treatments")
     * @ORM\JoinColumn(nullable=false)
     * @var SPA
     */
    private $spa;

    public function __construct($name, $price, $duration, $VAT, $operator, $rooms, $spa)
    {
        $this->setName($name);
        $this->setPrice($price);
        $this->setDuration($duration);
        $this->setVAT($VAT);
        $this->setSpa($spa);
        $this->operator = new ArrayCollection();
        $this->rooms = new ArrayCollection();
        $this->reservations = new ArrayCollection();

        foreach ($rooms as $room) {
            $this->addRoom($room);
        }

        $this->addOperator($operator);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVAT(): ?float
    {
        return $this->VAT;
    }

    public function setVAT(float $VAT): self
    {
        $this->VAT = $VAT;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection|Operator[]
     */
    public function getOperator(): Collection
    {
        return $this->operator;
    }

    public function addOperator(Operator $operator): self
    {
        if (!$this->operator->contains($operator)) {
            $this->operator[] = $operator;
        }

        return $this;
    }

    public function removeOperator(Operator $operator): self
    {
        if ($this->operator->contains($operator)) {
            $this->operator->removeElement($operator);
        }

        return $this;
    }

    /**
     * @return Collection|Room[]
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(Room $room): self
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms[] = $room;
            $room->addTreatment($this);
        }

        return $this;
    }

    public function removeRoom(Room $room): self
    {
        if ($this->rooms->contains($room)) {
            $this->rooms->removeElement($room);
            $room->removeTreatment($this);
        }

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setTreatment($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getTreatment() === $this) {
                $reservation->setTreatment(null);
            }
        }

        return $this;
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

    public function getSpa(): ?SPA
    {
        return $this->spa;
    }

    public function setSpa(?SPA $spa): self
    {
        $this->spa = $spa;

        return $this;
    }
}

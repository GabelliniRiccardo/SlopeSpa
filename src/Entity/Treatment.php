<?php

namespace App\Entity;

use App\Objects\Money;
use App\Types\MoneyType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Mapping as ORM;

Type::addType('money_type', MoneyType::class);

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
     * @ORM\Column(type="money_type", name="price")
     * @var Money
     */
    private $money;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $duration;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $vat;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Operator", inversedBy="treatments")
     * @var Collection|Operator[]
     */
    private $operators;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Room", mappedBy="treatment")
     * @var Collection|Room[]
     */
    private $rooms;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="treatment", orphanRemoval=true)
     * @var Collection|Reservation[]
     */
    private $reservations;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SPA", inversedBy="treatments")
     * @ORM\JoinColumn(nullable=false)
     * @var SPA
     */
    private $spa;

    public function __construct(string $name, Money $money, int $duration, float $vat, SPA $spa)
    {
        $this->setName($name);
        $this->setMoney($money);
        $this->setDuration($duration);
        $this->setVat($vat);
        $this->setSpa($spa);
        $this->operators = new ArrayCollection();
        $this->rooms = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getVat(): float
    {
        return $this->vat;
    }

    public function setVat(float $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    public function getMoney(): ?Money
    {
        return $this->money;
    }

    public function setMoney(Money $money): self
    {
        $this->money = $money;

        return $this;
    }

    public function getDuration(): int
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
    public function getOperators(): Collection
    {
        return $this->operators;
    }

    public function addOperator(Operator $operator): self
    {
        if (!$this->operators->contains($operator)) {
            $this->operators[] = $operator;
        }

        return $this;
    }

    public function removeOperator(Operator $operator): self
    {
        if ($this->operators->contains($operator)) {
            $this->operators->removeElement($operator);
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSpa(): SPA
    {
        return $this->spa;
    }

    public function setSpa(SPA $spa): self
    {
        $this->spa = $spa;

        return $this;
    }
}

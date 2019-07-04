<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="reservations")
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(type="date_immutable")
     * @var \DateTimeImmutable
     */
    private $start_time;

    /**
     * @ORM\Column(type="date_immutable")
     * @var \DateTimeImmutable
     */
    private $end_time;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $duration;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Treatment", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     * @var Treatment
     */
    private $treatment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Room", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     * @var Room
     */
    private $room;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     * @var Customer
     */
    private $customer;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $vat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SPA", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     * @var SPA
     */
    private $spa;

    public function __construct(
        \DateTimeImmutable $start_time,
        \DateTimeImmutable $end_time,
        int $duration,
        float $price,
        Treatment $treatment,
        Room $room,
        Customer $customer,
        float $vat,
        SPA $spa)
    {
        $this->setStartTime($start_time);
        $this->setEndTime($end_time);
        $this->setDuration($duration);
        $this->setPrice($price);
        $this->setTreatment($treatment);
        $this->setRoom($room);
        $this->setCustomer($customer);
        $this->setVat($vat);
        $this->setSpa($spa);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStartTime(): \DateTimeImmutable
    {
        return $this->start_time;
    }

    public function setStartTime(\DateTimeImmutable $start_time): self
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getEndTime(): \DateTimeImmutable
    {
        return $this->end_time;
    }

    public function setEndTime(\DateTimeImmutable $end_time): self
    {
        $this->end_time = $end_time;

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

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getTreatment(): Treatment
    {
        return $this->treatment;
    }

    public function setTreatment(Treatment $treatment): self
    {
        $this->treatment = $treatment;

        return $this;
    }

    public function getRoom(): Room
    {
        return $this->room;
    }

    public function setRoom(Room $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
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

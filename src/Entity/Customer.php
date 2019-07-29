<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="customers")
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 */
class Customer
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $lastName;

    /**
     * @ORM\Column(type="date_immutable", nullable=true)
     * @var \DateTimeImmutable
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $phoneNumber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SPA", inversedBy="customers")
     * @ORM\JoinColumn(nullable=false)
     * @var SPA
     */
    private $spa;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="customer", orphanRemoval=true)
     * @var Collection|Reservation[]
     */
    private $reservations;

    public function __construct(string $first_name, string $last_name, SPA $spa)
    {
        $this->setFirstName($first_name);
        $this->setLastName($last_name);
        $this->setSpa($spa);
        $this->reservations = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthday(): ?\DateTimeImmutable
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeImmutable $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

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
            $reservation->setCustomer($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getCustomer() === $this) {
                $reservation->setCustomer(null);
            }
        }

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

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

    public function __toString() {
        return $this->firstName . ' ' . $this->lastName;
    }
}

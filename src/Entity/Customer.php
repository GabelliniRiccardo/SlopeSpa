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
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $last_name;

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
     * @ORM\ManyToMany(targetEntity="App\Entity\SPA", inversedBy="customers")
     * @var Collection|SPA[]
     */
    private $spas;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="customer")
     * @var Collection|Reservation[]
     */
    private $reservations;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $phone_number;

    public function __construct($first_name, $last_name, $spas)
    {
        $this->setFirstName($first_name);
        $this->setLastName($last_name);
        $this->spas = new ArrayCollection();
        $this->reservations = new ArrayCollection();

        foreach ($spas as $spa) {
            $this->addSpa($spa);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

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
     * @return Collection|SPA[]
     */
    public function getSpas(): Collection
    {
        return $this->spas;
    }

    public function addSpa(SPA $spa): self
    {
        if (!$this->spas->contains($spa)) {
            $this->spas[] = $spa;
        }

        return $this;
    }

    public function removeSpa(SPA $spa): self
    {
        if ($this->spas->contains($spa)) {
            $this->spas->removeElement($spa);
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
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }
}

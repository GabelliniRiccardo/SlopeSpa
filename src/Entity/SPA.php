<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="SPAs")
 * @ORM\Entity(repositoryClass="App\Repository\SPARepository")
 */
class SPA
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
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     *      minMessage = "The SPA's name must be at least {{ limit }} characters long",
     *      maxMessage = "The SPA's name cannot be longer than {{ limit }} characters"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Email
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "The SPA's address must be at least {{ limit }} characters long",
     *      maxMessage = "The SPA's address cannot be longer than {{ limit }} characters"
     * )
     * @var string
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(min = 8, max = 20, )
     * @Assert\Regex(pattern="/^[0-9]*$/", message="please insert number_only")
     * @var string
     */
    private $phoneNumber;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="spa", orphanRemoval=true)
     * @var Collection|User[]
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Operator", mappedBy="spa", orphanRemoval=true)
     * @var Collection|Operator[]
     */
    private $operators;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Treatment", mappedBy="spa", orphanRemoval=true)
     * @var Collection|Treatment[]
     */
    private $treatments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="spa", orphanRemoval=true)
     * @var Collection|Customer[]
     */
    private $customers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Room", mappedBy="spa", orphanRemoval=true)
     * @var Collection|Room[]
     */
    private $rooms;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="spa", orphanRemoval=true)
     * @var Collection|Reservation[]
     */
    private $reservations;

    public function __construct($name, $email)
    {
        $this->setName($name);
        $this->setEmail($email);
        $this->users = new ArrayCollection();
        $this->operators = new ArrayCollection();
        $this->treatments = new ArrayCollection();
        $this->customers = new ArrayCollection();
        $this->rooms = new ArrayCollection();
        $this->reservations = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

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

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setSpa($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getSpa() === $this) {
                $user->setSpa(null);
            }
        }

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
            $operator->setSpa($this);
        }

        return $this;
    }

    public function removeOperator(Operator $operator): self
    {
        if ($this->operators->contains($operator)) {
            $this->operators->removeElement($operator);
            // set the owning side to null (unless already changed)
            if ($operator->getSpa() === $this) {
                $operator->setSpa(null);
            }
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Treatment[]
     */
    public function getTreatments(): Collection
    {
        return $this->treatments;
    }

    public function addTreatment(Treatment $treatment): self
    {
        if (!$this->treatments->contains($treatment)) {
            $this->treatments[] = $treatment;
            $treatment->setSpa($this);
        }

        return $this;
    }

    public function removeTreatment(Treatment $treatment): self
    {
        if ($this->treatments->contains($treatment)) {
            $this->treatments->removeElement($treatment);
            // set the owning side to null (unless already changed)
            if ($treatment->getSpa() === $this) {
                $treatment->setSpa(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Customer[]
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers[] = $customer;
            $customer->setSpa($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        if ($this->customers->contains($customer)) {
            $this->customers->removeElement($customer);
            // set the owning side to null (unless already changed)
            if ($customer->getSpa() === $this) {
                $customer->setSpa(null);
            }
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
            $room->setSpa($this);
        }

        return $this;
    }

    public function removeRoom(Room $room): self
    {
        if ($this->rooms->contains($room)) {
            $this->rooms->removeElement($room);
            // set the owning side to null (unless already changed)
            if ($room->getSpa() === $this) {
                $room->setSpa(null);
            }
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
            $reservation->setSpa($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getSpa() === $this) {
                $reservation->setSpa(null);
            }
        }

        return $this;
    }
}

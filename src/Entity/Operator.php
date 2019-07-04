<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="operators")
 * @ORM\Entity(repositoryClass="App\Repository\OperatorRepository")
 */
class Operator
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
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $phoneNumber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SPA", inversedBy="operators")
     * @ORM\JoinColumn(nullable=false)
     * @var SPA
     */
    private $spa;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Treatment", mappedBy="operators")
     * @var Collection|Treatment[]
     */
    private $treatments;

    public function __construct(string $first_name, string $last_name, SPA $spa )
    {
        $this->setFirstName($first_name);
        $this->setLastName($last_name);
        $this->setSpa($spa);
        $this->treatments = new ArrayCollection();
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

    public function getSpa(): SPA
    {
        return $this->spa;
    }

    public function setSpa(SPA $spa): self
    {
        $this->spa = $spa;

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
            $treatment->addOperator($this);
        }

        return $this;
    }

    public function removeTreatment(Treatment $treatment): self
    {
        if ($this->treatments->contains($treatment)) {
            $this->treatments->removeElement($treatment);
            $treatment->removeOperator($this);
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
}

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
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $phone_number;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SPA", inversedBy="operators")
     * @ORM\JoinColumn(nullable=false)
     * @var SPA
     */
    private $spa;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Treatment", mappedBy="operator")
     * @var Collection|Treatment[]
     */
    private $treatments;

    public function __construct($first_name, $last_name, $spa )
    {
        $this->setFirstName($first_name);
        $this->setLastName($last_name);
        $this->setSpa($spa);
        $this->treatments = new ArrayCollection();
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

    public function getSpa(): ?SPA
    {
        return $this->spa;
    }

    public function setSpa(?SPA $spa): self
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
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }
}

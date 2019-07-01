<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="users")

 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=45)
     * @Assert\Regex(
     *     pattern     = "/^[a-z ]+$/i",
     *     match=true,
     *     message="DTO.UserDTO.Name.LettersOnly"
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     * )
     * @var string
     */
    private $name;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=45)
     * @Assert\Regex(
     *     pattern     = "/^[a-z ]+$/i",
     *     match=true,
     *     message="DTO.UserDTO.LastName.LettersOnly"
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     * )
     * @var string
     */
    private $lastName;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     * @ORM\Column(type="string", length=180)
     * @var string
     */
    private $email;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     * )
     * @ORM\Column(type="string")
     * @var string
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     * @var array
     */
    private $roles = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SPA", inversedBy="users")
     * @var SPA
     */
    private $spa;

    public function __construct($name, $last_name, $email, $password, $roles)
    {
        $this->setName($name);
        $this->setLastName($last_name);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setRoles($roles);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

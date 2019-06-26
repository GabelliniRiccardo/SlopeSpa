<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="users")
 * @UniqueEntity("email")
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
     *     message="Name cannot contain a number"
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     *      minMessage = "The User's name must be at least {{ limit }} characters long",
     *      maxMessage = "The User's name cannot be longer than {{ limit }} characters"
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
     *     message="Last name cannot contain a number"
     * )
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     *      minMessage = "The User's last name must be at least {{ limit }} characters long",
     *      maxMessage = "The User's last name cannot be longer than {{ limit }} characters"
     * )
     * @var string
     */
    private $lastName;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     * @ORM\Column(type="string", length=180, unique=true)
     * @var string
     */
    private $email;

    /**
     * @var string The hashed password
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     *      minMessage = "Password must be at least {{ limit }} characters long",
     *      maxMessage = "Passwordcannot be longer than {{ limit }} characters"
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

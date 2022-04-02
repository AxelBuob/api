<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Validator;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['get', 'delete'],
    denormalizationContext: ['groups' => ['write']],
    normalizationContext: ['groups' => ['read']],
)]
class User implements PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read', 'write'])]
    private $id;

    #[ORM\Column(type: 'string', length: 180)]
    #[Groups(['read', 'write'])]
    #[Validator\NotBlank(message: 'Le champ email ne doit pas être vide.')]
    #[Validator\Email(message: 'Le champ email doit être un email valide.')]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read', 'write'])]
    #[Validator\NotBlank(message: 'Le mot de passe ne doit pas être vide.')]
    #[Validator\Length(
        max: 255,
        maxMessage: 'Le mot de passe ne doit pas faire plus de {{ limit }} caractères.'
    )]
    private $password;

    #[ORM\Column(type: 'string', length: 100)]
    #[Groups(['read', 'write'])]
    #[Validator\NotBlank(message: 'Le prénom ne doit pas être vide.')]
    #[Validator\Length(
        min: 2,
        max: 255,
        minMessage: 'Le nom doit faire au moins {{ limit }} caractères.',
        maxMessage: 'Le nom ne doit pas faire plus de {{ limit }} caractères.'
    )]
    private $firstName;

    #[ORM\Column(type: 'string', length: 100)]
    #[Groups(['read', 'write'])]
    #[Validator\NotBlank(message: 'Le prénom ne doit pas être vide.')]
    #[Validator\Length(
        min: 2,
        max: 255,
        minMessage: 'Le prénom doit faire au moins {{ limit }} caractères.',
        maxMessage: 'Le prénom ne doit pas faire plus de {{ limit }} caractères.'
    )]
    private $lastName;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['write'])]
    private $customer;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

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

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}

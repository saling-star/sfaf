<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
class Person
{
    const FIELDTYPE = ['firstName'=>'string', 'lastName'=>'string', 'fullName'=>'string', 'name'=>'string', 'phone'=>'string', 'email'=>'string', 'address'=>'string', 'addDetail'=>'string', 'city'=>'string', 'district'=>'string', 'zip'=>'string', 'comment'=>'text', 'createdAt'=>'datetime'];

    const FLDTYPE = ['firstName'=>'string', 'lastName'=>'string', 'fullName'=>'string', 'name'=>'string', 'phone'=>'string', 'email'=>'string',];

    const FLDG = ['fullName'=>'string', 'name'=>'string',];

    const FLDH = ['firstName'=>'string', 'lastName'=>'string', 'fullName'=>'string', 'name'=>'string',];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 63, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(length: 63, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(length: 127, nullable: true)]
    private ?string $fullName = null;

    #[ORM\Column(length: 27)]
    private ?string $name = null;

    #[ORM\Column(length: 63)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $addDetail = null;

    #[ORM\Column(length: 63)]
    private ?string $city = null;

    #[ORM\Column(length: 127, nullable: true)]
    private ?string $district = null;

    #[ORM\Column(length: 31)]
    private ?string $zip = null;

    #[ORM\Column(type: Types::TEXT, length: 4095, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): static
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getAddDetail(): ?string
    {
        return $this->addDetail;
    }

    public function setAddDetail(?string $addDetail): static
    {
        $this->addDetail = $addDetail;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getDistrict(): ?string
    {
        return $this->district;
    }

    public function setDistrict(?string $district): static
    {
        $this->district = $district;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): static
    {
        $this->zip = $zip;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}

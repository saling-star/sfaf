<?php

namespace App\Entity;

use App\Repository\MedicalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedicalRepository::class)]
class Medical
{
    const FIELDTYPE = ['refId'=>'integer', 'category'=>'string', 'dateO'=>'datetime', 'whenO'=>'string', 'whereO'=>'string', 'whoO'=>'string', 'person'=>'string', 'title'=>'string', 'description'=>'text',];

    const FLDTYPE = ['category'=>'string', 'dateO'=>'datetime', 'whenO'=>'string', 'whereO'=>'string', 'whoO'=>'string', 'person'=>'string', 'title'=>'string',];

    const FLDG = ['category'=>'string',];

    const FLDH = ['category'=>'string','whoO'=>'string', 'person'=>'string', ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $refId = null;

    #[ORM\Column(length: 63, nullable: true)]
    private ?string $category = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $dateO = null;

    #[ORM\Column(length: 31, nullable: true)]
    private ?string $whenO = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $whereO = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $whoO = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $person = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefId(): ?int
    {
        return $this->refId;
    }

    public function setRefId(?int $refId): static
    {
        $this->refId = $refId;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getDateO(): ?\DateTimeImmutable
    {
        return $this->dateO;
    }

    public function setDateO(?\DateTimeImmutable $dateO): static
    {
        $this->dateO = $dateO;

        return $this;
    }

    public function getWhenO(): ?string
    {
        return $this->whenO;
    }

    public function setWhenO(?string $whenO): static
    {
        $this->whenO = $whenO;

        return $this;
    }

    public function getWhereO(): ?string
    {
        return $this->whereO;
    }

    public function setWhereO(?string $whereO): static
    {
        $this->whereO = $whereO;

        return $this;
    }

    public function getWhoO(): ?string
    {
        return $this->whoO;
    }

    public function setWhoO(?string $whoO): static
    {
        $this->whoO = $whoO;

        return $this;
    }

    public function getPerson(): ?string
    {
        return $this->person;
    }

    public function setPerson(?string $person): static
    {
        $this->person = $person;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}

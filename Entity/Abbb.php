<?php

namespace App\Entity;

use App\Repository\AbbbRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbbbRepository::class)]
class Abbb
{
    const FIELDTYPE = ['dir'=>'string', 'year'=>'string', 'month'=>'string', 'upuSlug'=>'string', 'upvSlug'=>'string', 'date'=>'string', 'affect'=>'string', 'value'=>'string', 'description'=>'string', 'category'=>'string', 'reference'=>'string', ];

    const FLDTYPE = ['dir'=>'string', 'year'=>'string', 'month'=>'string', 'upuSlug'=>'string', 'upvSlug'=>'string', 'date'=>'string', 'affect'=>'string', 'value'=>'string', 'description'=>'string', 'category'=>'string', 'reference'=>'string', ];

    const FLDG = ['dir'=>'string', 'category'=>'string', ];

    const FLDH = ['dir'=>'string', 'category'=>'string', 'year'=>'string', ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ulowers')]
    private ?Aacb $upperU = null;

    #[ORM\ManyToOne(inversedBy: 'vlowers')]
    private ?Aacb $upperV = null;

    #[ORM\Column(length: 63, nullable: true)]
    private ?string $upuSlug = null;

    #[ORM\Column(length: 63, nullable: true)]
    private ?string $upvSlug = null;

    #[ORM\Column(length: 31, nullable: true)]
    private ?string $date = null;

    #[ORM\Column(length: 31, nullable: true)]
    private ?string $affect = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $value = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 31, nullable: true)]
    private ?string $category = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $dir = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $year = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $month = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reference = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUpperU(): ?Aacb
    {
        return $this->upperU;
    }

    public function setUpperU(?Aacb $upperU): static
    {
        $this->upperU = $upperU;

        return $this;
    }

    public function getUpperV(): ?Aacb
    {
        return $this->upperV;
    }

    public function setUpperV(?Aacb $upperV): static
    {
        $this->upperV = $upperV;

        return $this;
    }

    public function getUpuSlug(): ?string
    {
        return $this->upuSlug;
    }

    public function setUpuSlug(?string $upuSlug): static
    {
        $this->upuSlug = $upuSlug;

        return $this;
    }

    public function getUpvSlug(): ?string
    {
        return $this->upvSlug;
    }

    public function setUpvSlug(?string $upvSlug): static
    {
        $this->upvSlug = $upvSlug;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getAffect(): ?string
    {
        return $this->affect;
    }

    public function setAffect(?string $affect): static
    {
        $this->affect = $affect;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): static
    {
        $this->value = $value;

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

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getDir(): ?string
    {
        return $this->dir;
    }

    public function setDir(?string $dir): static
    {
        $this->dir = $dir;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getMonth(): ?int
    {
        return $this->month;
    }

    public function setMonth(?int $month): static
    {
        $this->month = $month;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }
}

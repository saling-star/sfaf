<?php

namespace App\Entity;

use App\Repository\WwwwRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WwwwRepository::class)]
class Wwww
{
    const FIELDTYPE = ['categ'=>'string', 'fai'=>'string', 'mmm'=>'string', 'nnn'=>'string', 'ppp'=>'string', 'status'=>'string', 'extra'=>'string',];

    const FLDTYPE = ['categ'=>'string', 'fai'=>'string', 'nnn'=>'string', 'status'=>'string', 'extra'=>'string',];

    const FLDG = ['categ'=>'string', ];

    const FLDH = ['categ'=>'string', 'fai'=>'string', ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 63, nullable: true)]
    private ?string $categ = null;

    #[ORM\Column(length: 63, nullable: true)]
    private ?string $fai = null;

    #[ORM\Column(length: 63, nullable: true)]
    private ?string $mmm = null;

    #[ORM\Column(length: 63, nullable: true)]
    private ?string $nnn = null;

    #[ORM\Column(length: 63, nullable: true)]
    private ?string $ppp = null;

    #[ORM\Column(length: 63, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(length: 4095, nullable: true)]
    private ?string $extra = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCateg(): ?string
    {
        return $this->categ;
    }

    public function setCateg(?string $categ): static
    {
        $this->categ = $categ;

        return $this;
    }

    public function getFai(): ?string
    {
        return $this->fai;
    }

    public function setFai(?string $fai): static
    {
        $this->fai = $fai;

        return $this;
    }

    public function getMmm(): ?string
    {
        return $this->mmm;
    }

    public function setMmm(?string $mmm): static
    {
        $this->mmm = $mmm;

        return $this;
    }

    public function getNnn(): ?string
    {
        return $this->nnn;
    }

    public function setNnn(?string $nnn): static
    {
        $this->nnn = $nnn;

        return $this;
    }

    public function getPpp(): ?string
    {
        return $this->ppp;
    }

    public function setPpp(?string $ppp): static
    {
        $this->ppp = $ppp;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getExtra(): ?string
    {
        return $this->extra;
    }

    public function setExtra(?string $extra): static
    {
        $this->extra = $extra;

        return $this;
    }
}

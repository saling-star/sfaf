<?php

namespace App\Entity;

//use App\Entity\Qccc as Ulower;
//use App\Entity\Qaaa as Vlower;
use App\Repository\QdddRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QdddRepository::class)]
class Qddd
{
    const FIELDTYPE = ['upuId'=>'int', 'upvId'=>'int', 'num'=>'int', 'name'=>'string', 'content'=>'string', 'qfffId'=>'int',];

    const FLDTYPE = ['upuId'=>'int', 'upvId'=>'int', 'num'=>'int', 'name'=>'string', 'content'=>'string', 'qfffId'=>'int',];

    const FLDG = ['upuId'=>'int',];

    const FLDH = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ulowers', cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Qccc $upperU = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $upuId = null;

    #[ORM\ManyToOne(inversedBy: 'ulowers', cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Qeee $upperV = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $upvId = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $num = null;

    #[ORM\Column(length: 63)]
    private ?string $name = null;

    #[ORM\Column(nullable: true, length: 255)]
    private ?string $content = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $qfffId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUpperU(): ?Qccc
    {
        return $this->upperU;
    }

    public function setUpperU(?Qccc $upperU): static
    {
        $this->upperU = $upperU;

        return $this;
    }

    public function getUpuId(): ?int
    {
        return $this->upuId;
    }

    public function setUpuId(int $upuId): static
    {
        $this->upuId = $upuId;

        return $this;
    }

    public function getUpperV(): ?Qeee
    {
        return $this->upperV;
    }

    public function setUpperV(?Qeee $upperV): static
    {
        $this->upperV = $upperV;

        return $this;
    }

    public function getUpvId(): ?int
    {
        return $this->upvId;
    }

    public function setUpvId(int $upvId): static
    {
        $this->upvId = $upvId;

        return $this;
    }

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(int $num): static
    {
        $this->num = $num;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getQfffId(): ?int
    {
        return $this->qfffId;
    }

    public function setQfffId(?int $qfffId): static
    {
        $this->qfffId = $qfffId;

        return $this;
    }
}

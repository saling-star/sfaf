<?php

namespace App\Entity;

use App\Entity\Qddd as Ulower;
//use App\Entity\Qddd as Vlower;
use App\Repository\QcccRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QcccRepository::class)]
class Qccc
{
    const FIELDTYPE = ['upuId'=>'int', 'num'=>'int', 'name'=>'string', 'label'=>'string', 'content'=>'string',];

    const FLDTYPE = ['upuId'=>'int', 'num'=>'int', 'name'=>'string', 'label'=>'string', 'content'=>'string',];

    const FLDG = ['name'=>'string', 'label'=>'string', ];

    const FLDH = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ulowers', cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Qbbb $upperU = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $upuId = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $num = null;

    #[ORM\Column(length: 63)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, length: 255)]
    private ?string $label = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, length: 1023)]
    private ?string $content = null;

    #[ORM\OneToMany(mappedBy: 'upperU', targetEntity: Ulower::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $ulowers;

    public function __construct()
    {
        $this->ulowers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUpperU(): ?Qbbb
    {
        return $this->upperU;
    }

    public function setUpperU(?Qbbb $upperU): static
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

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

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

    /**
     * @return Collection<int, Ulower>
     */
    public function getUlowers(): Collection
    {
        return $this->ulowers;
    }

    public function addUlower(Ulower $ulower): static
    {
        if (!$this->ulowers->contains($ulower)) {
            $this->ulowers->add($ulower);
            $ulower->setUpperU($this);
        }

        return $this;
    }

    public function removeUlower(Ulower $ulower): static
    {
        if ($this->ulowers->removeElement($ulower)) {
            // set the owning side to null (unless already changed)
            if ($ulower->getUpperU() === $this) {
                $ulower->setUpperU(null);
            }
        }

        return $this;
    }
}

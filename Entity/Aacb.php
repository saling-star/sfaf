<?php

namespace App\Entity;

use App\Repository\AacbRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AacbRepository::class)]
class Aacb
{
    const FIELDTYPE = ['uptSlug'=>'string', 'code'=>'string', 'slug'=>'string', 'title'=>'string', 'description'=>'string', 'sumT'=>'integer', 'sumU'=>'integer', 'sumV'=>'integer', ];

    const FLDTYPE = ['uptSlug'=>'string', 'code'=>'string', 'slug'=>'string', 'title'=>'string', 'description'=>'string', 'sumT'=>'integer', 'sumU'=>'integer', 'sumV'=>'integer', ];

    const FLDG = ['uptSlug'=>'string',];// 'code'=>'string', 'slug'=>'string',];

    const FLDH = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'tlowers')]
    private ?self $upperT = null;

    #[ORM\OneToMany(mappedBy: 'upperT', targetEntity: self::class)]
    private Collection $tlowers;

    #[ORM\Column(length: 63, nullable: true)]
    private ?string $uptSlug = null;

    #[ORM\Column(length: 63, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 63, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(length: 63, nullable: true)]
    private ?string $code = null;

    #[ORM\OneToMany(mappedBy: 'upperU', targetEntity: Abbb::class)]
    private Collection $ulowers;

    #[ORM\OneToMany(mappedBy: 'upperV', targetEntity: Abbb::class)]
    private Collection $vlowers;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $sumT = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $sumU = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $sumV = null;

    public function __construct()
    {
        $this->tlowers = new ArrayCollection();
        $this->ulowers = new ArrayCollection();
        $this->vlowers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUpperT(): ?self
    {
        return $this->upperT;
    }

    public function setUpperT(?self $upperT): static
    {
        $this->upperT = $upperT;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getTlowers(): Collection
    {
        return $this->tlowers;
    }

    public function addTlower(self $tlower): static
    {
        if (!$this->tlowers->contains($tlower)) {
            $this->tlowers->add($tlower);
            $tlower->setUpperT($this);
        }

        return $this;
    }

    public function removeTlower(self $tlower): static
    {
        if ($this->tlowers->removeElement($tlower)) {
            // set the owning side to null (unless already changed)
            if ($tlower->getUpperT() === $this) {
                $tlower->setUpperT(null);
            }
        }

        return $this;
    }

    public function getUptSlug(): ?string
    {
        return $this->uptSlug;
    }

    public function setUptSlug(?string $uptSlug): static
    {
        $this->uptSlug = $uptSlug;

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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Abbb>
     */
    public function getUlowers(): Collection
    {
        return $this->ulowers;
    }

    public function addUlower(Abbb $ulower): static
    {
        if (!$this->ulowers->contains($ulower)) {
            $this->ulowers->add($ulower);
            $ulower->setUpperU($this);
        }

        return $this;
    }

    public function removeUlower(Abbb $ulower): static
    {
        if ($this->ulowers->removeElement($ulower)) {
            // set the owning side to null (unless already changed)
            if ($ulower->getUpperU() === $this) {
                $ulower->setUpperU(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Abbb>
     */
    public function getVlowers(): Collection
    {
        return $this->vlowers;
    }

    public function addVlower(Abbb $vlower): static
    {
        if (!$this->vlowers->contains($vlower)) {
            $this->vlowers->add($vlower);
            $vlower->setUpperV($this);
        }

        return $this;
    }

    public function removeVlower(Abbb $vlower): static
    {
        if ($this->vlowers->removeElement($vlower)) {
            // set the owning side to null (unless already changed)
            if ($vlower->getUpperV() === $this) {
                $vlower->setUpperV(null);
            }
        }

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

    public function getSumT(): ?int
    {
        return $this->sumT;
    }

    public function setSumT(?int $sumT): static
    {
        $this->sumT = $sumT;

        return $this;
    }

    public function getSumU(): ?int
    {
        return $this->sumU;
    }

    public function setSumU(?int $sumU): static
    {
        $this->sumU = $sumU;

        return $this;
    }

    public function getSumV(): ?int
    {
        return $this->sumV;
    }

    public function setSumV(?int $sumV): static
    {
        $this->sumV = $sumV;

        return $this;
    }
}

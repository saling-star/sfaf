<?php

namespace App\Entity;

use App\Entity\Qccc as Ulower;
use App\Entity\Qaaa as Vlower;
use App\Repository\QbbbRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QbbbRepository::class)]
class Qbbb
{
    const FIELDTYPE = ['title'=>'string', 'slug'=>'string', 'description'=>'string',];

    const FLDTYPE = ['title'=>'string', 'slug'=>'string', 'description'=>'string',];

    const FLDG = ['title'=>'string',];

    const FLDH = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 63)]
    private ?string $title = null;

    #[Gedmo\Slug(fields: "title")]
    #[ORM\Column(length: 63, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, length: 4095)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'upperU', targetEntity: Ulower::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $ulowers;

    #[ORM\OneToMany(mappedBy: 'upperV', targetEntity: Vlower::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $vlowers;

    public function __construct()
    {
        $this->ulowers = new ArrayCollection();
        $this->vlowers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    /**
     * @return Collection<int, Vlower>
     */
    public function getVlowers(): Collection
    {
        return $this->vlowers;
    }

    public function addVlower(Vlower $vlower): static
    {
        if (!$this->vlowers->contains($vlower)) {
            $this->vlowers->add($vlower);
            $vlower->setUpperV($this);
        }

        return $this;
    }

    public function removeVlower(Vlower $vlower): static
    {
        if ($this->vlowers->removeElement($vlower)) {
            // set the owning side to null (unless already changed)
            if ($vlower->getUpperV() === $this) {
                $vlower->setUpperV(null);
            }
        }

        return $this;
    }
}

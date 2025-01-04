<?php

namespace App\Entity;

//use App\Entity\Qddd as Ulower;
use App\Entity\Qddd as Vlower;
use App\Repository\QeeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QeeeRepository::class)]
class Qeee
{
    const FIELDTYPE = ['upuId'=>'int', 'eString'=>'string', 'fString'=>'string', 'gText'=>'string', 'hText'=>'string', 'createdAt'=>'datetime',];

    const FLDTYPE = ['upuId'=>'int', 'eString'=>'string', 'fString'=>'string', 'gText'=>'string', 'hText'=>'string', 'createdAt'=>'datetime',];

    const FLDG = ['upuId'=>'int',];

    const FLDH = null;

    const CMSTYPE = ['eString'=>'string', 'createdAt'=>'datetime',];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 63)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'ulowers', cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Qaaa $upperU = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $upuId = null;

    #[ORM\Column(nullable: true, length: 255)]
    private ?string $eString = null;

    #[ORM\Column(nullable: true, length: 255)]
    private ?string $fString = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, length: 1023)]
    private ?string $gText = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, length: 1023)]
    private ?string $hText = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'upperV', targetEntity: Vlower::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $vlowers;//Qddd

    public function __construct()
    {
        $this->vlowers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getUpperU(): ?Qaaa
    {
        return $this->upperU;
    }

    public function setUpperU(?Qaaa $upperU): static
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

    public function getEString(): ?string
    {
        return $this->eString;
    }

    public function setEString(string $eString): static
    {
        $this->eString = $eString;

        return $this;
    }

    public function getFString(): ?string
    {
        return $this->fString;
    }

    public function setFString(string $fString): static
    {
        $this->fString = $fString;

        return $this;
    }

    public function getGText(): ?string
    {
        return $this->gText;
    }

    public function setGText(?string $gText): static
    {
        $this->gText = $gText;

        return $this;
    }

    public function getHText(): ?string
    {
        return $this->hText;
    }

    public function setHText(?string $hText): static
    {
        $this->hText = $hText;

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

<?php

namespace App\Entity;

use App\Entity\Qeee as Ulower;
//use App\Entity\Qaaa as Vlower;
use App\Repository\QaaaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QaaaRepository::class)]
class Qaaa
{
    const FIELDTYPE = ['upvId'=>'integer', 'status'=>'string', 'title'=>'string', 'slug'=>'string', 'description'=>'string', 'message'=>'string', 'mailFrom'=>'string', 'mailTo'=>'string', 'returnLink'=>'string',];

    const FLDTYPE = ['upvId'=>'integer', 'status'=>'string', 'title'=>'string', 'slug'=>'string', 'description'=>'string', 'message'=>'string', 'mailFrom'=>'string', 'mailTo'=>'string', 'returnLink'=>'string',];

    const FLDG = ['mailFrom'=>'string', 'mailTo'=>'string',];

    const FLDH = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 63)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'qaaas')]
    private ?Qbbb $upperV = null;

    #[ORM\Column]
    private ?int $upvId = null;

    #[ORM\Column(length: 63)]
    private ?string $title = null;

    #[ORM\Column(length: 63)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, length: 1023)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, length: 1023)]
    private ?string $message = null;

    #[ORM\Column(length: 63, nullable: true)]
    private ?string $mailFrom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mailTo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $returnLink = null;

    #[ORM\OneToMany(mappedBy: 'upperU', targetEntity: Ulower::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $ulowers; //Qeee

    public function __construct()
    {
        $this->ulowers = new ArrayCollection();
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

    public function getUpperV(): ?Qbbb
    {
        return $this->upperV;
    }

    public function setUpperV(?Qbbb $upperV): static
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

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getMailFrom(): ?string
    {
        return $this->mailFrom;
    }

    public function setMailFrom(?string $mailFrom): static
    {
        $this->mailFrom = $mailFrom;

        return $this;
    }

    public function getMailTo(): ?string
    {
        return $this->mailTo;
    }

    public function setMailTo(?string $mailTo): static
    {
        $this->mailTo = $mailTo;

        return $this;
    }

    public function getReturnLink(): ?string
    {
        return $this->returnLink;
    }

    public function setReturnLink(?string $returnLink): static
    {
        $this->returnLink = $returnLink;

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
            $ulower->setUpperV($this);
        }

        return $this;
    }

    public function removeUlower(Ulower $ulower): static
    {
        if ($this->ulowers->removeElement($ulower)) {
            // set the owning side to null (unless already changed)
            if ($ulower->getUpperV() === $this) {
                $ulower->setUpperV(null);
            }
        }

        return $this;
    }
}

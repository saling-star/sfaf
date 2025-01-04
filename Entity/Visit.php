<?php

namespace App\Entity;

use App\Repository\VisitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisitRepository::class)]
class Visit
{
    const FIELDTYPE = ['createdAt'=>'datetime', 'delay'=>'integer', 'addr'=>'string', 'name'=>'string', 'root'=>'string', 'uri'=>'string', 'query'=>'string', 'referer'=>'string', 'userAgent'=>'string', ];//'cookie'=>'string', 

    const FLDTYPE = ['createdAt'=>'datetime', 'delay'=>'integer', 'addr'=>'string', 'name'=>'string', 'root'=>'string', 'uri'=>'string', 'query'=>'string',];// 'referer'=>'string', 'userAgent'=>'string', 'cookie'=>'string', 

    const FLDG = ['name'=>'string',];

    const FLDH = ['name'=>'string', 'root'=>'string',];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?int $delay = null;

    #[ORM\Column(length: 31, nullable: true)]
    private ?string $addr = null;

    #[ORM\Column(length: 31, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $root = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $uri = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $query = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $referer = null;

    #[ORM\Column(length: 1023, nullable: true)]
    private ?string $userAgent = null;

    #[ORM\Column(length: 1023, nullable: true)]
    private ?string $cookie = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDelay(): ?int
    {
        return $this->delay;
    }

    public function setDelay(int $delay): static
    {
        $this->delay = $delay;

        return $this;
    }

    public function getAddr(): ?string
    {
        return $this->addr;
    }

    public function setAddr(string $addr): static
    {
        $this->addr = $addr;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getRoot(): ?string
    {
        return $this->root;
    }

    public function setRoot(?string $root): static
    {
        $this->root = $root;

        return $this;
    }

    public function getUri(): ?string
    {
        return $this->uri;
    }

    public function setUri(?string $uri): static
    {
        $this->uri = $uri;

        return $this;
    }

    public function getQuery(): ?string
    {
        return $this->query;
    }

    public function setQuery(string $query): static
    {
        $this->query = $query;

        return $this;
    }

    public function getReferer(): ?string
    {
        return $this->referer;
    }

    public function setReferer(?string $referer): static
    {
        $this->referer = $referer;

        return $this;
    }

    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    public function setUserAgent(?string $userAgent): static
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    public function getCookie(): ?string
    {
        return $this->cookie;
    }

    public function setCookie(?string $cookie): static
    {
        $this->cookie = $cookie;

        return $this;
    }
}

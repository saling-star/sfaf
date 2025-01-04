<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use App\Repository\QfffRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QfffRepository::class)]
class Qfff
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $longcontent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongcontent(): ?string
    {
        return $this->longcontent;
    }

    public function setLongcontent(string $longcontent): static
    {
        $this->longcontent = $longcontent;

        return $this;
    }
}

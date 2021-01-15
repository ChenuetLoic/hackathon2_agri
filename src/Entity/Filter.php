<?php

namespace App\Entity;

use App\Repository\FilterRepository;
use Doctrine\ORM\Mapping as ORM;

class Filter
{
    private $role;

    private $category;

    private $farmSize;

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getCategory(): array
    {
        return $this->category;
    }

    public function setCategory(array $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getFarmSize(): ?string
    {
        return $this->farmSize;
    }

    public function setFarmSize(string $farmSize): self
    {
        $this->farmSize = $farmSize;

        return $this;
    }
}

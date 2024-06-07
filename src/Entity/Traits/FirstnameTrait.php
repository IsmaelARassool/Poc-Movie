<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait FirstnameTrait
{
    #[ORM\Column(length: 50, nullable: false)]
    private ?string $firstname = null;
    
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname = null): self
    {
        $this->firstname = $firstname;

        return $this;
    }
}

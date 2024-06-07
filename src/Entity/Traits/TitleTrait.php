<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait TitleTrait
{
    #[ORM\Column(length: 80, nullable: false)]
    private ?string $title = null;
    
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title = null): self
    {
        $this->title = $title;

        return $this;
    }
}

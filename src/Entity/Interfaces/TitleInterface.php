<?php

namespace App\Entity\Interfaces;

interface TitleInterface
{
    public function getTitle(): ?string;
    
    public function setTitle(?string $title = null): self;
}

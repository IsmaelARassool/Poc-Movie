<?php

namespace App\Entity\Interfaces;

interface FirstnameInterface
{
    public function getFirstname(): ?string;
    
    public function setFirstname(?string $firstname = null): self;
}

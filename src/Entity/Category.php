<?php

namespace App\Entity;

use App\Entity\Interfaces\IdInterface;
use App\Entity\Interfaces\TitleInterface;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TitleTrait;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: '`category`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_TITLE', fields: ['title'])]
#[UniqueEntity(fields: ['title'], message: 'There is already category with this title')]
class Category implements IdInterface, TitleInterface
{
    use IdTrait;
    use TitleTrait;
}

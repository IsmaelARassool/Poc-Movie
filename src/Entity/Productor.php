<?php

namespace App\Entity;

use App\Entity\Interfaces\FirstnameInterface;
use App\Entity\Interfaces\IdInterface;
use App\Entity\Interfaces\NameInterface;
use App\Entity\Traits\FirstnameTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\NameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ProductorRepository::class)]
#[ORM\Table(name: '`productor`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_NAME', fields: ['name','firstname'])]
#[UniqueEntity(fields: ['name','firstname'], message: 'There is already productor with this name and firstname')]
class Productor implements FirstnameInterface, IdInterface, NameInterface
{
    use IdTrait;
    use NameTrait;
    use FirstnameTrait;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\OneToMany(mappedBy: 'productor', targetEntity: Movie::class, orphanRemoval: true)]
    private Collection $movies;

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * @return Collection|Movie[]
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): static
    {
        if (!$this->movies->contains($movie)) {
            $this->movies[] = $movie;
            $movie->setProductor($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): static
    {
        if ($this->movies->removeElement($movie)) {
            // set the owning side to null (unless already changed)
            if ($movie->getProductor() === $this) {
                $movie->setProductor(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Entity\Interfaces\IdInterface;
use App\Entity\Interfaces\TitleInterface;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TitleTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ORM\Table(name: '`movie`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_TITLE', fields: ['title'])]
#[UniqueEntity(fields: ['title'], message: 'There is already a movie with this name')]
class Movie implements IdInterface, TitleInterface
{
    use IdTrait;
    use TitleTrait;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $releaseAt = null;

    #[ORM\Column(length: 180)]
    private ?string $synopsis = null;

    #[ORM\ManyToOne(targetEntity: Productor::class, inversedBy: 'movies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Productor $productor = null;

    #[ORM\ManyToMany(targetEntity: Category::class)]
    #[ORM\JoinTable(name: 'movie_category')]
    private Collection $categories;

    public function getReleaseAt(): ?\DateTimeInterface
    {
        return $this->releaseAt;
    }

    public function setReleaseAt(\DateTimeInterface $releaseAt): static
    {
        $this->releaseAt = $releaseAt;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): static
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getProductor(): ?Productor
    {
        return $this->productor;
    }

    public function setProductor(?Productor $productor): static
    {
        $this->productor = $productor;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }
}

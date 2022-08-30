<?php

namespace App\Entity;

use App\Repository\ModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModelRepository::class)]
class Model
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'model')]
    private ?Brand $brand = null;

    #[ORM\OneToMany(mappedBy: 'model', targetEntity: Listing::class)]
    private Collection $listing;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picturePath = null;

    public function __construct()
    {
        $this->listing = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection<int, Listing>
     */
    public function getListing(): Collection
    {
        return $this->listing;
    }

    public function addListing(Listing $listing): self
    {
        if (!$this->listing->contains($listing)) {
            $this->listing->add($listing);
            $listing->setModel($this);
        }

        return $this;
    }

    public function removeListing(Listing $listing): self
    {
        if ($this->listing->removeElement($listing)) {
            // set the owning side to null (unless already changed)
            if ($listing->getModel() === $this) {
                $listing->setModel(null);
            }
        }

        return $this;
    }

    public function getPicturePath(): ?string
    {
        return $this->picturePath;
    }

    public function setPicturePath(?string $picturePath): self
    {
        $this->picturePath = $picturePath;

        return $this;
    }
}

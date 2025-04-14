<?php

namespace App\Entity;

use App\Repository\FoodRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: FoodRepository::class)]
class Food
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    #[Groups("food", "takeAwayBooking")]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups("food", "takeAwayBooking")]
    private ?float $price = null;

    #[ORM\Column]
    #[Groups("food")]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups("food")]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Picture>
     */
    #[ORM\OneToMany(targetEntity: Picture::class, mappedBy: 'food', orphanRemoval: true)]
    private Collection $pictures;

    #[ORM\ManyToOne(inversedBy: 'food')]
    #[Groups("category", "food")]
    private ?Category $category = null;

    /**
     * @var Collection<int, TakeAwayBooking>
     */
    #[ORM\ManyToMany(targetEntity: TakeAwayBooking::class, inversedBy: 'food')]
    #[Groups("takeAwayBooking")]
    private Collection $takeAwayBooking;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->takeAwayBooking = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Picture>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): static
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures->add($picture);
            $picture->setFood($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): static
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getFood() === $this) {
                $picture->setFood(null);
            }
        }
        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, TakeAwayBooking>
     */
    public function getTakeAwayBooking(): Collection
    {
        return $this->takeAwayBooking;
    }

    public function addTakeAwayBooking(TakeAwayBooking $takeAwayBooking): static
    {
        if (!$this->takeAwayBooking->contains($takeAwayBooking)) {
            $this->takeAwayBooking->add($takeAwayBooking);
        }

        return $this;
    }

    public function removeTakeAwayBooking(TakeAwayBooking $takeAwayBooking): static
    {
        $this->takeAwayBooking->removeElement($takeAwayBooking);

        return $this;
    }
}

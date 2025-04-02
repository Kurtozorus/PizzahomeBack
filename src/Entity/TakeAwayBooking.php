<?php

namespace App\Entity;

use App\Repository\TakeAwayBookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TakeAwayBookingRepository::class)]
class TakeAwayBooking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Food>
     */
    #[ORM\OneToMany(targetEntity: Food::class, mappedBy: 'takeawaybooking', orphanRemoval: true)]
    private Collection $food;

    public function __construct()
    {
        $this->food = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Food>
     */
    public function getFood(): Collection
    {
        return $this->food;
    }

    public function addFood(Food $food): static
    {
        if (!$this->food->contains($food)) {
            $this->food->add($food);
            $food->setTakeawaybooking($this);
        }

        return $this;
    }

    public function removeFood(Food $food): static
    {
        if ($this->food->removeElement($food)) {
            // set the owning side to null (unless already changed)
            if ($food->getTakeawaybooking() === $this) {
                $food->setTakeawaybooking(null);
            }
        }

        return $this;
    }
}

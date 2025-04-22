<?php

namespace App\Entity;

use App\Repository\TakeAwayBookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: TakeAwayBookingRepository::class)]
class TakeAwayBooking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(nullable: true)]
    #[Groups("takeAwayBookings")]
    private ?int $id = null;

    /**
     * @var Collection<int, Food>
     */
    #[ORM\ManyToMany(targetEntity: Food::class, cascade: ['persist'], mappedBy: 'takeAwayBooking')]
    #[Groups("takeAwayBookings")]
    private Collection $food;

    #[ORM\ManyToOne(inversedBy: 'takeAwayBookings')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups("takeAwayBookings", "user:read")]
    private ?User $user = null;

    #[ORM\Column]
    #[Groups("takeAwayBookings")]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;


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
            $food->addTakeAwayBooking($this);
        }

        return $this;
    }

    public function removeFood(Food $food): static
    {
        if ($this->food->removeElement($food)) {
            $food->removeTakeAwayBooking($this);
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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
}

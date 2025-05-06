<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['bookings', 'userInfo'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['bookings', 'userInfo'])]
    private ?int $guestNumber = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['userInfo'])]
    private ?\DateTimeInterface $orderDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['userInfo'])]
    private ?\DateTimeInterface $orderHour = null;

    #[ORM\Column(length: 255)]
    #[Groups(['bookings', 'userInfo'])]
    private ?string $guestAllergy = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'bookings')]
    #[Groups(['bookings'])]
    private Collection $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGuestNumber(): ?int
    {
        return $this->guestNumber;
    }

    public function setGuestNumber(int $guestNumber): static
    {
        $this->guestNumber = $guestNumber;

        return $this;
    }

    #[Groups(['bookings'])]
    public function getOrderDateString(): ?string
    {
        return $this->orderDate->format('d-m-Y');
    }
    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTimeInterface $orderDate): static
    {

        $this->orderDate = $orderDate;

        return $this;
    }

    #[Groups(['bookings'])]
    public function getOrderHourString(): ?string
    {
        return $this->orderHour->format('H:i');
    }
    public function getOrderHour(): ?\DateTimeInterface
    {
        return $this->orderHour;
    }

    public function setOrderHour(\DateTimeInterface $orderHour): static
    {
        $this->orderHour = $orderHour;

        return $this;
    }

    public function getGuestAllergy(): ?string
    {
        return $this->guestAllergy;
    }

    public function setGuestAllergy(string $guestAllergy): static
    {
        $this->guestAllergy = $guestAllergy;

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
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->user->removeElement($user);

        return $this;
    }
}

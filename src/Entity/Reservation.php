<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{

    const PAID = 'paid';
    const RESERVED = 'reserved';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Schedule $schedule = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column]
    private ?float $totalPrice = 0;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $validDate = null;

    #[ORM\OneToMany(mappedBy: 'reservation', targetEntity: ReservationItem::class, cascade: ['persist'])]
    private Collection $reservationItems;

    public function __construct()
    {
        $this->reservationItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSchedule(): ?Schedule
    {
        return $this->schedule;
    }

    public function setSchedule(?Schedule $schedule): self
    {
        $this->schedule = $schedule;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getValidDate(): ?\DateTimeInterface
    {
        return $this->validDate;
    }

    public function setValidDate(\DateTimeInterface $validDate): self
    {
        $this->validDate = $validDate;

        return $this;
    }

    /**
     * @return Collection<int, ReservationItem>
     */
    public function getReservationItems(): Collection
    {
        return $this->reservationItems;
    }

    public function addReservationItem(ReservationItem $reservationItem): self
    {
        if (!$this->reservationItems->contains($reservationItem)) {
            $this->reservationItems->add($reservationItem);
            $reservationItem->setReservation($this);
        }

        return $this;
    }

    public function removeReservationItem(ReservationItem $reservationItem): self
    {
        if ($this->reservationItems->removeElement($reservationItem)) {
            // set the owning side to null (unless already changed)
            if ($reservationItem->getReservation() === $this) {
                $reservationItem->setReservation(null);
            }
        }

        return $this;
    }
}

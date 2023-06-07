<?php

namespace App\Entity;

use App\Repository\SeatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SeatRepository::class)]
class Seat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(groups: 'schedule:reservation')]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'seats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Screen $screen = null;

    #[ORM\Column]
    #[Groups(groups: 'schedule:reservation')]
    private ?int $number = null;

    #[ORM\OneToMany(mappedBy: 'seat', targetEntity: ReservationItem::class)]
    private Collection $reservationItems;

    public function __construct()
    {
        $this->reservationItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScreen(): ?Screen
    {
        return $this->screen;
    }

    public function setScreen(?Screen $screen): self
    {
        $this->screen = $screen;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

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
            $reservationItem->setSeat($this);
        }

        return $this;
    }

    public function removeReservationItem(ReservationItem $reservationItem): self
    {
        if ($this->reservationItems->removeElement($reservationItem)) {
            // set the owning side to null (unless already changed)
            if ($reservationItem->getSeat() === $this) {
                $reservationItem->setSeat(null);
            }
        }

        return $this;
    }

    public function __toString():string
    {
        return sprintf('%s',$this->number);
    }
}

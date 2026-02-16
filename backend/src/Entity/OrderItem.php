<?php

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['order:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['order:read'])]
    private ?Order $order = null;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['order:read'])]
    private ?Skin $skin = null;

    #[ORM\Column]
    #[Groups(['order:read'])]
    private ?int $priceAtPurchase = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): static
    {
        $this->order = $order;

        return $this;
    }

    public function getSkin(): ?Skin
    {
        return $this->skin;
    }

    public function setSkin(?Skin $skin): static
    {
        $this->skin = $skin;

        return $this;
    }

    public function getPriceAtPurchase(): ?int
    {
        return $this->priceAtPurchase;
    }

    public function setPriceAtPurchase(int $priceAtPurchase): static
    {
        $this->priceAtPurchase = $priceAtPurchase;

        return $this;
    }

    #[Groups(['order:read'])]
    public function getFormattedPrice(): string
    {
        return number_format($this->priceAtPurchase / 100, 2, '.', ' ') . ' €';
    }
}

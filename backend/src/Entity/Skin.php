<?php

namespace App\Entity;

use App\Repository\SkinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SkinRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Skin
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'Ramsey\Uuid\Doctrine\UuidGenerator')]
    #[Groups(['skin:read', 'order:read'])]
    private ?string $id = null;

    #[ORM\ManyToOne(inversedBy: 'skins')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['skin:read', 'skin:write'])]
    private ?User $seller = null;

    #[ORM\ManyToOne(inversedBy: 'skins')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['skin:read', 'skin:write'])]
    private ?Champion $champion = null;

    #[ORM\Column(length: 255)]
    #[Groups(['skin:read', 'skin:write'])]
    private ?string $title = null;

    #[ORM\Column(type: 'text')]
    #[Groups(['skin:read', 'skin:write'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['skin:read', 'skin:write'])]
    private ?int $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['skin:read', 'skin:write'])]
    private ?string $filePath = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['skin:read', 'skin:write'])]
    private ?string $coverImage = null;

    #[ORM\Column(length: 50)]
    #[Groups(['skin:read', 'skin:write'])]
    private ?string $status = 'draft';

    #[ORM\Column]
    #[Groups(['skin:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'skins')]
    #[Groups(['skin:read', 'skin:write'])]
    private Collection $categories;

    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'skin')]
    private Collection $orderItems;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->orderItems = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getSeller(): ?User
    {
        return $this->seller;
    }

    public function setSeller(?User $seller): static
    {
        $this->seller = $seller;

        return $this;
    }

    public function getChampion(): ?Champion
    {
        return $this->champion;
    }

    public function setChampion(?Champion $champion): static
    {
        $this->champion = $champion;

        return $this;
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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): static
    {
        $this->filePath = $filePath;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(?string $coverImage): static
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addSkin($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->categories->removeElement($category)) {
            $category->removeSkin($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): static
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setSkin($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): static
    {
        if ($this->orderItems->removeElement($orderItem)) {
            if ($orderItem->getSkin() === $this) {
                $orderItem->setSkin(null);
            }
        }

        return $this;
    }
}

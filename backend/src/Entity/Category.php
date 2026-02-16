<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['category:read', 'skin:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['category:read', 'category:write', 'skin:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 100, unique: true)]
    #[Groups(['category:read', 'category:write', 'skin:read'])]
    private ?string $slug = null;

    #[ORM\ManyToMany(targetEntity: Skin::class, mappedBy: 'categories')]
    private Collection $skins;

    public function __construct()
    {
        $this->skins = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Skin>
     */
    public function getSkins(): Collection
    {
        return $this->skins;
    }

    public function addSkin(Skin $skin): static
    {
        if (!$this->skins->contains($skin)) {
            $this->skins->add($skin);
            $skin->addCategory($this);
        }

        return $this;
    }

    public function removeSkin(Skin $skin): static
    {
        if ($this->skins->removeElement($skin)) {
            $skin->removeCategory($this);
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MarkRepository")
 */
class Mark
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Liquid", mappedBy="mark")
     */
    private $liquids;

    public function __construct()
    {
        $this->liquids = new ArrayCollection();
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

    /**
     * @return Collection|Liquid[]
     */
    public function getLiquids(): Collection
    {
        return $this->liquids;
    }

    public function addLiquid(Liquid $liquid): self
    {
        if (!$this->liquids->contains($liquid)) {
            $this->liquids[] = $liquid;
            $liquid->setMark($this);
        }

        return $this;
    }

    public function removeLiquid(Liquid $liquid): self
    {
        if ($this->liquids->contains($liquid)) {
            $this->liquids->removeElement($liquid);
            // set the owning side to null (unless already changed)
            if ($liquid->getMark() === $this) {
                $liquid->setMark(null);
            }
        }

        return $this;
    }
}

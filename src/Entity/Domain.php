<?php

namespace App\Entity;

use App\Repository\DomainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DomainRepository::class)]
class Domain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $imgUrl = null;

    #[ORM\OneToMany(mappedBy: 'domain', targetEntity: Station::class)]
    private Collection $stations;

    public function __construct()
    {
        $this->stations = new ArrayCollection();
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

    public function getImgUrl(): ?string
    {
        return $this->imgUrl;
    }

    public function setImgUrl(string $imgUrl): self
    {
        $this->imgUrl = $imgUrl;

        return $this;
    }

    /**
     * @return Collection<int, Station>
     */
    public function getStations(): Collection
    {
        return $this->stations;
    }

    public function addStation(Station $station): self
    {
        if (!$this->stations->contains($station)) {
            $this->stations->add($station);
            $station->setDomain($this);
        }

        return $this;
    }

    public function removeStation(Station $station): self
    {
        if ($this->stations->removeElement($station)) {
            // set the owning side to null (unless already changed)
            if ($station->getDomain() === $this) {
                $station->setDomain(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->name;
    }
}

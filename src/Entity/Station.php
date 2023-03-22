<?php

namespace App\Entity;

use App\Repository\StationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StationRepository::class)]
class Station
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $imgUrl = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'stations')]
    private ?Domain $domain = null;

    #[ORM\OneToMany(mappedBy: 'station', targetEntity: Slope::class)]
    private Collection $slopes;

    #[ORM\OneToMany(mappedBy: 'station', targetEntity: Lift::class)]
    private Collection $lifts;

    #[ORM\OneToMany(mappedBy: 'station', targetEntity: Faq::class)]
    private Collection $faqs;

    public function __construct()
    {
        $this->slopes = new ArrayCollection();
        $this->lifts = new ArrayCollection();
        $this->faqs = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDomain(): ?Domain
    {
        return $this->domain;
    }

    public function setDomain(?Domain $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @return Collection<int, Slope>
     */
    public function getSlopes(): Collection
    {
        return $this->slopes;
    }

    public function addSlope(Slope $slope): self
    {
        if (!$this->slopes->contains($slope)) {
            $this->slopes->add($slope);
            $slope->setStation($this);
        }

        return $this;
    }

    public function removeSlope(Slope $slope): self
    {
        if ($this->slopes->removeElement($slope)) {
            // set the owning side to null (unless already changed)
            if ($slope->getStation() === $this) {
                $slope->setStation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Lift>
     */
    public function getLifts(): Collection
    {
        return $this->lifts;
    }

    public function addLift(Lift $lift): self
    {
        if (!$this->lifts->contains($lift)) {
            $this->lifts->add($lift);
            $lift->setStation($this);
        }

        return $this;
    }

    public function removeLift(Lift $lift): self
    {
        if ($this->lifts->removeElement($lift)) {
            // set the owning side to null (unless already changed)
            if ($lift->getStation() === $this) {
                $lift->setStation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Faq>
     */
    public function getFaqs(): Collection
    {
        return $this->faqs;
    }

    public function addFaq(Faq $faq): self
    {
        if (!$this->faqs->contains($faq)) {
            $this->faqs->add($faq);
            $faq->setStation($this);
        }

        return $this;
    }

    public function removeFaq(Faq $faq): self
    {
        if ($this->faqs->removeElement($faq)) {
            // set the owning side to null (unless already changed)
            if ($faq->getStation() === $this) {
                $faq->setStation(null);
            }
        }

        return $this;
    }
}

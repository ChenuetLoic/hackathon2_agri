<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CityRepository::class)
 */
class City
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $longitude;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $inseeCode;

    /**
     * @ORM\OneToMany(targetEntity=Farmer::class, mappedBy="city")
     */
    private $farmers;

    /**
     * @ORM\OneToMany(targetEntity=Buyer::class, mappedBy="city")
     */
    private $buyers;

    public function __construct()
    {
        $this->farmers = new ArrayCollection();
        $this->buyers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getZipcode(): ?int
    {
        return $this->zipcode;
    }

    public function setZipcode(int $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getInseeCode(): ?string
    {
        return $this->inseeCode;
    }

    public function setInseeCode(string $inseeCode): self
    {
        $this->inseeCode = $inseeCode;

        return $this;
    }

    /**
     * @return Collection|Farmer[]
     */
    public function getFarmers(): Collection
    {
        return $this->farmers;
    }

    public function addFarmer(Farmer $farmer): self
    {
        if (!$this->farmers->contains($farmer)) {
            $this->farmers[] = $farmer;
            $farmer->setCity($this);
        }

        return $this;
    }

    public function removeFarmer(Farmer $farmer): self
    {
        if ($this->farmers->removeElement($farmer)) {
            // set the owning side to null (unless already changed)
            if ($farmer->getCity() === $this) {
                $farmer->setCity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Buyer[]
     */
    public function getBuyers(): Collection
    {
        return $this->buyers;
    }

    public function addBuyer(Buyer $buyer): self
    {
        if (!$this->buyers->contains($buyer)) {
            $this->buyers[] = $buyer;
            $buyer->setCity($this);
        }

        return $this;
    }

    public function removeBuyer(Buyer $buyer): self
    {
        if ($this->buyers->removeElement($buyer)) {
            // set the owning side to null (unless already changed)
            if ($buyer->getCity() === $this) {
                $buyer->setCity(null);
            }
        }

        return $this;
    }
}

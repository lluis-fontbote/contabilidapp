<?php

namespace App\Entity;

use App\Repository\ProviderTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProviderTypeRepository")
 * @ORM\Table(name="provider_types")
 */
class ProviderType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=Provider::class, mappedBy="providerType")
     */
    private $providers;

    public function __construct()
    {
        $this->providers = new ArrayCollection();
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
     * @return Collection<int, Provider>
     */
    public function getProviders(): Collection
    {
        return $this->providers;
    }

    public function addProvider(Provider $provider): self
    {
        if (!$this->providers->contains($provider)) {
            $this->providers[] = $provider;
            $provider->setProviderType($this);
        }

        return $this;
    }

    public function removeProvider(Provider $provider): self
    {
        if ($this->providers->removeElement($provider)) {
            // set the owning side to null (unless already changed)
            if ($provider->getProviderType() === $this) {
                $provider->setProviderType(null);
            }
        }

        return $this;
    }
}

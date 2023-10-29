<?php

namespace App\Entity;

use App\Repository\ProviderRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProviderRepository")
 * @ORM\Table(name="providers")
 */
class Provider 
{
    /**
     * @var int
     * 
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
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=50)
     */
    private $phone;

    /**
     * @var boolean
     * 
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $active;

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
     * @ORM\ManyToOne(targetEntity=ProviderType::class, inversedBy="providers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $providerType;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getProviderType(): ?ProviderType
    {
        return $this->providerType;
    }

    public function setProviderType(?ProviderType $providerType): self
    {
        $this->providerType = $providerType;

        return $this;
    }
}

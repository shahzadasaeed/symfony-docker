<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    private ?string $last_name = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone_number = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'contact', targetEntity: CampaignContact::class, orphanRemoval: true)]
    private Collection $campaignContacts;

    
    public function __construct()
    {
        $this->campaignContacts = new ArrayCollection();
    }


    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addConstraint(new UniqueEntity([
            'fields' => ['email', 'phoneNumber'],
            'ignoreNull' => 'phoneNumber',
        ]));

        $metadata->addPropertyConstraint('email', new Assert\Email());
        $metadata->addPropertyConstraint('phone_number', new Assert\PhoneNumber());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): static
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, CampaignContact>
     */
    public function getCampaignContacts(): Collection
    {
        return $this->campaignContacts;
    }

    public function addCampaignContact(CampaignContact $campaignContact): static
    {
        if (!$this->campaignContacts->contains($campaignContact)) {
            $this->campaignContacts->add($campaignContact);
            $campaignContact->setContact($this);
        }

        return $this;
    }

    public function removeCampaignContact(CampaignContact $campaignContact): static
    {
        if ($this->campaignContacts->removeElement($campaignContact)) {
            // set the owning side to null (unless already changed)
            if ($campaignContact->getContact() === $this) {
                $campaignContact->setContact(null);
            }
        }

        return $this;
    }

    
}

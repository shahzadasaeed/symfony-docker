<?php

namespace App\Entity;

use App\Repository\CampaignRunLogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampaignRunLogRepository::class)]
class CampaignRunLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'campaignRunLogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campaign $campaign = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $run_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $complete_at = null;

    #[ORM\OneToMany(mappedBy: 'campaign', targetEntity: CampaignContact::class, orphanRemoval: true)]
    private Collection $campaignContacts;

    public function __construct()
    {
        $this->campaignContacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCampaign(): ?Campaign
    {
        return $this->campaign;
    }

    public function setCampaign(?Campaign $campaign): static
    {
        $this->campaign = $campaign;

        return $this;
    }

    public function getRunAt(): ?\DateTimeInterface
    {
        return $this->run_at;
    }

    public function setRunAt(\DateTimeInterface $run_at): static
    {
        $this->run_at = $run_at;

        return $this;
    }

    public function getCompleteAt(): ?\DateTimeInterface
    {
        return $this->complete_at;
    }

    public function setCompleteAt(?\DateTimeInterface $complete_at): static
    {
        $this->complete_at = $complete_at;

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
            $campaignContact->setCampaign($this);
        }

        return $this;
    }

    public function removeCampaignContact(CampaignContact $campaignContact): static
    {
        if ($this->campaignContacts->removeElement($campaignContact)) {
            // set the owning side to null (unless already changed)
            if ($campaignContact->getCampaign() === $this) {
                $campaignContact->setCampaign(null);
            }
        }

        return $this;
    }
}

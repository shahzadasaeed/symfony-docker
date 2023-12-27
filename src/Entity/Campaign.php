<?php

namespace App\Entity;

use App\Repository\CampaignRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampaignRepository::class)]
class Campaign
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $scheduledDate = null;

    #[ORM\OneToMany(mappedBy: 'campaign', targetEntity: CampaignRunLog::class, orphanRemoval: true)]
    private Collection $campaignRunLogs;
    
    public function __construct()
    {
        $this->campaign = new ArrayCollection();
        $this->campaignRunLogs = new ArrayCollection();
        $this->campaignContacts = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getScheduledDate(): ?\DateTimeInterface
    {
        return $this->scheduledDate;
    }

    public function setScheduledDate(?\DateTimeInterface $scheduledDate): static
    {
        $this->scheduledDate = $scheduledDate;

        return $this;
    }

    /**
     * @return Collection<int, CampaignRunLog>
     */
    public function getCampaignRunLogs(): Collection
    {
        return $this->campaignRunLogs;
    }

    public function addCampaignRunLog(CampaignRunLog $campaignRunLog): static
    {
        if (!$this->campaignRunLogs->contains($campaignRunLog)) {
            $this->campaignRunLogs->add($campaignRunLog);
            $campaignRunLog->setCampaign($this);
        }

        return $this;
    }

    public function removeCampaignRunLog(CampaignRunLog $campaignRunLog): static
    {
        if ($this->campaignRunLogs->removeElement($campaignRunLog)) {
            // set the owning side to null (unless already changed)
            if ($campaignRunLog->getCampaign() === $this) {
                $campaignRunLog->setCampaign(null);
            }
        }

        return $this;
    }


}

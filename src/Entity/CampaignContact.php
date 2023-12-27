<?php

namespace App\Entity;

use App\Repository\CampaignContactRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampaignContactRepository::class)]
class CampaignContact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'campaignContacts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CampaignRunLog $campaign = null;

    #[ORM\ManyToOne(inversedBy: 'campaignContacts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contact $contact = null;

    #[ORM\Column(nullable: true)]
    private ?bool $is_sms_sent = null;

    #[ORM\Column(nullable: true)]
    private ?bool $is_email_sent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCampaign(): ?CampaignRunLog
    {
        return $this->campaign;
    }

    public function setCampaign(?CampaignRunLog $campaign): static
    {
        $this->campaign = $campaign;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function isIsSmsSent(): ?bool
    {
        return $this->is_sms_sent;
    }

    public function setIsSmsSent(?bool $is_sms_sent): static
    {
        $this->is_sms_sent = $is_sms_sent;

        return $this;
    }

    public function isIsEmailSent(): ?bool
    {
        return $this->is_email_sent;
    }

    public function setIsEmailSent(?bool $is_email_sent): static
    {
        $this->is_email_sent = $is_email_sent;

        return $this;
    }
}

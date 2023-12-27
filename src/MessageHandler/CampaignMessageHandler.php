<?php

namespace App\MessageHandler;

use App\Entity\Contact;
use App\Entity\Campaign;
use App\Entity\CampaignRunLog;
use App\Entity\CampaignContact;
use App\Message\CampaignMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;


class CampaignMessageHandler implements MessageHandlerInterface
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function __invoke(CampaignMessage $message): void
    {
        $campaignId = $message->getCampaignId();
        $campaign = $this->entityManager->getRepository(Campaign::class)->find($campaignId);
        $campaignRunLog = new CampaignRunLog();
        $campaignRunLog->setCampaign($campaign);
        $campaignRunLog->setRunAt(new \DateTime());
        $this->entityManager->persist($campaignRunLog);
        
        $contacts = $this->entityManager->getRepository(Contact::class)->findAll();
        foreach($contacts as $contact){
            $campaignContact = new CampaignContact();
            $campaignContact->setCampaign($campaignRunLog);
            $campaignContact->setContact($contact);
            $campaignContact->setIsSmsSent($this->sendSms($contact->getPhoneNumber()) ? true : false);
            $campaignContact->setIsEmailSent($this->sendEmail($contact->getEmail()) ? true : false);
            $this->entityManager->persist($campaignContact);
        }
        $campaignRunLog->setCompleteAt(new \DateTime());

        $this->entityManager->flush();

        // Log or handle the campaign execution as needed
        file_put_contents('campaign_log.log', 'Campaign executed: ' . $campaignId . PHP_EOL, FILE_APPEND);
    }
    private function sendSms($phone_number)
    {
        if(!empty($phone_number)){
            return true;
        }
        return false;
    }
    private function sendEmail($email)
    {
        if(!empty($email)){
            return true;
        }
        return false;
    }
}

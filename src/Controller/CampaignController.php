<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\CampaignContact;
use App\Entity\CampaignRunLog;
use App\Form\CampaignType;
use App\Message\CampaignMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CampaignController extends AbstractController
{
    #[Route('/campaign', name: 'campaign_list')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $campaigns = $entityManager->getRepository(Campaign::class)->findAll();

        return $this->render('campaign/list.html.twig', [
            'campaigns' => $campaigns,
        ]);
    }

    #[Route('/campaign/create', name: 'create_campaign')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $campaign = new Campaign();
        $form = $this->createForm(CampaignType::class, $campaign);
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($campaign);
            $entityManager->flush(); 

            return $this->redirectToRoute('campaign_list', [], Response::HTTP_SEE_OTHER);
        }
 
        return $this->renderForm('campaign/new.html.twig', [
            'campaign' => $campaign,
            'form' => $form,
        ]);
    }

    #[Route('/campaign/run/{campaign_id}', name: 'campaign_run')]
    public function runCampaignCommand($campaign_id, MessageBusInterface $messageBus): Response
    {
        // Dispatch the campaign message to the message bus
        $messageBus->dispatch(new CampaignMessage($campaign_id));

        return $this->redirectToRoute('campaign_list', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/campaign/history/{campaign_id}', name: 'campaign_history')]
    public function history($campaign_id, EntityManagerInterface $entityManager): Response
    {
        $campaign = $entityManager->getRepository(Campaign::class)->find($campaign_id);
        $campaignLogs = $entityManager->getRepository(CampaignRunLog::class)->findBy(['campaign' => $campaign]);
        return $this->render('campaign/logs.html.twig', [
            'campaignLogs' => $campaignLogs,
        ]);    
    }

    #[Route('/campaign/contact/{campaign_id}', name: 'campaign_contact_list')]
    public function contactList($campaign_id, EntityManagerInterface $entityManager): Response
    {
        $campaignRunLog = $entityManager->getRepository(CampaignRunLog::class)->find($campaign_id);
        $campaignContacts = $entityManager->getRepository(CampaignContact::class)->findBy(['campaign' => $campaignRunLog]);
        return $this->render('contact/contact.html.twig', [
            'campaignContacts' => $campaignContacts,
        ]);    
    }

}

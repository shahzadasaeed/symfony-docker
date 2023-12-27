<?php

namespace App\Controller;
use App\Entity\Contact;
use App\Form\CsvUploadType;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
//use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContactController extends AbstractController
{   
    private $validator;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/contact', name: 'contact_list')]
    public function index(): Response
    {
        $contacts = $this->entityManager->getRepository(Contact::class)->findAll();

        return $this->render('contact/list.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    #[Route('/contact/import', name: 'contact_import')]
    public function importCsv(Request $request): Response
    {
        $form = $this->createForm(CsvUploadType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $csvFile = $form->get('upload')->getData();

            // Process the CSV file (e.g., save to database)
            $this->processCsvFile($csvFile);

            $this->addFlash('success', 'CSV file uploaded and processed successfully');

            return $this->redirectToRoute('contact_list');
        }

        return $this->render('contact/import.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function processCsvFile($csvFile)
    {
        $csv = Reader::createFromString(file_get_contents($csvFile->getPathname()));
        $csv->setHeaderOffset(0); 

        foreach ($csv->getRecords() as $record) {
            //$this->validateCsvRecord($record); // Facing Error => ValidatorInterface
            $contact = new Contact();
            $contact->setFirstName($record['first_name']); 
            $contact->setLastName($record['last_name']); 
            $contact->setPhoneNumber($record['phone_number']); 
            $contact->setEmail($record['email']); 
            $this->entityManager->persist($contact);
            $this->entityManager->flush();
        }
    }
    // private function validateCsvRecord($record)
    // {
    //     // Create a temporary entity for validation
    //     $contact = new Contact();
    //     $contact->setFirstName($record['first_name']); 
    //     $contact->setLastName($record['last_name']); 
    //     $contact->setPhoneNumber($record['phone_number']); 
    //     $contact->setEmail($record['email']); 

    //     $errors = $this->validator->validate($contact);

    //     if (count($errors) > 0) {
    //         // Handle validation errors
    //         foreach ($errors as $error) {
    //             dump($error->getMessage());
    //         }
    //     } else {
    //          // Save Record
    //     }
  //  }


}

<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Repository\PatientRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class PatientController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route('/patient', name: 'app_patient')]
    public function patient(PatientRepository $repo): Response
    {
        $patients=$repo->findAll();
        return $this->render('patient/index.html.twig', ['controller_name' =>'PatientController','patients'=>$patients,]);
        
    }
    

    #[Route('/patient/new', name: 'new_form') ]
    public function new(Request $request,EntityManagerInterface $entityManager): Response
    
    {
    
    // creates a article object and initializes some data for this example
    
    $patient = new Patient();    
    $form = $this->createFormBuilder($patient)
    ->add('nom', TextType::class)
    ->add('prenom',TextType::class)
    ->add('date', DateType::class)
    ->add('adresse', TextType::class)
    ->add('num', TextType::class)
    ->add('valide', TextType::class)
    ->add('save', SubmitType::class, ['label' => 'Create Patient'])

    ->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
    $patient = $form->getData();
    $entityManager->persist($patient);
    $entityManager->flush();
// ... perform some action, such as saving the article to the
return $this->redirectToRoute('app_patient');
}
return $this->render('/patient/create.html.twig', ['form' => $form,]);
}



#[Route('/patient/{id}/edit', name: 'edit_patient')]
public function edit(Request $request, EntityManagerInterface $entityManager, Patient $patient): Response
{
    $form = $this->createFormBuilder($patient)
    
    ->add('valide', TextType::class)

        ->add('save', SubmitType::class, ['label' => 'Save Changes'])
        ->getForm();

    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();
        return $this->redirectToRoute('app_patient');
    }

    return $this->render('/patient/edit.html.twig', ['form' => $form->createView()]);
}

#[Route('/admin/patient/{id}/delete', name: 'delete_patient')]
public function delete(Request $request, EntityManagerInterface $entityManager, Patient $patient): Response
{
    $entityManager->remove($patient);
    $entityManager->flush();

    return $this->redirectToRoute('app_patient');
}


}

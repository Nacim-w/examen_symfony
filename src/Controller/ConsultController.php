<?php

namespace App\Controller;

use App\Entity\Analyse;
use App\Repository\AnalyseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class ConsultController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route('/analyse', name: 'app_analyse')]
    public function analyse(AnalyseRepository $repo): Response
    {
        $analyses=$repo->findAll();
        return $this->render('consult/index.html.twig', ['controller_name' =>'ConsultController','analyses'=>$analyses,]);
        
    }
    

    #[Route('/admin/consult/new', name: 'new_form') ]
    public function new(Request $request,EntityManagerInterface $entityManager): Response
    
    {
    
    // creates a article object and initializes some data for this example
    
    $analyse = new Analyse();    
    $form = $this->createFormBuilder($analyse)
    ->add('numanalyse', TextType::class)
    ->add('nom',TextType::class)
    ->add('type', TextType::class)
    ->add('date',   TextType::class)
    ->add('save', SubmitType::class, ['label' => 'Create Analyse'])

    ->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
    $analyse = $form->getData();
    $entityManager->persist($analyse);
    $entityManager->flush();
// ... perform some action, such as saving the article to the
return $this->redirectToRoute('app_analyse');
}
return $this->render('/consult/create.html.twig', ['form' => $form,]);
}



#[Route('/admin/consult/{id}/edit', name: 'edit_analyse')]
public function edit(Request $request, EntityManagerInterface $entityManager, Analyse $analyse): Response
{
    $form = $this->createFormBuilder($analyse)
    ->add('numanalyse', TextType::class)
    ->add('nom',TextType::class)
    ->add('type', TextType::class)
    ->add('date', DateType::class)
        ->add('save', SubmitType::class, ['label' => 'Save Changes'])
        ->getForm();

    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();
        return $this->redirectToRoute('app_analyse');
    }

    return $this->render('/consult/edit.html.twig', ['form' => $form->createView()]);
}

#[Route('/admin/consult/{id}/delete', name: 'delete_analyse')]
public function delete(Request $request, EntityManagerInterface $entityManager, Analyse $analyse): Response
{
    $entityManager->remove($analyse);
    $entityManager->flush();

    return $this->redirectToRoute('app_analyse');
}


}

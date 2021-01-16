<?php

namespace App\Controller;

use App\Entity\Aliment;
use App\Repository\AlimentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlimentController extends AbstractController
{
    /**
     * @Route("/", name="aliment")
     */
    public function index(AlimentRepository $repository)
    {

    $aliments = $repository->findAll();

        return $this->render('aliment/index.html.twig', [
            'aliments' => $aliments,
        ]);
    }

     /**
     * @Route("/ajout", name="ajoutAliment")
     */
    public function ajoutAliment(Request $request, EntityManagerInterface $entityManager)
    {
        $aliment = new Aliment();
        $formulaire = $this->createFormBuilder($aliment)
        ->add('nom',TextType::class)
        ->add('image',FileType::class)
        ->add('prix',IntegerType::class)
        ->add('calories',IntegerType::class)
        ->add('proteines',IntegerType::class)
        ->add('glucides',IntegerType::class)
        ->add('lipides',IntegerType::class)
        ->add('save', SubmitType::class,['label'=>'ajouter un aliment'])
        ->getForm();

        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original $task variable has also been updated
            $formulaire = $formulaire->getData();
            $nom = $aliment->getNom();
            $image = strtolower($nom);
            $aliment->setImage($image);

            $upload = $formulaire['image']->getData();
            $upload->move('image'.$nom.'jpg');

           

            $entityManager->persist($aliment);
            $entityManager->flush();

            return $this->redirectToRoute('aliment');
        }


        return $this->render('aliment/ajoutAliment.html.twig', [
            'formulaire' => $formulaire->createView()
        ]);
    }

}

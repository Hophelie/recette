<?php

namespace App\Controller;


use App\Repository\AlimentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Aliment;
use App\Entity\AlimentFiltre;
use App\Form\FiltreType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\FormulaireType;


class AlimentController extends AbstractController
{
    /**
     * @Route("/", name="aliment")
     */
    public function index(AlimentRepository $repository, Request $request)
    {
        $search = new AlimentFiltre();

        $form = $this->createForm(FiltreType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data[] = $form->getData();

            $aliments = $repository->findBySearch($data);
        } else {

            $aliments = $repository->findAll();
        }
        return $this->render('aliment/index.html.twig', [
            'aliments' => $aliments,
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/ajout", name="ajoutAliment")
     */

    public function ajoutAliment(Request $request, EntityManagerInterface $entityManager)
    {

        $aliment = new Aliment();

        $formulaire = $this->createForm(FormulaireType::class, $aliment);

        $formulaire->handleRequest($request);

        dump($aliment);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            dump($aliment);


            $nom = $aliment->getNom();
            $image = strtolower($nom);
            $aliment->setImage($image);

            $upload = $formulaire['image']->getData();
            $upload->move('images/' . $nom . '.jpg');


            $entityManager->persist($aliment);
            $entityManager->flush();

            return $this->redirectToRoute('aliment');
        }

        return $this->render('aliment/ajoutAliment.html.twig', [
            'formulaire' => $formulaire->createView()
        ]);
    }
}

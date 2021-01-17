<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Aliment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\FormulaireType;


class FormController extends AbstractController
{
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
            $upload->move('images'.$nom.'.jpg');
            

            $entityManager->persist($aliment);
            $entityManager->flush();

            return $this->redirectToRoute('aliment');
        }

        return $this->render('aliment/ajoutAliment.html.twig', [
            'formulaire' => $formulaire->createView()
        ]);
    }
}

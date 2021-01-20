<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Repository\AlimentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Aliment;
use App\Form\FormulaireType;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="Administration")
     */
    public function admin(AlimentRepository $repository): Response
    {
        $aliments = $repository->findAll();
        return $this->render('admin/admin.html.twig', [
            'aliments' => $aliments,
        ]);
    }


   
    /**
     * @param Aliment Supprimer aliment
     * @Route("/admin/delet{id}", name="supprAdmin")
     */
    public function supprAdmin(AlimentRepository $repository, $id, EntityManagerInterface $em): Response
    {

        $aliment = $repository->find($id); //on recupere l'id de l'aliment et on l'enregistre dans une variable

        $em->remove($aliment); //On le supprime
        $em->flush(); //on applique en bdd

        $aliments = $repository->findAll();

        return $this->render('admin/admin.html.twig', [
            'aliments' => $aliments,
        ]);
    }
    
    /**
     * @param Aliment Ajout d'acticle
     * @Route("/ajout", name="ajoutAliment")

     * @param Aliment Modifier aliment
     * @Route("/admin/modif{id}", name="modifAdmin")
     */
    public function modifAdmin(AlimentRepository $repository, $id = null, Request $request, EntityManagerInterface $em): Response
    {

        if ($id == NULL) {

            $aliment = new Aliment();
        } else {

            $aliment = $repository->find($id);
        }
        $formulaire = $this->createForm(FormulaireType::class, $aliment);

        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {


            //PARAMETRAGES DE L IMAGE-------------------------
            $nom = $aliment->getNom();
            $image = strtolower($nom);
            $aliment->setImage($image);

            $upload = $formulaire['image']->getData();
            $upload->move('images', $image . '.jpg');
            //PARAMETRAGES DE L IMAGE-------------------------

            $em->persist($aliment);
            $em->flush();

            return $this->redirectToRoute('aliment');
        }

        return $this->render('admin/modifAliment.html.twig', [
            'aliments' => $aliment,
            'formulaire' => $formulaire->createView(),
            'modification' => $id !== null
        ]);
    }
}

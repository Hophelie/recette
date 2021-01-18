<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Repository\AlimentRepository;
use Doctrine\ORM\EntityManager;
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
    public function admin(AlimentRepository $repository ): Response
    {
        $aliments = $repository->findAll();
        return $this->render('admin/admin.html.twig', [
            'aliments' => $aliments,
        ]);
    }


  /**
   * @param Aliment Ajout d'acticle
     * @Route("/ajout", name="ajoutAliment")
     */

    public function ajoutAliment(Request $request, EntityManagerInterface $entityManager)
    {

        $aliment = new Aliment();

        $formulaire = $this->createForm(FormulaireType::class, $aliment); //creer un formulaire d'apres FormulaireType

        $formulaire->handleRequest($request);//sert de methode POST ou GET pour recuperer les données 

        

        if ($formulaire->isSubmitted() && $formulaire->isValid()) { //si le formulaire est soumis &si il correspond a la bdd


//PARAMETRAGES DE L IMAGE-------------------------

            $nom = $aliment->getNom();//On recupere le nom de l'objet
            $image = strtolower($nom);//On s'assure que le nom soit en minuscule et on l'enregistre dans la vaiable $image
            $aliment->setImage($image);//On modifie le nom de l'image 

            $upload = $formulaire['image']->getData();//On recupère l'adresse de l'image
           
            $upload->move('images', $nom . '.jpg');//on la deplace vers notre dossier images

//PARAMETRAGES DE L IMAGE-------------------------

            $entityManager->persist($aliment);
            $entityManager->flush();

            return $this->redirectToRoute('aliment');
        }

        return $this->render('aliment/ajoutAliment.html.twig', [
            'formulaire' => $formulaire->createView()
        ]);
    }



    /**
     * @param Aliment Supprimer aliment
     * @Route("/admin/delet{id}", name="supprAdmin")
     */
    public function supprAdmin(AlimentRepository $repository, $id, EntityManagerInterface $em ): Response
    {
      
        $aliment = $repository->find($id);//on recupere l'id de l'aliment et on l'enregistre dans une variable
       
        $em->remove($aliment);//On le supprime
        $em->flush();//on applique en bdd

        $aliments = $repository->findAll();

        return $this->render('admin/admin.html.twig', [
            'aliments' => $aliments,
        ]);
    }
    
    /**
     * @param Aliment Modifier aliment
     * @Route("/admin/modif{id}", name="modifAdmin")
  */
    public function modifAdmin(AlimentRepository $repository, $id , Request $request, EntityManagerInterface $em): Response
    {
        $aliment = $repository->find($id);

        $formulaire = $this->createForm(FormulaireType::class, $aliment);
        
        $formulaire->handleRequest($request);

        if($formulaire->isSubmitted() && $formulaire->isValid()){

            
//PARAMETRAGES DE L IMAGE-------------------------
            $nom = $aliment->getNom();
            $image = strtolower($nom);
            $aliment->setImage($image);

            $upload = $formulaire['image']->getData();
            $upload->move('images' , $image . '.jpg');
//PARAMETRAGES DE L IMAGE-------------------------

            $em->persist($aliment);
            $em->flush();

            return $this->redirectToRoute('aliment');


        }
       
        return $this->render('admin/modifAliment.html.twig', [
            'aliments' => $aliment,
            'formulaire' => $formulaire->createView()
        ]);
    }

  
}

<?php

namespace App\Controller;


use App\Repository\AlimentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\AlimentFiltre;
use App\Form\FiltreType;
use Symfony\Component\HttpFoundation\Request;



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



    
}

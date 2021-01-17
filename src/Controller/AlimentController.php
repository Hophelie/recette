<?php

namespace App\Controller;


use App\Repository\AlimentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    

}

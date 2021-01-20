<?php

    namespace App\Controller;

    use App\Entity\User;
    use App\Form\InscriptionType;
    use App\Repository\UserRepository;
    use Doctrine\ORM\EntityManager;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends AbstractController
    {

        /**
         * @Route("/modifInfos{id}", name="modifInfos")
         * @Route("/inscription", name="inscription")
         */
        public function gestionInfos($id, UserRepository $repository, Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder): Response
        {
            if($id == null){
            $user = new User(); 
           
        }else{

            $user = $repository->find($id);

        }
            $form = $this->createForm(InscriptionType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $hash = $encoder->encodePassword($user, $user->getPassword());

                $user->setPassword($hash);

                $em->persist($user);
                $em->flush();

                if($id == null){

                 return $this->redirectToRoute('connexion');  

                }else{

                 return $this->redirectToRoute('infoUser'); 

                }
                
            }
            
            return $this->render('User/inscription.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        }

        
        /**
         * @Route("/infoUser", name="infoUser")
         */
        public function infoUser(UserRepository $repository)
        {
            
        return $this->render('User/infoUser.html.twig');
        }
        

    }

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
    use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
    use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
    {

        /**
         * @Route("/inscription", name="inscription")
         */
        public function inscription(UserRepository $repository, Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder): Response
        {
            $user = new User();
            $form = $this->createForm(InscriptionType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $hash = $encoder->encodePassword($user, $user->getPassword());

                $user->setPassword($hash);

                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('connexion');
            }
            return $this->render('User/inscription.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        }

        /**
         * @Route("/connexion", name="connexion")
         */
        public function connexion(AuthenticationUtils $authenticationUtils): Response
        {
            $erreur = $authenticationUtils->getLastAuthenticationError(); //recupere le message d'erreur
            $lastusername = $authenticationUtils->getLastUsername(); //recupere le dernier identifiant utilisé
            return $this->render('User/connexion.html.twig', [
                'lastUserName' =>  $lastusername,
                'erreur' => $erreur
            ]);
        }

        /**
         * @Route("/logout", name="logout")
         */
        public function logout(){}
        
    }

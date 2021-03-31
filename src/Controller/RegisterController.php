<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    //Manager de Doctrine dans le constructeur pour eviter de l'appeler partout
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;

    }
    /**
     * @Route("/inscription", name="register")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        //instancier la classe USer ==> nouveaux objet utilisateurs
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //Récupération des données
            $user = $form->getData();
            $password = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            //Pour enregistré, il nous faut l'ORM doctrine pour enregistrer les données ds notre bdd
            //$doctrine =$this->getDoctrine()->getManager(); //Appel de l'ORM doctrine (de pref a mettre dans le constructeur)
            $this->entityManager->persist($user); //prend en param l'entité pour persister l'user => figé la data pour l'enregistrer
            $this->entityManager->flush(); //enregistre l'information, exécute la persistence

        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

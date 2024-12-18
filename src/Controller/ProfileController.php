<?php

namespace App\Controller;

use App\Form\ProfileFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    public function __construct(Private EntityManagerInterface $entityManager)
    {

    }
    #[Route('/profile', name: 'profile' , methods: ['POST', 'GET'])]
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->addFlash('success', "Your account has been modified.");
        }

        return $this->render('profile/editProfile.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}

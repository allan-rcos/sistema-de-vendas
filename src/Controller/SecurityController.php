<?php

namespace App\Controller;

use App\Form\LoginForm;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SecurityController extends AbstractController
{
    #[Route('/login', name: 'Login')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(LoginForm::class);

        $form->handleRequest($request);

        return $this->render('security/login.html.twig', [
            "login_form" => $form->createView()
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/logout', name: 'Logout')]
    public function logout()
    {
        throw new Exception('logout() should never be reached');
    }
}

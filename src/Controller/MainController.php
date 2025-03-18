<?php

namespace App\Controller;

use App\Traits\ControllerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    use ControllerTrait;

    protected string $NAME = 'home';

    #[Route(path: '/', name: 'Home')]
    public function homeAction(): Response
    {
        return $this->renderWithSideBarItems('main/home.html.twig');
    }
}
<?php

namespace App\Controller;

use App\Enum\FormasPagamento;
use App\Repository\PedidoRepository;
use App\Traits\ControllerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    use ControllerTrait;

    protected string $NAME = 'home';

    #[Route(path: '/', name: 'Home')]
    public function homeAction(PedidoRepository $repository): Response
    {
        $describe = $repository->describeByFormaDePagamento();

        return $this->renderWithSideBarItems('main/home.html.twig', parameters:[
            "described_pedidos" => $describe,
            "fdp_enum_name" => FormasPagamento::class
        ]);
    }
}
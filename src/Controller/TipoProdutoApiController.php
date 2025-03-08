<?php

namespace App\Controller;

use App\Model\TipoProduto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TipoProdutoApiController extends AbstractController
{
    #[Route(path: '/api/tipo-produto')]
    public function getAction(): Response
    {
        $tiposProduto = [
            new TipoProduto(
                0,
                "Pizzas"
            ),
            new TipoProduto(
                1,
                "Hamburgers"
            ),
            new TipoProduto(
                2,
                "Sucos de Garrafa"
            )
        ];
        return $this->json($tiposProduto);
    }
}
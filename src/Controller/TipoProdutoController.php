<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\TipoProdutoModelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TipoProdutoController extends AbstractController
{
    #[Route('/tipo-produto', name: 'TipoProduto')]
    public function index(TipoProdutoModelRepository $repository): Response
    {
        $tiposProduto = $repository->fetchAll();
        return $this->render('tipo_produto/index.html.twig', [
            'tiposProduto' => $tiposProduto
        ]);
    }
}

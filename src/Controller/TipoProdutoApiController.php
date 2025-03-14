<?php

namespace App\Controller;

use App\Model\TipoProduto;
use App\Repository\TipoProdutoModelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/api/tipo-produto', methods: ["GET", "POST", "PUT", "DELETE"])]
class TipoProdutoApiController extends AbstractController
{
    #[Route(path: '', methods: ["GET"])]
    public function getAllAction(TipoProdutoModelRepository $repository): Response
    {
        $tiposProduto = $repository->fetchAll();
        return $this->json($tiposProduto);
    }

    #[Route(path: '/{id<\d+>}', methods: ["GET"])]
    public function getAction(int $id, TipoProdutoModelRepository $repository)
    {
        $tipoProduto = $repository->fetch($id);

        if (!$tipoProduto) throw $this->createNotFoundException("Tipo produto não encontrado.");

        return $this->json($tipoProduto);
    }
}
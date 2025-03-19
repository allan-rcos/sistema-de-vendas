<?php

namespace App\Controller;

use App\Repository\TipoProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/api/tipo-produto/', methods: ["GET", "POST", "PUT", "DELETE"])]
class TipoProdutoApiController extends AbstractController
{
    #[Route(path: '/', methods: ["GET"])]
    public function getAllAction(TipoProdutoRepository $repository): Response
    {
        $tiposProduto = $repository->findAll();
        return $this->json($tiposProduto);
    }

    #[Route(path: '/{id<\d+>}', methods: ["GET"])]
    public function getAction(int $id, TipoProdutoRepository $repository): Response
    {
        $tipoProduto = $repository->find($id);

        if (!$tipoProduto) throw $this->createNotFoundException("Tipo produto não encontrado.");

        return $this->json($tipoProduto);
    }
}
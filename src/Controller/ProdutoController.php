<?php

namespace App\Controller;

use App\Entity\Produto;
use App\Enum\ProdutoHeaders;
use App\Form\ConfirmExclusionForm;
use App\Form\ProdutoForm;
use App\Repository\ProdutoRepository;
use App\Traits\ControllerTrait;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

#[Route(path: '/produto')]
class ProdutoController extends AbstractController
{
    use ControllerTrait;

    protected string $NAME = "produtos";
    #[Route(path: '/', name: 'Produto')]
    public function index(ProdutoRepository $repository,
                          #[MapQueryParameter] int $page = 1,
                          #[MapQueryParameter(options: ['min_range' => 1, 'max_range' => 10])] int $limit = 5): Response
    {
        return $this->renderWithSideBarItems('main/index.html.twig', $this->createPagination($repository, $page, $limit));
    }

    #[Route(path: '/new', name: 'AddProduto')]
    public function createAction(ProdutoRepository $repository,
                                 Request $request,
                                 EntityManagerInterface $em,
                                 #[MapQueryParameter] int $page = 1,
                                 #[MapQueryParameter(options: ['min_range' => 1, 'max_range' => 10])] int $limit = 5): RedirectResponse|Response
    {
        $form = $this->createForm(ProdutoForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($form->getData());
            $em->flush();

            $this->addFlash('success', 'Produto criado.');

            return $this->redirectToRoute('Produto', [$page, $limit]);
        }

        return $this->renderWithSideBarItems('main/index.html.twig', $this->createPagination($repository, $page, $limit), $form);
    }

    #[Route(path: '/edit/{id<\d+>}', name: 'EditProduto')]
    public function editAction(
        Produto $produto,
        ProdutoRepository $repository,
        Request $request,
        EntityManagerInterface $em,
        #[MapQueryParameter] int $page = 1,
        #[MapQueryParameter(options: ['min_range' => 1, 'max_range' => 10])] int $limit = 5): RedirectResponse|Response
    {
        $form = $this->createForm(ProdutoForm::class, $produto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($produto);
            $em->flush();

            $this->addFlash('success', 'Produto salvo.');

            return $this->redirectToRoute('Produto', [$page, $limit]);
        }

        return $this->renderWithSideBarItems('main/index.html.twig', $this->createPagination($repository, $page, $limit), $form);
    }

    #[Route(path: '/confirm-exclusion/{id<\d+>}', name: 'RemoveProduto')]
    public function removeAction(
        Produto $produto,
        ProdutoRepository $repository,
        Request $request,
        EntityManagerInterface $em,
        #[MapQueryParameter] int $page = 1,
        #[MapQueryParameter(options: ['min_range' => 1, 'max_range' => 10])] int $limit = 5): RedirectResponse|Response
    {
        $form = $this->createForm(ConfirmExclusionForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($produto);
            $em->flush();

            $this->addFlash('success', 'Produto removido.');

            return $this->redirectToRoute('Produto', [$page, $limit]);
        }

        return $this->renderWithSideBarItems('main/index.html.twig', $this->createPagination($repository, $page, $limit), $form);
    }
}
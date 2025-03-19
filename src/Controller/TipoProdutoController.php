<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\TipoProduto;
use App\Form\ConfirmExclusionForm;
use App\Form\TipoProdutoForm;
use App\Repository\TipoProdutoRepository;
use App\Traits\ControllerTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tipo-produto')]
class TipoProdutoController extends AbstractController
{
    use ControllerTrait;

    protected string $NAME = "tipos-produto";
    #[Route('/', name: 'TipoProduto')]
    public function index(TipoProdutoRepository $repository,
                          #[MapQueryParameter] int $page = 1,
                          #[MapQueryParameter(options: ['min_range' => 1, 'max_range' => 10])] int $limit = 5): Response
    {
        return $this->renderWithSideBarItems('main/index.html.twig', $this->createPagination($repository, $page, $limit));
    }

    #[Route(path: '/new', name: 'AddTipoProduto')]
    public function createAction(TipoProdutoRepository $repository,
                                 Request $request,
                                 EntityManagerInterface $em,
                                 #[MapQueryParameter] int $page = 1,
                                 #[MapQueryParameter(options: ['min_range' => 1, 'max_range' => 10])] int $limit = 5): RedirectResponse|Response
    {
        $form = $this->createForm(TipoProdutoForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($form->getData());
            $em->flush();

            $this->addFlash('success', 'Tipo Produto criado.');

            return $this->redirectToRoute('TipoProduto', [$page, $limit]);
        }

        return $this->renderWithSideBarItems('main/index.html.twig', $this->createPagination($repository, $page, $limit), $form);
    }

    #[Route(path: '/edit/{id<\d+>}', name: 'EditTipoProduto')]
    public function editAction(
        TipoProduto $tipoProduto,
        TipoProdutoRepository $repository,
        Request $request,
        EntityManagerInterface $em,
        #[MapQueryParameter] int $page = 1,
        #[MapQueryParameter(options: ['min_range' => 1, 'max_range' => 10])] int $limit = 5): RedirectResponse|Response
    {
        $form = $this->createForm(TipoProdutoForm::class, $tipoProduto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($tipoProduto);
            $em->flush();

            $this->addFlash('success', 'Tipo Produto salvo.');

            return $this->redirectToRoute('TipoProduto', [$page, $limit]);
        }

        return $this->renderWithSideBarItems('main/index.html.twig', $this->createPagination($repository, $page, $limit), $form);
    }

    #[Route(path: '/confirm-exclusion/{id<\d+>}', name: 'RemoveTipoProduto')]
    public function removeAction(
        TipoProduto $tipoProduto,
        TipoProdutoRepository $repository,
        Request $request,
        EntityManagerInterface $em,
        #[MapQueryParameter] int $page = 1,
        #[MapQueryParameter(options: ['min_range' => 1, 'max_range' => 10])] int $limit = 5): RedirectResponse|Response
    {
        $form = $this->createForm(ConfirmExclusionForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($tipoProduto);
            $em->flush();

            $this->addFlash('success', 'Tipo Produto removido.');

            return $this->redirectToRoute('TipoProduto', [$page, $limit]);
        }

        return $this->renderWithSideBarItems('main/index.html.twig', $this->createPagination($repository, $page, $limit), $form);
    }
}

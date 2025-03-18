<?php

namespace App\Controller;

use App\Entity\Pedido;
use App\Enum\PedidoHeaders;
use App\Form\ConfirmExclusionForm;
use App\Form\PedidoForm;
use App\Repository\PedidoRepository;
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

#[Route(path: '/pedidos')]
class PedidoController extends AbstractController
{
    use ControllerTrait;

    protected string $NAME = "pedidos";

    #[Route(path: '/', name: 'Pedido')]
    public function index(PedidoRepository $repository,
                          #[MapQueryParameter] int $page = 1,
                          #[MapQueryParameter(options: ['min_range' => 1, 'max_range' => 10])] int $limit = 10): Response
    {
        return $this->renderWithSideBarItems('main/index.html.twig', $this->createPagination($repository, $page, $limit));
    }

    #[Route(path: '/new', name: 'AddPedido')]
    public function createAction(PedidoRepository $repository,
                                 Request $request,
                                 EntityManagerInterface $em,
                                 #[MapQueryParameter] int $page = 1,
                                 #[MapQueryParameter(options: ['min_range' => 1, 'max_range' => 10])] int $limit = 10): RedirectResponse|Response
    {
        $form = $this->createForm(PedidoForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($form->getData());
            $em->flush();

            $this->addFlash('success', 'Pedido criado.');

            return $this->redirectToRoute('Pedido', [$page, $limit]);
        }

        return $this->renderWithSideBarItems('main/index.html.twig', $this->createPagination($repository, $page, $limit), $form);
    }

    #[Route(path: '/edit/{id<\d+>}', name: 'EditPedido')]
    public function editAction(
        Pedido $pedido,
        PedidoRepository $repository,
        Request $request,
        EntityManagerInterface $em,
        #[MapQueryParameter] int $page = 1,
        #[MapQueryParameter(options: ['min_range' => 1, 'max_range' => 10])] int $limit = 10): RedirectResponse|Response
    {
        $form = $this->createForm(PedidoForm::class, $pedido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($pedido);
            $em->flush();

            $this->addFlash('success', 'Pedido salvo.');

            return $this->redirectToRoute('Pedido', [$page, $limit]);
        }

        return $this->renderWithSideBarItems('main/index.html.twig', $this->createPagination($repository, $page, $limit), $form);
    }

    #[Route(path: '/confirm-exclusion/{id<\d+>}', name: 'RemovePedido')]
    public function removeAction(
        Pedido $pedido,
        PedidoRepository $repository,
        Request $request,
        EntityManagerInterface $em,
        #[MapQueryParameter] int $page = 1,
        #[MapQueryParameter(options: ['min_range' => 1, 'max_range' => 10])] int $limit = 10): RedirectResponse|Response
    {
        $form = $this->createForm(ConfirmExclusionForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($pedido);
            $em->flush();

            $this->addFlash('success', 'Pedido removido.');

            return $this->redirectToRoute('Pedido', [$page, $limit]);
        }

        return $this->renderWithSideBarItems('main/index.html.twig', $this->createPagination($repository, $page, $limit), $form);
    }
}